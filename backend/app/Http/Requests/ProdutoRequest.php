<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdutoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $produto = $this->route('produto');

        return [
            'categoria_id' => 'required|exists:categorias,id',

            'nome' => 'required|string|max:255',

            'codigo' => 'required|string|max:100|unique:produtos,codigo,' . $produto,

            'marca' => 'nullable|string|max:255',

            'descricao' => 'nullable|string',

            'preco' => 'required|numeric|min:0',

            'estoque' => 'required|integer|min:0',

            'destaque' => 'boolean',

            'ativo' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'categoria_id.required' => 'Selecione uma categoria.',
            'categoria_id.exists' => 'Categoria inválida.',

            'nome.required' => 'Informe o nome do produto.',

            'codigo.required' => 'Informe o código do produto.',
            'codigo.unique' => 'Este código já está cadastrado.',

            'preco.required' => 'Informe o preço.',
            'preco.numeric' => 'Preço inválido.',

            'estoque.required' => 'Informe o estoque.',
        ];
    }
}