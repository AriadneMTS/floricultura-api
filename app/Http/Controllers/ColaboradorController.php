<?php

namespace App\Http\Controllers;
use App\Models\Colaborador;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class ColaboradorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dados = Colaborador::get();

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

        $colaborador = Colaborador::create($dados);

        return Response()->json($colaborador, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $colaborador = Colaborador::find($id);

        if(!$colaborador) {
            return Response()->json([], 404);
        }

        return Response()->json($colaborador);
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

        $colaborador = Colaborador::find($id);

        $colaborador->update($dados);

        return Response()->json([], 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        {
            Colaborador::destroy($id);
    
            return Response()->json([], 204);
        }
    }
}
