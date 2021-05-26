<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentToItem extends Model
{
    use HasFactory;
    
    public function item() {
        
        return $this->hasOne('\App\Models\Item', 'id', 'items_id');
    }
    
    public function user() {
        
        return $this->hasOne('\App\Models\User', 'id', 'users_id');
    }
}
