<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Account extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'balance',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function outWardtransactions()
    {
        return $this->hasMany(Transaction::class, 'from_account_id');
    }
    public function inWardtransactions()
    {
        return $this->hasMany(Transaction::class, 'to_account_id');
    }
}
