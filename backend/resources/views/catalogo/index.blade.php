@extends('layouts.catalogo')

@section('content')

<style>

/* =========================================================
   LAYOUT PRINCIPAL
========================================================= */

.catalogo-layout {

    max-width: 1500px;

    margin: 0 auto;

    display: grid;

    grid-template-columns:
        minmax(0, 1fr)
        330px;

    gap: 30px;

    align-items: start;

}


/* =========================================================
   ÁREA PRINCIPAL
========================================================= */

.catalogo-principal {

    min-width: 0;

}


/* =========================================================
   CABEÇALHO
========================================================= */

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


/* =========================================================
   FILTROS
========================================================= */

.filtros-box {

    background: white;

    padding: 20px;

    border-radius: 16px;

    box-shadow:
        0 4px 18px rgba(0, 0, 0, .06);

    margin-bottom: 20px;

}

.filtros {

    display: grid;

    grid-template-columns:
        minmax(0, 1fr)
        230px
        140px;

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

    box-shadow:
        0 0 0 3px rgba(37, 99, 235, .10);

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


/* =========================================================
   CATEGORIAS
========================================================= */

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


/* =========================================================
   GRID DOS PRODUTOS
========================================================= */

.produtos-grid {

    display: grid;

    grid-template-columns:
        repeat(
            auto-fill,
            minmax(240px, 1fr)
        );

    gap: 22px;

}


/* =========================================================
   CARD DO PRODUTO
========================================================= */

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

    box-shadow:
        0 5px 18px rgba(15, 23, 42, .06);

    transition:
        transform .25s ease,
        box-shadow .25s ease,
        border-color .25s ease;

    height: 100%;

}

.produto-card:hover {

    transform: translateY(-5px);

    box-shadow:
        0 12px 30px rgba(15, 23, 42, .12);

    border-color: #dbeafe;

}


/* =========================================================
   IMAGEM DO PRODUTO
========================================================= */

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

    transition: transform .3s ease;

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


/* =========================================================
   BADGES
========================================================= */

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

    box-shadow:
        0 3px 10px rgba(0, 0, 0, .15);

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

    box-shadow:
        0 3px 10px rgba(0, 0, 0, .15);

}


/* =========================================================
   INFORMAÇÕES
========================================================= */

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


/* =========================================================
   PREÇOS
========================================================= */

