<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    public function index()
    {
        if (!auth()->user()->tokenCan('fornecedor-index')) {
            return Response()->json([
                "message" => "Colaborador sem permissão para listar fornecedores."
            ], 403);
        }

        $dados = Fornecedor::get();

        return Response()->json($dados);
    }

    public function store(Request $request)
    {
        if (!auth()->user()->tokenCan('fornecedor-store')) {
            return Response()->json([
                "message" => "Colaborador sem permissão para cadastrar fornecedor."
            ], 403);
        }

        $dados = $request->except('_token');

        $cnpjExists = Fornecedor::where('cnpj', $dados["cnpj"])->first();

        if ($cnpjExists) {
            return Response()->json([
                "message" => "Já existe fornecedor cadastrado com esse CNPJ."
            ], 403);
        }

        $fornecedor = Fornecedor::create($dados);

        return Response()->json($fornecedor, 201);
    }

    public function show(string $id)
    {
        if (!auth()->user()->tokenCan('fornecedor-show')) {
            return Response()->json([
                "message" => "Colaborador sem permissão para visualizar fornecedor."
            ], 403);
        }

        $fornecedor = Fornecedor::find($id);

        if(!$fornecedor) {
            return Response()->json([], 404);
        }

        return Response()->json($fornecedor);
    }

    public function update(Request $request, string $id)
    {
        if (!auth()->user()->tokenCan('fornecedor-update')) {
            return Response()->json([
                "message" => "Colaborador sem permissão para editar fornecedor."
            ], 403);
        }

        $dados = $request->except('_token');

        $cnpjExists = Fornecedor::where('cnpj', $dados["cnpj"])->first();

        if ($cnpjExists && $cnpjExists->id !== intval($id)) {
            return Response()->json([
                "message" => "Já existe fornecedor cadastrado com esse CNPJ."
            ], 403);
        }

        $fornecedor = Fornecedor::find($id);

        $fornecedor->update($dados);

        return Response()->json([], 204);
    }

    public function destroy(string $id)
    {
        if (!auth()->user()->tokenCan('fornecedor-destroy')) {
            return Response()->json([
                "message" => "Colaborador sem permissão para excluir fornecedor."
            ], 403);
        }

        $fornecedor = Fornecedor::find($id);

        if ($fornecedor->produtos->all()) {
            return Response()->json([
                "message" => "Não foi possível deletar pois existem um ou mais produtos cadastrados com esse fornecedor."
            ], 409);
        }

        Fornecedor::destroy($id);

        return Response()->json([], 204);
    }
}
