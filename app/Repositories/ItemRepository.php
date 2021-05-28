<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

use App\Models\Comment;
use App\Models\Item;

class ItemRepository {

    public function add(Request $request) {
    
         $validator = Validator::make($request->all(), [
            'subject' => 'max:100',
            'description' => 'required'
        ]);
        
        if($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();
                
        $item = new Item();
        $item->subject = $request->input('subject');
        $item->description = $request->input('description');
        $item->users_id = Auth::user()->id;
        
        $item->save();
        
        return redirect()->route('index')->with(['message' => 'Post został dodany']);
    }

    public function update(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'subject' => 'max:100|required',
            'description' => 'required',
            'item_id' => 'required|numeric',
        ]);

        $user = Auth::user();
        
        $validator->after(function($validator) use($request, $user) {

            // wpis musi istniec, a jego aktualizacje moze zrobic autor lub administrator
            $query = Item::where('id', $request->input('item_id'));
            
            if(!$user->is_admin) {
                
                $query->where('users_id', $user->id);
            }
            
            if(is_null($query->first())) {
                
                $validator->errors()->add('Brak', 'Brak możliwości zaktualizowania wpisu');
            }
        });
        
        if($validator->fails()) {
            
            return redirect()->route('index')->withErrors($validator)->withInput();
        }
        
        $item = Item::find($request->input('item_id'));
        $item->subject = $request->input('subject');
        $item->description = $request->input('description');
        $item->save();
        
        return redirect()->route('index')->with(['message' => 'Gratulacje wpis został zaktualizowany']);
    }
    
    public function remove($id) {
        
        if($item = Item::find($id)) {

            if($item->users_id == Auth::user()->id || Auth::user()->is_admin) {

                $item->delete();

                return redirect()->route('index')->with(['message' => 'Wpis został usunięty']);
            }

            return redirect()->back()->withErrors(['Nie masz uprawnień do usunięcia tego wpisu']);
        }
        
        return redirect()->back()->withErrors(['Wpis już zostal usunięty']);
    }
    
    public function restore($id) {
        
        if($item = Item::withTrashed()->find($id)) {
            
            $item->restore();
            
            return redirect()->back()->with(['message' => 'Gratulacje wpis został przywrócony']);
        }
        
        return redirect()->back()->withErrors(['Wpis nie został znaleziony']);
    }
}