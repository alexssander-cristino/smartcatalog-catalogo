@extends('admin.layouts.app')

@section('content')


<div class="card">


<h1 style="
font-size:28px;
font-weight:bold;
margin-bottom:25px;
">

📦 Novo Produto

</h1>




@if($errors->any())

<div style="
background:#fee2e2;
color:#991b1b;
padding:15px;
border-radius:8px;
margin-bottom:20px;
">

@foreach($errors->all() as $error)

<p>{{ $error }}</p>

@endforeach

</div>

@endif






<form 
method="POST"
action="{{ route('admin.produtos.store') }}"
enctype="multipart/form-data"
>


@csrf





<label>
Categoria
</label>


<select
name="categoria_id"
required
style="
width:100%;
padding:12px;
border:1px solid #ddd;
border-radius:8px;
margin-top:8px;
margin-bottom:15px;
"
>


<option value="">
Selecione uma categoria
</option>


@foreach($categorias as $categoria)


<option value="{{ $categoria->id }}">

{{ $categoria->nome }}

</option>


@endforeach


</select>






<label>
Código SKU
</label>


<input

type="text"

name="sku"

value="{{ old('sku') }}"

placeholder="Ex: PROD-001"

style="
width:100%;
padding:12px;
border:1px solid #ddd;
border-radius:8px;
margin-top:8px;
margin-bottom:15px;
"

>








<label>
Nome do produto
</label>


<input

type="text"

name="nome"

value="{{ old('nome') }}"

required

style="
width:100%;
padding:12px;
border:1px solid #ddd;
border-radius:8px;
margin-top:8px;
margin-bottom:15px;
"

>







<label>
Marca
</label>


<input

type="text"

name="marca"

value="{{ old('marca') }}"

style="
width:100%;
padding:12px;
border:1px solid #ddd;
border-radius:8px;
margin-top:8px;
margin-bottom:15px;
"

>








<label>
Descrição
</label>


<textarea

name="descricao"

rows="5"

placeholder="Descrição completa do produto"

style="
width:100%;
padding:12px;
border:1px solid #ddd;
border-radius:8px;
margin-top:8px;
margin-bottom:15px;
"

>{{ old('descricao') }}</textarea>








<label>
Preço normal
</label>


<input

type="number"

name="preco"

step="0.01"

value="{{ old('preco') }}"

required

style="
width:100%;
padding:12px;
border:1px solid #ddd;
border-radius:8px;
margin-top:8px;
margin-bottom:15px;
"

>







<label>
Preço promocional
</label>


<input

type="number"

name="preco_promocional"

step="0.01"

value="{{ old('preco_promocional') }}"

placeholder="Opcional"

style="
width:100%;
padding:12px;
border:1px solid #ddd;
border-radius:8px;
margin-top:8px;
margin-bottom:15px;
"

>







<label>
Estoque
</label>


<input

type="number"

name="estoque"

value="{{ old('estoque',0) }}"

required

style="
width:100%;
padding:12px;
border:1px solid #ddd;
border-radius:8px;
margin-top:8px;
margin-bottom:15px;
"

>







<label>
Unidade
</label>


<input

type="text"

name="unidade"

value="{{ old('unidade','UN') }}"

placeholder="UN, KG, CX"

style="
width:100%;
padding:12px;
border:1px solid #ddd;
border-radius:8px;
margin-top:8px;
margin-bottom:15px;
"

>








<label>
Imagem principal
</label>


<input

type="file"

name="imagem"

accept="image/*"

style="
margin-top:10px;
margin-bottom:20px;
"

>







<div style="margin-bottom:20px;">


<label>

<input

type="checkbox"

name="ativo"

value="1"

checked

>

Produto ativo


</label>



<br>


<label>

<input

type="checkbox"

name="destaque"

value="1"

>

Produto em destaque


</label>


</div>







<button

type="submit"

style="
background:#2563eb;
color:white;
border:none;
padding:13px 30px;
border-radius:8px;
cursor:pointer;
font-size:15px;
font-weight:bold;
"

>

💾 Salvar Produto


</button>





<a

href="{{ route('admin.produtos.index') }}"

style="
background:#6b7280;
color:white;
padding:13px 30px;
border-radius:8px;
text-decoration:none;
margin-left:10px;
"

>

← Cancelar


</a>



</form>



</div>



@endsection