```blade
@extends('admin.layouts.app')

@section('content')

<style>

    .produtos-container {
        width: 100%;
    }

    .topo-produtos {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 25px;
    }

    .topo-produtos h1 {
        margin: 0;
        color: #111827;
        font-size: 28px;
    }

    .topo-produtos p {
        margin-top: 6px;
        color: #64748b;
        font-size: 14px;
    }

    .btn-novo {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #2563eb;
        color: white;
        text-decoration: none;
        padding: 12px 20px;
        border-radius: 10px;
        font-weight: 600;
        transition: .2s;
    }

    .btn-novo:hover {
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
    }

    .produtos-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,.06);
        overflow: hidden;
    }

    .tabela-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .tabela-produtos {
        width: 100%;
        border-collapse: collapse;
        min-width: 950px;
    }

    .tabela-produtos thead {
        background: #f8fafc;
    }

    .tabela-produtos th {
        padding: 16px;
        text-align: left;
        color: #475569;
        font-size: 13px;
        font-weight: 700;
        border-bottom: 1px solid #e2e8f0;
    }

    .tabela-produtos td {
        padding: 15px 16px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        color: #334155;
    }

    .tabela-produtos tbody tr {
        transition: .2s;
    }

    .tabela-produtos tbody tr:hover {
        background: #f8fafc;
    }

    .produto-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .produto-imagem {
        width: 60px;
        height: 60px;
        border-radius: 10px;
        object-fit: cover;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
    }

    .sem-imagem {
        width: 60px;
        height: 60px;
        border-radius: 10px;
        background: #f1f5f9;
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        text-align: center;
        border: 1px solid #e2e8f0;
    }

    .produto-nome {
        font-weight: 700;
        color: #111827;
        margin-bottom: 4px;
    }

    .produto-marca {
        font-size: 12px;
        color: #64748b;
    }

    .categoria-badge {
        display: inline-block;
        background: #eff6ff;
        color: #1d4ed8;
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
    }

    .preco-normal {
        font-weight: 700;
        color: #334155;
    }

    .preco-antigo {
        display: block;
        color: #94a3b8;
        text-decoration: line-through;
        font-size: 12px;
        margin-bottom: 2px;
    }

    .preco-promocional {
        display: block;
        color: #16a34a;
        font-weight: 800;
        font-size: 16px;
    }

    .sem-promocao {
        color: #334155;
        font-weight: 700;
    }

    .estoque {
        font-weight: 700;
    }

    .estoque-baixo {
        color: #dc2626;
    }

    .estoque-normal {
        color: #16a34a;
    }

    .status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
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

    .destaque {
        display: inline-block;
        margin-top: 6px;
        background: #fef3c7;
        color: #92400e;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
    }

    .acoes {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .btn-acao {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-size: 16px;
        transition: .2s;
    }

    .btn-ver {
        background: #eff6ff;
        color: #2563eb;
    }

    .btn-ver:hover {
        background: #dbeafe;
        transform: translateY(-2px);
    }

    .btn-editar {
        background: #fef3c7;
        color: #b45309;
    }

    .btn-editar:hover {
        background: #fde68a;
        transform: translateY(-2px);
    }

    .btn-excluir {
        background: #fee2e2;
        color: #dc2626;
    }

    .btn-excluir:hover {
        background: #fecaca;
        transform: translateY(-2px);
    }

    .sem-produtos {
        padding: 60px 20px;
        text-align: center;
    }

    .sem-produtos-icon {
        font-size: 50px;
        margin-bottom: 15px;
    }

    .sem-produtos h3 {
        margin: 0 0 8px;
        color: #334155;
    }

    .sem-produtos p {
        margin: 0 0 20px;
        color: #64748b;
    }

    @media (max-width: 800px) {

        .topo-produtos {
            align-items: flex-start;
            flex-direction: column;
        }

        .btn-novo {
            width: 100%;
            justify-content: center;
        }

    }

</style>


<div class="produtos-container">

    {{-- =========================================================
         CABEÇALHO
    ========================================================== --}}

    <div class="topo-produtos">

        <div>

            <h1>
                Produtos
            </h1>

            <p>
                Gerencie os produtos do seu catálogo.
            </p>

        </div>


        <a
            href="{{ route('admin.produtos.create') }}"
            class="btn-novo"
        >

            ➕
            Novo Produto

        </a>

    </div>


    {{-- =========================================================
         MENSAGEM DE SUCESSO
    ========================================================== --}}

    @if(session('success'))

        <div class="alert-success">

            ✅
            {{ session('success') }}

        </div>

    @endif


    {{-- =========================================================
         LISTAGEM
    ========================================================== --}}

    <div class="produtos-card">

        @if($produtos->count())

            <div class="tabela-wrapper">

                <table class="tabela-produtos">

                    <thead>

                        <tr>

                            <th>
                                Produto
                            </th>

                            <th>
                                Categoria
                            </th>

                            <th>
                                Preço
                            </th>

                            <th>
                                Estoque
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Ações
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($produtos as $produto)

                            <tr>

                                {{-- =================================================
                                     PRODUTO
                                ================================================== --}}

                                <td>

                                    <div class="produto-info">

                                        @if($produto->imagens->count())

                                            <img
                                                src="{{ asset('storage/' . $produto->imagens->first()->imagem) }}"
                                                alt="{{ $produto->nome }}"
                                                class="produto-imagem"
                                            >

                                        @else

                                            <div class="sem-imagem">
                                                Sem imagem
                                            </div>

                                        @endif


                                        <div>

                                            <div class="produto-nome">

                                                {{ $produto->nome }}

                                            </div>


                                            <div class="produto-marca">

                                                @if($produto->marca)

                                                    {{ $produto->marca }}

                                                @else

                                                    Sem marca

                                                @endif

                                                @if($produto->sku)

                                                    · SKU:
                                                    {{ $produto->sku }}

                                                @endif

                                            </div>


                                            @if($produto->destaque)

                                                <span class="destaque">
                                                    ⭐ Destaque
                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                </td>


                                {{-- =================================================
                                     CATEGORIA
                                ================================================== --}}

                                <td>

                                    @if($produto->categoria)

                                        <span class="categoria-badge">

                                            {{ $produto->categoria->nome }}

                                        </span>

                                    @else

                                        <span style="color:#94a3b8;">
                                            Sem categoria
                                        </span>

                                    @endif

                                </td>


                                {{-- =================================================
                                     PREÇO
                                ================================================== --}}

                                <td>

                                    @if(
                                        $produto->preco_promocional !== null &&
                                        $produto->preco_promocional > 0 &&
                                        $produto->preco_promocional < $produto->preco
                                    )

                                        <span class="preco-antigo">

                                            R$
                                            {{ number_format(
                                                $produto->preco,
                                                2,
                                                ',',
                                                '.'
                                            ) }}

                                        </span>


                                        <span class="preco-promocional">

                                            R$
                                            {{ number_format(
                                                $produto->preco_promocional,
                                                2,
                                                ',',
                                                '.'
                                            ) }}

                                        </span>

                                    @else

                                        <span class="sem-promocao">

                                            R$
                                            {{ number_format(
                                                $produto->preco,
                                                2,
                                                ',',
                                                '.'
                                            ) }}

                                        </span>

                                    @endif

                                </td>


                                {{-- =================================================
                                     ESTOQUE
                                ================================================== --}}

                                <td>

                                    @if($produto->estoque <= 5)

                                        <span class="estoque estoque-baixo">

                                            {{ $produto->estoque }}

                                            @if($produto->unidade)
                                                {{ $produto->unidade }}
                                            @endif

                                        </span>

                                    @else

                                        <span class="estoque estoque-normal">

                                            {{ $produto->estoque }}

                                            @if($produto->unidade)
                                                {{ $produto->unidade }}
                                            @endif

                                        </span>

                                    @endif

                                </td>


                                {{-- =================================================
                                     STATUS
                                ================================================== --}}

                                <td>

                                    @if($produto->ativo)

                                        <span class="status status-ativo">

                                            ●
                                            Ativo

                                        </span>

                                    @else

                                        <span class="status status-inativo">

                                            ●
                                            Inativo

                                        </span>

                                    @endif

                                </td>


                                {{-- =================================================
                                     AÇÕES
                                ================================================== --}}

                                <td>

                                    <div class="acoes">


                                        {{-- VER --}}

                                        <a
                                            href="{{ route(
                                                'admin.produtos.show',
                                                $produto
                                            ) }}"
                                            class="btn-acao btn-ver"
                                            title="Ver produto"
                                        >

                                            👁️

                                        </a>


                                        {{-- EDITAR --}}

                                        <a
                                            href="{{ route(
                                                'admin.produtos.edit',
                                                $produto
                                            ) }}"
                                            class="btn-acao btn-editar"
                                            title="Editar produto"
                                        >

                                            ✏️

                                        </a>


                                        {{-- EXCLUIR --}}

                                        <form
                                            method="POST"
                                            action="{{ route(
                                                'admin.produtos.destroy',
                                                $produto
                                            ) }}"
                                            onsubmit="return confirm(
                                                'Tem certeza que deseja excluir este produto?'
                                            );"
                                        >

                                            @csrf

                                            @method('DELETE')


                                            <button
                                                type="submit"
                                                class="btn-acao btn-excluir"
                                                title="Excluir produto"
                                            >

                                                🗑️

                                            </button>

                                        </form>


                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="sem-produtos">

                <div class="sem-produtos-icon">
                    📦
                </div>

                <h3>
                    Nenhum produto cadastrado
                </h3>

                <p>
                    Comece cadastrando o primeiro produto do seu catálogo.
                </p>


                <a
                    href="{{ route('admin.produtos.create') }}"
                    class="btn-novo"
                    style="display:inline-flex;"
                >

                    ➕
                    Cadastrar primeiro produto

                </a>

            </div>

        @endif

    </div>

</div>

@endsection
