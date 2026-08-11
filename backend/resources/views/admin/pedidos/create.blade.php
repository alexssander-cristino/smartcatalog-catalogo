@extends('admin.layouts.app')

@section('content')

<div style="
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
    gap:15px;
    flex-wrap:wrap;
">


<div>

    <h1 style="
        font-size:28px;
        color:#111827;
        margin-bottom:5px;
    ">
        🧾 Emitir Pedido
    </h1>

    <p style="
        color:#64748b;
    ">
        Monte o pedido e baixe os produtos do estoque.
    </p>

</div>


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
    ← Pedidos
</a>


</div>

@if($errors->any())


<div style="
    background:#fee2e2;
    color:#991b1b;
    padding:15px 18px;
    border-radius:10px;
    margin-bottom:20px;
    border:1px solid #fecaca;
">

    <strong style="
        display:block;
        margin-bottom:8px;
    ">
        ⚠️ Verifique os dados:
    </strong>

    @foreach($errors->all() as $error)

        <div style="
            margin-bottom:5px;
        ">
            • {{ $error }}
        </div>

    @endforeach

</div>


@endif

<form
    method="POST"
    action="{{ route('admin.pedidos.store') }}"
    id="pedido-form"
>


@csrf


<div style="
    background:white;
    border-radius:16px;
    padding:25px;
    box-shadow:0 4px 15px rgba(0,0,0,.06);
    margin-bottom:20px;
">

    <h2 style="
        margin-bottom:20px;
        color:#111827;
        font-size:20px;
    ">
        Informações do pedido
    </h2>


    <div style="
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:15px;
    ">

        <div>

            <label style="
                display:block;
                font-weight:600;
                color:#374151;
                margin-bottom:8px;
            ">
                Cliente
            </label>

            <input
                type="text"
                name="cliente"
                value="{{ old('cliente') }}"
                placeholder="Nome do cliente (opcional)"
                style="
                    width:100%;
                    padding:12px;
                    border:1px solid #d1d5db;
                    border-radius:8px;
                "
            >

        </div>


        <div>

            <label style="
                display:block;
                font-weight:600;
                color:#374151;
                margin-bottom:8px;
            ">
                Data do pedido
            </label>

            <input
                type="text"
                value="{{ now()->format('d/m/Y H:i') }}"
                readonly
                style="
                    width:100%;
                    padding:12px;
                    border:1px solid #d1d5db;
                    border-radius:8px;
                    background:#f8fafc;
                    color:#64748b;
                "
            >

        </div>

    </div>

</div>


<div style="
    background:white;
    border-radius:16px;
    padding:25px;
    box-shadow:0 4px 15px rgba(0,0,0,.06);
