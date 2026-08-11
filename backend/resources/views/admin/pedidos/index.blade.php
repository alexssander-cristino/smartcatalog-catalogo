@extends('admin.layouts.app')

@section('content')

<h1 style="
    font-size:28px;
    color:#111827;
    margin-bottom:5px;
">
    🧾 Pedidos
</h1>

<p style="
    color:#64748b;
    margin:0;
">
    Consulte e gerencie os pedidos emitidos.
</p>

<a
href="{{ route('admin.pedidos.create') }}"
style="
display:inline-flex;
align-items:center;
gap:8px;
background:#2563eb;
color:white;
padding:12px 20px;
border-radius:9px;
text-decoration:none;
font-weight:600;
margin-top:20px;
margin-bottom:20px;
"

>


+ Emitir Pedido


</a>

{{-- MENSAGEM DE SUCESSO --}}

@if(session('success'))


<div style="
    background:#dcfce7;
    color:#166534;
    padding:12px 16px;
    border-radius:8px;
    margin-bottom:15px;
    font-weight:600;
">
    ✓ {{ session('success') }}
</div>


@endif

{{-- MENSAGEM DE ERRO --}}

@if(session('error'))


<div style="
    background:#fee2e2;
    color:#991b1b;
    padding:12px 16px;
    border-radius:8px;
    margin-bottom:15px;
    font-weight:600;
">
    ⚠ {{ session('error') }}
</div>


@endif

{{-- ERROS DE VALIDAÇÃO --}}

@if($errors->any())


<div style="
    background:#fef3c7;
    color:#92400e;
    padding:12px 16px;
    border-radius:8px;
    margin-bottom:15px;
">

    @foreach($errors->all() as $error)

        <div style="margin-bottom:5px;">
            ⚠️ {{ $error }}
        </div>

    @endforeach

</div>


@endif

{{-- LISTA DE PEDIDOS --}}

@if($pedidos->count())


{{-- CABEÇALHO --}}

<div style="
    margin-bottom:20px;
">

    <h2 style="
        margin:0;
        color:#111827;
        font-size:20px;
    ">
        Pedidos emitidos
    </h2>

    <p style="
        margin-top:4px;
        margin-bottom:0;
        color:#64748b;
        font-size:14px;
    ">

        {{ $pedidos->count() }}

        {{ $pedidos->count() == 1
            ? 'pedido cadastrado'
            : 'pedidos cadastrados'
        }}

    </p>

</div>

{{-- TABELA --}}

<div style="
    overflow-x:auto;
    background:white;
    border-radius:12px;
    border:1px solid #e5e7eb;
