<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $products = [];
    if (request('query') && request('query') !== null) {
      $query = request('query');
      $products = Product::where('name', 'like', '%' . $query . '%')->orWhere('price', 'like', '%' . $query . '%')->orWhere('description', 'like', '%' . $query . '%')->paginate(8);
    } else {
      $products = Product::paginate(8);
    }

    if (Auth::check() && Auth::user()->is_admin) {
      return view('product.index', compact('products'));
    }

    return view('product.index_user', compact('products'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('product.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $this->validate($request, [
      'name' => 'required|min:5',
      'price' => 'required|numeric',
      'stock' => 'required|numeric',
      'description' => 'min:5',
      'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
    ]);

    $image = $request->file('image');
    $imageName = 'products/' . $image->getClientOriginalName(); // Ubah nama sesuai kebutuhan

    $image->storeAs('public', $imageName);

    Product::create([
      'name' => $request->name,
      'price' => $request->price,
      'stock' => $request->stock,
      'description' => $request->description,
      'image' => $imageName,
    ]);

    return redirect()->route('product.index')->with(['success' => 'Data Berhasil Disimpan!']);
  }

  /**
   * Display the specified resource.
   */
  public function show(Product $product)
  {
    return view('product.show', compact('product'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Product $product)
  {
    return view('product.edit', compact('product'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateProductRequest $request, Product $product)
  {
    $this->validate($request, [
      'name' => 'required|min:5',
      'price' => 'required|numeric',
      'stock' => 'required|numeric',
      'description' => 'min:5',
      'image' => 'image|mimes:jpeg,jpg,png|max:2048',
    ]);

    if ($request->hasFile('image')) {
      $image = $request->file('image');
      $imageName = 'products/' . $image->hashName();
      $image->storeAs('public', $imageName);

      if ($product->image) {
        Storage::delete('public/' . $product->image);
      }

      $product->update([
        'name' => $request->name,
        'price' => $request->price,
        'stock' => $request->stock,
        'description' => $request->description,
        'image' => $imageName,
      ]);
    } else {
      $product->update([
        'name' => $request->name,
        'price' => $request->price,
        'stock' => $request->stock,
        'description' => $request->description,
      ]);
    }


    return redirect()->route('product.index')->with(['success' => 'Data Berhasil Diubah!']);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Product $product)
  {
    $product->delete();
    return Redirect::route('product.index');
  }
}