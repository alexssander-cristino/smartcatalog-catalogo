@extends('layouts.app')

@section('title', 'Adicionar conteúdo ao carrossel')

@section('content')

<style>

    .carrossel-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .pagina-header {
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

    .form-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 5px 18px rgba(15, 23, 42, .06);
    }

    .campo {
        margin-bottom: 20px;
    }

    .campo label {
        display: block;
        margin-bottom: 7px;
        color: #1e293b;
        font-size: 14px;
        font-weight: 700;
    }

    .campo small {
        display: block;
        margin-top: 6px;
        color: #94a3b8;
        font-size: 12px;
    }

    .campo input,
    .campo select,
    .campo textarea {
        width: 100%;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        padding: 12px 13px;
        font-size: 14px;
        color: #111827;
        background: white;
        outline: none;
        transition: .2s;
    }

    .campo input:focus,
    .campo select:focus,
    .campo textarea:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .10);
    }

    .campo textarea {
        min-height: 120px;
        resize: vertical;
    }

    .arquivo-area {
        border: 2px dashed #cbd5e1;
        border-radius: 14px;
        padding: 30px 20px;
        text-align: center;
        background: #f8fafc;
        transition: .2s;
    }

    .arquivo-area:hover {
        border-color: #2563eb;
        background: #eff6ff;
    }

    .arquivo-icone {
        font-size: 42px;
        margin-bottom: 10px;
    }

    .arquivo-area strong {
        display: block;
        color: #1e293b;
        font-size: 16px;
        margin-bottom: 5px;
    }

    .arquivo-area p {
        margin: 0 0 15px;
        color: #64748b;
        font-size: 13px;
    }

    .arquivo-area input[type="file"] {
        max-width: 100%;
        border: none;
        padding: 0;
        background: transparent;
    }

    .erro {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
        border-radius: 10px;
        padding: 14px 16px;
        margin-bottom: 20px;
    }

    .erro ul {
        margin: 0;
        padding-left: 20px;
    }

    .acoes {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        border-top: 1px solid #eef2f7;
        padding-top: 20px;
        margin-top: 10px;
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

    .btn-voltar {
        background: #f1f5f9;
        color: #475569;
    }

    .btn-voltar:hover {
        background: #e2e8f0;
    }

    .btn-primary {
        background: #2563eb;
        color: white;
    }

    .btn-primary:hover {
        background: #1d4ed8;
    }

    .grid {
        display: grid;
        grid-template-columns: 1fr 180px;
        gap: 18px;
    }

    @media (max-width: 700px) {

        .form-card {
            padding: 18px;
        }

        .grid {
            grid-template-columns: 1fr;
        }

        .acoes {
            flex-direction: column-reverse;
        }

        .acoes .btn {
            width: 100%;
        }

    }

</style>


<div class="carrossel-container">

    {{-- CABEÇALHO --}}

    <div class="pagina-header">

        <h1>
            🎞️ Adicionar conteúdo
        </h1>

        <p>
            Adicione uma imagem ou vídeo que será exibido no catálogo.
        </p>

    </div>


    {{-- ERROS DE VALIDAÇÃO --}}

    @if($errors->any())

        <div class="erro">

            <strong>
                Não foi possível adicionar o conteúdo:
            </strong>

            <ul>

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- FORMULÁRIO --}}

    <div class="form-card">

        <form
            method="POST"
            action="{{ route('admin.carrossel.store') }}"
            enctype="multipart/form-data"
        >

            @csrf


            {{-- TIPO E ORDEM --}}

            <div class="grid">

                {{-- TIPO --}}

                <div class="campo">

                    <label for="tipo">
                        Tipo de conteúdo
                    </label>

                    <select
                        name="tipo"
                        id="tipo"
                        required
                    >

                        <option value="">
                            Selecione...
                        </option>

                        <option
                            value="imagem"
                            {{ old('tipo') === 'imagem' ? 'selected' : '' }}
                        >
                            🖼️ Imagem
                        </option>

                        <option
                            value="video"
                            {{ old('tipo') === 'video' ? 'selected' : '' }}
                        >
                            🎥 Vídeo
                        </option>

                    </select>

                </div>


                {{-- ORDEM --}}

                <div class="campo">

                    <label for="ordem">
                        Ordem
                    </label>

                    <input
                        type="number"
                        name="ordem"
                        id="ordem"
                        value="{{ old('ordem', 0) }}"
                        min="0"
                    >

                    <small>
                        Menor número aparece primeiro.
                    </small>

                </div>

            </div>


            {{-- ARQUIVO --}}

            <div class="campo">

                <label for="arquivo">
                    Arquivo
                </label>

                <div class="arquivo-area">

                    <div class="arquivo-icone">
                        📁
                    </div>

                    <strong>
                        Selecione uma imagem ou vídeo
                    </strong>

                    <p>
                        Imagens: JPG, JPEG, PNG ou WEBP.
                        Vídeos: MP4, WEBM ou MOV.
                    </p>

                    <input
                        type="file"
                        name="arquivo"
                        id="arquivo"
                        accept="image/jpeg,image/png,image/webp,video/mp4,video/webm,video/quicktime"
                        required
                    >

                </div>

                <small>
                    Tamanho máximo: 100 MB.
                </small>

            </div>


            {{-- TÍTULO --}}

            <div class="campo">

                <label for="titulo">
                    Título
                </label>

                <input
                    type="text"
                    name="titulo"
                    id="titulo"
                    value="{{ old('titulo') }}"
                    maxlength="255"
                    placeholder="Ex.: Nova coleção"
                >

            </div>


            {{-- DESCRIÇÃO --}}

            <div class="campo">

                <label for="descricao">
                    Descrição
                </label>

                <textarea
                    name="descricao"
                    id="descricao"
                    placeholder="Descrição opcional do conteúdo..."
                >{{ old('descricao') }}</textarea>

            </div>


            {{-- AÇÕES --}}

            <div class="acoes">

                <a
                    href="{{ route('admin.carrossel.index') }}"
                    class="btn btn-voltar"
                >
                    ← Voltar
                </a>


                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    + Adicionar ao carrossel
                </button>

            </div>

        </form>

    </div>

</div>

@endsection