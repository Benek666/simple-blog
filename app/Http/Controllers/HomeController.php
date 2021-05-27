<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Item;
use App\Models\User;
use App\Models\Comment;

class HomeController extends Controller
{
    public function index() {
                
        return view('index')->with('items', Item::paginate(10));
    }
    
    public function showProfile($id, $comment_id = 0) {
        
        try {
            
            $user = User::findOrFail($id); 
            
        } catch(ModelNotFoundException $e) {
        
            abort(404, 'Profil o podanym identyfikatorze nie został znaleziony!');
        }
        
        $comment = null;
        
        if(Auth::user() && $comment_id) {

            $comments = Comment::where('id', $comment_id);
            
            if(!Auth::user()->is_admin) {
                    
                $comments->where('users_id', Auth::user()->id);
            }
            
            $comment = $comments->first();
        }
        
        return view('profile')->with('user', $user)
                              ->with('comments', $user->comments()->orderBy('created_at', 'DESC')->paginate(5))
                              ->with('userComment', $comment);
    }
    
    public function showItem($id, $comment_id = 0) {
        
        try {
            
            $item = Item::findOrFail($id);
            
        } catch (ModelNotFoundException $e) {

            abort(404, 'Brak wpisu o podanym identyfikatorze!');
        }

        $comment = null;
        
        if(Auth::user() && $comment_id) {

            $comments = Comment::where('id', $comment_id);
            
            if(!Auth::user()->is_admin) {
                    
                $comments->where('users_id', Auth::user()->id);
            }
            
            $comment = $comments->first();
        }
        
        return view('item')->with('item', $item)
                           ->with('comments', $item->comments()->orderBy('created_at', 'DESC')->paginate(5))
                           ->with('userComment', $comment);
    }
    
    public function addComment(Request $request) {
        
        $item = false;
        
        if($request->has('item_id')) {
            
            $commentable_id = $request->input('item_id');
            $commentable_type = 'App\Models\Item';
            $item = true;
        }
        else if($request->has('user_id')){
            
            $commentable_id = $request->input('user_id');
            $commentable_type = 'App\Models\User';
        }
        
        $validator = Validator::make($request->all(), ['subject' => 'max:100',
                            'description' => 'required',
                            'item_id' => Rule::requiredIf($item),
                            'user_id' => Rule::requiredIf(!$item),
        ]);

        
        $auth = Auth::check();

        $validator->after(function ($validator) use($request, $auth, $item, $commentable_id, $commentable_type) {
            
            if($item && is_null(Item::find($request->input('item_id')))) {
        
                $validator->errors()->add('wpis', 'Wpis nie istnieje!');
            }
            
            if(!$item && is_null(User::find($request->input('user_id')))) {
                
                $validator->errors()->add('wpis', 'Użytkownik nie istnieje!');
            }
            
            if(!$auth) {
                
                $validator->errors()->add('autoryzacja', 'Użytkownik niezalogowany!');
            }
    
            if(Comment::where('commentable_id', $commentable_id)->where('commentable_type', $commentable_type)->where('description', $request->input('description'))->count()) {
                
                $validator->errors()->add('komentarz', 'Komentarz o tej samej treści już został dodany');
            }     
        });

               
        
        if($validator->fails()) {
            
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
   
        $comment = new Comment();
        
        $comment->subject = $request->input('subject');
        $comment->description = $request->input('description');
        $comment->commentable_id = $commentable_id;
        $comment->commentable_type = $commentable_type;
        $comment->users_id = Auth::id();
        
        $comment->save();
        
        return redirect()->back()->with(['message' => 'Gratulacje komentarz został dodany!']);
    }
    
    public function updateComment(Request $request) {
        
        $item = false;
        
        if($request->has('item_id')) {
            
            $commentable_id = $request->input('item_id');
            $commentable_type = 'App\Models\Item';
            $item = true;
        }
        else if($request->has('user_id')){
            
            $commentable_id = $request->input('user_id');
            $commentable_type = 'App\Models\User';
        }
        
        $validator = Validator::make($request->all(), ['subject' => 'max:100',
                            'description' => 'required',
                            'item_id' => Rule::requiredIf($item),
                            'user_id' => Rule::requiredIf(!$item),
        ]);
        
        $auth = Auth::check();
        $user = Auth::user();
        
        $validator->after(function ($validator) use($request, $auth, $user, $item, $commentable_id, $commentable_type) {
            
            if($item && is_null(Item::find($request->input('item_id')))) {
        
                $validator->errors()->add('wpis', 'Wpis nie istnieje!');
            }
            
            if(!$item && is_null(User::find($request->input('user_id')))) {
                
                $validator->errors()->add('wpis', 'Użytkownik nie istnieje!');
            }
            
            if(!$auth) {
                
                $validator->errors()->add('autoryzacja', 'Użytkownik niezalogowany!');
            }
            
            if(is_null(Comment::where('id', $request->input('comments_id'))->where('users_id', $user->id)->first())) {
            
                $validator->errors()->add('komentarz', 'Komentarz dla określonego użytkownika nie istnieje');
            }
            
            if(Comment::where('commentable_id', $request->input('item_id'))->where('commentable_type', $commentable_type)->where('description', $request->input('description'))->count()) {
                
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
        
        return redirect()->back()->with(['message' => 'Gratulacje komentarz został zaktualizowany!']);
    }
    
    public function removeComment($id) {
        
        if(Auth::check()) {
        
            if($comment = Comment::find($id)) {
                
                if($comment->users_id == Auth::id() || Auth::user()->is_admin) {
                    
                   $comment->delete();
                   
                   return redirect()->back()->with('message', 'Komentarz został usunięty');
                }
                
                return redirect()->back()->withErrors(['Nie masz uprawnień do usunięcia tego komentarza!']);                                
            }
            
            return redirect()->back()->withErrors(['Komentarz już zostal usunięty']);
        }
        
        return redirect()->back()->withErrors(['Nie jesteś zalogowany']);
    }
}
