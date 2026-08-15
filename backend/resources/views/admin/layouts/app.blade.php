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

        /* =========================================================
           RESET
        ========================================================== */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family:
                'Segoe UI',
                Arial,
                Helvetica,
                sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            display: flex;
            min-height: 100vh;
            background: #f5f7fb;
            color: #0f172a;
        }

        a {
            text-decoration: none;
        }

        button,
        input,
        select,
        textarea {
            font-family: inherit;
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
                    #0f172a 0%,
                    #172033 50%,
                    #111827 100%
                );

            color: white;

            padding: 24px 18px;

            position: fixed;

            left: 0;
            top: 0;
            bottom: 0;

            display: flex;
            flex-direction: column;

            z-index: 1000;

            border-right:
                1px solid rgba(255,255,255,.05);

            box-shadow:
                8px 0 30px rgba(15,23,42,.08);

            overflow-y: auto;
        }


        /* =========================================================
           LOGO
        ========================================================== */

        .logo {

            display: flex;

            align-items: center;

            gap: 12px;

            margin-bottom: 28px;

            padding:
                4px 6px;
        }

        .logo-icon {

            width: 44px;
            height: 44px;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #3b82f6
                );

            border-radius: 13px;

            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 21px;

            box-shadow:
                0 8px 20px rgba(37,99,235,.28);
        }

        .logo h2 {

            font-size: 21px;

            font-weight: 750;

            letter-spacing: -.4px;

            color: #ffffff;
        }


        /* =========================================================
           USUÁRIO
        ========================================================== */

        .usuario {

            background:
                linear-gradient(
                    135deg,
                    rgba(255,255,255,.07),
                    rgba(255,255,255,.035)
                );

            border:
                1px solid rgba(255,255,255,.08);

            border-radius: 16px;

            padding: 14px;

            margin-bottom: 28px;

            transition:
                background .25s ease,
                border-color .25s ease,
                transform .25s ease;
        }

        .usuario:hover {

            background:
                rgba(255,255,255,.09);

            border-color:
                rgba(255,255,255,.13);

            transform:
                translateY(-1px);
        }

        .usuario-link {

            display: flex;

            align-items: center;

            gap: 12px;

            color: white;

            text-decoration: none;
        }

        .usuario-foto {

            width: 50px;
            height: 50px;

            min-width: 50px;

            border-radius: 50%;

            object-fit: cover;

            border:
                3px solid #3b82f6;

            background:
                linear-gradient(
                    135deg,
                    #334155,
                    #475569
                );

            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 19px;

            font-weight: 700;

            flex-shrink: 0;

            box-shadow:
                0 0 0 3px rgba(59,130,246,.12);
        }

        .usuario-info {

            min-width: 0;

            flex: 1;
        }

        .usuario-nome {

            font-size: 14px;

            font-weight: 650;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;

            color: #f8fafc;
        }

        .usuario-perfil {

            color: #94a3b8;

            font-size: 12px;

            margin-top: 4px;
        }


        /* =========================================================
           MENU
        ========================================================== */

        .menu {

            flex: 1;
        }

        .menu-title {

            color: #64748b;

            font-size: 10px;

            font-weight: 700;

            text-transform: uppercase;

            margin:
                0 10px 10px;

            letter-spacing:
                1.2px;
        }

        .sidebar a {

            display: flex;

            align-items: center;

            gap: 12px;

            color: #cbd5e1;

            text-decoration: none;

            padding:
                12px 13px;

            border-radius: 11px;

            margin-bottom: 5px;

            transition:
                background .2s ease,
                color .2s ease,
                transform .2s ease;
        }

        .sidebar a:hover {

            background:
                rgba(59,130,246,.13);

            color: #ffffff;

            transform:
                translateX(3px);
        }

        .sidebar a.ativo {

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #1d4ed8
                );

            color: white;

            box-shadow:
                0 6px 18px rgba(37,99,235,.25);
        }

        .sidebar a .icone {

            width: 28px;

            height: 28px;

            display: flex;

            align-items: center;
            justify-content: center;

            text-align: center;

            font-size: 17px;

            flex-shrink: 0;
        }

        .sidebar a span:not(.icone) {

            font-size: 14px;

            font-weight: 500;
        }


        /* =========================================================
           LOGOUT
        ========================================================== */

        .logout {

            margin-top: 18px;

            padding-top: 16px;

            border-top:
                1px solid rgba(255,255,255,.07);
        }

        .logout form {

            width: 100%;
        }

        .logout button {

            width: 100%;

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 9px;

            background:
                rgba(220,38,38,.12);

            color: #fca5a5;

            border:
                1px solid rgba(248,113,113,.12);

            border-radius: 11px;

            padding: 12px;

            font-size: 14px;

            font-weight: 600;

            cursor: pointer;

            transition:
                background .2s ease,
                color .2s ease,
                transform .2s ease;
        }

        .logout button:hover {

            background:
                #dc2626;

            color: white;

            transform:
                translateY(-2px);

            box-shadow:
                0 6px 18px rgba(220,38,38,.20);
        }


        /* =========================================================
           CONTEÚDO
        ========================================================== */

        .content {

            margin-left: 270px;

            width:
                calc(100% - 270px);

            padding:
                32px;

            min-height: 100vh;

            overflow-x: hidden;
        }


        /* =========================================================
           DASHBOARD HEADER
        ========================================================== */

        .dashboard-header {

            position: relative;

            background:
                linear-gradient(
                    135deg,
                    #ffffff 0%,
                    #f8fafc 100%
                );

            padding:
                27px 30px;

            border-radius: 18px;

            margin-bottom: 24px;

            border:
                1px solid #e8edf5;

            box-shadow:
                0 8px 30px rgba(15,23,42,.05);

            overflow: hidden;
        }

        .dashboard-header::after {

            content: '';

            position: absolute;

            width: 180px;
            height: 180px;

            right: -70px;
            top: -90px;

            background:
                rgba(37,99,235,.07);

            border-radius: 50%;
        }

        .dashboard-header h1 {

            position: relative;

            z-index: 1;

            margin: 0;

            color: #0f172a;

            font-size: 27px;

            font-weight: 750;

            letter-spacing: -.6px;
        }

        .dashboard-header p {

            position: relative;

            z-index: 1;

            margin-top: 7px;

            color: #64748b;

            font-size: 14px;
        }


        /* =========================================================
           CARDS
        ========================================================== */

        .cards {

            display: grid;

            grid-template-columns:
                repeat(4, minmax(0, 1fr));

            gap: 18px;

            margin-bottom: 20px;
        }

        .card-dashboard {

            position: relative;

            background: #ffffff;

            padding:
                21px;

            min-height: 145px;

            border-radius: 17px;

            border:
                1px solid #e8edf5;

            box-shadow:
                0 5px 20px rgba(15,23,42,.045);

            overflow: hidden;

            transition:
                transform .22s ease,
                box-shadow .22s ease,
                border-color .22s ease;
        }

        .card-dashboard::after {

            content: '';

            position: absolute;

            width: 90px;
            height: 90px;

            right: -35px;
            bottom: -45px;

            background:
                rgba(37,99,235,.035);

            border-radius: 50%;
        }

        .card-dashboard:hover {

            transform:
                translateY(-4px);

            border-color:
                #dbe5f3;

            box-shadow:
                0 12px 30px rgba(15,23,42,.08);
        }

        .card-top {

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 15px;
        }

        .card-icon {

            width: 48px;
            height: 48px;

            border-radius: 13px;

            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 21px;

            flex-shrink: 0;

            box-shadow:
                inset 0 0 0 1px rgba(0,0,0,.025);
        }

        .card-title {

            margin-top: 17px;

            color: #64748b;

            font-size: 13px;

            font-weight: 600;
        }

        .card-value {

            margin-top: 4px;

            color: #0f172a;

            font-size: 28px;

            line-height: 1.2;

            font-weight: 800;

            letter-spacing: -.7px;
        }


        /* =========================================================
           SEGUNDA LINHA
        ========================================================== */

        .cards + .cards {

            margin-top: 0;
        }

        .cards + .cards .card-dashboard {

            min-height: 125px;
        }


        /* =========================================================
           GRID DO DASHBOARD
        ========================================================== */

        .dashboard-grid {

            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 20px;

            margin-bottom: 20px;
        }


        /* =========================================================
           BOX
        ========================================================== */

        .dashboard-box {

            background: #ffffff;

            border-radius: 17px;

            border:
                1px solid #e8edf5;

            box-shadow:
                0 5px 20px rgba(15,23,42,.045);

            overflow: hidden;

            transition:
                box-shadow .2s ease;
        }

        .dashboard-box:hover {

            box-shadow:
                0 9px 28px rgba(15,23,42,.065);
        }

        .box-header {

            display: flex;

            flex-direction: column;

            padding:
                19px 22px;

            border-bottom:
                1px solid #edf1f6;

            background:
                #ffffff;
        }

        .box-header h2 {

            margin: 0;

            color: #0f172a;

            font-size: 17px;

            font-weight: 700;
        }

        .box-header p {

            margin-top: 5px;

            color: #94a3b8;

            font-size: 12px;
        }

        .box-body {

            padding:
                7px 22px 15px;
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

            padding:
                14px 0;

            border-bottom:
                1px solid #f1f5f9;

            transition:
                background .2s ease;
        }

        .produto-item:last-child,
        .pedido-item:last-child {

            border-bottom: none;
        }

        .produto-info,
        .pedido-info {

            min-width: 0;

            flex: 1;
        }

        .produto-nome,
        .pedido-numero {

            font-weight: 650;

            color: #1e293b;

            font-size: 14px;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;
        }

        .produto-categoria,
        .pedido-cliente {

            margin-top: 4px;

            color: #94a3b8;

            font-size: 11px;
        }

        .produto-preco,
        .pedido-total {

            font-weight: 750;

            color: #0f172a;

            font-size: 13px;

            white-space: nowrap;
        }


        /* =========================================================
           STATUS
        ========================================================== */

        .pedido-status {

            display: inline-flex;

            align-items: center;

            margin-top: 6px;

            padding:
                4px 9px;

            border-radius: 20px;

            font-size: 10px;

            font-weight: 700;

            letter-spacing: .1px;
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

            padding:
                35px 20px;

            text-align: center;

            color: #94a3b8;

            font-size: 13px;
        }


        /* =========================================================
           ACESSOS RÁPIDOS
        ========================================================== */

        .atalhos {

            display: grid;

            grid-template-columns:
                repeat(3, minmax(0, 1fr));

            gap: 13px;
        }

        .atalho {

            display: flex;

            align-items: center;

            gap: 12px;

            padding:
                15px;

            background:
                #f8fafc;

            border:
                1px solid #edf1f6;

            border-radius: 13px;

            text-decoration: none;

            color: #111827;

            transition:
                transform .2s ease,
                background .2s ease,
                border-color .2s ease,
                box-shadow .2s ease;
        }

        .atalho:hover {

            transform:
                translateY(-3px);

            background:
                #ffffff;

            border-color:
                #dbe5f3;

            box-shadow:
                0 8px 20px rgba(15,23,42,.07);
        }

        .atalho-icon {

            width: 43px;
            height: 43px;

            border-radius: 11px;

            background: #eff6ff;

            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 20px;

            flex-shrink: 0;
        }

        .atalho strong {

            display: block;

            color: #1e293b;

            font-size: 13px;

            font-weight: 700;
        }

        .atalho span {

            display: block;

            margin-top: 3px;

            color: #94a3b8;

            font-size: 10px;
        }


        /* =========================================================
           SCROLLBAR
        ========================================================== */

        .sidebar::-webkit-scrollbar {

            width: 5px;
        }

        .sidebar::-webkit-scrollbar-track {

            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {

            background:
                rgba(148,163,184,.25);

            border-radius: 10px;
        }


        /* =========================================================
           RESPONSIVO 1200
        ========================================================== */

        @media(max-width:1200px) {

            .content {

                padding:
                    25px;
            }

            .cards {

                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

            .atalhos {

                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

        }


        /* =========================================================
           RESPONSIVO 900
        ========================================================== */

        @media(max-width:900px) {

            .dashboard-grid {

                grid-template-columns:
                    1fr;
            }

        }


        /* =========================================================
           RESPONSIVO SIDEBAR
        ========================================================== */

        @media(max-width:800px) {

            .sidebar {

                width: 78px;

                padding:
                    18px 9px;

                align-items: center;
            }

            .logo {

                justify-content: center;

                margin-bottom: 24px;

                padding: 0;
            }

            .logo-icon {

                width: 45px;
                height: 45px;
            }

            .logo h2,
            .sidebar a span:not(.icone),
            .usuario-info,
            .menu-title {

                display: none;
            }

            .usuario {

                width: 58px;

                padding: 6px;

                margin-bottom: 25px;
            }

            .usuario-link {

                justify-content: center;
            }

            .usuario-foto {

                width: 45px;
                height: 45px;

                min-width: 45px;
            }

            .sidebar a {

                width: 58px;

                height: 48px;

                padding: 8px;

                justify-content: center;

                margin-bottom: 6px;
            }

            .sidebar a .icone {

                width: auto;

                font-size: 19px;
            }

            .sidebar a:hover {

                transform:
                    translateX(0)
                    scale(1.03);
            }

            .logout {

                width: 100%;
            }

            .logout button {

                width: 58px;

                height: 48px;

                padding: 8px;

                margin: 0 auto;

                font-size: 0;
            }

            .logout button span {

                display: none;
            }

            .logout button::before {

                content: '↪';

                font-size: 20px;
            }

            .content {

                margin-left: 78px;

                width:
                    calc(100% - 78px);

                padding:
                    20px;
            }

        }


        /* =========================================================
           RESPONSIVO 600
        ========================================================== */

        @media(max-width:600px) {

            .content {

                padding:
                    14px;
            }

            .dashboard-header {

                padding:
                    21px;

                border-radius: 15px;
            }

            .dashboard-header h1 {

                font-size: 22px;
            }

            .dashboard-header p {

                font-size: 12px;
            }

            .cards {

                grid-template-columns:
                    1fr;

                gap: 12px;

                margin-bottom: 12px;
            }

            .card-dashboard {

                min-height: auto;

                padding:
                    18px;
            }

            .dashboard-grid {

                gap: 12px;
            }

            .dashboard-box {

                border-radius: 14px;
            }

            .box-header {

                padding:
                    17px;
            }

            .box-body {

                padding:
                    5px 17px 12px;
            }

            .atalhos {

                grid-template-columns:
                    1fr;
            }

            .atalho {

                padding:
                    14px;
            }

        }


        /* =========================================================
           RESPONSIVO 420
        ========================================================== */

        @media(max-width:420px) {

            .sidebar {

                width: 64px;

                padding:
                    15px 6px;
            }

            .usuario {

                width: 48px;
            }

            .usuario-foto {

                width: 38px;
                height: 38px;

                min-width: 38px;

                font-size: 15px;
            }

            .sidebar a {

                width: 48px;

                height: 45px;
            }

            .logout button {

                width: 48px;
            }

            .content {

                margin-left: 64px;

                width:
                    calc(100% - 64px);

                padding:
                    10px;
            }

            .dashboard-header {

                padding:
                    18px;
            }

            .card-value {

                font-size: 25px;
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


        {{-- CARROSSEL --}}

        <a
            href="{{ route('admin.carrossel.index') }}"
            class="{{ request()->routeIs('admin.carrossel.*') ? 'ativo' : '' }}"
        >

            <span class="icone">
                🎞️
            </span>

            <span>
                Carrossel
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
                    margin-top:6px;
                    color:#94a3b8;
                    font-size:11px;
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


        {{-- ÚLTIMOS PRODUTOS --}}

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


        {{-- ÚLTIMOS PEDIDOS --}}

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


                {{-- CARROSSEL --}}

                <a
                    href="{{ route('admin.carrossel.index') }}"
                    class="atalho"
                >

                    <div class="atalho-icon">
                        🎞️
                    </div>

                    <div>

                        <strong>
                            Carrossel
                        </strong>

                        <span>
                            Gerenciar imagens e vídeos
                        </span>

                    </div>

                </a>


            </div>

        </div>

    </div>


@else


    {{-- =====================================================
         TODAS AS OUTRAS PÁGINAS
    ====================================================== --}}

    @yield('content')


@endif

</main>

</body>

</html>