">

    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:20px;
        gap:10px;
        flex-wrap:wrap;
    ">

        <div>

            <h2 style="
                color:#111827;
                font-size:20px;
                margin-bottom:4px;
            ">
                Produtos
            </h2>

            <p style="
                color:#64748b;
                font-size:14px;
            ">
                Selecione os produtos e informe as quantidades.
            </p>

        </div>


        <button
            type="button"
            id="adicionar-produto"
            style="
                background:#e0f2fe;
                color:#0369a1;
                border:none;
                padding:11px 18px;
                border-radius:8px;
                cursor:pointer;
                font-weight:600;
            "
        >
            + Adicionar produto
        </button>

    </div>


    <div id="produtos-container">

        @php

            $produtosOld = old('produtos', [
                [
                    'produto_id' => '',
                    'quantidade' => 1
                ]
            ]);

        @endphp


        @foreach($produtosOld as $index => $oldProduto)

            <div
                class="produto-linha"
                style="
                    display:grid;
                    grid-template-columns:minmax(200px,1fr) 150px 130px 45px;
                    gap:12px;
                    align-items:end;
                    margin-bottom:15px;
                    padding-bottom:15px;
                    border-bottom:1px solid #e5e7eb;
                "
            >

                <div>

                    <label style="
                        display:block;
                        font-weight:600;
                        margin-bottom:7px;
                        color:#374151;
                    ">
                        Produto
                    </label>


                    <select
                        name="produtos[{{ $index }}][produto_id]"
                        class="produto-select"
                        required
                        style="
                            width:100%;
                            padding:12px;
                            border:1px solid #d1d5db;
                            border-radius:8px;
                            background:white;
                        "
                    >

                        <option value="">
                            Selecione um produto
                        </option>


                        @foreach($produtos as $produto)

                            <option
                                value="{{ $produto->id }}"
                                data-preco="{{ $produto->preco_atual }}"
                                data-estoque="{{ $produto->estoque }}"
                                {{ $oldProduto['produto_id'] == $produto->id ? 'selected' : '' }}
                            >

                                {{ $produto->nome }}

                                —

                                Estoque:
                                {{ $produto->estoque }}

                                —

                                R$
                                {{ number_format(
                                    $produto->preco_atual,
                                    2,
                                    ',',
                                    '.'
                                ) }}

                            </option>

                        @endforeach

                    </select>


                    <div
                        class="estoque-info"
                        style="
                            margin-top:5px;
                            color:#64748b;
                            font-size:12px;
                        "
                    >
                    </div>

                </div>


                <div>

                    <label style="
                        display:block;
                        font-weight:600;
                        margin-bottom:7px;
                        color:#374151;
                    ">
                        Quantidade
                    </label>


                    <input
                        type="number"
                        name="produtos[{{ $index }}][quantidade]"
                        class="quantidade"
                        min="1"
                        value="{{ $oldProduto['quantidade'] ?? 1 }}"
                        required
                        style="
                            width:100%;
                            padding:12px;
                            border:1px solid #d1d5db;
                            border-radius:8px;
                        "
                    >

                </div>


                <div>

                    <label style="
                        display:block;
                        font-weight:600;
                        margin-bottom:7px;
                        color:#374151;
                    ">
                        Subtotal
                    </label>


                    <div
                        class="subtotal"
                        style="
                            background:#f1f5f9;
                            padding:12px;
                            border-radius:8px;
                            font-weight:700;
                            color:#2563eb;
                        "
                    >
                        R$ 0,00
                    </div>

                </div>


                <button
                    type="button"
                    class="remover"
                    style="
                        background:#fee2e2;
                        color:#dc2626;
                        border:none;
                        width:40px;
                        height:40px;
                        border-radius:8px;
                        cursor:pointer;
                        font-size:20px;
                    "
                    title="Remover produto"
                >
                    ×
                </button>

            </div>

        @endforeach

    </div>


    <div
        id="aviso-estoque"
        style="
            display:none;
            background:#fff7ed;
            color:#c2410c;
            border:1px solid #fed7aa;
            padding:12px 15px;
            border-radius:8px;
            margin-top:15px;
        "
    >
        ⚠️ A quantidade informada é maior que o estoque disponível.
    </div>


    <hr style="
        margin:25px 0;
        border:none;
        border-top:1px solid #e5e7eb;
    ">


    <div>

        <label style="
            display:block;
            font-weight:600;
            color:#374151;
            margin-bottom:8px;
        ">
            Observação
        </label>


        <textarea
            name="observacao"
            rows="3"
            placeholder="Observações sobre o pedido..."
            style="
                width:100%;
                padding:12px;
                border:1px solid #d1d5db;
                border-radius:8px;
                resize:vertical;
            "
        >{{ old('observacao') }}</textarea>

    </div>


    <div style="
        margin-top:25px;
        background:#f8fafc;
        border-radius:12px;
        padding:20px;
        text-align:right;
    ">

        <span style="
            color:#64748b;
            font-size:15px;
        ">
            Total do pedido
        </span>


        <div
            id="total"
            style="
                font-size:30px;
                font-weight:800;
                color:#2563eb;
                margin-top:5px;
            "
        >
            R$ 0,00
        </div>

    </div>


    <div style="
        display:flex;
        justify-content:flex-end;
        gap:10px;
        margin-top:20px;
        flex-wrap:wrap;
    ">

        <a
            href="{{ route('admin.pedidos.index') }}"
            style="
                background:#64748b;
                color:white;
                padding:13px 25px;
                border-radius:8px;
                text-decoration:none;
                font-weight:600;
            "
        >
            Cancelar
        </a>


        <button
            type="submit"
            id="btn-submit"
            style="
                background:#2563eb;
                color:white;
                border:none;
                padding:13px 25px;
                border-radius:8px;
                font-weight:600;
                cursor:pointer;
            "
        >
            🧾 Emitir Pedido
        </button>

    </div>

</div>


