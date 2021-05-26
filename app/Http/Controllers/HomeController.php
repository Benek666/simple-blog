<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Item;
use App\Models\User;

class HomeController extends Controller
{
    public function index() {
                
        return view('index')->with('items', Item::paginate(10));
    }
    
    public function showProfile($id) {
        
        try {
            
            $user = User::findOrFail($id); 
            
        } catch(ModelNotFoundException $e) {
        
            abort(404, 'Profil o podanym identyfikatorze nie został znaleziony!');
        }
        
        return view('profile')->with('user', $user)->with('comments', $user->comments()->paginate(5));
    }
    
    public function showItem($id) {
        
        try {
            
            $item = Item::findOrFail($id);
            
        } catch (ModelNotFoundException $e) {

            abort(404, 'Brak wpisu o podanym identyfikatorze!');
        }
        
        return view('item')->with('item', $item)->with('comments', $item->comments()->paginate(5));
    }
}
