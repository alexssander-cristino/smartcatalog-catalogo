@extends('admin.layouts.app')


@section('content')


<div class="header">

    <h1>
        Editar Produto
    </h1>

</div>



@if(session('success'))

<div class="card"
style="
background:#dcfce7;
color:#166534;
padding:15px;
margin-bottom:20px;
">

    {{ session('success') }}

</div>

@endif




@if($errors->any())

<div class="card"
style="
background:#fee2e2;
color:#991b1b;
padding:15px;
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





<div class="card">


<h2>
Dados do Produto
</h2>


<br>


<form method="POST"
action="{{ route('admin.produtos.update',$produto) }}">


@csrf

@method('PUT')



<label>
Categoria
</label>

<br>


<select
name="categoria_id"
required
style="
width:100%;
padding:10px;
">


<option value="">
Selecione uma categoria
</option>


@foreach($categorias as $categoria)

<option
value="{{ $categoria->id }}"
{{ old('categoria_id',$produto->categoria_id) == $categoria->id ? 'selected' : '' }}
>

{{ $categoria->nome }}

</option>

@endforeach


</select>



<br><br>




<label>
Nome
</label>

<br>


<input
type="text"
name="nome"
value="{{ old('nome',$produto->nome) }}"
required
style="
width:100%;
padding:10px;
">



<br><br>




<label>
Código
</label>

<br>


<input
type="text"
name="codigo"
value="{{ old('codigo',$produto->codigo) }}"
style="
width:100%;
padding:10px;
">



<br><br>




<label>
Marca
</label>

<br>


<input
type="text"
name="marca"
value="{{ old('marca',$produto->marca) }}"
style="
width:100%;
padding:10px;
">



<br><br>




<label>
Descrição
</label>

<br>


<textarea
name="descricao"
style="
width:100%;
height:120px;
padding:10px;
">{{ old('descricao',$produto->descricao) }}</textarea>



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
value="{{ old('preco',$produto->preco) }}"
style="
width:100%;
padding:10px;
">


</div>



<div style="flex:1">


<label>
Estoque
</label>

<br>


<input
type="number"
name="estoque"
value="{{ old('estoque',$produto->estoque) }}"
style="
width:100%;
padding:10px;
">


</div>


</div>




<br><br>



<label>

<input
type="checkbox"
name="ativo"
value="1"
{{ $produto->ativo ? 'checked' : '' }}
>

Produto ativo

</label>


<br><br>


<label>

<input
type="checkbox"
name="destaque"
value="1"
{{ $produto->destaque ? 'checked' : '' }}
>

Produto em destaque

</label>



<br><br>



<button
style="
background:#2563eb;
color:white;
border:none;
padding:12px 25px;
border-radius:6px;
cursor:pointer;
">

Atualizar Produto

</button>



<a
href="{{ route('admin.produtos.index') }}"
style="
background:#64748b;
color:white;
padding:12px 25px;
border-radius:6px;
text-decoration:none;
font-weight:bold;
margin-left:15px;
display:inline-block;
"
>
Cancelar
</a>



</form>


</div>







<div class="card"
style="margin-top:30px;">


<h2>
Imagens do Produto
</h2>



<p>
Adicione imagens para o catálogo.
</p>



<form
method="POST"
action="{{ route('admin.produtos.imagem.store',$produto) }}"
enctype="multipart/form-data"
>


@csrf



<input
type="file"
name="imagem"
accept="image/*"
required
>



<br><br>



<button
style="
background:#16a34a;
color:white;
border:none;
padding:10px 20px;
border-radius:6px;
cursor:pointer;
">

Adicionar Imagem

</button>



</form>





<br>





@if($produto->imagens->count())


<div style="
display:grid;
grid-template-columns:repeat(auto-fill,minmax(180px,1fr));
gap:20px;
">


@foreach($produto->imagens as $imagem)


<div
style="
border:1px solid #ddd;
padding:10px;
border-radius:8px;
">


<img
src="{{ $imagem->url }}"
style="
width:100%;
height:180px;
object-fit:cover;
border-radius:6px;
">



<br><br>




<form
method="POST"
action="{{ route('admin.produtos.imagem.destroy',$imagem) }}"
>


@csrf

@method('DELETE')



<button
onclick="return confirm('Excluir imagem?')"
style="
width:100%;
background:#dc2626;
color:white;
border:none;
padding:10px;
border-radius:6px;
cursor:pointer;
">

Excluir

</button>


</form>



</div>



@endforeach


</div>



@else


<div
style="
padding:30px;
text-align:center;
border:2px dashed #ddd;
border-radius:8px;
">

Nenhuma imagem cadastrada.

</div>


@endif



</div>



@endsection