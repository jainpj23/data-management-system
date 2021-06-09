<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {  
        $user_data = User::where('id','!=',1)->count();
        $product_count = Product::count();
        $category_count = Category::count();
        return view('home',compact('user_data','product_count','category_count'));
    }
}