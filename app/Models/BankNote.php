<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BankNote extends Model
{
	protected $table = 'bank_notes';

	protected $casts = [
		'value' => 'int'
	];

	protected $fillable = [
		'description',
		'value'
	];
}
