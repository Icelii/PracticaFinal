<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    public function index()
    {
        $productos = Product::all();

        return view('welcome', compact('productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_producto' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imgpath = null;
        if ($request->hasFile('image')) {
            $imgpath = $request->file('image')->store('images', 'public');
        }

        $producto = Product::create([
            'nombre_producto' => $request->nombre_producto,
            'precio' => $request->precio,
            'descripcion' => $request->descripcion,
            'image' => $request->image ? $request->file('image')->getClientOriginalName() : null,
            'imgpath' => $imgpath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Producto creado.',
            'producto' => $producto,
        ]);
    }

}
