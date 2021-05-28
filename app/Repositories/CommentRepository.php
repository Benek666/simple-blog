<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

use App\Models\Comment;
use App\Models\Item;

class CommentRepository {
    
    public function add(Request $request) {
        
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

        $validator->after(function ($validator) use($request, $item, $commentable_id, $commentable_type) {
            
            if($item && is_null(Item::find($request->input('item_id')))) {
        
                $validator->errors()->add('wpis', 'Wpis nie istnieje!');
            }
            
            if(!$item && is_null(User::find($request->input('user_id')))) {
                
                $validator->errors()->add('wpis', 'Użytkownik nie istnieje!');
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
    
    public function update(Request $request) {
        
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
        
        $user = Auth::user();
        
        $validator->after(function ($validator) use($request, $user, $item, $commentable_id, $commentable_type) {
            
            if($item && is_null(Item::find($request->input('item_id')))) {
        
                $validator->errors()->add('wpis', 'Wpis nie istnieje!');
            }
            
            if(!$item && is_null(User::find($request->input('user_id')))) {
                
                $validator->errors()->add('wpis', 'Użytkownik nie istnieje!');
            }
            
            if(is_null(Comment::where('id', $request->input('comments_id'))->where('users_id', $user->id)->first())) {
            
                $validator->errors()->add('komentarz', 'Komentarz dla określonego użytkownika nie istnieje');
            }
            
            if(Comment::where('commentable_id', $commentable_id)->where('commentable_type', $commentable_type)->where('description', $request->input('description'))->count()) {
                
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
    
    public function remove($id) {
        
        if($comment = Comment::find($id)) {

            if($comment->users_id == Auth::id() || Auth::user()->is_admin) {

               $comment->delete();

               return redirect()->back()->with('message', 'Komentarz został usunięty');
            }

            return redirect()->back()->withErrors(['Nie masz uprawnień do usunięcia tego komentarza!']);                                
        }

        return redirect()->back()->withErrors(['Komentarz już zostal usunięty']);
    }
    
    /*
        Zwroc komentarz nalezacy do autora lub zwroc komentarz dla uzytkownika z prawami admina
    */
    public function find($id = 0) {
        
        $comment = null;
        
        if($id) {

            $comments = Comment::where('id', $id);
            
            if(!Auth::user()->is_admin) {
                    
                $comments->where('users_id', Auth::user()->id);
            }
            
            $comment = $comments->first();
        }
        
        return $comment;
    }
    
    public function restore($id) {
        
        if($comment = Comment::withTrashed()->find($id)) {
            
            $comment->restore;
            
            return redirect()->back()->with(['message' => 'Gratulacje komentarz został przywrócony']);
        }
        
        return redirect()->back()->withErrors(['Komentarz nie został znaleziony']);
    }
}