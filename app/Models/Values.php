<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Values extends Model
{
	protected $fillable = ['title','description','state','picture'];
    use HasFactory;
}
