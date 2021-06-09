<?php
    
namespace App\Http\Controllers;
    
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

    
class ProductController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index']]);
         $this->middleware('permission:product-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->paginate(5);
        return view('products.index',compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::select('id','name')->get();
        return view('products.create',compact('category'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'product_image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        $input = $request->all();
        $imageName = time().'.'.$request->product_image->extension();  
        $request->product_image->move(public_path('uploads'), $imageName);
        $input['product_image'] = $imageName;
        Product::create($input);
    
        return redirect()->route('products.index')
                        ->with('success','Product created successfully.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('/');
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $category = Category::select('id','name')->get();
        return view('products.edit',compact('product','category'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        request()->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'category_id' => 'required',
        ]);

        $input = $request->all();
        $Product = Product::find($id);
        if($request->hasFile('product_image')) 
        {
          request()->validate([
            'product_image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
          ]);

          $imageName = time().'.'.$request->product_image->extension();  
          $request->product_image->move(public_path('uploads'), $imageName);
          $input['product_image'] = $imageName;
        }else{
          $input['product_image'] = $Product->product_image;
        }
         
         $Product->update($input);
    
        return redirect()->route('products.index')
                        ->with('success','Product updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
    
        return redirect()->route('products.index')
                        ->with('success','Product deleted successfully');
    }


    /*show category detail page on product*/
    public function getCategoryDetail(Request $request)
    {
        $category = Category::where('id',$request->input('row_id'))->first();
        if(!empty($category)){
           
           echo "<p><b>Category Name</b> : ".$category->name."<br> <b>Description</b> : ".$category->description."</p>";

        }

    }
}