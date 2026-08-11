@extends('admin.layouts.app')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:25px;">


<div>
    <h1 style="font-size:28px; color:#111827; margin-bottom:6px;">
        📦 Controle de Estoque
    </h1>

    <p style="color:#64748b;">
        Consulte e gerencie o estoque dos seus produtos.
    </p>
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
    ✓ {{ session('success') }}
</div>


@endif

@if(session('error'))


<div style="
    background:#fee2e2;
    color:#991b1b;
    padding:15px 18px;
    border-radius:10px;
    margin-bottom:20px;
    border:1px solid #fecaca;
">
    ⚠ {{ session('error') }}
</div>


@endif

<div style="
    background:white;
    border-radius:16px;
    box-shadow:0 4px 15px rgba(0,0,0,.06);
    overflow:hidden;
">

<div style="
    padding:20px 25px;
    border-bottom:1px solid #e5e7eb;
">

    <h2 style="
        font-size:18px;
        color:#111827;
    ">
        Produtos em estoque
    </h2>

</div>


<div style="overflow-x:auto;">

    <table style="
        width:100%;
        border-collapse:collapse;
    ">

        <thead>

            <tr style="background:#f8fafc;">

                <th style="padding:15px 20px; text-align:left; color:#64748b;">
                    Produto
                </th>

                <th style="padding:15px 20px; text-align:left; color:#64748b;">
                    SKU
                </th>

                <th style="padding:15px 20px; text-align:center; color:#64748b;">
                    Estoque
                </th>

                <th style="padding:15px 20px; text-align:center; color:#64748b;">
                    Situação
                </th>

                <th style="padding:15px 20px; text-align:right; color:#64748b;">
                    Ações
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse($produtos as $produto)

                <tr style="
                    border-top:1px solid #f1f5f9;
                ">

                    <td style="padding:16px 20px;">

                        <div style="
                            display:flex;
                            align-items:center;
                            gap:12px;
                        ">

                            @if($produto->imagens->count())

                                <img
                                    src="{{ asset('storage/' . $produto->imagens->first()->imagem) }}"
                                    alt="{{ $produto->nome }}"
                                    style="
                                        width:50px;
                                        height:50px;
                                        object-fit:cover;
                                        border-radius:10px;
                                    "
                                >

                            @else

                                <div style="
                                    width:50px;
                                    height:50px;
                                    background:#f1f5f9;
                                    border-radius:10px;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    font-size:22px;
                                ">
                                    📦
                                </div>

                            @endif


                            <div>

                                <strong style="
                                    color:#111827;
                                    display:block;
                                ">
                                    {{ $produto->nome }}
                                </strong>

                                <span style="
                                    color:#64748b;
                                    font-size:13px;
                                ">
                                    {{ $produto->marca ?? 'Sem marca' }}
                                </span>

                            </div>

                        </div>

                    </td>


                    <td style="
                        padding:16px 20px;
                        color:#64748b;
                    ">

                        {{ $produto->sku ?? '---' }}

                    </td>


                    <td style="
                        padding:16px 20px;
                        text-align:center;
                    ">

                        <strong style="
                            font-size:18px;
                            color:#111827;
                        ">
                            {{ $produto->estoque }}
                        </strong>

                        <span style="
                            color:#64748b;
                            font-size:13px;
                        ">
                            {{ $produto->unidade ?? 'un.' }}
                        </span>

                    </td>


                    <td style="
                        padding:16px 20px;
                        text-align:center;
                    ">

                        @if($produto->estoque <= 0)

                            <span style="
                                background:#fee2e2;
                                color:#b91c1c;
                                padding:7px 12px;
                                border-radius:20px;
                                font-size:13px;
                                font-weight:600;
                            ">
                                🔴 Sem estoque
                            </span>

                        @elseif($produto->estoque <= 5)

                            <span style="
                                background:#fef3c7;
                                color:#92400e;
                                padding:7px 12px;
                                border-radius:20px;
                                font-size:13px;
                                font-weight:600;
                            ">
                                🟡 Estoque baixo
                            </span>

                        @else

                            <span style="
                                background:#dcfce7;
                                color:#166534;
                                padding:7px 12px;
                                border-radius:20px;
                                font-size:13px;
                                font-weight:600;
                            ">
                                🟢 Normal
                            </span>

                        @endif

                    </td>


                    <td style="
                        padding:16px 20px;
                        text-align:right;
                    ">

                        <a
                            href="{{ route('admin.estoque.create', $produto) }}"
                            style="
                                display:inline-block;
                                background:#2563eb;
                                color:white;
                                padding:9px 14px;
                                border-radius:8px;
                                text-decoration:none;
                                font-size:13px;
                                font-weight:600;
                            "
                        >
                            ↕ Movimentar
                        </a>


                        <a
                            href="{{ route('admin.estoque.historico', $produto) }}"
                            style="
                                display:inline-block;
                                background:#f1f5f9;
                                color:#334155;
                                padding:9px 14px;
                                border-radius:8px;
                                text-decoration:none;
                                font-size:13px;
                                font-weight:600;
                                margin-left:5px;
                            "
                        >
                            📋 Histórico
                        </a>

                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="5"
                        style="
                            padding:40px;
                            text-align:center;
                            color:#64748b;
                        "
                    >
                        Nenhum produto cadastrado.
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>


</div>

@endsection
