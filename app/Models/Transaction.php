<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_id',
        'category_id',
        'amount',
        'type',
        'description',
        'transaction_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'transaction_date' => 'date',
        ];
    }

    // Transaction belongs to one User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Transaction belongs to one Account
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    // Transaction belongs to one Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
