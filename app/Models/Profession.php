<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
	//protected $table = 'custom_table_name';

	public $timestamps = false;

	protected $fillable = [
		'title'
	];


	/*
		For example:
		If the field is boolean, the database will be tinyint(1)
		And we can cast it to a boolean type
	*/
	protected $casts = [
		'title' => 'string'
	];
}
