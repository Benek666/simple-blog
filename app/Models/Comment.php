<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    
    protected $table = 'comments';
    
    public function commentable() {
        
        return $this->morphTo();
    }
    
    public function user() {
        
        return $this->hasOne('\App\Models\User', 'id', 'users_id');
    }
}
