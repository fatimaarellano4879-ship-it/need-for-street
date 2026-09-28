<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all();

        return view('productos.index', compact('productos'));
    }


    public function create()
    {
        return view('productos.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric',
        ]);

        Producto::create([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
        ]);

        Log::info('Nuevo producto registrado: ' . $request->nombre);

        return redirect('/productos')
            ->with('success', 'Producto registrado correctamente');
    }
}
