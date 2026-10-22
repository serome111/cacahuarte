<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
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