</form>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const container =
        document.getElementById('produtos-container');

    const adicionar =
        document.getElementById('adicionar-produto');

    const totalElement =
        document.getElementById('total');

    const avisoEstoque =
        document.getElementById('aviso-estoque');

    const form =
        document.getElementById('pedido-form');

    let contador =
        container.querySelectorAll('.produto-linha').length;


    function formatarMoeda(valor) {

        return valor.toLocaleString(
            'pt-BR',
            {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }
        );

    }


    function atualizarLinha(linha) {

        const select =
            linha.querySelector('.produto-select');

        const quantidade =
            linha.querySelector('.quantidade');

        const subtotal =
            linha.querySelector('.subtotal');

        const estoqueInfo =
            linha.querySelector('.estoque-info');


        const option =
            select.options[select.selectedIndex];


        if (!option || !option.value) {

            subtotal.textContent =
                'R$ 0,00';

            estoqueInfo.textContent =
                '';

            quantidade.removeAttribute('max');

            return;

        }


        const preco =
            parseFloat(
                option.dataset.preco || 0
            );


        const estoque =
            parseInt(
                option.dataset.estoque || 0
            );


        let qtd =
            parseInt(
                quantidade.value || 0
            );


        quantidade.setAttribute(
            'max',
            estoque
        );


        estoqueInfo.textContent =
            'Disponível: ' + estoque;


        if (qtd > estoque) {

            quantidade.style.borderColor =
                '#dc2626';

            estoqueInfo.style.color =
                '#dc2626';

            estoqueInfo.textContent =
                '⚠️ Disponível: ' + estoque;

        } else {

            quantidade.style.borderColor =
                '#d1d5db';

            estoqueInfo.style.color =
                '#64748b';

        }


        const subtotalValor =
            preco * qtd;


        subtotal.textContent =
            'R$ ' + formatarMoeda(
                subtotalValor
            );


        atualizarTotal();

    }


    function atualizarTotal() {

        let total = 0;

        let possuiErroEstoque = false;


        container
            .querySelectorAll('.produto-linha')
            .forEach(function (linha) {

                const select =
                    linha.querySelector('.produto-select');

                const quantidade =
                    linha.querySelector('.quantidade');


                if (!select.value) {
                    return;
                }


                const option =
                    select.options[
                        select.selectedIndex
                    ];


                const preco =
                    parseFloat(
                        option.dataset.preco || 0
                    );


                const estoque =
                    parseInt(
                        option.dataset.estoque || 0
                    );


                const qtd =
                    parseInt(
                        quantidade.value || 0
                    );


                total +=
                    preco * qtd;


                if (qtd > estoque) {

                    possuiErroEstoque = true;

                }

            });


        totalElement.textContent =
            'R$ ' + formatarMoeda(total);


        if (possuiErroEstoque) {

            avisoEstoque.style.display =
                'block';

        } else {

            avisoEstoque.style.display =
                'none';

        }

    }


    function adicionarEventos(linha) {

        const select =
            linha.querySelector('.produto-select');

        const quantidade =
            linha.querySelector('.quantidade');

        const remover =
            linha.querySelector('.remover');


        select.addEventListener(
            'change',
            function () {

                atualizarLinha(linha);

            }
        );


        quantidade.addEventListener(
            'input',
            function () {

                atualizarLinha(linha);

            }
        );


        remover.addEventListener(
            'click',
            function () {

                const linhas =
                    container.querySelectorAll(
                        '.produto-linha'
                    );


                if (linhas.length === 1) {

                    select.value = '';

                    quantidade.value = 1;

                    atualizarLinha(linha);

                    return;

                }


                linha.remove();

                renumerar();

                atualizarTotal();

            }
        );


        atualizarLinha(linha);

    }


    function renumerar() {

        const linhas =
            container.querySelectorAll(
                '.produto-linha'
            );


        linhas.forEach(
            function (linha, index) {

                const select =
                    linha.querySelector(
                        '.produto-select'
                    );

                const quantidade =
                    linha.querySelector(
                        '.quantidade'
                    );


                select.name =
                    'produtos[' +
                    index +
                    '][produto_id]';


                quantidade.name =
                    'produtos[' +
                    index +
                    '][quantidade]';

            }
        );


        contador =
            linhas.length;

    }


    adicionar.addEventListener(
        'click',
        function () {

            const linha =
                document.querySelector(
                    '.produto-linha'
                ).cloneNode(true);


            linha
                .querySelector('.produto-select')
                .value = '';


            linha
                .querySelector('.quantidade')
                .value = 1;


            linha
                .querySelector('.subtotal')
                .textContent = 'R$ 0,00';


            linha
                .querySelector('.estoque-info')
                .textContent = '';


            linha
                .querySelector('.quantidade')
                .removeAttribute('max');


            linha
                .querySelector('.quantidade')
                .style.borderColor =
                '#d1d5db';


            container.appendChild(linha);


            renumerar();

            adicionarEventos(linha);

            atualizarTotal();

        }
    );


    container
        .querySelectorAll('.produto-linha')
        .forEach(function (linha) {

            adicionarEventos(linha);

        });


    form.addEventListener(
        'submit',
        function (event) {

            let possuiErro = false;


            container
                .querySelectorAll('.produto-linha')
                .forEach(function (linha) {

                    const select =
                        linha.querySelector(
                            '.produto-select'
                        );

                    const quantidade =
                        linha.querySelector(
                            '.quantidade'
                        );


                    if (!select.value) {

                        possuiErro = true;

                        return;

                    }


                    const option =
                        select.options[
                            select.selectedIndex
                        ];


                    const estoque =
                        parseInt(
                            option.dataset.estoque || 0
                        );


                    const qtd =
                        parseInt(
                            quantidade.value || 0
                        );


                    if (qtd > estoque) {

                        possuiErro = true;

                    }

                });


            if (possuiErro) {

                event.preventDefault();


                avisoEstoque.style.display =
                    'block';


                avisoEstoque.scrollIntoView({
                    behavior:'smooth',
                    block:'center'
                });

                return;

            }

        }
    );


    atualizarTotal();

});

</script>

@endsection
