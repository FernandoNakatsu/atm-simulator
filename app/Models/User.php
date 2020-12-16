<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
	protected $table = 'user';

	protected $casts = [
		'birthday' => 'date:Y-m-d',
	];

	protected $dates = [
		'birthday' => 'date:Y-m-d',
	];

	protected $fillable = [
		'fullname',
		'birthday',
		'cpf'
	];

	public function account_banks()
	{
		return $this->hasMany(\App\Models\AccountBank::class);
	}
}
