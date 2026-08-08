@extends('admin.layouts.app')

@section('content')

<style>
    .categorias-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 30px;
    }

    .categorias-titulo h1 {
        font-size: 28px;
        color: #111827;
        margin-bottom: 6px;
    }

    .categorias-titulo p {
        color: #64748b;
        font-size: 15px;
    }

    .btn-nova-categoria {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #2563eb;
        color: white;
        padding: 12px 18px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        transition: .2s;
        box-shadow: 0 4px 10px rgba(37, 99, 235, .2);
    }

    .btn-nova-categoria:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
        padding: 14px 18px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-weight: 500;
    }

    .categorias-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
    }

    .categoria-card {
        background: white;
        border-radius: 16px;
        padding: 22px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, .06);
        border: 1px solid #e5e7eb;
        transition: .2s;
        display: flex;
        flex-direction: column;
        min-height: 220px;
    }

    .categoria-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, .09);
    }

    .categoria-topo {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 18px;
    }

    .categoria-icone {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
    }

    .categoria-status {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }

    .status-ativo {
        background: #dcfce7;
        color: #166534;
    }

    .status-inativo {
        background: #fee2e2;
        color: #991b1b;
    }

    .categoria-nome {
        font-size: 19px;
        color: #111827;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .categoria-descricao {
        color: #64748b;
        font-size: 14px;
        line-height: 1.6;
        flex: 1;
    }

    .sem-descricao {
        color: #94a3b8;
        font-style: italic;
    }

    .categoria-acoes {
        display: flex;
        gap: 10px;
        margin-top: 20px;
        padding-top: 18px;
        border-top: 1px solid #f1f5f9;
    }

    .btn-editar,
    .btn-excluir {
        flex: 1;
        border-radius: 8px;
        padding: 10px;
        text-align: center;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: .2s;
    }

    .btn-editar {
        background: #eff6ff;
        color: #2563eb;
        text-decoration: none;
        border: 1px solid #dbeafe;
    }

    .btn-editar:hover {
        background: #dbeafe;
    }

    .btn-excluir {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fee2e2;
    }

    .btn-excluir:hover {
        background: #fee2e2;
    }

    .form-excluir {
        flex: 1;
        margin: 0;
    }

    .nenhuma-categoria {
        background: white;
        border: 1px dashed #cbd5e1;
        border-radius: 16px;
        padding: 50px 20px;
        text-align: center;
        color: #64748b;
    }

    .nenhuma-categoria-icon {
        font-size: 42px;
        margin-bottom: 15px;
    }

    .nenhuma-categoria h3 {
        color: #334155;
        margin-bottom: 6px;
    }

    @media (max-width: 650px) {

        .categorias-header {
            flex-direction: column;
            align-items: stretch;
        }

        .btn-nova-categoria {
            justify-content: center;
        }

        .categorias-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="categorias-header">


<div class="categorias-titulo">

    <h1>
        📂 Categorias
    </h1>

    <p>
        Organize seus produtos por categorias.
    </p>

</div>


<a
    href="{{ route('admin.categorias.create') }}"
    class="btn-nova-categoria"
>

    <span>＋</span>

    Nova Categoria

</a>


</div>

@if(session('success'))


<div class="alert-success">

    ✓ {{ session('success') }}

</div>


@endif

@if($categorias->count())


<div class="categorias-grid">

    @foreach($categorias as $categoria)

        <div class="categoria-card">


            <div class="categoria-topo">

                <div class="categoria-icone">
                    📂
                </div>


                @if($categoria->ativo)

                    <span class="categoria-status status-ativo">
                        ATIVA
                    </span>

                @else

                    <span class="categoria-status status-inativo">
                        INATIVA
                    </span>

                @endif

            </div>


            <div>

                <div class="categoria-nome">

                    {{ $categoria->nome }}

                </div>


                @if($categoria->descricao)

                    <div class="categoria-descricao">

                        {{ $categoria->descricao }}

                    </div>

                @else

                    <div class="categoria-descricao sem-descricao">

                        Nenhuma descrição cadastrada.

                    </div>

                @endif

            </div>


            <div class="categoria-acoes">


                <a
                    href="{{ route('admin.categorias.edit', $categoria) }}"
                    class="btn-editar"
                >

                    ✏️ Editar

                </a>


                <form
                    method="POST"
                    action="{{ route('admin.categorias.destroy', $categoria) }}"
                    class="form-excluir"
                    onsubmit="return confirm('Tem certeza que deseja excluir esta categoria?')"
                >

                    @csrf

                    @method('DELETE')

                    <button
                        type="submit"
                        class="btn-excluir"
                        style="width:100%;"
                    >

                        🗑️ Excluir

                    </button>

                </form>


            </div>


        </div>

    @endforeach

</div>
```

@else

```
<div class="nenhuma-categoria">

    <div class="nenhuma-categoria-icon">
        📂
    </div>

    <h3>
        Nenhuma categoria cadastrada
    </h3>

    <p>
        Crie sua primeira categoria para começar a organizar seus produtos.
    </p>

</div>


@endif

@endsection
