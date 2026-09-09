<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'type',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    // Category belongs to one User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Category has many Transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
