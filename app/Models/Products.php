<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
	protected $fillable = ['code','name','price','stock','categorie_id','state','picture','description'];
    use HasFactory;

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('state', 1);
    }
}
