@extends('admin.layouts.app')

@section('content')

<div style="
    max-width:900px;
    margin:0 auto;
">

    {{-- CABEÇALHO --}}

    <div style="
        margin-bottom:25px;
    ">

        <h1 style="
            font-size:28px;
            color:#111827;
            margin-bottom:6px;
        ">
            📦 Movimentar Estoque
        </h1>

        <p style="
            color:#64748b;
            font-size:15px;
        ">
            Registre uma entrada, saída ou ajuste de estoque.
        </p>

    </div>


    {{-- MENSAGENS DE ERRO --}}

    @if($errors->any())

        <div style="
            background:#fef2f2;
            border:1px solid #fecaca;
            color:#991b1b;
            padding:16px 18px;
            border-radius:12px;
            margin-bottom:20px;
            box-shadow:0 2px 8px rgba(0,0,0,.04);
        ">

            <div style="
                font-weight:700;
                margin-bottom:8px;
            ">
                ⚠️ Não foi possível registrar a movimentação
            </div>

            @foreach($errors->all() as $error)

                <div style="
                    margin-top:5px;
                ">
                    • {{ $error }}
                </div>

            @endforeach

        </div>

    @endif


    {{-- PRODUTO --}}

    <div style="
        background:white;
        padding:25px;
        border-radius:16px;
        margin-bottom:20px;
        box-shadow:0 4px 15px rgba(0,0,0,.06);
        border:1px solid #e5e7eb;
    ">

        <div style="
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:20px;
            flex-wrap:wrap;
        ">

            <div>

                <div style="
                    color:#64748b;
                    font-size:13px;
                    margin-bottom:5px;
                ">
                    PRODUTO
                </div>

                <h2 style="
                    color:#111827;
                    font-size:22px;
                    margin-bottom:7px;
                ">
                    {{ $produto->nome }}
                </h2>

                <div style="
                    color:#64748b;
                    font-size:14px;
                ">
                    SKU:
                    <strong>
                        {{ $produto->sku ?? '---' }}
                    </strong>
                </div>

                @if($produto->categoria)

                    <div style="
                        color:#64748b;
                        font-size:14px;
                        margin-top:4px;
                    ">
                        Categoria:
                        <strong>
                            {{ $produto->categoria->nome }}
                        </strong>
                    </div>

                @endif

            </div>


            {{-- ESTOQUE ATUAL --}}

            <div style="
                background:#eff6ff;
                border:1px solid #bfdbfe;
                padding:18px 25px;
                border-radius:12px;
                text-align:center;
                min-width:190px;
            ">

                <div style="
                    color:#64748b;
                    font-size:13px;
                    margin-bottom:5px;
                ">
                    ESTOQUE ATUAL
                </div>

                <div style="
                    font-size:30px;
                    font-weight:700;
                    color:#2563eb;
                ">
                    {{ $produto->estoque }}
                </div>

                <div style="
                    color:#64748b;
                    font-size:13px;
                ">
                    {{ $produto->unidade ?? 'un.' }}
                </div>

            </div>

        </div>

    </div>


    {{-- FORMULÁRIO --}}

    <form
        method="POST"
        action="{{ route('admin.estoque.store', $produto) }}"
    >

        @csrf


        <div style="
            background:white;
            padding:25px;
            border-radius:16px;
            box-shadow:0 4px 15px rgba(0,0,0,.06);
            border:1px solid #e5e7eb;
        ">


            {{-- TIPO --}}

            <div style="
                margin-bottom:22px;
            ">

                <label style="
                    display:block;
                    font-weight:600;
                    color:#374151;
                    margin-bottom:8px;
                ">
                    Tipo de movimentação
                </label>

                <select
                    name="tipo"
                    required
                    style="
                        width:100%;
                        padding:13px;
                        border:1px solid #d1d5db;
                        border-radius:9px;
                        background:white;
                        font-size:15px;
                        outline:none;
                    "
                >

                    <option value="">
                        Selecione...
                    </option>

                    <option
                        value="entrada"
                        {{ old('tipo') === 'entrada' ? 'selected' : '' }}
                    >
                        ➕ Entrada
                    </option>

                    <option
                        value="saida"
                        {{ old('tipo') === 'saida' ? 'selected' : '' }}
                    >
                        ➖ Saída
                    </option>

                    <option
                        value="ajuste"
                        {{ old('tipo') === 'ajuste' ? 'selected' : '' }}
                    >
                        🔧 Ajuste
                    </option>

                </select>

                <small style="
                    display:block;
                    color:#64748b;
                    margin-top:6px;
                ">
                    Entrada adiciona ao estoque, saída remove e ajuste define uma nova quantidade.
                </small>

            </div>


            {{-- QUANTIDADE --}}

            <div style="
                margin-bottom:22px;
            ">

                <label style="
                    display:block;
                    font-weight:600;
                    color:#374151;
                    margin-bottom:8px;
                ">
                    Quantidade
                </label>

                <input
                    type="number"
                    name="quantidade"
                    min="1"
                    step="1"
                    value="{{ old('quantidade') }}"
                    required
                    style="
                        width:100%;
                        padding:13px;
                        border:1px solid #d1d5db;
                        border-radius:9px;
                        font-size:15px;
                    "
                >

                @error('quantidade')

                    <div style="
                        color:#dc2626;
                        font-size:13px;
                        margin-top:6px;
                    ">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- OBSERVAÇÃO --}}

            <div style="
                margin-bottom:25px;
            ">

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
                    rows="4"
                    placeholder="Ex.: Compra de mercadoria, venda, ajuste de estoque..."
                    style="
                        width:100%;
                        padding:13px;
                        border:1px solid #d1d5db;
                        border-radius:9px;
                        resize:vertical;
                        font-family:inherit;
                        font-size:15px;
                    "
                >{{ old('observacao') }}</textarea>

                @error('observacao')

                    <div style="
                        color:#dc2626;
                        font-size:13px;
                        margin-top:6px;
                    ">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- BOTÕES --}}

            <div style="
                display:flex;
                gap:10px;
                flex-wrap:wrap;
            ">

                <button
                    type="submit"
                    style="
                        background:#2563eb;
                        color:white;
                        border:none;
                        padding:13px 25px;
                        border-radius:9px;
                        font-weight:600;
                        cursor:pointer;
                        font-size:15px;
                    "
                >
                    💾 Registrar movimentação
                </button>


                <a
                    href="{{ route('admin.estoque.index') }}"
                    style="
                        background:#64748b;
                        color:white;
                        padding:13px 25px;
                        border-radius:9px;
                        text-decoration:none;
                        font-weight:600;
                        font-size:15px;
                    "
                >
                    ← Voltar
                </a>

            </div>

        </div>

    </form>

</div>

@endsection

