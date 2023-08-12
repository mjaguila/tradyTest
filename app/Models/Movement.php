<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'credit',
        'debit'
    ];

    public function account(){
        return $this->belongsTo(Account::class);
    }
}