">

    <table style="
        width:100%;
        border-collapse:collapse;
        min-width:1000px;
    ">

        <thead>

            <tr style="
                background:#f8fafc;
                border-bottom:1px solid #e5e7eb;
            ">

                {{-- ID --}}

                <th style="
                    padding:16px 20px;
                    text-align:left;
                    color:#475569;
                    font-size:13px;
                    font-weight:700;
                ">
                    ID
                </th>

                {{-- NÚMERO --}}

                <th style="
                    padding:16px 20px;
                    text-align:left;
                    color:#475569;
                    font-size:13px;
                    font-weight:700;
                ">
                    Pedido
                </th>

                {{-- CLIENTE --}}

                <th style="
                    padding:16px 20px;
                    text-align:left;
                    color:#475569;
                    font-size:13px;
                    font-weight:700;
                ">
                    Cliente
                </th>

                {{-- ITENS --}}

                <th style="
                    padding:16px 20px;
                    text-align:left;
                    color:#475569;
                    font-size:13px;
                    font-weight:700;
                ">
                    Itens
                </th>

                {{-- TOTAL --}}

                <th style="
                    padding:16px 20px;
                    text-align:left;
                    color:#475569;
                    font-size:13px;
                    font-weight:700;
                ">
                    Total
                </th>

                {{-- STATUS --}}

                <th style="
                    padding:16px 20px;
                    text-align:left;
                    color:#475569;
                    font-size:13px;
                    font-weight:700;
                ">
                    Status
                </th>

                {{-- EMISSÃO --}}

                <th style="
                    padding:16px 20px;
                    text-align:left;
                    color:#475569;
                    font-size:13px;
                    font-weight:700;
                ">
                    Emissão
                </th>

                {{-- AÇÕES --}}

                <th style="
                    padding:16px 20px;
                    text-align:center;
                    color:#475569;
                    font-size:13px;
                    font-weight:700;
                ">
                    Ações
                </th>

            </tr>

        </thead>

        <tbody>

            @foreach($pedidos as $pedido)

                <tr style="
                    border-bottom:1px solid #f1f5f9;
                ">

                    {{-- ID --}}

                    <td style="
                        padding:18px 20px;
                        color:#64748b;
                        font-weight:700;
                    ">

                        #{{ $pedido->id }}

                    </td>

                    {{-- NÚMERO DO PEDIDO --}}

                    <td style="
                        padding:18px 20px;
                    ">

                        <div style="
                            font-weight:800;
                            color:#111827;
                            font-size:14px;
                        ">

                            {{ $pedido->numero }}

                        </div>

                        <div style="
                            color:#94a3b8;
                            font-size:11px;
                            margin-top:4px;
                        ">

                            ID interno #{{ $pedido->id }}

                        </div>

                    </td>

                    {{-- CLIENTE --}}

                    <td style="
                        padding:18px 20px;
                        color:#475569;
                    ">

                        @if($pedido->cliente)

                            <div style="
                                font-weight:600;
                                color:#334155;
                            ">

                                {{ $pedido->cliente }}

                            </div>

                        @else

                            <span style="
                                color:#94a3b8;
                                font-style:italic;
                            ">
                                Não informado
                            </span>

                        @endif

                    </td>

                    {{-- ITENS --}}

                    <td style="
                        padding:18px 20px;
                        color:#475569;
                    ">

                        <span style="
                            background:#eff6ff;
                            color:#1d4ed8;
                            padding:6px 10px;
                            border-radius:20px;
                            font-size:12px;
                            font-weight:700;
                        ">

                            {{ $pedido->itens->sum('quantidade') }}

                            {{ $pedido->itens->sum('quantidade') == 1
                                ? 'item'
                                : 'itens'
                            }}

                        </span>

                    </td>

                    {{-- TOTAL --}}

                    <td style="
                        padding:18px 20px;
                        font-weight:800;
                        color:#111827;
                    ">

                        R$

                        {{ number_format(
                            $pedido->valor_total,
                            2,
                            ',',
                            '.'
                        ) }}

                    </td>

                    {{-- STATUS --}}

                    <td style="
                        padding:18px 20px;
                    ">

                        @if($pedido->status === 'emitido')

                            <span style="
                                display:inline-block;
                                background:#dcfce7;
                                color:#166534;
                                padding:6px 11px;
                                border-radius:20px;
                                font-size:12px;
                                font-weight:700;
                            ">
                                ✓ Emitido
                            </span>

                        @elseif($pedido->status === 'cancelado')

                            <span style="
                                display:inline-block;
                                background:#fee2e2;
                                color:#991b1b;
                                padding:6px 11px;
                                border-radius:20px;
                                font-size:12px;
                                font-weight:700;
                            ">
                                ✕ Cancelado
                            </span>

                        @else

                            <span style="
                                display:inline-block;
                                background:#f1f5f9;
                                color:#475569;
                                padding:6px 11px;
                                border-radius:20px;
                                font-size:12px;
                                font-weight:700;
                            ">

                                {{ ucfirst($pedido->status) }}

                            </span>

                        @endif

                    </td>

                    {{-- DATA DE EMISSÃO --}}

                    <td style="
                        padding:18px 20px;
                        color:#64748b;
                        white-space:nowrap;
                    ">

                        @if($pedido->emitido_em)

                            {{ $pedido->emitido_em->format('d/m/Y') }}

                            <div style="
                                color:#94a3b8;
                                font-size:12px;
                                margin-top:3px;
                            ">

                                {{ $pedido->emitido_em->format('H:i') }}

                            </div>

                        @elseif($pedido->created_at)

                            {{ $pedido->created_at->format('d/m/Y') }}

                            <div style="
                                color:#94a3b8;
                                font-size:12px;
                                margin-top:3px;
                            ">

                                {{ $pedido->created_at->format('H:i') }}

                            </div>

                        @else

                            <span style="color:#94a3b8;">
                                Não informado
                            </span>

                        @endif

                    </td>

                    {{-- AÇÕES --}}

                    <td style="
                        padding:18px 20px;
                        text-align:center;
                    ">

                        <div style="
                            display:flex;
                            justify-content:center;
                            align-items:center;
                            gap:8px;
                            flex-wrap:wrap;
                        ">

                            {{-- VER --}}

                            <a
                                href="{{ route(
                                    'admin.pedidos.show',
                                    $pedido
                                ) }}"
                                style="
                                    background:#2563eb;
                                    color:white;
                                    padding:8px 13px;
                                    border-radius:7px;
                                    text-decoration:none;
                                    font-size:13px;
                                    font-weight:600;
                                "
                            >
                                👁 Ver
                            </a>

                            {{-- CANCELAR --}}

                            @if($pedido->status !== 'cancelado')

                                <form
                                    method="POST"
                                    action="{{ route(
                                        'admin.pedidos.destroy',
                                        $pedido
                                    ) }}"
                                    onsubmit="
                                        return confirm(
                                            'Tem certeza que deseja cancelar este pedido? O estoque será restaurado.'
                                        );
                                    "
                                    style="margin:0;"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        style="
                                            background:#dc2626;
                                            color:white;
                                            border:none;
                                            padding:8px 13px;
                                            border-radius:7px;
                                            cursor:pointer;
                                            font-size:13px;
                                            font-weight:600;
                                        "
                                    >
                                        ✕ Cancelar
                                    </button>

                                </form>

                            @endif

                        </div>

                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

</div>


@else


{{-- NENHUM PEDIDO --}}

<div style="
    padding:60px 30px;
    text-align:center;
">

    <div style="
        width:80px;
        height:80px;
        margin:0 auto 20px;
        background:#eff6ff;
        border-radius:50%;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:40px;
    ">
        🧾
    </div>

    <h2 style="
        color:#111827;
        margin-bottom:8px;
    ">
        Nenhum pedido emitido
    </h2>

    <p style="
        color:#64748b;
        margin-bottom:22px;
    ">
        Ainda não existem pedidos cadastrados no sistema.
    </p>

    <a
        href="{{ route('admin.pedidos.create') }}"
        style="
            display:inline-block;
            background:#2563eb;
            color:white;
            padding:12px 20px;
            border-radius:8px;
            text-decoration:none;
            font-weight:600;
        "
    >
        + Emitir primeiro pedido
    </a>

</div>


@endif

@endsection
