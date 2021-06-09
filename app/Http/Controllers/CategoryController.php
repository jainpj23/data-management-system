<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use DB;


class CategoryController extends Controller
{

    public function __construct() 
    {
        $this->middleware('permission:category-list')->only('index');
        $this->middleware('permission:category-create')->only('create');
        $this->middleware('permission:category-edit')->only('edit');
        $this->middleware('permission:category-delete')->only('destroy');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
     {

        $data = Category::orderBy('id','DESC')->paginate(5);

        return view('category.index',compact('data'))
        ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories,name',
            'description' => 'required',
        ]);

        $input = $request->all();

        $user = Category::create($input);
        return redirect()->route('category.index')
        ->with('success','Category created successfully');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       return redirect('/home');
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('category.edit',compact('category'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
        ]);
    
        $input = $request->all();
        $category = Category::find($id);
        $category->update($input);

        return redirect()->route('category.index')
        ->with('success','Category updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::find($id)->delete();
        Product::where('category_id',$id)->delete();
        return redirect()->route('category.index')
        ->with('success','category deleted successfully');
    }
}
