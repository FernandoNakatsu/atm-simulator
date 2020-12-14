<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
	protected $table = 'user';

	protected $dates = [
		'birthdate'
	];

	protected $fillable = [
		'fullname',
		'birthdate',
		'cpf'
	];

	public function account_banks()
	{
		return $this->hasMany(\App\Models\AccountBank::class);
	}
}