.preco-area {

    margin-top: 15px;

    padding-top: 14px;

    border-top:
        1px solid #eef2f7;

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


/* =========================================================
   BOTÃO DETALHES
========================================================= */

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


/* =========================================================
   NENHUM PRODUTO
========================================================= */

.nenhum-produto {

    background: white;

    padding: 50px 25px;

    border-radius: 16px;

    text-align: center;

    color: #64748b;

    grid-column: 1 / -1;

    box-shadow:
        0 4px 18px rgba(0, 0, 0, .05);

}

.nenhum-produto .icone {

    font-size: 42px;

    margin-bottom: 10px;

}


/* =========================================================
   CARROSSEL LATERAL
========================================================= */

.carrossel-lateral {

    width: 100%;

    position: sticky;

    top: 20px;

}


/* =========================================================
   CARROSSEL 9:16
========================================================= */

.carrossel {

    position: relative;

    width: 100%;

    aspect-ratio: 9 / 16;

    background: #111827;

    border-radius: 18px;

    overflow: hidden;

    box-shadow:
        0 10px 35px rgba(15, 23, 42, .18);

}


/* =========================================================
   ITEM
========================================================= */

.carrossel-item {

    position: absolute;

    inset: 0;

    width: 100%;

    height: 100%;

    opacity: 0;

    visibility: hidden;

    pointer-events: none;

    transition:
        opacity .5s ease,
        visibility .5s ease;

}

.carrossel-item.ativo {

    opacity: 1;

    visibility: visible;

    pointer-events: auto;

}


/* =========================================================
   IMAGEM / VÍDEO
========================================================= */

.carrossel-media {

    width: 100%;

    height: 100%;

    display: block;

    object-fit: cover;

}


/* =========================================================
   LEGENDA
========================================================= */

.carrossel-legenda {

    position: absolute;

    left: 0;

    right: 0;

    bottom: 0;

    padding:
        60px 18px 18px;

    color: white;

    background:
        linear-gradient(
            to bottom,
            transparent,
            rgba(0, 0, 0, .92)
        );

    display: flex;

    flex-direction: column;

    gap: 5px;

}

.carrossel-legenda strong {

    font-size: 18px;

    font-weight: 800;

}

.carrossel-legenda span {

    font-size: 13px;

    line-height: 1.4;

    opacity: .9;

}


/* =========================================================
   CARROSSEL VAZIO
========================================================= */

.carrossel-vazio {

    width: 100%;

    aspect-ratio: 9 / 16;

    background: white;

    border-radius: 18px;

    display: flex;

    align-items: center;

    justify-content: center;

    text-align: center;

    padding: 25px;

    color: #94a3b8;

    box-shadow:
        0 5px 18px rgba(15, 23, 42, .06);

}

.carrossel-vazio div {

    font-size: 40px;

}

.carrossel-vazio p {

    margin-top: 10px;

    font-size: 14px;

}


/* =========================================================
   RESPONSIVO - TABLET
========================================================= */

@media (max-width: 1150px) {

    .catalogo-layout {

        grid-template-columns:
            minmax(0, 1fr)
            280px;

        gap: 20px;

    }

    .produtos-grid {

        grid-template-columns:
            repeat(
                2,
                minmax(0, 1fr)
            );

    }

}


/* =========================================================
   RESPONSIVO - CELULAR
========================================================= */

@media (max-width: 850px) {

    .catalogo-layout {

        display: flex;

        flex-direction: column;

        gap: 25px;

    }

    /*
     * No celular o carrossel fica
     * acima dos produtos.
     */

    .carrossel-lateral {

        position: relative;

        top: auto;

        order: 2;

        width: min(
            100%,
            380px
        );

        margin: 0 auto;

    }

    .catalogo-principal {

        order: 1;

        width: 100%;

    }

}


/* =========================================================
   FILTROS MOBILE
========================================================= */

@media (max-width: 700px) {

    .filtros {

        grid-template-columns: 1fr;

    }

    .btn {

        min-height: 45px;

    }

    .produtos-grid {

        grid-template-columns:
            repeat(
                2,
                minmax(0, 1fr)
            );

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


/* =========================================================
   CELULAR PEQUENO
========================================================= */

@media (max-width: 500px) {

    .produtos-grid {

        grid-template-columns: 1fr;

    }

    .produto-imagem-area {

        height: 260px;

    }

    .carrossel-lateral {

        width: min(
            100%,
            330px
        );

    }

}


/* =========================================================
   CONTROLES DO CARROSSEL
========================================================= */

.carrossel-controles {

    position: absolute;

    left: 0;

    right: 0;

    bottom: 10px;

    display: flex;

    justify-content: center;

    gap: 6px;

    z-index: 10;

}

.carrossel-ponto {

    width: 8px;

    height: 8px;

    border-radius: 50%;

    background: rgba(255,255,255,.45);

    transition: .2s;

}

.carrossel-ponto.ativo {

    width: 22px;

    border-radius: 10px;

    background: white;

}

</style>


<div class="catalogo-layout">


    {{-- =====================================================
         CATÁLOGO PRINCIPAL
    ====================================================== --}}

    <div class="catalogo-principal">


        {{-- =================================================
             CABEÇALHO
        ================================================== --}}

        <div class="catalogo-header">

            <h1>
                🛍️ Catálogo
            </h1>

            <p>
                Encontre o produto que você procura.
            </p>

        </div>


        {{-- =================================================
             FILTROS
        ================================================== --}}

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


        {{-- =================================================
             CATEGORIAS
        ================================================== --}}

        <div class="categorias">

            <a
                href="{{ route('catalogo.index') }}"
                class="categoria"
            >
                Todas
            </a>


            @foreach ($categorias as $categoria)

                <a
                    href="{{ route(
                        'catalogo.index',
                        ['categoria' => $categoria->id]
                    ) }}"
                    class="categoria"
                >

                    {{ $categoria->nome }}

                </a>

            @endforeach

        </div>


        {{-- =================================================
             PRODUTOS
        ================================================== --}}

        <div class="produtos-grid">


            @forelse ($produtos as $produto)


                <a
                    href="{{ route(
                        'catalogo.produto',
                        $produto->id
                    ) }}"
                    class="produto-link"
                >


                    <div class="produto-card">


                        {{-- IMAGEM --}}

                        <div class="produto-imagem-area">


                            @if($produto->destaque)

                                <div class="destaque">
                                    ⭐ Destaque
                                </div>

                            @endif


                            @if(
                                $produto->preco_promocional &&
                                $produto->preco_promocional > 0 &&
                                $produto->preco_promocional < $produto->preco
                            )

                                <div class="badge-promocao">
                                    🔥 Oferta
                                </div>

                            @endif


                            @if($produto->imagens->count())

                                <img
                                    src="{{ asset(
                                        'storage/' .
                                        $produto->imagens->first()->imagem
                                    ) }}"
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


                                @if(
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

                        Tente pesquisar por outro
                        nome ou categoria.

                    </p>

                </div>


            @endforelse


        </div>


    </div>


    {{-- =====================================================
         CARROSSEL LATERAL DIREITO
    ====================================================== --}}

    <aside class="carrossel-lateral">


        @if(isset($carrosseis) && $carrosseis->count())


            <div class="carrossel">


                @foreach($carrosseis as $index => $item)


                    <div
                        class="carrossel-item {{ $index === 0 ? 'ativo' : '' }}"
                        data-index="{{ $index }}"
                    >


                        {{-- VÍDEO --}}

                        @if($item->tipo === 'video')


                            <video
                                class="carrossel-media"
                                muted
                                playsinline
                                preload="metadata"
                            >

                                <source
                                    src="{{ asset(
                                        'storage/' . $item->arquivo
                                    ) }}"
                                >

                                Seu navegador não suporta vídeos.

                            </video>


                        {{-- IMAGEM --}}

                        @else


                            <img
                                src="{{ asset(
                                    'storage/' . $item->arquivo
                                ) }}"
                                alt="{{ $item->titulo ?? 'Carrossel' }}"
                                class="carrossel-media"
                            >


                        @endif


                        {{-- LEGENDA --}}

                        @if(
                            $item->titulo ||
                            $item->descricao
                        )

                            <div class="carrossel-legenda">


                                @if($item->titulo)

                                    <strong>
                                        {{ $item->titulo }}
                                    </strong>

                                @endif


                                @if($item->descricao)

                                    <span>
                                        {{ $item->descricao }}
                                    </span>

                                @endif


                            </div>

                        @endif


                    </div>


                @endforeach


                {{-- INDICADORES --}}

                @if($carrosseis->count() > 1)

                    <div class="carrossel-controles">

                        @foreach($carrosseis as $index => $item)

                            <span
                                class="carrossel-ponto {{ $index === 0 ? 'ativo' : '' }}"
                                data-slide="{{ $index }}"
                            ></span>

                        @endforeach

                    </div>

                @endif


            </div>


        @else


            <div class="carrossel-vazio">

                <div>

                    📺

                    <p>
                        Nenhum conteúdo
                        no carrossel.
                    </p>

                </div>

            </div>


        @endif


    </aside>


