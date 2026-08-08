@extends('admin.layouts.app')

@section('content')

<style>
    .produto-container {
        max-width: 1000px;
        margin: 0 auto;
    }

    .produto-header {
        margin-bottom: 25px;
    }

    .produto-header h1 {
        color: #111827;
        font-size: 28px;
        margin-bottom: 5px;
    }

    .produto-header p {
        color: #64748b;
    }

    .produto-card {
        background: white;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,.06);
        margin-bottom: 25px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-group {
        margin-bottom: 20px;
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
    }

    textarea {
        min-height: 130px;
        resize: vertical;
    }

    input:focus,
    select:focus,
    textarea:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,.1);
    }

    .promocao {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        padding: 18px;
        border-radius: 12px;
    }

    .promocao label {
        color: #166534;
    }

    .ajuda {
        display: block;
        color: #64748b;
        font-size: 13px;
        margin-top: 6px;
    }

    .checkbox-area {
        display: flex;
        gap: 25px;
        margin: 10px 0 25px;
    }

    .checkbox {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .checkbox input {
        width: auto;
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

    .btn-secondary {
        background: #64748b;
        color: white;
    }

    .btn-danger {
        background: #dc2626;
        color: white;
    }

    .botoes {
        display: flex;
        gap: 12px;
        margin-top: 25px;
    }

    .erro {
        color: #dc2626;
        font-size: 13px;
        margin-top: 5px;
    }

    .imagem-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 15px;
    }

    .imagem-item {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 10px;
        background: #f8fafc;
    }

    .imagem-item img {
        width: 100%;
        height: 160px;
        object-fit: cover;
        border-radius: 8px;
        display: block;
    }

    .imagem-item form {
        margin-top: 10px;
    }

    @media(max-width:700px) {
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

    <h1>
        ✏️ Editar Produto
    </h1>

    <p>
        Atualize as informações do produto.
    </p>

</div>


@if(session('success'))

    <div
        style="
            background:#dcfce7;
            color:#166534;
            padding:15px;
            border-radius:10px;
            margin-bottom:20px;
        "
    >
        {{ session('success') }}
    </div>

@endif


@if($errors->any())

    <div
        style="
            background:#fee2e2;
            color:#991b1b;
            padding:15px;
            border-radius:10px;
            margin-bottom:20px;
        "
    >

        <strong>
            Corrija os seguintes erros:
        </strong>

        <ul style="padding-left:20px;margin-top:8px;">

            @foreach($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

    </div>

@endif


{{-- DADOS DO PRODUTO --}}

<div class="produto-card">

    <form
        method="POST"
        action="{{ route('admin.produtos.update', $produto) }}"
        enctype="multipart/form-data"
    >

        @csrf

        @method('PUT')


        <div class="form-group">

            <label for="categoria_id">
                Categoria
            </label>

            <select
                id="categoria_id"
                name="categoria_id"
                required
            >

                @foreach($categorias as $categoria)

                    <option
                        value="{{ $categoria->id }}"
                        {{ old('categoria_id', $produto->categoria_id) == $categoria->id ? 'selected' : '' }}
                    >
                        {{ $categoria->nome }}
                    </option>

                @endforeach

            </select>

        </div>


        <div class="form-row">

            <div class="form-group">

                <label for="nome">
                    Nome
                </label>

                <input
                    type="text"
                    id="nome"
                    name="nome"
                    value="{{ old('nome', $produto->nome) }}"
                    required
                >

            </div>


            <div class="form-group">

                <label for="sku">
                    SKU
                </label>

                <input
                    type="text"
                    id="sku"
                    name="sku"
                    value="{{ old('sku', $produto->sku) }}"
                >

            </div>

        </div>


        <div class="form-row">

            <div class="form-group">

                <label for="marca">
                    Marca
                </label>

                <input
                    type="text"
                    id="marca"
                    name="marca"
                    value="{{ old('marca', $produto->marca) }}"
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
                    value="{{ old('unidade', $produto->unidade) }}"
                >

            </div>

        </div>


        {{-- PREÇOS --}}

        <div class="form-row">

            <div class="form-group">

                <label for="preco">
                    💰 Preço normal
                </label>

                <input
                    type="number"
                    id="preco"
                    name="preco"
                    step="0.01"
                    min="0"
                    value="{{ old('preco', $produto->preco) }}"
                    required
                >

                @error('preco')

                    <div class="erro">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            <div class="form-group promocao">

                <label for="preco_promocional">
                    🏷️ Preço promocional
                </label>

                <input
                    type="number"
                    id="preco_promocional"
                    name="preco_promocional"
                    step="0.01"
                    min="0"
                    value="{{ old('preco_promocional', $produto->preco_promocional) }}"
                    placeholder="Sem promoção"
                >

                <span class="ajuda">
                    Deixe vazio para remover a promoção.
                </span>

                @error('preco_promocional')

                    <div class="erro">
                        {{ $message }}
                    </div>

                @enderror

            </div>

        </div>


        <div class="form-row">

            <div class="form-group">

                <label for="estoque">
                    📦 Estoque
                </label>

                <input
                    type="number"
                    id="estoque"
                    name="estoque"
                    min="0"
                    value="{{ old('estoque', $produto->estoque) }}"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    🖼️ Nova imagem
                </label>

                <input
                    type="file"
                    name="imagem"
                    accept="image/*"
                >

            </div>

        </div>


        <div class="form-group">

            <label for="descricao">
                📝 Descrição
            </label>

            <textarea
                id="descricao"
                name="descricao"
            >{{ old('descricao', $produto->descricao) }}</textarea>

        </div>


        <div class="checkbox-area">

            <label class="checkbox">

                <input
                    type="checkbox"
                    name="ativo"
                    value="1"
                    {{ old('ativo', $produto->ativo) ? 'checked' : '' }}
                >

                Produto ativo

            </label>


            <label class="checkbox">

                <input
                    type="checkbox"
                    name="destaque"
                    value="1"
                    {{ old('destaque', $produto->destaque) ? 'checked' : '' }}
                >

                ⭐ Produto em destaque

            </label>

        </div>


        <div class="botoes">

            <button
                type="submit"
                class="btn btn-primary"
            >
                💾 Atualizar Produto
            </button>


            <a
                href="{{ route('admin.produtos.index') }}"
                class="btn btn-secondary"
            >
                ← Cancelar
            </a>

        </div>

    </form>

</div>


{{-- IMAGENS --}}

<div class="produto-card">

    <h2 style="margin-bottom:20px;">
        🖼️ Imagens do produto
    </h2>


    <form
        method="POST"
        action="{{ route('admin.produtos.imagem.store', $produto) }}"
        enctype="multipart/form-data"
        style="margin-bottom:25px;"
    >

        @csrf

        <input
            type="file"
            name="imagem"
            accept="image/*"
            required
        >

        <button
            type="submit"
            class="btn btn-primary"
            style="margin-top:10px;"
        >
            ➕ Adicionar imagem
        </button>

    </form>


    @if($produto->imagens->count())

        <div class="imagem-grid">

            @foreach($produto->imagens as $imagem)

                <div class="imagem-item">

                    <img
                        src="{{ asset('storage/' . $imagem->imagem) }}"
                        alt="{{ $produto->nome }}"
                    >


                    <form
                        method="POST"
                        action="{{ route('admin.produtos.imagem.destroy', $imagem) }}"
                    >

                        @csrf

                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn btn-danger"
                            style="width:100%;"
                            onclick="return confirm('Deseja excluir esta imagem?')"
                        >
                            🗑️ Excluir
                        </button>

                    </form>

                </div>

            @endforeach

        </div>

    @else

        <p style="color:#64748b;">
            Nenhuma imagem cadastrada.
        </p>

    @endif

</div>


</div>

@endsection
