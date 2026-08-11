@extends('admin.layouts.app')

@section('title', 'Relatórios - SmartCatalog')

@section('content')

<style>

    .relatorios-header {
        background: white;
        padding: 25px;
        border-radius: 16px;
        margin-bottom: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,.06);
    }

    .relatorios-header h1 {
        margin: 0;
        color: #111827;
        font-size: 28px;
    }

    .relatorios-header p {
        margin-top: 6px;
        color: #64748b;
    }

    .filtro {
        background: white;
        padding: 20px;
        border-radius: 16px;
        margin-bottom: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,.06);
    }

    .filtro form {
        display: flex;
        align-items: end;
        gap: 15px;
        flex-wrap: wrap;
    }

    .campo {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .campo label {
        font-size: 13px;
        font-weight: 600;
        color: #475569;
    }

    .campo input {
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 10px 12px;
        font-size: 14px;
    }

    .btn-filtrar {
        background: #2563eb;
        color: white;
        border: none;
        padding: 11px 18px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
    }

    .btn-filtrar:hover {
        background: #1d4ed8;
    }

    .btn-limpar {
        background: #e2e8f0;
        color: #334155;
        padding: 11px 18px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
    }

    .cards {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        margin-bottom: 25px;
    }

    .card {
        background: white;
        padding: 22px;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,.06);
    }

    .card-titulo {
        color: #64748b;
        font-size: 13px;
    }

    .card-valor {
        margin-top: 8px;
        color: #111827;
        font-size: 28px;
        font-weight: 800;
    }

    .card-info {
        margin-top: 5px;
        color: #94a3b8;
        font-size: 12px;
    }

    .grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 25px;
    }

    .box {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,.06);
        overflow: hidden;
    }

    .box-header {
        padding: 20px;
        border-bottom: 1px solid #e5e7eb;
    }

    .box-header h2 {
        margin: 0;
        font-size: 18px;
        color: #111827;
    }

    .box-header p {
        margin-top: 5px;
        color: #64748b;
        font-size: 13px;
    }

    .box-body {
        padding: 20px;
    }

    .linha {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 13px 0;
        border-bottom: 1px solid #f1f5f9;
        gap: 15px;
    }

    .linha:last-child {
        border-bottom: none;
    }

    .nome {
        font-weight: 700;
        color: #111827;
    }

    .sub {
        color: #94a3b8;
        font-size: 12px;
        margin-top: 3px;
    }

    .valor {
        font-weight: 800;
        color: #111827;
        white-space: nowrap;
    }

    .alerta {
        color: #dc2626;
        font-weight: 800;
    }

    .ok {
        color: #16a34a;
        font-weight: 800;
    }

    .status {
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
    }

    .status-emitido {
        background: #dcfce7;
        color: #166534;
    }

    .status-cancelado {
        background: #fee2e2;
        color: #991b1b;
    }

    .tabela {
        width: 100%;
        border-collapse: collapse;
    }

    .tabela th {
        text-align: left;
        padding: 12px;
        background: #f8fafc;
        color: #64748b;
        font-size: 12px;
    }

    .tabela td {
        padding: 12px;
        border-top: 1px solid #f1f5f9;
        color: #334155;
        font-size: 13px;
    }

    .vazio {
        text-align: center;
        padding: 30px;
        color: #94a3b8;
    }

    @media(max-width:1100px) {

        .cards {
            grid-template-columns: repeat(2, 1fr);
        }

        .grid {
            grid-template-columns: 1fr;
        }

    }

    @media(max-width:700px) {

        .cards {
            grid-template-columns: 1fr;
        }

        .filtro form {
            flex-direction: column;
            align-items: stretch;
        }

    }

</style>


{{-- CABEÇALHO --}}

<div class="relatorios-header">

    <h1>
        📈 Relatórios
    </h1>

    <p>
        Análise geral de produtos, estoque, categorias e pedidos.
    </p>

</div>


{{-- FILTRO --}}

<div class="filtro">

    <form method="GET" action="{{ route('admin.relatorios.index') }}">

        <div class="campo">

            <label>
                Data inicial
            </label>

            <input
                type="date"
                name="data_inicio"
                value="{{ $dataInicio }}"
            >

        </div>


        <div class="campo">

            <label>
                Data final
            </label>

            <input
                type="date"
                name="data_fim"
                value="{{ $dataFim }}"
            >

        </div>


        <button
            type="submit"
            class="btn-filtrar"
        >
            Filtrar
        </button>


        <a
            href="{{ route('admin.relatorios.index') }}"
            class="btn-limpar"
        >
            Limpar
        </a>

    </form>

</div>


{{-- RESUMO DE PRODUTOS --}}

<div class="cards">

    <div class="card">

        <div class="card-titulo">
            Total de produtos
        </div>

        <div class="card-valor">
            {{ $totalProdutos }}
        </div>

        <div class="card-info">
            {{ $produtosAtivos }} ativos
        </div>

    </div>


    <div class="card">

        <div class="card-titulo">
            Estoque total
        </div>

        <div class="card-valor">
            {{ $quantidadeTotalEstoque }}
        </div>

        <div class="card-info">
            unidades cadastradas
        </div>

    </div>


    <div class="card">

        <div class="card-titulo">
            Estoque baixo
        </div>

        <div class="card-valor alerta">
            {{ $estoqueBaixo }}
        </div>

        <div class="card-info">
            produtos com até 5 unidades
        </div>

    </div>


    <div class="card">

        <div class="card-titulo">
            Valor do estoque
        </div>

        <div class="card-valor" style="font-size:23px;">

            R$
            {{ number_format(
                $valorTotalEstoque,
                2,
                ',',
                '.'
            ) }}

        </div>

    </div>

