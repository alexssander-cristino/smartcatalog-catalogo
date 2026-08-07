@extends('admin.layouts.app')

@section('content')


<div style="
max-width:900px;
margin:auto;
">


<h1 style="
margin-bottom:25px;
">
Novo Produto
</h1>




@if($errors->any())

<div style="
background:#fee2e2;
color:#991b1b;
padding:15px;
border-radius:8px;
margin-bottom:20px;
">

<ul style="margin:0;padding-left:20px;">

@foreach($errors->all() as $error)

<li>
{{ $error }}
</li>

@endforeach

</ul>

</div>

@endif






<div style="
background:white;
padding:30px;
border-radius:12px;
box-shadow:0 4px 15px rgba(0,0,0,.08);
">





<form
method="POST"
action="{{ route('admin.produtos.store') }}"
enctype="multipart/form-data"
>


@csrf





<label>
Categoria
</label>

<br>


<select
name="categoria_id"
required
style="
width:100%;
padding:12px;
border:1px solid #ddd;
border-radius:8px;
margin-top:8px;
"
>


<option value="">
Selecione uma categoria
</option>


@foreach($categorias as $categoria)


<option
value="{{ $categoria->id }}"
{{ old('categoria_id') == $categoria->id ? 'selected' : '' }}
>

{{ $categoria->nome }}

</option>


@endforeach


</select>






<br><br>




<label>
Nome do produto
</label>

<br>


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
"
>






<br><br>





<div style="
display:flex;
gap:20px;
">


<div style="flex:1">


<label>
Código
</label>

<br>


<input
type="text"
name="codigo"
value="{{ old('codigo') }}"
style="
width:100%;
padding:12px;
border:1px solid #ddd;
border-radius:8px;
margin-top:8px;
"
>


</div>





<div style="flex:1">


<label>
Marca
</label>

<br>


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
"
>


</div>


</div>






<br><br>






<div style="
display:flex;
gap:20px;
">


<div style="flex:1">


<label>
Preço
</label>

<br>


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
"
>


</div>





<div style="flex:1">


<label>
Estoque
</label>

<br>


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
"
>


</div>



</div>







<br><br>




<label>
Imagem do produto
</label>

<br>


<input
type="file"
name="imagem"
accept="image/*"
style="
margin-top:10px;
padding:8px;
"
>






<br><br>




<div style="
background:#f9fafb;
padding:15px;
border-radius:8px;
">


<label style="display:block;margin-bottom:10px;">


<input
type="checkbox"
name="ativo"
value="1"
checked
>


 Produto ativo


</label>





<label>


<input
type="checkbox"
name="destaque"
value="1"
>


 Produto em destaque


</label>



</div>







<br><br>





<div style="
display:flex;
gap:15px;
">


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
font-size:15px;
"
>

← Cancelar

</a>



</div>





</form>



</div>


</div>


@endsection