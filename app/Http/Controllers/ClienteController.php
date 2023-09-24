<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        if (!auth()->user()->tokenCan('cliente-index')) {
            return Response()->json([
                "message" => "Sem permissão"
            ], 403);
        }

        $dados = Cliente::get();

        return Response()->json($dados);
    }

    public function store(Request $request)
    {
        if (!auth()->user()->tokenCan('cliente-store')) {
            return Response()->json([
                "message" => "Sem permissão"
            ], 403);
        }

        $dados = $request->except('_token');

        $cliente = Cliente::create($dados);

        return Response()->json($cliente, 201);
    }

    public function show(string $id)
    {
        if (!auth()->user()->tokenCan('cliente-show')) {
            return Response()->json([
                "message" => "Sem permissão"
            ], 403);
        }

        $cliente = Cliente::find($id);

        if(!$cliente) {
            return Response()->json([], 404);
        }

        return Response()->json($cliente);
    }

    public function update(Request $request, string $id)
    {
        if (!auth()->user()->tokenCan('cliente-update')) {
            return Response()->json([
                "message" => "Sem permissão"
            ], 403);
        }

        $dados = $request->except('_token');

        $cliente = Cliente::find($id);

        $cliente->update($dados);

        return Response()->json([], 204);
    }

    public function destroy(string $id)
    {
        if (!auth()->user()->tokenCan('cliente-destroy')) {
            return Response()->json([
                "message" => "Sem permissão"
            ], 403);
        }

        Cliente::destroy($id);

        return Response()->json([], 204);
    }
}
