@extends('layouts.catalogo')

@section('content')

<style>
    .detalhes {
        max-width: 1100px;
        margin: 40px auto;
        padding: 20px;
    }

    .voltar {
        display: inline-block;
        margin-bottom: 20px;
        color: #2563eb;
        text-decoration: none;
        font-weight: 600;
    }

    .produto {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        background: white;
        padding: 30px;
        border-radius: 18px;
        box-shadow: 0 6px 25px rgba(0,0,0,.08);
    }

    .imagem-principal {
        width: 100%;
        height: 450px;
        object-fit: cover;
        border-radius: 14px;
        background: #f1f5f9;
    }

    .sem-imagem {
        height: 450px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f1f5f9;
        border-radius: 14px;
        color: #94a3b8;
    }

    .categoria {
        display: inline-block;
        background: #eff6ff;
        color: #2563eb;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 12px;
    }

    h1 {
        font-size: 34px;
        color: #111827;
        margin-bottom: 10px;
    }

    .marca {
        color: #64748b;
        font-size: 16px;
        margin-bottom: 20px;
    }

    .descricao {
        color: #475569;
        line-height: 1.7;
        margin: 25px 0;
    }

    .preco-normal {
        color: #111827;
        font-size: 32px;
        font-weight: 800;
        margin-top: 20px;
    }

    .preco-antigo {
        color: #94a3b8;
        text-decoration: line-through;
        font-size: 17px;
        margin-top: 20px;
    }

    .preco-promocional {
        color: #16a34a;
        font-size: 36px;
        font-weight: 900;
        margin-top: 3px;
    }

    .badge-promocao {
        display: inline-block;
        margin-top: 10px;
        background: #dc2626;
        color: white;
        padding: 7px 12px;
        border-radius: 7px;
        font-size: 12px;
        font-weight: 700;
    }

    .informacoes {
        border-top: 1px solid #e2e8f0;
        margin-top: 25px;
        padding-top: 20px;
    }

    .info {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .info strong {
        color: #374151;
    }

    .info span {
        color: #64748b;
    }

    .voltar-btn {
        display: inline-block;
        margin-top: 25px;
        background: #2563eb;
        color: white;
        text-decoration: none;
        padding: 12px 22px;
        border-radius: 9px;
        font-weight: 600;
    }

    @media(max-width:800px) {

        .produto {
            grid-template-columns: 1fr;
        }

        .imagem-principal,
        .sem-imagem {
            height: 320px;
        }

        h1 {
            font-size: 27px;
        }

    }
</style>

<div class="detalhes">


<a
    href="{{ route('catalogo.index') }}"
    class="voltar"
>
    ← Voltar para o catálogo
</a>


<div class="produto">

    {{-- IMAGEM --}}

    <div>

        @if($produto->imagens->count())

            <img
                src="{{ asset('storage/' . $produto->imagens->first()->imagem) }}"
                alt="{{ $produto->nome }}"
                class="imagem-principal"
            >

        @else

            <div class="sem-imagem">
                Sem imagem disponível
            </div>

        @endif

    </div>


    {{-- INFORMAÇÕES --}}

    <div>

        @if($produto->categoria)

            <div class="categoria">
                {{ $produto->categoria->nome }}
            </div>

        @endif


        <h1>
            {{ $produto->nome }}
        </h1>


        <div class="marca">

            Marca:
            <strong>
                {{ $produto->marca ?? 'Não informada' }}
            </strong>

        </div>


        @if($produto->descricao)

            <div class="descricao">

                {{ $produto->descricao }}

            </div>

        @endif


        {{-- PREÇO --}}

        @if(
            $produto->preco_promocional &&
            $produto->preco_promocional < $produto->preco
        )

            <div class="preco-antigo">
                R$
                {{ number_format($produto->preco, 2, ',', '.') }}
            </div>

            <div class="preco-promocional">
                R$
                {{ number_format($produto->preco_promocional, 2, ',', '.') }}
            </div>

            <span class="badge-promocao">
                🔥 OFERTA ESPECIAL
            </span>

        @else

            <div class="preco-normal">
                R$
                {{ number_format($produto->preco, 2, ',', '.') }}
            </div>

        @endif


        <div class="informacoes">

            @if($produto->sku)

                <div class="info">

                    <strong>
                        SKU
                    </strong>

                    <span>
                        {{ $produto->sku }}
                    </span>

                </div>

            @endif


            <div class="info">

                <strong>
                    Estoque
                </strong>

                <span>

                    @if($produto->estoque > 0)

                        Disponível ({{ $produto->estoque }} {{ $produto->estoque == 1 ? 'unidade' : 'unidades' }})

                    @else

                        Indisponível

                    @endif

                </span>

            </div>


            @if($produto->unidade)

                <div class="info">

                    <strong>
                        Unidade
                    </strong>

                    <span>
                        {{ $produto->unidade }}
                    </span>

                </div>

            @endif

        </div>


        <a
            href="{{ route('catalogo.index') }}"
            class="voltar-btn"
        >
            ← Continuar navegando
        </a>

    </div>

</div>


</div>

@endsection