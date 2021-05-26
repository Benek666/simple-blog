<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class HomeController extends Controller
{
    public function index() {
                
        return view('index')->with('items', Item::paginate(10));
    }
}
