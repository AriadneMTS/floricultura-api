<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index()
    {
        if (!auth()->user()->tokenCan('produto-index')) {
            return Response()->json([
                "message" => "Colaborador sem permissão para listar produtos."
            ], 403);
        }

        $dados = Produto::get();

        return Response()->json($dados);
    }

    public function store(Request $request)
    {
        if (!auth()->user()->tokenCan('produto-store')) {
            return Response()->json([
                "message" => "Colaborador sem permissão para cadastrar produto."
            ], 403);
        }

        $dados = $request->except('_token');

        if (!$request->hasFile('imagem') || !$request->file('imagem')->isValid()) {

            $dados["imagem_url"] = 'produto-default.png';
        }

        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            $requestImage = $request->imagem;

            $extension = $requestImage->extension();

            $imageName = md5($requestImage->getClientOriginalName() . strtotime('now')) . '.' . $extension;

            $requestImage->move(public_path('images/produtos'), $imageName);

            $dados["imagem_url"] = $imageName;
        }

        $produto = Produto::create($dados);

        return Response()->json($produto, 201);
    }

    public function show(string $id)
    {
        if (!auth()->user()->tokenCan('produto-show')) {
            return Response()->json([
                "message" => "Colaborador sem permissão para visualizar produto."
            ], 403);
        }

        $produto = Produto::find($id);

        if(!$produto) {
            return Response()->json([], 404);
        }

        return Response()->json($produto);
    }

    public function update(Request $request, string $id)
    {
        if (!auth()->user()->tokenCan('produto-update')) {
            return Response()->json([
                "message" => "Colaborador sem permissão para editar produto."
            ], 403);
        }

        $dados = $request->except('_token');

        $produto = Produto::find($id);

        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            $requestImage = $request->imagem;

            $extension = $requestImage->extension();

            $imageName = md5($requestImage->getClientOriginalName() . strtotime('now')) . '.' . $extension;

            $requestImage->move(public_path('images/produtos'), $imageName);

            $dados["imagem_url"] = $imageName;

            // Deleta imagem atual caso ja tenha cadastrada
            if($produto->imagem_url !== "produto-default.png") {
                $image_path = public_path('images/produtos').'/'.$produto->imagem_url;
                unlink($image_path);
            }
        }

        $produto->update($dados);

        return Response()->json([], 204);
    }

    public function destroy(string $id)
    {
        if (!auth()->user()->tokenCan('produto-destroy')) {
            return Response()->json([
                "message" => "Colaborador sem permissão para excluir produto."
            ], 403);
        }

        $produto = Produto::find($id);

        if (sizeof($produto->vendas()->get()) > 0) {
            return Response()->json([
                "message" => "Não foi possível deletar o pois há vendas vinculadas a esse produto."
            ], 403);
        }

        if($produto->imagem_url !== "produto-default.png") {
            $image_path = public_path('images/produtos').'/'.$produto->imagem_url;
            unlink($image_path);
        }

        $produto->delete();

        return Response()->json([], 204);
    }
}
