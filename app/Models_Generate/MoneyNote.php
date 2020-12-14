<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class MoneyNote extends Model
{
	protected $table = 'money_notes';

	protected $casts = [
		'value' => 'int'
	];

	protected $fillable = [
		'description',
		'value'
	];
}
