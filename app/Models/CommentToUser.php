<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentToUser extends Model
{
    use HasFactory;
    
    public function user() {
        
        return $this->hasOne('\App\Models\User', 'id', 'users_id');
    }
}
