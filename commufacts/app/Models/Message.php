<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'user_id',
        'fact_id',
    ];

    public function users(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function facts(){
        return $this->belongsTo(Fact::class, 'fact_id');
    }

}
