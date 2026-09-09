<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'type',
        'balance',
        'currency',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'balance' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    // Account belongs to one User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Account has many Transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
