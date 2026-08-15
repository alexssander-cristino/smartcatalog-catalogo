@extends('layouts.app')

@section('title', 'Carrossel')

@section('content')

<style>

    .carrossel-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .pagina-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 25px;
    }

    .pagina-header h1 {
        margin: 0;
        font-size: 28px;
        font-weight: 800;
        color: #111827;
    }

    .pagina-header p {
        margin: 6px 0 0;
        color: #64748b;
    }

    .btn {
        border: none;
        border-radius: 10px;
        padding: 11px 17px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        transition: .2s;
    }

    .btn-primary {
        background: #2563eb;
        color: white;
    }

    .btn-primary:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
    }

    .mensagem {
        background: #f0fdf4;
        color: #166534;
        border: 1px solid #bbf7d0;
        padding: 14px 16px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .lista {
        display: grid;
        grid-template-columns: repeat(
            auto-fill,
            minmax(280px, 1fr)
        );
        gap: 20px;
    }

    .card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 5px 18px rgba(15, 23, 42, .06);
    }

    .preview {
        height: 210px;
        background: #0f172a;
        position: relative;
        overflow: hidden;
    }

    .preview img,
    .preview video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .preview video {
        background: #000;
    }

    .tipo {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(15, 23, 42, .85);
        color: white;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
    }

    .ordem {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #2563eb;
        color: white;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
    }

    .card-body {
        padding: 17px;
    }

    .card-body h2 {
        margin: 0 0 6px;
        color: #111827;
        font-size: 17px;
    }

    .descricao {
        color: #64748b;
        font-size: 13px;
        min-height: 20px;
        margin-bottom: 15px;
    }

    .status {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 800;
        margin-bottom: 15px;
    }

    .ativo {
        background: #dcfce7;
        color: #166534;
    }

    .inativo {
        background: #f1f5f9;
        color: #64748b;
    }

    .acoes {
        display: flex;
        gap: 8px;
        border-top: 1px solid #eef2f7;
        padding-top: 14px;
    }

    .acoes form {
        flex: 1;
        margin: 0;
    }

    .acoes button {
        width: 100%;
    }

    .btn-toggle {
        background: #f1f5f9;
        color: #475569;
    }

    .btn-toggle:hover {
        background: #e2e8f0;
    }

    .btn-excluir {
        background: #fef2f2;
        color: #dc2626;
    }

    .btn-excluir:hover {
        background: #fee2e2;
    }

    .vazio {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 60px 20px;
        text-align: center;
        color: #64748b;
        box-shadow: 0 5px 18px rgba(15, 23, 42, .06);
    }

    .vazio .icone {
        font-size: 50px;
        margin-bottom: 12px;
    }

    .vazio strong {
        display: block;
        font-size: 18px;
        color: #1e293b;
        margin-bottom: 6px;
    }

    @media (max-width: 700px) {

        .pagina-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .pagina-header .btn {
            width: 100%;
        }

        .lista {
            grid-template-columns: 1fr;
        }

    }

</style>


<div class="carrossel-container">

    {{-- CABEÇALHO --}}

    <div class="pagina-header">

        <div>

            <h1>
                🎞️ Carrossel do catálogo
            </h1>

            <p>
                Gerencie as imagens e vídeos exibidos no catálogo.
            </p>

        </div>


        <a
            href="{{ route('admin.carrossel.create') }}"
            class="btn btn-primary"
        >
            + Adicionar conteúdo
        </a>

    </div>


    {{-- MENSAGEM --}}

    @if(session('success'))

        <div class="mensagem">
            {{ session('success') }}
        </div>

    @endif


    {{-- LISTA --}}

    @if($carrosseis->count())

        <div class="lista">

            @foreach($carrosseis as $item)

                <div class="card">

                    {{-- PREVIEW --}}

                    <div class="preview">

                        @if($item->tipo === 'video')

                            <video
                                controls
                                muted
                                preload="metadata"
                            >
                                <source
                                    src="{{ asset('storage/' . $item->arquivo) }}"
                                >

                                Seu navegador não suporta vídeo.
                            </video>

                            <div class="tipo">
                                🎥 Vídeo
                            </div>

                        @else

                            <img
                                src="{{ asset('storage/' . $item->arquivo) }}"
                                alt="{{ $item->titulo ?: 'Imagem do carrossel' }}"
                            >

                            <div class="tipo">
                                🖼️ Imagem
                            </div>

                        @endif


                        <div class="ordem">
                            Ordem: {{ $item->ordem }}
                        </div>

                    </div>


                    {{-- INFORMAÇÕES --}}

                    <div class="card-body">

                        <h2>
                            {{ $item->titulo ?: 'Sem título' }}
                        </h2>


                        <div class="descricao">

                            {{ $item->descricao ?: 'Sem descrição.' }}

                        </div>


                        @if($item->ativo)

                            <span class="status ativo">
                                ● Ativo
                            </span>

                        @else

                            <span class="status inativo">
                                ● Inativo
                            </span>

                        @endif


                        {{-- AÇÕES --}}

                        <div class="acoes">

                            {{-- ATIVAR / DESATIVAR --}}

                            <form
                                method="POST"
                                action="{{ route(
                                    'admin.carrossel.toggle',
                                    $item
                                ) }}"
                            >

                                @csrf

                                @method('PATCH')

                                <button
                                    type="submit"
                                    class="btn btn-toggle"
                                >

                                    {{ $item->ativo
                                        ? 'Desativar'
                                        : 'Ativar'
                                    }}

                                </button>

                            </form>


                            {{-- EXCLUIR --}}

                            <form
                                method="POST"
                                action="{{ route(
                                    'admin.carrossel.destroy',
                                    $item
                                ) }}"
                                onsubmit="return confirm(
                                    'Deseja realmente excluir este conteúdo?'
                                );"
                            >

                                @csrf

                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-excluir"
                                >
                                    Excluir
                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        {{-- ESTADO VAZIO --}}

        <div class="vazio">

            <div class="icone">
                🎞️
            </div>

            <strong>
                Nenhum conteúdo no carrossel
            </strong>

            <p>
                Adicione uma imagem ou vídeo para começar.
            </p>

            <br>

            <a
                href="{{ route('admin.carrossel.create') }}"
                class="btn btn-primary"
            >
                + Adicionar conteúdo
            </a>

        </div>

    @endif

</div>

@endsection