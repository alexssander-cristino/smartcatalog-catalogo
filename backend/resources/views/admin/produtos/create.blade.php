@extends('admin.layouts.app')

@section('content')

<style>
    .produto-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .produto-header {
        margin-bottom: 25px;
    }

    .produto-header h1 {
        font-size: 28px;
        color: #111827;
        margin-bottom: 6px;
    }

    .produto-header p {
        color: #64748b;
    }

    .produto-card {
        background: white;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, .06);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: 7px;
    }

    input,
    select,
    textarea {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #d1d5db;
        border-radius: 9px;
        font-size: 15px;
        font-family: inherit;
        background: white;
    }

    textarea {
        min-height: 120px;
        resize: vertical;
    }

    input:focus,
    select:focus,
    textarea:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .1);
    }

    .preco-promocao {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        padding: 18px;
        border-radius: 12px;
    }

    .preco-promocao label {
        color: #166534;
    }

    .preco-ajuda {
        margin-top: 6px;
        font-size: 13px;
        color: #64748b;
    }

    .checkbox-area {
        display: flex;
        gap: 25px;
        margin-top: 10px;
        margin-bottom: 25px;
    }

    .checkbox-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .checkbox-item input {
        width: auto;
    }

    .imagem-area {
        border: 2px dashed #cbd5e1;
        padding: 25px;
        border-radius: 12px;
        text-align: center;
        background: #f8fafc;
    }

    .botoes {
        display: flex;
        gap: 12px;
        margin-top: 30px;
    }

    .btn {
        border: none;
        padding: 13px 25px;
        border-radius: 9px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }

    .btn-primary {
        background: #2563eb;
        color: white;
    }

    .btn-primary:hover {
        background: #1d4ed8;
    }

    .btn-secondary {
        background: #64748b;
        color: white;
    }

    .erro {
        color: #dc2626;
        font-size: 13px;
        margin-top: 5px;
    }

    .alert {
        background: #fee2e2;
        color: #991b1b;
        padding: 15px;
        border-radius: 9px;
        margin-bottom: 20px;
    }

    @media(max-width: 700px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .checkbox-area {
            flex-direction: column;
            gap: 12px;
        }
    }
</style>

<div class="produto-container">


<div class="produto-header">
    <h1>➕ Novo Produto</h1>
    <p>Cadastre um novo produto no catálogo.</p>
</div>

@if($errors->any())
    <div class="alert">
        <strong>Corrija os seguintes erros:</strong>

        <ul style="margin-top: 8px; padding-left: 20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="produto-card">

    <form
        method="POST"
        action="{{ route('admin.produtos.store') }}"
        enctype="multipart/form-data"
    >

        @csrf

        {{-- Categoria --}}
        <div class="form-group">

            <label for="categoria_id">
                Categoria
            </label>

            <select
                name="categoria_id"
                id="categoria_id"
                required
            >

                <option value="">
                    Selecione uma categoria
                </option>

                @foreach($categorias as $categoria)

                    <option
                        value="{{ $categoria->id }}"
                        {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}
                    >
                        {{ $categoria->nome }}
                    </option>

                @endforeach

            </select>

            @error('categoria_id')
                <div class="erro">
                    {{ $message }}
                </div>
            @enderror

        </div>

        {{-- Nome e SKU --}}
        <div class="form-row">

            <div class="form-group">

                <label for="nome">
                    Nome do produto
                </label>

                <input
                    type="text"
                    id="nome"
                    name="nome"
                    value="{{ old('nome') }}"
                    placeholder="Ex.: Camiseta Básica"
                    required
                >

                @error('nome')
                    <div class="erro">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="form-group">

                <label for="sku">
                    SKU
                </label>

                <input
                    type="text"
                    id="sku"
                    name="sku"
                    value="{{ old('sku') }}"
                    placeholder="Ex.: CAM-001"
                >

                @error('sku')
                    <div class="erro">
                        {{ $message }}
                    </div>
                @enderror

            </div>

        </div>

        {{-- Marca e Unidade --}}
        <div class="form-row">

            <div class="form-group">

                <label for="marca">
                    Marca
                </label>

                <input
                    type="text"
                    id="marca"
                    name="marca"
                    value="{{ old('marca') }}"
                    placeholder="Ex.: Nike"
                >

            </div>

            <div class="form-group">

                <label for="unidade">
                    Unidade
                </label>

                <input
                    type="text"
                    id="unidade"
                    name="unidade"
                    value="{{ old('unidade', 'un') }}"
                    placeholder="Ex.: un, kg, cx"
                >

            </div>

        </div>

        {{-- Preços --}}
        <div class="form-row">

            <div class="form-group">

                <label for="preco">
                    Preço normal
                </label>

                <input
                    type="number"
                    id="preco"
                    name="preco"
                    step="0.01"
                    min="0"
                    value="{{ old('preco') }}"
                    placeholder="0,00"
                    required
                >

                @error('preco')
                    <div class="erro">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="form-group preco-promocao">

                <label for="preco_promocional">
                    🏷️ Preço promocional
                </label>

                <input
                    type="number"
                    id="preco_promocional"
                    name="preco_promocional"
                    step="0.01"
                    min="0"
                    value="{{ old('preco_promocional') }}"
                    placeholder="Deixe vazio se não houver promoção"
                >

                <div class="preco-ajuda">
                    Deve ser menor que o preço normal.
                </div>

                @error('preco_promocional')
                    <div class="erro">
                        {{ $message }}
                    </div>
                @enderror

            </div>

        </div>

        {{-- Estoque --}}
        <div class="form-row">

            <div class="form-group">

                <label for="estoque">
                    Estoque
                </label>

                <input
                    type="number"
                    id="estoque"
                    name="estoque"
                    min="0"
                    value="{{ old('estoque', 0) }}"
                    required
                >

                @error('estoque')
                    <div class="erro">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="form-group">

                <label>
                    Imagem principal
                </label>

                <div class="imagem-area">

                    <input
                        type="file"
                        name="imagem"
                        accept="image/*"
                    >

                    <p style="margin-top:8px;color:#64748b;font-size:13px;">
                        JPG, PNG, WEBP — máximo 2 MB
                    </p>

                </div>

                @error('imagem')
                    <div class="erro">
                        {{ $message }}
                    </div>
                @enderror

            </div>

        </div>

        {{-- Descrição --}}
        <div class="form-group">

            <label for="descricao">
                Descrição
            </label>

            <textarea
                id="descricao"
                name="descricao"
                placeholder="Descreva o produto..."
            >{{ old('descricao') }}</textarea>

            @error('descricao')
                <div class="erro">
                    {{ $message }}
                </div>
            @enderror

        </div>

        {{-- Opções --}}
        <div class="checkbox-area">

            <label class="checkbox-item">

                <input
                    type="checkbox"
                    name="ativo"
                    value="1"
                    {{ old('ativo', true) ? 'checked' : '' }}
                >

                Produto ativo

            </label>

            <label class="checkbox-item">

                <input
                    type="checkbox"
                    name="destaque"
                    value="1"
                    {{ old('destaque') ? 'checked' : '' }}
                >

                ⭐ Produto em destaque

            </label>

        </div>

        {{-- Botões --}}
        <div class="botoes">

            <button
                type="submit"
                class="btn btn-primary"
            >
                💾 Salvar Produto
            </button>

            <a
                href="{{ route('admin.produtos.index') }}"
                class="btn btn-secondary"
            >
                ← Cancelar
            </a>

        </div>

    </form>

<div>


</div>

@endsection
