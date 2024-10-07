<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscribeUser extends Model
{
    use HasFactory;

    protected $table = 'subscribe_users';
    protected $guarded = [];
    protected $hidden = ['id', 'user_id'];

    public function user() {
        $this->belongsTo(User::class, 'user_id', 'id');
    }
}
