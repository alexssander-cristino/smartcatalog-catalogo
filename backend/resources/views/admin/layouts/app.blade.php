<!DOCTYPE html>

<html lang="pt-BR">

<head>


<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>
    SmartCatalog
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


    /* ==========================
       SIDEBAR
    ========================== */

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

    }


    /* ==========================
       LOGO
    ========================== */

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


    /* ==========================
       PERFIL
    ========================== */

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


    /* ==========================
       MENU
    ========================== */

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

    .sidebar a .icone {

        width: 25px;

        text-align: center;

        font-size: 18px;

    }


    /* ==========================
       ESPAÇO DO MENU
    ========================== */

    .menu {

        flex: 1;

    }


    /* ==========================
       LOGOUT
    ========================== */

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


    /* ==========================
       CONTEÚDO
    ========================== */

    .content {

        margin-left: 270px;

        width: calc(100% - 270px);

        padding: 35px;

        min-height: 100vh;

    }


    .header {

        background: white;

        padding: 25px;

        border-radius: 16px;

        margin-bottom: 25px;

        box-shadow:
            0 4px 15px rgba(0,0,0,.06);

    }


    .card {

        background: white;

        padding: 25px;

        border-radius: 16px;

        box-shadow:
            0 4px 15px rgba(0,0,0,.06);

    }


    button {

        font-family: inherit;

    }


    /* ==========================
       RESPONSIVO
    ========================== */

    @media(max-width:800px) {

        .sidebar {

            width: 80px;

            padding: 20px 10px;

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

            width: calc(100% - 80px);

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


    {{-- PERFIL DO USUÁRIO --}}

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


        <a href="{{ route('admin.dashboard') }}">

            <span class="icone">
                📊
            </span>

            <span>
                Dashboard
            </span>

        </a>


        <a href="{{ route('admin.categorias.index') }}">

            <span class="icone">
                📂
            </span>

            <span>
                Categorias
            </span>

        </a>


        <a href="{{ route('admin.produtos.index') }}">

            <span class="icone">
                📦
            </span>

            <span>
                Produtos
            </span>

        </a>


        <a href="{{ route('admin.estoque.index') }}">

            <span class="icone">
                📋
            </span>

            <span>
                Estoque
            </span>

        </a>


        {{-- PEDIDOS --}}

        <a href="{{ route('admin.pedidos.index') }}">

            <span class="icone">
                🧾
            </span>

            <span>
                Pedidos
            </span>

        </a>


        <a href="{{ route('profile.edit') }}">

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


{{-- CONTEÚDO --}}

<div class="content">

    @yield('content')

</div>


</body>

</html>
