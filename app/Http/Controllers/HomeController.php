<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;


use App\Models\Item;
use App\Models\User;
use App\Models\Comment;

use App\Repositories\CommentRepository;
use App\Repositories\ItemRepository;

class HomeController extends Controller
{
    private $commentRepository, $itemRepository;
    
    public function __construct(CommentRepository $commentRepository, ItemRepository $itemRepository) {
        
        $this->middleware('auth', ['except' => ['index', 'showProfile', 'showItem']]);
        
        $this->commentRepository = $commentRepository;
        
        $this->itemRepository = $itemRepository;
    }
    
    public function index() {
                
        return view('index')->with('items', Item::orderBy('created_at', 'DESC')->paginate(5));
    }
    
    public function showProfile($id, $comment_id = 0) {
        
        try {
            
            $user = User::findOrFail($id); 
            
        } catch(ModelNotFoundException $e) {
        
            abort(404, 'Profil o podanym identyfikatorze nie został znaleziony!');
        }
        
        return view('profile')->with('user', $user)
                              ->with('comments', $user->comments()->orderBy('created_at', 'DESC')->paginate(5))
                              ->with('userComment', $this->commentRepository->find($comment_id));
    }
    
    public function showItem($id, $comment_id = 0) {
        
        try {
            
            $item = Item::findOrFail($id);
            
        } catch (ModelNotFoundException $e) {

            abort(404, 'Brak wpisu o podanym identyfikatorze!');
        }
        
        return view('item')->with('item', $item)
                           ->with('comments', $item->comments()->orderBy('created_at', 'DESC')->paginate(5))
                           ->with('userComment', $this->commentRepository->find($comment_id));
    }
    
    public function addComment(Request $request) {
                
        return $this->commentRepository->add($request);
                 
    }
    
    public function updateComment(Request $request) {
        
        return $this->commentRepository->update($request);
    }
    
    public function removeComment($id) {
        
       return $this->commentRepository->remove($id);
    }
    
    public function addItem(Request $request) {
        
        return $this->itemRepository->add($request);
        
    }
    
    public function updateItem(Request $request) {
        
        return $this->itemRepository->update($request);        
    }
    
    public function removeItem($id) {
            
       return $this->itemRepository->remove($id);       
    }
    
    public function getFormItem($id = 0) {
        
        return view('add-item')->with('item',Item::find($id));
    }
}
