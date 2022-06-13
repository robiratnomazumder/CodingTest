<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVerify extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'token',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class,'user_id','id');
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class,'user_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

}
