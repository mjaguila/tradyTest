<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id'
    ];

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function movements(){
        return $this->hasMany(Movement::class);
    }
}
