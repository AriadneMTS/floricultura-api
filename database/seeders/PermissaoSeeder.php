<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissaos')->delete();

        // Ações relacionadas a Model Cliente
        DB::table('permissaos')->insert([
            [
                'descricao' => 'Listar clientes',
                'nome' => 'cliente-index',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'descricao' => 'Cadastrar cliente',
                'nome' => 'cliente-store',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'descricao' => 'Visualizar cliente',
                'nome' => 'cliente-show',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'descricao' => 'Editar cliente',
                'nome' => 'cliente-update',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'descricao' => 'Excluir cliente',
                'nome' => 'cliente-destroy',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
        ]);

        // Ações relacionadas a Model Colaborador
        DB::table('permissaos')->insert([
            [
                'descricao' => 'Listar colaboradores',
                'nome' => 'colaborador-index',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'descricao' => 'Cadastrar colaborador',
                'nome' => 'colaborador-store',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'descricao' => 'Visualizar colaborador',
                'nome' => 'colaborador-show',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'descricao' => 'Editar colaborador',
                'nome' => 'colaborador-update',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'descricao' => 'Excluir colaborador',
                'nome' => 'colaborador-destroy',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
        ]);

        // Ações relacionadas a Model Fornecedor
        DB::table('permissaos')->insert([
            [
                'descricao' => 'Listar fornecedores',
                'nome' => 'fornecedor-index',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'descricao' => 'Cadastrar fornecedor',
                'nome' => 'fornecedor-store',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'descricao' => 'Visualizar fornecedor',
                'nome' => 'fornecedor-show',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'descricao' => 'Editar fornecedor',
                'nome' => 'fornecedor-update',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'descricao' => 'Excluir fornecedor',
                'nome' => 'fornecedor-destroy',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
        ]);

        // Ações relacionadas a Model Funcao
        DB::table('permissaos')->insert([
            [
                'descricao' => 'Listar funções',
                'nome' => 'funcao-index',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'descricao' => 'Cadastrar função',
                'nome' => 'funcao-store',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'descricao' => 'Visualizar função',
                'nome' => 'funcao-show',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'descricao' => 'Editar função',
                'nome' => 'funcao-update',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'descricao' => 'Excluir função',
                'nome' => 'funcao-destroy',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
        ]);

        // Ações relacionadas a Model Produto
        DB::table('permissaos')->insert([
            [
                'descricao' => 'Listar produtos',
                'nome' => 'produto-index',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'descricao' => 'Cadastrar produto',
                'nome' => 'produto-store',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'descricao' => 'Visualizar produto',
                'nome' => 'produto-show',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'descricao' => 'Editar produto',
                'nome' => 'produto-update',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'descricao' => 'Excluir produto',
                'nome' => 'produto-destroy',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
        ]);

        // Ações relacionadas a Model Venda
        DB::table('permissaos')->insert([
            [
                'descricao' => 'Listar vendas',
                'nome' => 'venda-index',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'descricao' => 'Cadastrar venda',
                'nome' => 'venda-store',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'descricao' => 'Visualizar venda',
                'nome' => 'venda-show',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'descricao' => 'Editar venda',
                'nome' => 'venda-update',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'descricao' => 'Excluir venda',
                'nome' => 'venda-destroy',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
        ]);

        // Ações relacionadas a Model Permissao
        DB::table('permissaos')->insert([
            [
                'descricao' => 'Listar permissões',
                'nome' => 'permissao-index',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'descricao' => 'Cadastrar permissão',
                'nome' => 'permissao-store',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'descricao' => 'Visualizar permissão',
                'nome' => 'permissao-show',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'descricao' => 'Editar permissão',
                'nome' => 'permissao-update',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'descricao' => 'Excluir permissão',
                'nome' => 'permissao-destroy',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
        ]);
    }
}
