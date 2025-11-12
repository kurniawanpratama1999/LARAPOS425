<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Product;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $datas = Product::with('categories')->get();
        return view('pages.products.index', compact('datas'));
    }
    public function create()
    {
        $categories = Categories::all();
        return view('pages.products.create', compact('categories',));
    }
    public function edit(string $id)
    {
        $datas = Product::with('categories')->find($id);
        $categories = Categories::all();
        return view('pages.products.create', compact('datas', 'categories'));
    }
    public function search(Request $request)
    {
        $q = request()->query('q');

        $datas = Product::with('categories');
        if ($q != '') {

            $datas->where(function ($query) use ($q) {
                $query
                    ->where('name', 'like', '%' . $q . '%')
                    ->orWhere('description', 'like', '%' . $q . '%')
                    ->orWhere('price', 'like', '%' . $q . '%')
                    ->orWhere('category_id', 'like', '%' . $q . '%');
            });
        }

        $datas = $datas->get();

        $html = view('partials.ProductsTableBody', compact('datas', 'q'))->render();

        return response()->json(['html' => $html]);
    }
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'categories_id' => 'required|integer|exists:categories,id',
            'photo_product' => 'required|image|mimes:jpg,jpeg,png|max:1000',
            'description' => 'nullable|string',
            'price' => 'required|integer',
            'quantity' => 'nullable|integer',
        ]);

        if ($request->hasFile('photo_product')) {
            $photoPath = $request->file('photo_product')->store('products', 'public');
        }


        try {
            Product::create([
                'name' => $validate['name'],
                'categories_id' => $validate['categories_id'],
                'description' => $validate['description'],
                'photo_product' => $photoPath,
                'price' => $validate['price'],
                'quantity' => 0,
                'status' => 1,
            ]);

            return redirect()->route('products.index')
                ->with('floatingAlert', [
                    'title' => 'Success',
                    'type' => 'success',
                    'message' => 'Berhasil menambah product baru'
                ]);
        } catch (\Throwable $err) {
            return redirect()->back()->with('floatingAlert', ['title' => 'Failed', 'type' => 'error', 'message' => 'Gagal menambah product baru $err']);
        }
    }
    public function update(Request $request, string $id)
    {

        try {
            $validate = $request->validate([
                'name' => 'required|string|max:255',
                'categories_id' => 'required|integer|exists:categories,id',
                'photo_product' => 'nullable|image|mimes:jpg,jpeg,png|max:1000',
                'description' => 'nullable|string',
                'price' => 'required|integer',
                'quantity' => 'nullable|integer',
                'status' => 'required|integer',
            ]);

            $product = Product::findOrFail($id);

            if ($request->hasFile('photo_product')) {
                // hapus file lama (jika ada)
                if ($product->photo_product && Storage::disk('public')->exists($product->photo_product)) {
                    Storage::disk('public')->delete($product->photo_product);
                }

                // simpan file baru
                $validate['photo_product'] = $request->file('photo_product')->store('products', 'public');
            } else {
                // kalau tidak upload file baru, pertahankan file lama
                $validate['photo_product'] = $product->photo_product;
            }

            $product->update($validate);

            return redirect()->route('products.index')
                ->with('floatingAlert', [
                    'title' => 'Update Product Success',
                    'type' => 'success',
                    'message' => ""
                ]);
        } catch (\Throwable $err) {
            return redirect()->back()->withInput($request->except('password'))->with('floatingAlert', ['title' => 'Gagal Update Product', 'type' => 'error', 'message' => ""]);
        }
    }
    public function destroys(Request $request)
    {
        try {
            $ids = $request->query('id');
            Product::destroy($ids);
            $count = count($ids);
            return redirect()->route('products.index')
                ->with('floatingAlert', ['title' => "Berhasil Hapus $count Product", 'type' => 'success', 'message' => ""]);
        } catch (\Throwable $th) {
            return redirect()->back()->with('floatingAlert', ['title' => 'Gagal Hapus Product', 'type' => 'error', 'message' => ""]);
        }
    }
}
