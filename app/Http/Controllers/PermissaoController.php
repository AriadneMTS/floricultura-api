<?php

namespace App\Http\Controllers;

use App\Models\Permissao;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class PermissaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dados = Permissao::get();

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

        $permisao = Permissao::create($dados);

        return Response()->json($permisao, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $permisao = Permissao::find($id);

        if(!$permisao) {
            return Response()->json([], 404);
        }

        return Response()->json($permisao);
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

        $permissao = Permissao::find($id);

        $permissao->updade($dados);

        return Response()->json([], 204);
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Permissao::destroy($id);

        return Response()->json([], 204);
    }
}
