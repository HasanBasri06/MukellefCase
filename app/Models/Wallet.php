<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $table = 'wallet';
    protected $guarded = [];

    public function card() {
        return $this->belongsTo(Card::class, 'card_id', 'id');
    }
}
