<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\User;
use App\Models\Comment;

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
    
    public function addComment(Request $request) {
        
        $validator = Validator::make($request->all(), ['subject' => 'max:100',
                            'description' => 'required',
        ]);

        $auth = Auth::check();

        $validator->after(function ($validator) use($request, $auth) {
            
            if(is_null(Item::find($request->input('item_id')))) {
        
                $validator->errors()->add('wpis', 'Wpis nie istnieje!');
            }
            
            if(!$auth) {
                
                $validator->errors()->add('autoryzacja', 'Użytkownik niezalogowany!');
            }
    
            if(Comment::where('commentable_id', $request->input('item_id'))->where('commentable_type', 'App\Models\Item')->where('description', $request->input('description'))->count()) {
                
                $validator->errors()->add('komentarz', 'Komentarz o tej samej treści już został dodany');
            }     
        });

        if($validator->fails()) {
            
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
   
        $comment = new Comment();
        
        $comment->subject = $request->input('subject');
        $comment->description = $request->input('description');
        $comment->commentable_id = $request->input('item_id');
        $comment->commentable_type = 'App\Models\Item';
        $comment->users_id = Auth::id();
        
        $comment->save();
        
        return redirect()->back();
    }
    
    public function updateComment(Request $request) {
        
        $validator = Validator::make($request->all(), ['subject' => 'max:100',
                            'description' => 'required',
        ]);
        
        $auth = Auth::check();
        
        $validator->after(function ($validator) use($request, $auth) {
            
            if(is_null(Item::find($request->input('item_id')))) {
        
                $validator->errors()->add('wpis', 'Wpis nie istnieje!');
            }
            
            if(!$auth) {
                
                $validator->errors()->add('autoryzacja', 'Użytkownik niezalogowany!');
            }
    
            if(is_null(Comment::where('id', $request->input('comments_id'))->where('users_id', $auth::id))) {
            
                $validator->errors()->add('komentarz', 'Komentarz dla określonego użytkownika nie istnieje');
            }
            
            if(Comment::where('commentable_id', $request->input('item_id'))->where('commentable_type', 'App\Models\Item')->where('description', $request->input('description'))->count()) {
                
                $validator->errors()->add('komentarz', 'Komentarz o tej samej treści już został dodany');
            }     
        });

        if($validator->fails()) {
            
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $comment = Comment::find($request->input('comments_id'));
        
        $comment->subject = $request->input('subject');
        $comment->description = $request->input('description');
        $comment->save();
        
        return redirect()->back();
    }
    
    public function removeComment($id) {
        
        if(Auth::check()) {
        
            Comment::where('id', $id)->where('')
                
        }
        
        return redirect()->back()->withErrors();
    }
}
