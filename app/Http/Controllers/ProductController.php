<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $products = Product::orderBy('id','desc')->get();
        $total = Product::count();
        return view('admin.product.home', compact(['products', 'total']));
    }

    public function create(){
        return view('admin.product.create');
    }

    public function save(Request $request){
        $validation = $request->validate([
            'title'=>'required',
            'category'=>'required',
            'price'=>'required',
        ]);

        $data = Product::create($validation);
        if ($data) {
            session()->flash('success', 'Prodcut Successfully Added');
            return redirect(route('admin/products'));
        }else{
            session()->flash('error', 'Failed to adding Product');
            return redirect(route('admin/product/create'));
        }
    }

    public function edit($id){
        $products = Product::findOrFail($id);
        return view('admin.product.update', compact('products'));
    }

    public function update(Request $request , $id){
        $products = Product::findOrFail($id);
        $title = $request->title;
        $category = $request->category;
        $price = $request->price;

        $products->title = $title;
        $products->category = $category;
        $products->price = $price;
        $data = $products->save();
        if ($data) {
            session()->flash('success', 'Product Successfully Updated');
            return redirect(route('admin/products'));
        }else{
            session()->flash('error', 'Failed to Updating Product');
            return redirect(route('admin/product/updates'));
        }
    }

    public function delete($id){
        $products = Product::findOrFail($id)->delete();
        if ($products) {
            session()->flash('success', 'Product Successfully Deleted');
            return redirect(route('admin/products'));
        }else{
            session()->flash('error', 'Failed to Deleting Product');
            return redirect(route('admin/products'));
        }
    }
}