</div>


{{-- =========================================================
     JAVASCRIPT DO CARROSSEL
========================================================= --}}

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {


        const itens =
            document.querySelectorAll(
                '.carrossel-item'
            );


        const pontos =
            document.querySelectorAll(
                '.carrossel-ponto'
            );


        if (!itens.length) {

            return;

        }


        let atual = 0;

        let temporizador = null;


        /* =====================================================
           PARA TODOS OS VÍDEOS
        ====================================================== */

        function pararVideos() {

            itens.forEach(function(item) {


                const video =
                    item.querySelector('video');


                if (video) {

                    video.pause();

                    video.currentTime = 0;

                    video.onended = null;

                }


            });

        }


        /* =====================================================
           ATUALIZA INDICADORES
        ====================================================== */

        function atualizarPontos(index) {

            pontos.forEach(function(ponto, i) {

                ponto.classList.toggle(
                    'ativo',
                    i === index
                );

            });

        }


        /* =====================================================
           PRÓXIMO
        ====================================================== */

        function proximo() {

            clearTimeout(
                temporizador
            );


            let novoIndice =
                atual + 1;


            if (
                novoIndice >=
                itens.length
            ) {

                novoIndice = 0;

            }


            mostrarItem(
                novoIndice
            );

        }


        /* =====================================================
           MOSTRAR ITEM
        ====================================================== */

        function mostrarItem(index) {


            clearTimeout(
                temporizador
            );


            pararVideos();


            itens.forEach(function(item) {

                item.classList.remove(
                    'ativo'
                );

            });


            atual = index;


            if (
                atual < 0 ||
                atual >= itens.length
            ) {

                atual = 0;

            }


            const item =
                itens[atual];


            item.classList.add(
                'ativo'
            );


            atualizarPontos(
                atual
            );


            /* =================================================
               VÍDEO
            ================================================== */

            const video =
                item.querySelector('video');


            if (video) {


                video.currentTime = 0;


                const playPromise =
                    video.play();


                if (
                    playPromise !== undefined
                ) {


                    playPromise
                        .catch(function() {


                            /*
                             * Caso o navegador
                             * bloqueie o autoplay.
                             */

                            temporizador =
                                setTimeout(
                                    proximo,
                                    5000
                                );

                        });

                }


                video.onended =
                    function() {

                        proximo();

                    };


            }


            /* =================================================
               IMAGEM
            ================================================== */

            else {


                temporizador =
                    setTimeout(
                        proximo,
                        5000
                    );

            }

        }


        /* =====================================================
           CLIQUE NOS INDICADORES
        ====================================================== */

        pontos.forEach(function(
            ponto,
            index
        ) {


            ponto.addEventListener(
                'click',
                function() {

                    mostrarItem(
                        index
                    );

                }
            );


        });


        /* =====================================================
           INICIA
        ====================================================== */

        mostrarItem(0);


    }

);

</script>

@endsection