</div>


{{-- RESUMO DE PEDIDOS --}}

<div class="cards">

    <div class="card">

        <div class="card-titulo">
            Total de pedidos
        </div>

        <div class="card-valor">
            {{ $totalPedidos }}
        </div>

    </div>


    <div class="card">

        <div class="card-titulo">
            Pedidos emitidos
        </div>

        <div class="card-valor ok">
            {{ $pedidosEmitidos }}
        </div>

    </div>


    <div class="card">

        <div class="card-titulo">
            Pedidos cancelados
        </div>

        <div class="card-valor alerta">
            {{ $pedidosCancelados }}
        </div>

    </div>


    <div class="card">

        <div class="card-titulo">
            Valor dos pedidos emitidos
        </div>

        <div class="card-valor" style="font-size:23px;">

            R$
            {{ number_format(
                $valorPedidosEmitidos,
                2,
                ',',
                '.'
            ) }}

        </div>

    </div>

</div>


{{-- PRODUTOS E ESTOQUE --}}

<div class="grid">


    {{-- MAIS PEDIDOS --}}

    <div class="box">

        <div class="box-header">

            <h2>
                🏆 Produtos mais pedidos
            </h2>

            <p>
                Produtos com maior quantidade emitida.
            </p>

        </div>

        <div class="box-body">

            @forelse($produtosMaisPedidos as $produto)

                <div class="linha">

                    <div>

                        <div class="nome">
                            {{ $produto->nome }}
                        </div>

                        <div class="sub">
                            Quantidade pedida
                        </div>

                    </div>

                    <div class="valor">
                        {{ $produto->quantidade_vendida }}
                    </div>

                </div>

            @empty

                <div class="vazio">
                    Nenhum pedido emitido no período.
                </div>

            @endforelse

        </div>

    </div>


    {{-- ESTOQUE BAIXO --}}

    <div class="box">

        <div class="box-header">

            <h2>
                ⚠️ Estoque baixo
            </h2>

            <p>
                Produtos que precisam de atenção.
            </p>

        </div>

        <div class="box-body">

            @forelse($produtosEstoqueBaixo as $produto)

                <div class="linha">

                    <div>

                        <div class="nome">
                            {{ $produto->nome }}
                        </div>

                        <div class="sub">

                            {{ $produto->categoria->nome ?? 'Sem categoria' }}

                        </div>

                    </div>

                    <div class="valor alerta">

                        {{ $produto->estoque }}

                    </div>

                </div>

            @empty

                <div class="vazio">
                    Nenhum produto com estoque baixo.
                </div>

            @endforelse

        </div>

    </div>

</div>


{{-- CATEGORIAS --}}

<div class="box" style="margin-bottom:25px;">

    <div class="box-header">

        <h2>
            📂 Produtos por categoria
        </h2>

        <p>
            Quantidade de produtos cadastrados em cada categoria.
        </p>

    </div>

    <div class="box-body">

        <table class="tabela">

            <thead>

                <tr>

                    <th>
                        Categoria
                    </th>

                    <th>
                        Produtos
                    </th>

                    <th>
                        Situação
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($produtosPorCategoria as $categoria)

                    <tr>

                        <td>
                            {{ $categoria->nome }}
                        </td>

                        <td>
                            {{ $categoria->produtos_count }}
                        </td>

                        <td>

                            @if($categoria->ativo)

                                <span class="status status-emitido">
                                    Ativa
                                </span>

                            @else

                                <span class="status status-cancelado">
                                    Inativa
                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="3"
                            class="vazio"
                        >
                            Nenhuma categoria cadastrada.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


{{-- ÚLTIMOS PEDIDOS --}}

<div class="box">

    <div class="box-header">

        <h2>
            🧾 Últimos pedidos
        </h2>

        <p>
            Pedidos encontrados conforme o filtro selecionado.
        </p>

    </div>

    <div class="box-body">

        <table class="tabela">

            <thead>

                <tr>

                    <th>
                        Pedido
                    </th>

                    <th>
                        Data
                    </th>

                    <th>
                        Status
                    </th>

                    <th>
                        Valor
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($ultimosPedidos as $pedido)

                    <tr>

                        <td>
                            {{ $pedido->numero }}
                        </td>

                        <td>
                            {{ $pedido->created_at?->format('d/m/Y H:i') }}
                        </td>

                        <td>

                            @if($pedido->status === 'emitido')

                                <span class="status status-emitido">
                                    Emitido
                                </span>

                            @elseif($pedido->status === 'cancelado')

                                <span class="status status-cancelado">
                                    Cancelado
                                </span>

                            @else

                                <span class="status">
                                    {{ ucfirst($pedido->status) }}
                                </span>

                            @endif

                        </td>

                        <td>

                            R$
                            {{ number_format(
                                $pedido->valor_total,
                                2,
                                ',',
                                '.'
                            ) }}

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="4"
                            class="vazio"
                        >
                            Nenhum pedido encontrado.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection