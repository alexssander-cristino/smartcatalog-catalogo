@extends('admin.layouts.app')

@section('content')

<div class="page-header">


<div>

    <h1>
        Editar Categoria
    </h1>

    <p>
        Altere as informações da categoria abaixo.
    </p>

</div>

<a
    href="{{ route('admin.categorias.index') }}"
    class="btn-voltar"
>
    ← Voltar
</a>


</div>

<div class="categoria-card">


<div class="categoria-card-header">

    <div class="categoria-icon">
        📂
    </div>

    <div>

        <h2>
            Dados da categoria
        </h2>

        <p>
            Atualize as informações cadastradas.
        </p>

    </div>

</div>


<div class="categoria-card-body">

    <form
        method="POST"
        action="{{ route('admin.categorias.update',$categoria) }}"
        class="categoria-form"
    >

        @csrf
        @method('PUT')


        {{-- ERROS --}}

        @if($errors->any())

            <div class="form-alert">

                <strong>
                    Verifique os campos abaixo:
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


        {{-- NOME --}}

        <div class="form-group">

            <label for="nome">
                Nome da categoria
            </label>

            <input
                type="text"
                id="nome"
                name="nome"
                value="{{ old('nome',$categoria->nome) }}"
                placeholder="Ex: Camisetas"
                required
            >

        </div>


        {{-- DESCRIÇÃO --}}

        <div class="form-group">

            <label for="descricao">

                Descrição

                <span>
                    (opcional)
                </span>

            </label>

            <textarea
                id="descricao"
                name="descricao"
                placeholder="Descreva brevemente esta categoria..."
            >{{ old('descricao',$categoria->descricao) }}</textarea>

        </div>


        {{-- STATUS --}}

        <div class="status-box">

            <label class="status-label">

                <input
                    type="checkbox"
                    name="ativo"
                    value="1"
                    {{ $categoria->ativo ? 'checked' : '' }}
                >

                <span class="status-check"></span>

                <span>

                    <strong>
                        Categoria ativa
                    </strong>

                    <small>
                        A categoria ficará disponível no catálogo.
                    </small>

                </span>

            </label>

        </div>


        {{-- BOTÕES --}}

        <div class="form-actions">

            <a
                href="{{ route('admin.categorias.index') }}"
                class="btn-cancelar"
            >
                Cancelar
            </a>

            <button
                type="submit"
                class="btn-salvar"
            >
                ✓ Atualizar categoria
            </button>

        </div>

    </form>

</div>


</div>

<style>

/* =========================================================
   CABEÇALHO
========================================================= */

.page-header {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 20px;

    margin-bottom: 25px;

}

.page-header h1 {

    margin: 0;

    color: #111827;

    font-size: 28px;

    font-weight: 800;

}

.page-header p {

    margin-top: 6px;

    color: #64748b;

    font-size: 14px;

}


/* =========================================================
   BOTÃO VOLTAR
========================================================= */

.btn-voltar {

    display: inline-flex;

    align-items: center;

    gap: 8px;

    padding: 11px 17px;

    background: white;

    color: #334155;

    text-decoration: none;

    border: 1px solid #e2e8f0;

    border-radius: 10px;

    font-size: 14px;

    font-weight: 600;

    transition: .2s;

    box-shadow:
        0 2px 8px rgba(0,0,0,.04);

}

.btn-voltar:hover {

    background: #f8fafc;

    border-color: #cbd5e1;

    transform: translateY(-1px);

}


/* =========================================================
   CARD PRINCIPAL
========================================================= */

.categoria-card {

    width: 100%;

    max-width: 900px;

    background: white;

    border-radius: 18px;

    box-shadow:
        0 5px 20px rgba(15,23,42,.06);

    overflow: hidden;

}


/* =========================================================
   CABEÇALHO DO CARD
========================================================= */

.categoria-card-header {

    display: flex;

    align-items: center;

    gap: 15px;

    padding: 23px 25px;

    border-bottom: 1px solid #e5e7eb;

}

.categoria-icon {

    width: 48px;

    height: 48px;

    display: flex;

    align-items: center;

    justify-content: center;

    background: #eff6ff;

    border-radius: 12px;

    font-size: 22px;

}

.categoria-card-header h2 {

    margin: 0;

    color: #111827;

    font-size: 18px;

    font-weight: 700;

}

.categoria-card-header p {

    margin-top: 4px;

    color: #94a3b8;

    font-size: 13px;

}


/* =========================================================
   CORPO
========================================================= */

.categoria-card-body {

    padding: 28px 25px;

}


/* =========================================================
   FORMULÁRIO
========================================================= */

.categoria-form {

    width: 100%;

}

.form-group {

    margin-bottom: 22px;

}

.form-group label {

    display: block;

    margin-bottom: 8px;

    color: #334155;

    font-size: 14px;

    font-weight: 700;

}

.form-group label span {

    color: #94a3b8;

    font-size: 12px;

    font-weight: 400;

}


.form-group input[type="text"],
.form-group textarea {

    width: 100%;

    padding: 13px 14px;

    background: #f8fafc;

    border: 1px solid #cbd5e1;

    border-radius: 10px;

    color: #111827;

    font-size: 14px;

    outline: none;

    transition: .2s;

}

.form-group input[type="text"] {

    height: 46px;

}

.form-group textarea {

    min-height: 130px;

    resize: vertical;

    line-height: 1.5;

}


.form-group input[type="text"]:focus,
.form-group textarea:focus {

    background: white;

    border-color: #2563eb;

    box-shadow:
        0 0 0 3px rgba(37,99,235,.10);

}


.form-group input::placeholder,
.form-group textarea::placeholder {

    color: #94a3b8;

}


/* =========================================================
   STATUS
========================================================= */

.status-box {

    padding: 15px 16px;

    background: #f8fafc;

    border: 1px solid #e2e8f0;

    border-radius: 12px;

    margin-bottom: 25px;

}

.status-label {

    display: flex;

    align-items: center;

    gap: 12px;

    cursor: pointer;

}

.status-label input {

    position: absolute;

    opacity: 0;

}

.status-check {

    width: 21px;

    height: 21px;

    border: 2px solid #cbd5e1;

    border-radius: 6px;

    background: white;

    position: relative;

    flex-shrink: 0;

    transition: .2s;

}

.status-label input:checked + .status-check {

    background: #2563eb;

    border-color: #2563eb;

}

.status-label input:checked + .status-check::after {

    content: '✓';

    position: absolute;

    left: 50%;

    top: 50%;

    transform: translate(-50%, -50%);

    color: white;

    font-size: 13px;

    font-weight: 800;

}

.status-label strong {

    display: block;

    color: #334155;

    font-size: 14px;

}

.status-label small {

    display: block;

    margin-top: 3px;

    color: #94a3b8;

    font-size: 12px;

}


/* =========================================================
   ERROS
========================================================= */

.form-alert {

    padding: 14px 16px;

    margin-bottom: 22px;

    background: #fef2f2;

    border: 1px solid #fecaca;

    border-radius: 10px;

    color: #991b1b;

    font-size: 13px;

}

.form-alert strong {

    display: block;

    margin-bottom: 7px;

}

.form-alert ul {

    padding-left: 18px;

}

.form-alert li {

    margin-top: 3px;

}


/* =========================================================
   AÇÕES
========================================================= */

.form-actions {

    display: flex;

    justify-content: flex-end;

    align-items: center;

    gap: 12px;

    padding-top: 5px;

}

.btn-cancelar,
.btn-salvar {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    min-height: 44px;

    padding: 0 18px;

    border-radius: 10px;

    font-size: 14px;

    font-weight: 700;

    cursor: pointer;

    text-decoration: none;

    transition: .2s;

}


/* CANCELAR */

.btn-cancelar {

    background: white;

    color: #475569;

    border: 1px solid #cbd5e1;

}

.btn-cancelar:hover {

    background: #f8fafc;

    border-color: #94a3b8;

}


/* ATUALIZAR */

.btn-salvar {

    background: #2563eb;

    color: white;

    border: none;

    box-shadow:
        0 4px 10px rgba(37,99,235,.20);

}

.btn-salvar:hover {

    background: #1d4ed8;

    transform: translateY(-1px);

    box-shadow:
        0 6px 14px rgba(37,99,235,.25);

}

.btn-salvar:active {

    transform: translateY(0);

}


/* =========================================================
   RESPONSIVO
========================================================= */

@media(max-width:700px) {

    .page-header {

        align-items: flex-start;

        flex-direction: column;

    }

    .page-header h1 {

        font-size: 24px;

    }

    .categoria-card {

        max-width: 100%;

        border-radius: 14px;

    }

    .categoria-card-header {

        padding: 20px;

    }

    .categoria-card-body {

        padding: 20px;

    }

    .form-actions {

        flex-direction: column-reverse;

        width: 100%;

    }

    .btn-cancelar,
    .btn-salvar {

        width: 100%;

    }

}

</style>

@endsection
