<?php

namespace Tests\Feature;

use App\Models\ContactUs;
use App\Models\Products;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SecurityTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        DB::purge('sqlite');
        Schema::create('contact_us', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('subject');
            $table->string('message');
            $table->integer('state')->nullable();
            $table->timestamps();
        });
        Schema::create('email_spam', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->timestamps();
        });
    }

    public function test_guests_cannot_read_or_delete_contact_messages(): void
    {
        $this->postJson('/contact_us/filter', ['text' => ''])->assertUnauthorized();
        $this->postJson('/contact-us/bulk-destroy', ['ids' => [1]])->assertUnauthorized();
        $this->deleteJson('/contact_us/1')->assertUnauthorized();
    }

    public function test_non_admins_cannot_manage_users(): void
    {
        $user = new User(['name' => 'Editor', 'email' => 'editor@example.com']);
        $user->id = 1;
        $user->setRelation('role', (new Role())->forceFill(['name' => 'editor']));
        $this->actingAs($user);
        $this->getJson('/users')->assertForbidden();
        $this->postJson('/users', [])->assertForbidden();
        $this->deleteJson('/users/2')->assertForbidden();
    }

    public function test_admin_gate_accepts_only_admin_role(): void
    {
        $user = new User();
        $user->setRelation('role', (new Role())->forceFill(['name' => 'admin']));
        $this->assertTrue(\Illuminate\Support\Facades\Gate::forUser($user)->allows('manage-users'));
        $user->setRelation('role', null);
        $this->assertFalse(\Illuminate\Support\Facades\Gate::forUser($user)->allows('manage-users'));
    }

    public function test_contact_validation_prevents_invalid_input_and_state_assignment(): void
    {
        $this->postJson('/contact_us', ['email' => 'invalid'])->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'email', 'subject', 'message']);
        $this->postJson('/contact_us', [
            'name' => 'Cliente', 'email' => 'cliente@example.com',
            'subject' => 'Consulta', 'message' => 'Hola', 'state' => 999,
        ])->assertOk();
        $this->assertDatabaseHas('contact_us', ['email' => 'cliente@example.com', 'state' => null]);
    }

    public function test_bulk_delete_validates_ids_before_accessing_messages(): void
    {
        $user = new User();
        $user->id = 1;
        $this->actingAs($user)->postJson('/contact-us/bulk-destroy', ['ids' => ['invalid']])
            ->assertUnprocessable()->assertJsonValidationErrors('ids.0');
    }

    public function test_catalog_hides_inactive_products_and_keeps_the_old_picture_if_saving_fails(): void
    {
        require_once database_path('migrations/2021_02_01_232751_create_products_table.php');
        (new \CreateProductsTable())->up();

        Storage::fake('public')->put('products/original.png', 'original');
        $product = Products::create([
            'name' => 'Cacao',
            'code' => 'CAC01',
            'price' => '100',
            'stock' => 1,
            'categorie_id' => 1,
            'description' => 'Cacao',
            'state' => 0,
            'picture' => '/storage/products/original.png',
        ]);

        $this->get('/detalles/'.$product->id)->assertNotFound();

        $user = new User();
        $user->id = 1;
        Products::updating(fn () => false);
        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+jRZkAAAAASUVORK5CYII=');
        $data = $product->getAttributes();
        $data['picture'] = UploadedFile::fake()->createWithContent('nueva.png', $png);

        $this->actingAs($user)->put('/products/'.$product->id, $data)->assertServerError();

        $this->assertSame('/storage/products/original.png', $product->fresh()->picture);
        $this->assertSame(['products/original.png'], Storage::disk('public')->allFiles('products'));
    }

    public function test_contact_filter_paginates_and_bulk_delete_applies_the_filter_across_pages(): void
    {
        $user = new User();
        $user->id = 1;
        $message = ['name' => 'Cliente', 'email' => 'cliente@example.com', 'message' => 'Hola'];
        for ($i = 0; $i < 21; $i++) {
            ContactUs::create($message + ['subject' => 'Pedido']);
        }
        ContactUs::create($message + ['subject' => 'Otra consulta']);

        $this->actingAs($user)->postJson('/contact_us/filter', ['text' => 'Pedido'])
            ->assertOk()->assertJsonPath('total', 21)->assertJsonCount(20, 'data');
        $this->postJson('/contact-us/bulk-destroy', ['text' => 'Pedido'])->assertOk();

        $this->assertDatabaseCount('contact_us', 1);
        $this->assertDatabaseHas('contact_us', ['subject' => 'Otra consulta']);
        $this->assertDatabaseCount('email_spam', 1);
    }

    public function test_uploads_reject_images_with_executable_extensions(): void
    {
        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+jRZkAAAAASUVORK5CYII=');
        $rules = (new \App\Http\Requests\ClientRequest())->rules()['imagen'];
        $valid = \Illuminate\Http\UploadedFile::fake()->createWithContent('photo.png', $png);
        $disguised = \Illuminate\Http\UploadedFile::fake()->createWithContent('photo.php', $png);
        $this->assertTrue(validator(['imagen' => $valid], ['imagen' => $rules])->passes());
        $this->assertFalse(validator(['imagen' => $disguised], ['imagen' => $rules])->passes());
        $this->assertSame('png', pathinfo($valid->hashName(), PATHINFO_EXTENSION));
    }

    public function test_public_contact_form_is_rate_limited(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->postJson('/contact_us', [])->assertUnprocessable();
        }
        $this->postJson('/contact_us', [])->assertStatus(429);
    }
}
