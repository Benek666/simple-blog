<?php
namespace App\Repositories;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

use App\Models\Comment;
use App\Models\Item;
use App\Models\User;

class UserRepository {

    public function update(Request $request) {
 
        $validator = Validator::make($request->all(), [
            'email' => 'email|required',
            'name' => 'required|string|max:255',
            'id' => 'required|numeric',
        ]);

        if($validator->fails()) {
            
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $user = User::find($request->input('id'));
        $user->email = $request->input('email');
        $user->name = $request->input('name');
        $user->is_admin = $request->has('is_admin');
        $user->save();
        
        return redirect()->route('users')->with(['message' => 'Gratulacje użytkownik został zaktualizowany']);
        
    }
    
    public function remove($id) {
        
        if($user = User::find($id)) {

            $user->delete();

            return redirect()->back()->with(['message' => 'Wpis został usunięty']);
        }
        
        return redirect()->back()->withErrors(['Wpis już zostal usunięty']);
    }
    
    public function restore($id) {
        
        if($user= User::withTrashed()->find($id)) {
            
            $user->restore();
            
            return redirect()->back()->with(['message' => 'Gratulacje użytkownik został przywrócony']);
        }
        
        return redirect()->back()->withErrors(['Użytkownik nie został znaleziony']);
    }
}