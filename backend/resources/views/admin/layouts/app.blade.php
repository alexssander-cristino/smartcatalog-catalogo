<!DOCTYPE html>

<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'SmartCatalog')
    </title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background: #f1f5f9;
        }

        /* =========================================================
           SIDEBAR
        ========================================================== */

        .sidebar {

            width: 270px;
            min-height: 100vh;

            background:
                linear-gradient(
                    180deg,
                    #111827,
                    #1e293b
                );

            color: white;

            padding: 25px 20px;

            position: fixed;

            left: 0;
            top: 0;

            display: flex;
            flex-direction: column;

            z-index: 1000;
        }

        /* =========================================================
           LOGO
        ========================================================== */

        .logo {

            display: flex;

            align-items: center;

            gap: 12px;

            margin-bottom: 30px;
        }

        .logo-icon {

            width: 45px;
            height: 45px;

            background: #2563eb;

            border-radius: 12px;

            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 22px;
        }

        .logo h2 {

            font-size: 22px;

            font-weight: 700;
        }

        /* =========================================================
           USUÁRIO
        ========================================================== */

        .usuario {

            background: rgba(255,255,255,.06);

            border: 1px solid rgba(255,255,255,.08);

            border-radius: 14px;

            padding: 14px;

            margin-bottom: 30px;
        }

        .usuario-link {

            display: flex;

            align-items: center;

            gap: 12px;

            color: white;

            text-decoration: none;
        }

        .usuario-foto {

            width: 52px;
            height: 52px;

            border-radius: 50%;

            object-fit: cover;

            border: 3px solid #2563eb;

            background: #334155;

            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 20px;

            font-weight: bold;

            flex-shrink: 0;
        }

        .usuario-info {

            min-width: 0;
        }

        .usuario-nome {

            font-size: 15px;

            font-weight: 600;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;
        }

        .usuario-perfil {

            color: #94a3b8;

            font-size: 12px;

            margin-top: 3px;
        }

        /* =========================================================
           MENU
        ========================================================== */

        .menu {

            flex: 1;
        }

        .menu-title {

            color: #94a3b8;

            font-size: 12px;

            text-transform: uppercase;

            margin-bottom: 12px;

            letter-spacing: .5px;
        }

        .sidebar a {

            display: flex;

            align-items: center;

            gap: 12px;

            color: #e5e7eb;

            text-decoration: none;

            padding: 13px 15px;

            border-radius: 10px;

            margin-bottom: 8px;

            transition: .3s;
        }

        .sidebar a:hover {

            background: #2563eb;

            color: white;

            transform: translateX(5px);
        }

        .sidebar a.ativo {

            background: #2563eb;

            color: white;
        }

        .sidebar a .icone {

            width: 25px;

            text-align: center;

            font-size: 18px;
        }

        /* =========================================================
           LOGOUT
        ========================================================== */

        .logout {

            margin-top: 20px;
        }

        .logout form {

            width: 100%;
        }

        .logout button {

            width: 100%;

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 10px;

            background: #dc2626;

            color: white;

            border: none;

            border-radius: 10px;

            padding: 13px;

            font-size: 15px;

            cursor: pointer;

            transition: .3s;
        }

        .logout button:hover {

            background: #b91c1c;

            transform: translateY(-2px);
        }

        /* =========================================================
           CONTEÚDO
        ========================================================== */

        .content {

            margin-left: 270px;

            width: calc(100% - 270px);

            padding: 35px;

            min-height: 100vh;
        }

        /* =========================================================
           DASHBOARD
        ========================================================== */

        .dashboard-header {

            background: white;

            padding: 25px;

            border-radius: 16px;

            margin-bottom: 25px;

            box-shadow:
                0 4px 15px rgba(0,0,0,.06);
        }

        .dashboard-header h1 {

            margin: 0;

            color: #111827;

            font-size: 28px;
        }

        .dashboard-header p {

            margin-top: 6px;

            color: #64748b;
        }

        /* =========================================================
           CARDS
        ========================================================== */

        .cards {

            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 18px;

            margin-bottom: 25px;
        }

        .card-dashboard {

            background: white;

            padding: 22px;

            border-radius: 16px;

            box-shadow:
                0 4px 15px rgba(0,0,0,.06);
        }

        .card-top {

            display: flex;

            justify-content: space-between;

            align-items: center;
        }

        .card-icon {

            width: 48px;

            height: 48px;

            border-radius: 12px;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 22px;
        }

        .card-title {

            margin-top: 18px;

            color: #64748b;

            font-size: 14px;
        }

        .card-value {

            margin-top: 4px;

            color: #111827;

            font-size: 28px;

            font-weight: 800;
        }

        /* =========================================================
           GRID DO DASHBOARD
        ========================================================== */

        .dashboard-grid {

            display: grid;

            grid-template-columns:
                1fr 1fr;

            gap: 20px;

            margin-bottom: 25px;
        }

        .dashboard-box {

            background: white;

            border-radius: 16px;

            box-shadow:
                0 4px 15px rgba(0,0,0,.06);

            overflow: hidden;
        }

        .box-header {

            padding: 20px 22px;

            border-bottom:
                1px solid #e5e7eb;
        }

        .box-header h2 {

            margin: 0;

            color: #111827;

            font-size: 18px;
        }

        .box-header p {

            margin-top: 5px;

            color: #64748b;

            font-size: 13px;
        }

        .box-body {

            padding: 20px;
        }

        /* =========================================================
           PRODUTOS E PEDIDOS
        ========================================================== */

        .produto-item,
        .pedido-item {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 15px;

            padding: 13px 0;

            border-bottom:
                1px solid #f1f5f9;
        }

        .produto-item:last-child,
        .pedido-item:last-child {

            border-bottom: none;
        }

        .produto-info,
        .pedido-info {

            min-width: 0;
        }

        .produto-nome,
        .pedido-numero {

            font-weight: 700;

            color: #111827;
        }

        .produto-categoria,
        .pedido-cliente {

            margin-top: 3px;

            color: #94a3b8;

            font-size: 12px;
        }

        .produto-preco,
        .pedido-total {

            font-weight: 800;

            color: #111827;

            white-space: nowrap;
        }

        /* =========================================================
           STATUS DOS PEDIDOS
        ========================================================== */

        .pedido-status {

            display: inline-block;

            margin-top: 5px;

            padding: 4px 9px;

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

        .status-outro {

            background: #f1f5f9;

            color: #475569;
        }

        /* =========================================================
           VAZIO
        ========================================================== */

        .empty {

            padding: 30px;

            text-align: center;

            color: #94a3b8;
        }

        /* =========================================================
           ACESSOS RÁPIDOS
        ========================================================== */

        .atalhos {

            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 15px;
        }

        .atalho {

            display: flex;

            align-items: center;

            gap: 12px;

            padding: 18px;

            background: white;

            border-radius: 14px;

            text-decoration: none;

            color: #111827;

            box-shadow:
                0 4px 15px rgba(0,0,0,.06);

            transition: .2s;
        }

        .atalho:hover {

            transform:
                translateY(-3px);

            box-shadow:
                0 8px 20px rgba(0,0,0,.09);
        }

        .atalho-icon {

            width: 45px;

            height: 45px;

            border-radius: 10px;

            background: #eff6ff;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 21px;

            flex-shrink: 0;
        }

        .atalho strong {

            display: block;
        }

        .atalho span {

            color: #64748b;

            font-size: 12px;
        }

        /* =========================================================
           RESPONSIVO DASHBOARD
        ========================================================== */

        @media(max-width:1100px) {

            .cards {

                grid-template-columns:
                    repeat(2, 1fr);
            }

            .dashboard-grid {

                grid-template-columns:
                    1fr;
            }

            .atalhos {

                grid-template-columns:
                    repeat(2, 1fr);
            }

        }

        @media(max-width:700px) {

            .cards {

                grid-template-columns:
                    1fr;
            }

            .atalhos {

                grid-template-columns:
                    1fr;
            }

        }

        /* =========================================================
           RESPONSIVO SIDEBAR
        ========================================================== */

        @media(max-width:800px) {

            .sidebar {

                width: 80px;

                padding:
                    20px 10px;
            }

            .logo h2,
            .sidebar a span:not(.icone),
            .usuario-info,
            .menu-title {

                display: none;
            }

            .usuario {

                padding: 8px;
            }

            .usuario-link {

                justify-content: center;
            }

            .content {

                margin-left: 80px;

                width:
                    calc(100% - 80px);

                padding: 20px;
            }

            .logout button {

                font-size: 0;
            }

            .logout button::before {

                content: '↪';

                font-size: 20px;
            }

        }

    </style>

</head>

<body>

{{-- =========================================================
     SIDEBAR
========================================================== --}}

<div class="sidebar">

    {{-- LOGO --}}

    <div class="logo">

        <div class="logo-icon">
            🛒
        </div>

        <h2>
            SmartCatalog
        </h2>

    </div>


    {{-- USUÁRIO --}}

    <div class="usuario">

        <a
            href="{{ route('profile.edit') }}"
            class="usuario-link"
        >

            @if(auth()->user()->foto)

                <img
                    src="{{ asset('storage/' . auth()->user()->foto) }}"
                    alt="Foto de perfil"
                    class="usuario-foto"
                >

            @else

                <div class="usuario-foto">

                    {{ strtoupper(
                        substr(
                            auth()->user()->name,
                            0,
                            1
                        )
                    ) }}

                </div>

            @endif

            <div class="usuario-info">

                <div class="usuario-nome">
                    {{ auth()->user()->name }}
                </div>

                <div class="usuario-perfil">
                    Meu perfil
                </div>

            </div>

        </a>

    </div>


    {{-- MENU --}}

    <div class="menu">

        <div class="menu-title">
            Menu
        </div>


        {{-- DASHBOARD --}}

        <a
            href="{{ route('admin.dashboard') }}"
            class="{{ request()->routeIs('admin.dashboard') ? 'ativo' : '' }}"
        >

            <span class="icone">
                📊
            </span>

            <span>
                Dashboard
            </span>

        </a>


        {{-- CATEGORIAS --}}

        <a
            href="{{ route('admin.categorias.index') }}"
            class="{{ request()->routeIs('admin.categorias.*') ? 'ativo' : '' }}"
        >

            <span class="icone">
                📂
            </span>

            <span>
                Categorias
            </span>

        </a>


        {{-- PRODUTOS --}}

        <a
            href="{{ route('admin.produtos.index') }}"
            class="{{ request()->routeIs('admin.produtos.*') ? 'ativo' : '' }}"
        >

            <span class="icone">
                📦
            </span>

            <span>
                Produtos
            </span>

        </a>


        {{-- ESTOQUE --}}

        <a
            href="{{ route('admin.estoque.index') }}"
            class="{{ request()->routeIs('admin.estoque.*') ? 'ativo' : '' }}"
        >

            <span class="icone">
                📋
            </span>

            <span>
                Estoque
            </span>

        </a>


        {{-- PEDIDOS --}}

        <a
            href="{{ route('admin.pedidos.index') }}"
            class="{{ request()->routeIs('admin.pedidos.*') ? 'ativo' : '' }}"
        >

            <span class="icone">
                🧾
            </span>

            <span>
                Pedidos
            </span>

        </a>


        {{-- PERFIL --}}

        <a
            href="{{ route('profile.edit') }}"
            class="{{ request()->routeIs('profile.*') ? 'ativo' : '' }}"
        >

            <span class="icone">
                👤
            </span>

            <span>
                Meu Perfil
            </span>

        </a>

    </div>


    {{-- LOGOUT --}}

    <div class="logout">

        <form
            method="POST"
            action="{{ route('logout') }}"
        >

            @csrf

            <button type="submit">

                <span>
                    ↪
                </span>

                Sair

            </button>

        </form>

    </div>

</div>


{{-- =========================================================
     CONTEÚDO
========================================================== --}}

<main class="content">


@if(request()->routeIs('admin.dashboard'))

    {{-- =====================================================
         DASHBOARD
    ====================================================== --}}


    {{-- CABEÇALHO --}}

    <div class="dashboard-header">

        <h1>
            📊 Dashboard
        </h1>

        <p>
            Visão geral do seu SmartCatalog.
        </p>

    </div>


    {{-- =====================================================
         PRIMEIRA LINHA DE CARDS
    ====================================================== --}}

    <div class="cards">


        {{-- TOTAL DE PRODUTOS --}}

        <div class="card-dashboard">

            <div class="card-top">

                <div class="card-title">
                    Total de produtos
                </div>

                <div
                    class="card-icon"
                    style="background:#eff6ff;"
                >
                    📦
                </div>

            </div>

            <div class="card-value">
                {{ $totalProdutos ?? 0 }}
            </div>

        </div>


        {{-- CATEGORIAS --}}

        <div class="card-dashboard">

            <div class="card-top">

                <div class="card-title">
                    Categorias ativas
                </div>

                <div
                    class="card-icon"
                    style="background:#f0fdf4;"
                >
                    📂
                </div>

            </div>

            <div class="card-value">
                {{ $totalCategorias ?? 0 }}
            </div>

        </div>


        {{-- ESTOQUE BAIXO --}}

        <div class="card-dashboard">

            <div class="card-top">

                <div class="card-title">
                    Estoque baixo
                </div>

                <div
                    class="card-icon"
                    style="background:#fff7ed;"
                >
                    ⚠️
                </div>

            </div>

            <div class="card-value">
                {{ $estoqueBaixo ?? 0 }}
            </div>

        </div>


        {{-- PEDIDOS EMITIDOS --}}

        <div class="card-dashboard">

            <div class="card-top">

                <div class="card-title">
                    Pedidos emitidos
                </div>

                <div
                    class="card-icon"
                    style="background:#f5f3ff;"
                >
                    🧾
                </div>

            </div>

            <div class="card-value">
                {{ $pedidosEmitidos ?? 0 }}
            </div>

        </div>

    </div>


    {{-- =====================================================
         SEGUNDA LINHA DE CARDS
    ====================================================== --}}

    <div class="cards">


        {{-- PRODUTOS ATIVOS --}}

        <div class="card-dashboard">

            <div class="card-title">
                Produtos ativos
            </div>

            <div class="card-value">
                {{ $produtosAtivos ?? 0 }}
            </div>

            <div
                style="
                    margin-top:5px;
                    color:#94a3b8;
                    font-size:12px;
                "
            >
                {{ $produtosInativos ?? 0 }}
                inativos
            </div>

        </div>


        {{-- DESTAQUES --}}

        <div class="card-dashboard">

            <div class="card-title">
                Produtos em destaque
            </div>

            <div class="card-value">
                {{ $produtosDestaque ?? 0 }}
            </div>

        </div>


        {{-- PEDIDOS CANCELADOS --}}

        <div class="card-dashboard">

            <div class="card-title">
                Pedidos cancelados
            </div>

            <div class="card-value">
                {{ $pedidosCancelados ?? 0 }}
            </div>

        </div>


        {{-- VALOR DOS PEDIDOS --}}

        <div class="card-dashboard">

            <div class="card-title">
                Valor dos pedidos emitidos
            </div>

            <div
                class="card-value"
                style="font-size:24px;"
            >

                R$

                {{ number_format(
                    $valorTotalPedidos ?? 0,
                    2,
                    ',',
                    '.'
                ) }}

            </div>

        </div>

    </div>


    {{-- =====================================================
         LISTAS
    ====================================================== --}}

    <div class="dashboard-grid">


        {{-- =================================================
             ÚLTIMOS PRODUTOS
        ================================================== --}}

        <div class="dashboard-box">

            <div class="box-header">

                <h2>
                    📦 Últimos produtos
                </h2>

                <p>
                    Produtos cadastrados recentemente.
                </p>

            </div>


            <div class="box-body">

                @forelse(($ultimosProdutos ?? collect()) as $produto)

                    <div class="produto-item">

                        <div class="produto-info">

                            <div class="produto-nome">

                                {{ $produto->nome }}

                            </div>


                            <div class="produto-categoria">

                                @if($produto->categoria)

                                    {{ is_object($produto->categoria)
                                        ? $produto->categoria->nome
                                        : $produto->categoria
                                    }}

                                @else

                                    Sem categoria

                                @endif

                            </div>

                        </div>


                        <div class="produto-preco">

                            R$

                            {{ number_format(
                                $produto->preco ?? 0,
                                2,
                                ',',
                                '.'
                            ) }}

                        </div>

                    </div>

                @empty

                    <div class="empty">
                        Nenhum produto cadastrado.
                    </div>

                @endforelse

            </div>

        </div>


        {{-- =================================================
             ÚLTIMOS PEDIDOS
        ================================================== --}}

        <div class="dashboard-box">

            <div class="box-header">

                <h2>
                    🧾 Últimos pedidos
                </h2>

                <p>
                    Pedidos emitidos recentemente.
                </p>

            </div>


            <div class="box-body">

                @forelse(($ultimosPedidos ?? collect()) as $pedido)

                    <div class="pedido-item">

                        <div class="pedido-info">

                            <div class="pedido-numero">

                                {{ $pedido->numero }}

                            </div>


                            {{-- CLIENTE
                                 NÃO DEPENDE DE RELACIONAMENTO
                                 cliente
                            --}}

                            <div class="pedido-cliente">

                                @if(isset($pedido->cliente_nome) && $pedido->cliente_nome)

                                    {{ $pedido->cliente_nome }}

                                @elseif(
                                    isset($pedido->nome_cliente)
                                    && $pedido->nome_cliente
                                )

                                    {{ $pedido->nome_cliente }}

                                @elseif(
                                    isset($pedido->cliente_id)
                                    && $pedido->cliente_id
                                )

                                    Cliente #{{ $pedido->cliente_id }}

                                @else

                                    Cliente não informado

                                @endif

                            </div>


                            @if($pedido->status === 'emitido')

                                <span
                                    class="pedido-status status-emitido"
                                >
                                    ✓ Emitido
                                </span>

                            @elseif($pedido->status === 'cancelado')

                                <span
                                    class="pedido-status status-cancelado"
                                >
                                    ✕ Cancelado
                                </span>

                            @else

                                <span
                                    class="pedido-status status-outro"
                                >
                                    {{ ucfirst(
                                        $pedido->status ?? 'Não informado'
                                    ) }}
                                </span>

                            @endif

                        </div>


                        <div class="pedido-total">

                            R$

                            {{ number_format(
                                $pedido->valor_total ?? 0,
                                2,
                                ',',
                                '.'
                            ) }}

                        </div>

                    </div>

                @empty

                    <div class="empty">
                        Nenhum pedido cadastrado.
                    </div>

                @endforelse

            </div>

        </div>

    </div>


    {{-- =====================================================
         ACESSO RÁPIDO
    ====================================================== --}}

    <div class="dashboard-box">

        <div class="box-header">

            <h2>
                ⚡ Acesso rápido
            </h2>

            <p>
                Acesse rapidamente as principais áreas do sistema.
            </p>

        </div>


        <div class="box-body">

            <div class="atalhos">


                {{-- PRODUTOS --}}

                <a
                    href="{{ route('admin.produtos.index') }}"
                    class="atalho"
                >

                    <div class="atalho-icon">
                        📦
                    </div>

                    <div>

                        <strong>
                            Produtos
                        </strong>

                        <span>
                            Gerenciar produtos
                        </span>

                    </div>

                </a>


                {{-- CATEGORIAS --}}

                <a
                    href="{{ route('admin.categorias.index') }}"
                    class="atalho"
                >

                    <div class="atalho-icon">
                        📂
                    </div>

                    <div>

                        <strong>
                            Categorias
                        </strong>

                        <span>
                            Gerenciar categorias
                        </span>

                    </div>

                </a>


                {{-- ESTOQUE --}}

                <a
                    href="{{ route('admin.estoque.index') }}"
                    class="atalho"
                >

                    <div class="atalho-icon">
                        📋
                    </div>

                    <div>

                        <strong>
                            Estoque
                        </strong>

                        <span>
                            Controlar estoque
                        </span>

                    </div>

                </a>


                {{-- PEDIDOS --}}

                <a
                    href="{{ route('admin.pedidos.index') }}"
                    class="atalho"
                >

                    <div class="atalho-icon">
                        🧾
                    </div>

                    <div>

                        <strong>
                            Pedidos
                        </strong>

                        <span>
                            Gerenciar pedidos
                        </span>

                    </div>

                </a>

                {{-- RELATÓRIOS --}}

<a
    href="{{ route('admin.relatorios.index') }}"
    class="atalho"
>

    <div class="atalho-icon">
        📊
    </div>

    <div>

        <strong>
            Relatórios
        </strong>

        <span>
            Visualizar relatórios
        </span>

    </div>

</a>

            </div>

        </div>

    </div>


@else


    {{-- =====================================================
         TODAS AS OUTRAS PÁGINAS
         
         Produtos, Categorias, Estoque, Pedidos,
         Perfil etc. entram aqui.
    ====================================================== --}}

    @yield('content')


@endif

</main>

</body>

</html>