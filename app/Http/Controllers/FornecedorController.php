<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dados = Fornecedor::get();

        return Response()->json($dados);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dados = $request->except('_token');

        $fornecedor = Fornecedor::create($dados);

        return Response()->json($fornecedor, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $fornecedor = Fornecedor::find($id);

        if(!$fornecedor) {
            return Response()->json([], 404);
        }

        return Response()->json($fornecedor);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dados = $request->except('_token');

        $fornecedor = Fornecedor::find($id);

        $fornecedor->update($dados);

        return Response()->json([], 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Fornecedor::destroy($id);

        return Response()->json([], 204);
    }
}
