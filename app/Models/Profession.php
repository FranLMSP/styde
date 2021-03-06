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

	public function users()
	{
		return $this->hasMany(User::class);
	}
}
