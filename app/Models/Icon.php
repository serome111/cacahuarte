<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Icon extends Model
{
	protected $fillable=["icon_name", "icon_class", "icon_hex_code"];
    // use HasFactory;
}
