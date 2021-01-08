<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banners extends Model
{
    use HasFactory;

    protected $fillable = ['title','description','state','photo'];
    public function getRouteKeyName()
    {
    	return 'title';
    }
}
