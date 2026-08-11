@extends('admin.layouts.app')

@section('content')

<div style="
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:20px;
    margin-bottom:25px;
">


<div>

    <h1 style="
        font-size:28px;
        color:#111827;
        margin-bottom:5px;
    ">
        🧾 Pedido #{{ $pedido->id }}
    </h1>

    <p style="
        color:#64748b;
    ">
        Emitido em
        {{ $pedido->created_at->format('d/m/Y H:i') }}
    </p>

</div>


<div style="
    display:flex;
    gap:10px;
    flex-wrap:wrap;
">

    <a
        href="{{ route('admin.pedidos.index') }}"
        style="
            background:#64748b;
            color:white;
            padding:12px 20px;
            border-radius:8px;
            text-decoration:none;
            font-weight:600;
        "
    >
        ← Voltar
    </a>


    <button
        type="button"
        onclick="window.print()"
        style="
            background:#2563eb;
            color:white;
            border:none;
            padding:12px 20px;
            border-radius:8px;
            font-weight:600;
            cursor:pointer;
        "
    >
        🖨️ Imprimir
    </button>

</div>


</div>

@if(session('success'))


<div style="
    background:#dcfce7;
    color:#166534;
    padding:15px 18px;
    border-radius:10px;
    margin-bottom:20px;
    border:1px solid #bbf7d0;
">

    ✅ {{ session('success') }}

</div>


@endif

<div style="
    background:white;
    border-radius:16px;
    padding:25px;
    box-shadow:0 4px 15px rgba(0,0,0,.06);
">


{{-- CABEÇALHO DO PEDIDO --}}

<div style="
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:20px;
    padding-bottom:20px;
    border-bottom:1px solid #e5e7eb;
    margin-bottom:20px;
">

    <div>

        <div style="
            font-size:20px;
            font-weight:700;
            color:#111827;
        ">
            Pedido #{{ $pedido->id }}
        </div>


        <p style="
            color:#64748b;
            margin-top:6px;
        ">

            Emitido por:

            <strong style="color:#374151;">
                {{ $pedido->usuario->name ?? 'Sistema' }}
            </strong>

        </p>


        <p style="
            color:#64748b;
            margin-top:4px;
        ">

            Data:

            <strong style="color:#374151;">
                {{ $pedido->created_at->format('d/m/Y H:i') }}
            </strong>

        </p>

    </div>


    <div style="
        background:#dcfce7;
        color:#166534;
        padding:8px 16px;
        border-radius:20px;
        font-weight:600;
        white-space:nowrap;
    ">

        {{ ucfirst($pedido->status) }}

    </div>

</div>


{{-- PRODUTOS --}}

<h2 style="
    font-size:20px;
    color:#111827;
    margin-bottom:15px;
">
    Produtos do pedido
</h2>


<div style="
    overflow-x:auto;
">

    <table style="
        width:100%;
        border-collapse:collapse;
    ">

        <thead>

            <tr style="
                background:#f8fafc;
                text-align:left;
            ">

                <th style="
                    padding:14px;
                    color:#374151;
                    font-size:14px;
                ">
                    Produto
                </th>


                <th style="
                    padding:14px;
                    color:#374151;
                    font-size:14px;
                ">
                    Quantidade
                </th>


                <th style="
                    padding:14px;
                    color:#374151;
                    font-size:14px;
                ">
                    Preço unitário
                </th>


                <th style="
                    padding:14px;
                    color:#374151;
                    font-size:14px;
                    text-align:right;
                ">
                    Subtotal
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse($pedido->itens as $item)

                <tr style="
                    border-top:1px solid #e5e7eb;
                ">

                    <td style="
                        padding:14px;
                        color:#111827;
                        font-weight:600;
                    ">

                        {{ $item->produto->nome }}

                    </td>


                    <td style="
                        padding:14px;
                        color:#475569;
                    ">

                        {{ $item->quantidade }}

                    </td>


                    <td style="
                        padding:14px;
                        color:#475569;
                    ">

                        R$
                        {{ number_format(
                            $item->preco_unitario,
                            2,
                            ',',
                            '.'
                        ) }}

                    </td>


                    <td style="
                        padding:14px;
                        color:#111827;
                        font-weight:700;
                        text-align:right;
                    ">

                        R$
                        {{ number_format(
                            $item->subtotal,
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
                        style="
                            padding:30px;
                            text-align:center;
                            color:#64748b;
                        "
                    >

                        Nenhum produto registrado neste pedido.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>


{{-- TOTAL --}}

<div style="
    display:flex;
    justify-content:flex-end;
    margin-top:25px;
    padding-top:20px;
    border-top:1px solid #e5e7eb;
">

    <div style="
        min-width:220px;
        text-align:right;
    ">

        <span style="
            color:#64748b;
            font-size:15px;
        ">
            Total do pedido
        </span>


        <div style="
            font-size:30px;
            font-weight:800;
            color:#2563eb;
            margin-top:4px;
        ">

            R$
            {{ number_format(
                $pedido->valor_total,
                2,
                ',',
                '.'
            ) }}

        </div>

    </div>

</div>


{{-- OBSERVAÇÃO --}}

@if($pedido->observacao)

    <div style="
        margin-top:25px;
        background:#f8fafc;
        padding:18px;
        border-radius:10px;
        border:1px solid #e5e7eb;
    ">

        <strong style="
            color:#111827;
        ">
            Observação
        </strong>


        <p style="
            margin-top:7px;
            color:#64748b;
            line-height:1.6;
        ">
            {{ $pedido->observacao }}
        </p>

    </div>

@endif


</div>

<style>

@media print {

    body {
        background:white !important;
    }

    .sidebar {
        display:none !important;
    }

    .content {
        margin-left:0 !important;
        width:100% !important;
        padding:0 !important;
    }

    button,
    a {
        display:none !important;
    }

}

</style>

@endsection
