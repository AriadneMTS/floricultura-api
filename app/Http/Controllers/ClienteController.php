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
                "message" => "Colaborador sem permissão para listar clientes."
            ], 403);
        }

        $dados = Cliente::get();

        return Response()->json($dados);
    }

    public function store(Request $request)
    {
        if (!auth()->user()->tokenCan('cliente-store')) {
            return Response()->json([
                "message" => "Colaborador sem permissão para cadastrar cliente."
            ], 403);
        }

        $dados = $request->except('_token');

        $cpfExists = Cliente::where('cpf', $dados["cpf"])->first();

        if ($cpfExists) {
            return Response()->json([
                "message" => "Já existe cliente cadastrado com esse CPF."
            ], 403);
        }

        $cliente = Cliente::create($dados);

        return Response()->json($cliente, 201);
    }

    public function show(string $id)
    {
        if (!auth()->user()->tokenCan('cliente-show')) {
            return Response()->json([
                "message" => "Colaborador sem permissão para visualizar cliente."
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
                "message" => "Colaborador sem permissão para editar cliente."
            ], 403);
        }

        $dados = $request->except('_token');

        $cpfExists = Cliente::where('cpf', $dados["cpf"])->first();

        if ($cpfExists && $cpfExists->id !== intval($id)) {
            return Response()->json([
                "message" => "Já existe cliente cadastrado com esse CPF."
            ], 403);
        }

        $cliente = Cliente::find($id);

        $cliente->update($dados);

        return Response()->json([], 204);
    }

    public function destroy(string $id)
    {
        if (!auth()->user()->tokenCan('cliente-destroy')) {
            return Response()->json([
                "message" => "Colaborador sem permissão para excluir cliente."
            ], 403);
        }

        $cliente = Cliente::find($id);

        if (sizeof($cliente->compras()->get()) > 0) {
            return Response()->json([
                "message" => "Não foi possível deletar o pois há vendas vinculadas a esse cliente."
            ], 403);
        }

        $cliente->delete();

        return Response()->json([], 204);
    }
}
