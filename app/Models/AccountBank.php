<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AccountBank extends Model
{
	protected $table = 'account_bank';

	protected $casts = [
		'user_id' => 'int',
		'account_bank_type_id' => 'int',
		'balance' => 'int'
	];

	protected $fillable = [
		'user_id',
		'account_bank_type_id',
		'balance'
	];

	public function account_bank_type()
	{
		return $this->belongsTo(\App\Models\AccountBankType::class);
	}

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}
}
