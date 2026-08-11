@extends('admin.layouts.app')

@section('content')

<div style="margin-bottom:25px;">


<h1 style="
    font-size:28px;
    color:#111827;
    margin-bottom:6px;
">
    📋 Histórico de Estoque
</h1>

<p style="color:#64748b;">
    Histórico de movimentações de {{ $produto->nome }}.
</p>


</div>

<div style="
    background:white;
    padding:25px;
    border-radius:16px;
    box-shadow:0 4px 15px rgba(0,0,0,.06);
    margin-bottom:25px;
">


<div style="
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:15px;
">

    <div>

        <h2 style="
            font-size:20px;
            color:#111827;
        ">
            {{ $produto->nome }}
        </h2>

        <p style="
            color:#64748b;
            margin-top:5px;
        ">
            SKU: {{ $produto->sku ?? '---' }}
        </p>

    </div>


    <div style="
        background:#eff6ff;
        color:#1d4ed8;
        padding:12px 18px;
        border-radius:10px;
        font-weight:700;
    ">
        Estoque atual:
        {{ $produto->estoque }}
        {{ $produto->unidade ?? 'un.' }}
    </div>

</div>


</div>

<div style="
    background:white;
    border-radius:16px;
    box-shadow:0 4px 15px rgba(0,0,0,.06);
    overflow:hidden;
">


<div style="overflow-x:auto;">

    <table style="
        width:100%;
        border-collapse:collapse;
    ">

        <thead>

            <tr style="background:#f8fafc;">

                <th style="
                    padding:15px 20px;
                    text-align:left;
                    color:#64748b;
                ">
                    Data
                </th>

                <th style="
                    padding:15px 20px;
                    text-align:center;
                    color:#64748b;
                ">
                    Tipo
                </th>

                <th style="
                    padding:15px 20px;
                    text-align:center;
                    color:#64748b;
                ">
                    Quantidade
                </th>

                <th style="
                    padding:15px 20px;
                    text-align:left;
                    color:#64748b;
                ">
                    Observação
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse($movimentacoes as $movimentacao)

                <tr style="
                    border-top:1px solid #f1f5f9;
                ">

                    <td style="padding:16px 20px;">

                        {{ $movimentacao->created_at->format('d/m/Y H:i') }}

                    </td>


                    <td style="
                        padding:16px 20px;
                        text-align:center;
                    ">

                        @if($movimentacao->tipo === 'entrada')

                            <span style="
                                background:#dcfce7;
                                color:#166534;
                                padding:7px 12px;
                                border-radius:20px;
                                font-size:13px;
                                font-weight:600;
                            ">
                                ➕ Entrada
                            </span>

                        @else

                            <span style="
                                background:#fee2e2;
                                color:#991b1b;
                                padding:7px 12px;
                                border-radius:20px;
                                font-size:13px;
                                font-weight:600;
                            ">
                                ➖ Saída
                            </span>

                        @endif

                    </td>


                    <td style="
                        padding:16px 20px;
                        text-align:center;
                        font-weight:700;
                    ">

                        {{ $movimentacao->quantidade }}

                    </td>


                    <td style="
                        padding:16px 20px;
                        color:#64748b;
                    ">

                        {{ $movimentacao->observacao ?? '---' }}

                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="4"
                        style="
                            padding:40px;
                            text-align:center;
                            color:#64748b;
                        "
                    >
                        Nenhuma movimentação registrada.
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>


</div>

<div style="margin-top:20px;">


<a
    href="{{ route('admin.estoque.index') }}"
    style="
        display:inline-block;
        background:#64748b;
        color:white;
        padding:12px 20px;
        border-radius:8px;
        text-decoration:none;
        font-weight:600;
    "
>
    ← Voltar para estoque
</a>


</div>

@endsection
