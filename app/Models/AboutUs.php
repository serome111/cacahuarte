<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;

    // protected $table = 'about_us';

    protected $fillable = [
    	'title',
    	'description',
    	'state',
    	'photo',
    	'link',
    	'title1',
    	'description1',
    	'favicon1',
    	'title2',
    	'description2',
    	'favicon2',
    	'title3',
    	'description3',
    	'favicon3'
    ];
}