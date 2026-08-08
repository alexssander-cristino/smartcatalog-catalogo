@extends('layouts.catalogo')

@section('content')

<style>

    .catalogo-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    /* CABEÇALHO */

    .catalogo-header {
        margin-bottom: 25px;
    }

    .catalogo-header h1 {
        font-size: 32px;
        color: #111827;
        margin-bottom: 6px;
    }

    .catalogo-header p {
        color: #64748b;
        font-size: 16px;
    }


    /* FILTROS */

    .filtros-box {
        background: white;
        padding: 20px;
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, .06);
        margin-bottom: 20px;
    }

    .filtros {
        display: grid;
        grid-template-columns: 1fr 230px 140px;
        gap: 12px;
    }

    .input {
        width: 100%;
        padding: 13px 15px;
        border: 1px solid #dbe1ea;
        border-radius: 10px;
        background: #f8fafc;
        font-size: 15px;
        color: #1e293b;
        transition: .2s;
    }

    .input:focus {
        outline: none;
        border-color: #2563eb;
        background: white;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .10);
    }

    .btn {
        border: none;
        border-radius: 10px;
        background: #2563eb;
        color: white;
        font-weight: 600;
        cursor: pointer;
        transition: .2s;
        font-size: 15px;
    }

    .btn:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
    }


    /* CATEGORIAS */

    .categorias {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 25px;
    }

    .categoria {
        background: white;
        color: #475569;
        text-decoration: none;
        padding: 9px 15px;
        border-radius: 999px;
        border: 1px solid #e2e8f0;
        font-size: 14px;
        font-weight: 500;
        transition: .2s;
    }

    .categoria:hover {
        background: #2563eb;
        color: white;
        border-color: #2563eb;
        transform: translateY(-1px);
    }


    /* GRID */

    .produtos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 22px;
    }


    /* CARD */

    .produto-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .produto-card {
        position: relative;
        background: white;
        border-radius: 18px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
        box-shadow: 0 5px 18px rgba(15, 23, 42, .06);
        transition: .25s;
        height: 100%;
    }

    .produto-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(15, 23, 42, .12);
        border-color: #dbeafe;
    }


    /* IMAGEM */

    .produto-imagem-area {
        position: relative;
        height: 250px;
        background: #f8fafc;
        overflow: hidden;
    }

    .produto-imagem {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: .3s;
    }

    .produto-card:hover .produto-imagem {
        transform: scale(1.04);
    }

    .sem-imagem {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        font-size: 15px;
    }


    /* BADGES */

    .destaque {
        position: absolute;
        top: 12px;
        left: 12px;
        z-index: 2;
        background: #f59e0b;
        color: white;
        padding: 7px 11px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        box-shadow: 0 3px 10px rgba(0, 0, 0, .15);
    }

    .badge-promocao {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 2;
        background: #dc2626;
        color: white;
        padding: 7px 11px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        box-shadow: 0 3px 10px rgba(0, 0, 0, .15);
    }


    /* INFORMAÇÕES */

    .produto-info {
        padding: 18px;
    }

    .produto-info h2 {
        color: #111827;
        font-size: 18px;
        margin-bottom: 10px;
        line-height: 1.3;
    }

    .produto-info p {
        color: #64748b;
        font-size: 13px;
        margin-bottom: 5px;
    }

    .produto-info strong {
        color: #475569;
    }


    /* PREÇOS */

    .preco-area {
        margin-top: 15px;
        padding-top: 14px;
        border-top: 1px solid #eef2f7;
    }

    .preco-normal {
        color: #94a3b8;
        text-decoration: line-through;
        font-size: 13px;
        margin-bottom: 3px;
    }

    .preco-promocional {
        color: #16a34a;
        font-size: 24px;
        font-weight: 800;
    }

    .preco {
        color: #111827;
        font-size: 24px;
        font-weight: 800;
    }

    .promocao {
        color: #dc2626;
        font-size: 12px;
        font-weight: 700;
        margin-top: 4px;
    }


    /* BOTÃO */

    .ver-detalhes {
        display: block;
        width: 100%;
        margin-top: 15px;
        padding: 10px;
        text-align: center;
        border-radius: 9px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 13px;
        font-weight: 700;
        transition: .2s;
    }

    .produto-card:hover .ver-detalhes {
        background: #2563eb;
        color: white;
    }


    /* VAZIO */

    .nenhum-produto {
        background: white;
        padding: 50px 25px;
        border-radius: 16px;
        text-align: center;
        color: #64748b;
        grid-column: 1 / -1;
        box-shadow: 0 4px 18px rgba(0, 0, 0, .05);
    }

    .nenhum-produto .icone {
        font-size: 42px;
        margin-bottom: 10px;
    }


    /* RESPONSIVO */

    @media (max-width: 800px) {

        .filtros {
            grid-template-columns: 1fr;
        }

        .btn {
            min-height: 45px;
        }

        .produtos-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .produto-imagem-area {
            height: 200px;
        }

        .produto-info {
            padding: 14px;
        }

        .produto-info h2 {
            font-size: 16px;
        }

        .preco,
        .preco-promocional {
            font-size: 20px;
        }
    }


    @media (max-width: 500px) {

        .produtos-grid {
            grid-template-columns: 1fr;
        }

        .produto-imagem-area {
            height: 260px;
        }
    }

