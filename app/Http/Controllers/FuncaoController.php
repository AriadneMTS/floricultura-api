<?php

namespace App\Http\Controllers;

use App\Models\Funcao;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;

class FuncaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dados = Funcao::get();

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

        $funcao = Funcao::create($dados);

        return Response()->json($funcao, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $funcao = Funcao::find($id);

        if(!$funcao) {
            return Response()->json([], 404);
        }

        return Response()->json($funcao);
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

        $funcao = Funcao::find($id);

        $funcao->update($dados);

        return Response()->json([], 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Funcao::destroy($id);

        return Response()->json([], 204);
    }
}
