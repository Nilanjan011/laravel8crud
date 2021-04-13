<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = product::toBase()->orderBy('id','DESC')->paginate(2);
        // dd($product);
        return view("pruductlist",compact("product"))->with('message','successfully inserted');;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("product");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required|string|min:3|max:50',
            'image'=> 'required|file|image|mimes:jpeg,png,gif,webp',
             "price" =>"required"
        ]);
        $image=$request->file('image');
		$ext=$image->extension();
		$file=time().'.'.$ext;
		// $image->move(public_path('images'),$file);
        $image->storeAs('ava',$file,'public'); // laravel storage use 

        $product=new product([
            "name"=>$request->post("name"),
            "image"=>$file,
            "price"=>$request->post("price"),
        ]);
        if ($product->save())
        {
            return redirect('product')->with(['message'=>'successfully inserted','class'=>'success']);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(product $product)
    {
        return view('editProduct',compact("product"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, product $product)
    {
        $request->validate([
            'name'=> 'required|string|min:3|max:50',
            'image' => 'file|image|mimes:jpeg,png,gif,webp',
            "price" =>"required"
        ]);
        
        if ($request->has('image')) {
            // dd($product->image);
            storage::delete("./public/ava/$product->image");
            $image=$request->file('image');
            $ext=$image->extension();
            $file=time().'.'.$ext;
            
            $image->storeAs('ava',$file,'public'); // laravel storage use 

            $product->update([
                "name"=>$request->post('name'),
                "price"=>$request->post('price'),
                "image"=>$file
            ]);
        }else {
            $product->update([
                "name"=>$request->post('name'),
                "price"=>$request->post('price'),
            ]);
        }
        return redirect('product')->with(['message'=>'successfully Update','class'=>'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(product $product)
    {      //use Illuminate\Support\Facades\Storage; //important
        Storage::delete("./public/ava/$product->image");  /// use Illuminate\Support\Facades\Storage; ata add korte hobe
        $product->delete();
        return redirect('product')->with('message','Delete Successfully');
    }
}