</style>

<div class="catalogo-container">


{{-- CABEÇALHO --}}

<div class="catalogo-header">

    <h1>
        🛍️ Catálogo
    </h1>

    <p>
        Encontre o produto que você procura.
    </p>

</div>


{{-- FILTROS --}}

<div class="filtros-box">

    <form
        method="GET"
        action="{{ route('catalogo.index') }}"
    >

        <div class="filtros">

            <input
                type="text"
                name="busca"
                placeholder="🔎 Pesquisar produto..."
                value="{{ request('busca') }}"
                class="input"
            >

            <select
                name="categoria"
                class="input"
            >

                <option value="">
                    Todas as categorias
                </option>

                @foreach ($categorias as $categoria)

                    <option
                        value="{{ $categoria->id }}"
                        {{ request('categoria') == $categoria->id ? 'selected' : '' }}
                    >

                        {{ $categoria->nome }}

                    </option>

                @endforeach

            </select>

            <button
                type="submit"
                class="btn"
            >

                Pesquisar

            </button>

        </div>

    </form>

</div>


{{-- CATEGORIAS --}}

<div class="categorias">

    <a
        href="{{ route('catalogo.index') }}"
        class="categoria"
    >

        Todas

    </a>

    @foreach ($categorias as $categoria)

        <a
            href="{{ route('catalogo.index', ['categoria' => $categoria->id]) }}"
            class="categoria"
        >

            {{ $categoria->nome }}

        </a>

    @endforeach

</div>


{{-- PRODUTOS --}}

<div class="produtos-grid">

    @forelse ($produtos as $produto)

        <a
            href="{{ route('catalogo.produto', $produto->id) }}"
            class="produto-link"
        >

            <div class="produto-card">


                {{-- ÁREA DA IMAGEM --}}

                <div class="produto-imagem-area">


                    {{-- DESTAQUE --}}

                    @if ($produto->destaque)

                        <div class="destaque">
                            ⭐ Destaque
                        </div>

                    @endif


                    {{-- PROMOÇÃO --}}

                    @if (
                        $produto->preco_promocional &&
                        $produto->preco_promocional > 0 &&
                        $produto->preco_promocional < $produto->preco
                    )

                        <div class="badge-promocao">
                            🔥 Oferta
                        </div>

                    @endif


                    {{-- IMAGEM --}}

                    @if ($produto->imagens->count())

                        <img
                            src="{{ asset('storage/' . $produto->imagens->first()->imagem) }}"
                            alt="{{ $produto->nome }}"
                            class="produto-imagem"
                        >

                    @else

                        <div class="sem-imagem">
                            📷 Sem imagem
                        </div>

                    @endif

                </div>


                {{-- INFORMAÇÕES --}}

                <div class="produto-info">

                    <h2>
                        {{ $produto->nome }}
                    </h2>


                    <p>

                        <strong>
                            Marca:
                        </strong>

                        {{ $produto->marca ?? 'Sem marca' }}

                    </p>


                    <p>

                        <strong>
                            Categoria:
                        </strong>

                        {{ $produto->categoria?->nome ?? '---' }}

                    </p>


                    {{-- PREÇO --}}

                    <div class="preco-area">

                        @if (
                            $produto->preco_promocional &&
                            $produto->preco_promocional > 0 &&
                            $produto->preco_promocional < $produto->preco
                        )

                            <div class="preco-normal">

                                R$
                                {{ number_format(
                                    $produto->preco,
                                    2,
                                    ',',
                                    '.'
                                ) }}

                            </div>

                            <div class="preco-promocional">

                                R$
                                {{ number_format(
                                    $produto->preco_promocional,
                                    2,
                                    ',',
                                    '.'
                                ) }}

                            </div>

                            <div class="promocao">

                                🔥 Em promoção

                            </div>

                        @else

                            <div class="preco">

                                R$
                                {{ number_format(
                                    $produto->preco,
                                    2,
                                    ',',
                                    '.'
                                ) }}

                            </div>

                        @endif

                    </div>


                    <div class="ver-detalhes">

                        Ver detalhes →

                    </div>

                </div>

            </div>

        </a>

    @empty

        <div class="nenhum-produto">

            <div class="icone">
                🔍
            </div>

            <strong>
                Nenhum produto encontrado
            </strong>

            <p style="margin-top:8px;">
                Tente pesquisar por outro nome ou categoria.
            </p>

        </div>

    @endforelse

</div>


</div>

@endsection
