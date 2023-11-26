<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class ColaboradorController extends Controller
{
    public function index()
    {
        if (!auth()->user()->tokenCan('colaborador-index')) {
            return Response()->json([
                "message" => "Colaborador sem permissão para listar colaboradores."
            ], 403);
        }

        $colaborador = Colaborador::with('funcao')->get();

        return Response()->json($colaborador);
    }

    public function store(Request $request)
    {
        if (!auth()->user()->tokenCan('colaborador-store')) {
            return Response()->json([
                "message" => "Colaborador sem permissão para cadastrar colaborador."
            ], 403);
        }

        $dados = $request->except('_token');

        $cpfExists = Colaborador::where('cpf', $dados["cpf"])->first();

        if ($cpfExists) {
            return Response()->json([
                "message" => "Já existe colaborador cadastrado com esse CPF."
            ], 403);
        }

        $emailExists = Colaborador::where('email', $dados["email"])->first();

        if ($emailExists) {
            return Response()->json([
                "message" => "Já existe colaborador cadastrado com esse email."
            ], 403);
        }

        $dados["password"] = bcrypt($request->password);

        $colaborador = Colaborador::create($dados);

        return Response()->json($colaborador, 201);
    }

    public function show(string $id)
    {
        if (!auth()->user()->tokenCan('colaborador-show')) {
            return Response()->json([
                "message" => "Colaborador sem permissão para visualizar colaborador."
            ], 403);
        }

        $colaborador = Colaborador::find($id);

        if (!$colaborador) {
            return Response()->json([], 404);
        }

        return Response()->json($colaborador);
    }

    public function update(Request $request, string $id)
    {
        if (!auth()->user()->tokenCan('colaborador-update')) {
            return Response()->json([
                "message" => "Colaborador sem permissão para editar colaborador."
            ], 403);
        }

        $dados = $request->except('_token');

        if (array_key_exists("cpf", $dados)) {
            $cpfExists = Colaborador::where('cpf', $dados["cpf"])->first();

            if ($cpfExists && $cpfExists->id !== intval($id)) {
                return Response()->json([
                    "message" => "Já existe colaborador cadastrado com esse CPF."
                ], 403);
            }
        }

        if (array_key_exists("email", $dados)) {
            $emailExists = Colaborador::where('email', $dados["email"])->first();

            if ($emailExists && $emailExists->id !== intval($id)) {
                return Response()->json([
                    "message" => "Já existe colaborador cadastrado com esse email."
                ], 403);
            }
        }

        if (array_key_exists("password", $dados)) {
            $dados["password"] = bcrypt($request->password);
        }

        $colaborador = Colaborador::find($id);

        $colaborador->update($dados);

        return Response()->json([], 204);
    }

    public function destroy(string $id)
    {
        if (!auth()->user()->tokenCan('colaborador-destroy')) {
            return Response()->json([
                "message" => "Colaborador sem permissão para excluir colaborador."
            ], 403);
        }

        if ($id == 1) {
            return Response()->json([
                "message" => "Não é possível deletar o usuário administrador."
            ], 403);
        }

        $colaborador = Colaborador::find($id);

        if (sizeof($colaborador->vendas()->get()) > 0) {
            return Response()->json([
                "message" => "Não foi possível deletar o pois há vendas vinculadas a esse colaborador."
            ], 403);
        }

        $colaborador->delete();

        return Response()->json([], 204);
    }
}
