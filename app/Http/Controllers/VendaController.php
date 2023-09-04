<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class VendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dados = Venda::get();

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

        $venda = Venda::create($dados);

        return Response()->json($venda, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $venda = Venda::find($id);

        if(!$venda) {
            return Response()->json([], 404);
        }

        return Response()->json($venda);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dados = $request->except('_token');

        $venda = Venda::find($id);

        $venda->update($dados);

        return Response()->json([], 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Venda::destroy($id);

        return Response()->json([], 204);
    }
}
