<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'order';
    protected $guarded = [];

    protected $hidden = ['id', 'user_id'];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function card() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
