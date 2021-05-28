<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use App\Models\Item;
use App\Models\Comment;
use App\Models\User;

use App\Repositories\CommentRepository;
use App\Repositories\ItemRepository;
use App\Repositories\UserRepository;

class AdminController extends Controller
{
    private $commentRepository, $itemRepository, $userRepository;
    
    public function __construct(CommentRepository $commentRepository, ItemRepository $itemRepository, UserRepository $userRepository) {
    
        $this->middleware('is_admin');
        
        $this->commentRepository = $commentRepository;
        $this->itemRepository = $itemRepository;
        $this->userRepository = $userRepository;
    }
    
    public function index() {
        
        return view('admin.index');
    }
    
    public function getItems(Request $request) {
        
        $paginate = 20;
        
        $query = Item::orderBy('created_at', 'DESC')->paginate($paginate);
        
        if($request->has('rows')) {
        
            switch($request['rows']) {

                case 1:
                    $query = Item::withTrashed()->orderBy('created_at', 'DESC')->paginate($paginate);
                break;

                case 2:
                  $query = Item::onlyTrashed()->orderBy('created_at', 'DESC')->paginate($paginate);
                break;

                default:
                  $query = Item::orderBy('created_at', 'DESC')->paginate($paginate);
            }            
        }
        
        return view('admin.items')->with('items', $query);
    }
    
    public function getItem($id) {

        if($item = Item::find($id))
            return view('admin.item')->with('item', $item);
               
        return redirect()->route('admin')->withErrors(['blad' => 'Brak wpisu o podanym id!']);
    }
    
    public function updateItem(Request $request, $isAdmin = 0) {

       return $this->itemRepository->update($request, $isAdmin);
    }
    
    public function removeItem($id) {
        
        return $this->itemRepository->remove($id);
    }
    
    public function restoreItem($id) {
        
        return $this->itemRepository->restore($id);
    }

    public function getComments(Request $request, $commentable, $isItem = 1) {
         
        if($obj = (($isItem)? 'App\Models\Item':'App\Models\User')::withTrashed()->find($commentable)) {
        
            $paginate = 20;
        
            $comments = $obj->comments()->paginate($paginate); # ->orderBy('created_at', 'DESC');

            /*
            if($request->has('rows')) {

                switch($request['rows']) {

                    case 1:
                      $comments = $obj->comments()::withTrashed()->paginate($paginate); # ->orderBy('created_at', 'DESC')
                    break;

                    case 2:
                      $comments = $obj->comments()::onlyTrashed()->paginate($paginate); # ->orderBy('created_at', 'DESC')
                    break;

                    default:
                      $comments = $obj->comments()::paginate($paginate); # orderBy('created_at', 'DESC')
                }            
            }
            */  
            return view('admin.comments')->with('obj', $obj)
                                         ->with('comments', $comments)
                                         ->with('isItem', $isItem);
        }
        else
            return redirect()->back()->withErrors(['blad' => 'Brak wpisu o id '.$commentable]);
        
    }
    
    public function getComment($id) {
        
        if($comment = Comment::find($id))
            return view('admin.comment')->with('comment', $comment);
               
        return redirect()->route('admin')->withErrors(['blad' => 'Brak komentarza o podanym id!']);
    }
    
    public function updateComment(Request $request) {
        
        return $this->commentRepository->update($request);
    }
    
    public function removeComment($id) {
        
        return $this->commentRepository->remove($id);
    }
    
    public function restoreComment($id) {
        
        return $this->commentRepository->restore($id);
    }
    
    public function getUsers(Request $request) {
        
        $paginate = 20;
        
        $query = User::orderBy('created_at', 'DESC')->paginate($paginate);
        
        if($request->has('rows')) {
        
            switch($request['rows']) {

                case 1:
                    $query = User::withTrashed()->orderBy('created_at', 'DESC')->paginate($paginate);
                break;

                case 2:
                  $query = User::onlyTrashed()->orderBy('created_at', 'DESC')->paginate($paginate);
                break;

                default:
                  $query = User::orderBy('created_at', 'DESC')->paginate($paginate);
            }            
        }
        
        return view('admin.users')->with('users', $query);
        
    }
    
    public function getUser($id) {
        
         if($user = User::find($id))
            return view('admin.user')->with('user', $user);
               
        return redirect()->route('users')->withErrors(['blad' => 'Brak użytkownika o podanym id!']);
    }
    
    public function updateUser(Request $request) {
        
        return $this->userRepository->update($request);
    }
    
    public function removeUser($id) {
        
        return $this->userRepository->remove($id);
    }
    
    public function restoreUser($id) {
        
        return $this->userRepository->restore($id);
    }
}
