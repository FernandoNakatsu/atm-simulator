<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class AccountBankType extends Model
{
	protected $table = 'account_bank_type';

	protected $fillable = [
		'description'
	];

	public function account_banks()
	{
		return $this->hasMany(\App\Models\AccountBank::class);
	}
}
