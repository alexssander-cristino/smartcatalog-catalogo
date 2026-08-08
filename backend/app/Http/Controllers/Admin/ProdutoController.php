<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{
    /**
     * Lista os produtos.
     */
    public function index()
    {
        $produtos = Produto::with([
            'categoria',
            'imagens',
        ])
            ->orderBy('nome')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Categorias
        |--------------------------------------------------------------------------
        | Enviamos as categorias para o index porque a página de produtos
        | também utiliza o filtro por categoria.
        |--------------------------------------------------------------------------
        */

        $categorias = Categoria::where('ativo', true)
            ->orderBy('nome')
            ->get();

        return view(
            'admin.produtos.index',
            compact(
                'produtos',
                'categorias'
            )
        );
    }

    /**
     * Formulário de cadastro.
     */
    public function create()
    {
        $categorias = Categoria::where('ativo', true)
            ->orderBy('nome')
            ->get();

        return view(
            'admin.produtos.create',
            compact('categorias')
        );
    }

    /**
     * Cadastra um novo produto.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'categoria_id' => [
                    'required',
                    'exists:categorias,id',
                ],

                'sku' => [
                    'nullable',
                    'string',
                    'max:100',
                ],

                'nome' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'marca' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                'descricao' => [
                    'nullable',
                    'string',
                ],

                'preco' => [
                    'required',
                    'numeric',
                    'min:0',
                ],

                'preco_promocional' => [
                    'nullable',
                    'numeric',
                    'min:0',
                    'lt:preco',
                ],

                'estoque' => [
                    'required',
                    'integer',
                    'min:0',
                ],

                'unidade' => [
                    'nullable',
                    'string',
                    'max:20',
                ],

                'imagem' => [
                    'nullable',
                    'image',
                    'max:2048',
                ],
            ],
            [
                'categoria_id.required' =>
                    'Selecione uma categoria.',

                'categoria_id.exists' =>
                    'A categoria selecionada não existe.',

                'nome.required' =>
                    'Informe o nome do produto.',

                'preco.required' =>
                    'Informe o preço do produto.',

                'preco.numeric' =>
                    'O preço deve ser um valor numérico.',

                'preco.min' =>
                    'O preço não pode ser negativo.',

                'preco_promocional.numeric' =>
                    'O preço promocional deve ser um valor numérico.',

                'preco_promocional.min' =>
                    'O preço promocional não pode ser negativo.',

                'preco_promocional.lt' =>
                    'O preço promocional deve ser menor que o preço normal.',

                'estoque.required' =>
                    'Informe o estoque.',

                'estoque.integer' =>
                    'O estoque deve ser um número inteiro.',

                'estoque.min' =>
                    'O estoque não pode ser negativo.',

                'imagem.image' =>
                    'O arquivo enviado precisa ser uma imagem.',

                'imagem.max' =>
                    'A imagem não pode ter mais de 2 MB.',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Criação do produto
        |--------------------------------------------------------------------------
        */

        $produto = Produto::create([
            'categoria_id' => $request->categoria_id,

            'sku' => $request->sku,

            'nome' => $request->nome,

            'marca' => $request->marca,

            'descricao' => $request->descricao,

            'preco' => $request->preco,

            'preco_promocional' =>
                $request->preco_promocional,

            'estoque' => $request->estoque,

            'unidade' => $request->unidade,

            'ativo' =>
                $request->boolean('ativo'),

            'destaque' =>
                $request->boolean('destaque'),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Upload da imagem principal
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('imagem')) {
            $arquivo = $request
                ->file('imagem')
                ->store(
                    'produtos',
                    'public'
                );

            $produto->imagens()->create([
                'imagem' => $arquivo,
            ]);
        }

        return redirect()
            ->route('admin.produtos.index')
            ->with(
                'success',
                'Produto cadastrado com sucesso.'
            );
    }

    /**
     * Exibe os detalhes do produto no painel.
     */
    public function show(Produto $produto)
    {
        $produto->load([
            'categoria',
            'imagens',
        ]);

        return view(
            'admin.produtos.show',
            compact('produto')
        );
    }

    /**
     * Formulário de edição.
     */
    public function edit(Produto $produto)
    {
        $produto->load([
            'categoria',
            'imagens',
        ]);

        $categorias = Categoria::where('ativo', true)
            ->orderBy('nome')
            ->get();

        return view(
            'admin.produtos.edit',
            compact(
                'produto',
                'categorias'
            )
        );
    }

    /**
     * Atualiza um produto.
     */
    public function update(
        Request $request,
        Produto $produto
    ) {
        $request->validate(
            [
                'categoria_id' => [
                    'required',
                    'exists:categorias,id',
                ],

                'sku' => [
                    'nullable',
                    'string',
                    'max:100',
                ],

                'nome' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'marca' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                'descricao' => [
                    'nullable',
                    'string',
                ],

                'preco' => [
                    'required',
                    'numeric',
                    'min:0',
                ],

                'preco_promocional' => [
                    'nullable',
                    'numeric',
                    'min:0',
                    'lt:preco',
                ],

                'estoque' => [
                    'required',
                    'integer',
                    'min:0',
                ],

                'unidade' => [
                    'nullable',
                    'string',
                    'max:20',
                ],

                'imagem' => [
                    'nullable',
                    'image',
                    'max:2048',
                ],
            ],
            [
                'categoria_id.required' =>
                    'Selecione uma categoria.',

                'categoria_id.exists' =>
                    'A categoria selecionada não existe.',

                'nome.required' =>
                    'Informe o nome do produto.',

                'preco.required' =>
                    'Informe o preço do produto.',

                'preco.numeric' =>
                    'O preço deve ser um valor numérico.',

                'preco.min' =>
                    'O preço não pode ser negativo.',

                'preco_promocional.numeric' =>
                    'O preço promocional deve ser um valor numérico.',

                'preco_promocional.min' =>
                    'O preço promocional não pode ser negativo.',

                'preco_promocional.lt' =>
                    'O preço promocional deve ser menor que o preço normal.',

                'estoque.required' =>
                    'Informe o estoque.',

                'estoque.integer' =>
                    'O estoque deve ser um número inteiro.',

                'estoque.min' =>
                    'O estoque não pode ser negativo.',

                'imagem.image' =>
                    'O arquivo enviado precisa ser uma imagem.',

                'imagem.max' =>
                    'A imagem não pode ter mais de 2 MB.',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Atualização do produto
        |--------------------------------------------------------------------------
        */

        $produto->update([
            'categoria_id' => $request->categoria_id,

            'sku' => $request->sku,

            'nome' => $request->nome,

            'marca' => $request->marca,

            'descricao' => $request->descricao,

            'preco' => $request->preco,

            'preco_promocional' =>
                $request->preco_promocional,

            'estoque' => $request->estoque,

            'unidade' => $request->unidade,

            'ativo' =>
                $request->boolean('ativo'),

            'destaque' =>
                $request->boolean('destaque'),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Adicionar nova imagem
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('imagem')) {
            $arquivo = $request
                ->file('imagem')
                ->store(
                    'produtos',
                    'public'
                );

            $produto->imagens()->create([
                'imagem' => $arquivo,
            ]);
        }

        return redirect()
            ->route('admin.produtos.index')
            ->with(
                'success',
                'Produto atualizado com sucesso.'
            );
    }

    /**
     * Exclui um produto.
     */
    public function destroy(Produto $produto)
    {
        /*
        |--------------------------------------------------------------------------
        | Excluir imagens do storage
        |--------------------------------------------------------------------------
        */

        $produto->load('imagens');

        foreach ($produto->imagens as $imagem) {
            if (
                Storage::disk('public')
                    ->exists($imagem->imagem)
            ) {
                Storage::disk('public')
                    ->delete($imagem->imagem);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Excluir o produto
        |--------------------------------------------------------------------------
        */

        $produto->delete();

        return redirect()
            ->route('admin.produtos.index')
            ->with(
                'success',
                'Produto removido com sucesso.'
            );
    }
}

