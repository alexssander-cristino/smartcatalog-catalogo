@extends('admin.layouts.app')

@section('content')


<div class="card">


<h1>
    ✏️ Editar Produto
</h1>



@if(session('success'))

<div style="
background:#dcfce7;
color:#166534;
padding:12px;
border-radius:8px;
margin:15px 0;
">

{{ session('success') }}

</div>

@endif






@if($errors->any())

<div style="
background:#fee2e2;
color:#991b1b;
padding:12px;
border-radius:8px;
margin:15px 0;
">

@foreach($errors->all() as $error)

<p>{{ $error }}</p>

@endforeach

</div>

@endif








<form method="POST"

action="{{ route('admin.produtos.update',$produto->id) }}"

enctype="multipart/form-data">


@csrf

@method('PUT')





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


@foreach($categorias as $categoria)


<option

value="{{ $categoria->id }}"

{{ $produto->categoria_id == $categoria->id ? 'selected' : '' }}

>

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

value="{{ old('sku',$produto->sku) }}"

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
Nome
</label>


<input

type="text"

name="nome"

value="{{ old('nome',$produto->nome) }}"

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

value="{{ old('marca',$produto->marca) }}"

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

style="
width:100%;
padding:12px;
border:1px solid #ddd;
border-radius:8px;
margin-top:8px;
margin-bottom:15px;
"

>{{ old('descricao',$produto->descricao) }}</textarea>








<label>
Preço normal
</label>


<input

type="number"

step="0.01"

name="preco"

value="{{ old('preco',$produto->preco) }}"

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

step="0.01"

name="preco_promocional"

value="{{ old('preco_promocional',$produto->preco_promocional) }}"

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

value="{{ old('estoque',$produto->estoque) }}"

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

value="{{ old('unidade',$produto->unidade) }}"

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

<input

type="checkbox"

name="ativo"

value="1"

{{ $produto->ativo ? 'checked' : '' }}

>

Produto ativo

</label>




<br>



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

type="submit"

style="
background:#2563eb;
color:white;
border:none;
padding:12px 25px;
border-radius:8px;
font-weight:bold;
cursor:pointer;
"

>

💾 Atualizar Produto

</button>





<a

href="{{ route('admin.produtos.index') }}"

style="
background:#64748b;
color:white;
padding:12px 25px;
border-radius:8px;
text-decoration:none;
font-weight:bold;
margin-left:15px;
display:inline-block;
"

>

Cancelar

</a>



</form>







<hr style="margin:30px 0;">





<h2>
📷 Imagens do Produto
</h2>





<form

method="POST"

action="{{ route('admin.produtos.imagem.store',$produto->id) }}"

enctype="multipart/form-data"

style="margin-top:15px;"

>


@csrf



<input

type="file"

name="imagem"

accept="image/*"

required

>



<button

type="submit"

style="
background:#16a34a;
color:white;
border:none;
padding:10px 20px;
border-radius:8px;
cursor:pointer;
"

>

Adicionar Imagem

</button>


</form>







<div style="
display:flex;
gap:15px;
margin-top:20px;
flex-wrap:wrap;
">



@forelse($produto->imagens as $imagem)



<div>


<img

src="{{ asset('storage/'.$imagem->imagem) }}"

style="
width:150px;
height:150px;
object-fit:cover;
border-radius:10px;
"

>





<form

method="POST"

action="{{ route('admin.produtos.imagem.destroy',$imagem->id) }}"

>


@csrf

@method('DELETE')



<button

style="
background:#dc2626;
color:white;
border:none;
padding:8px;
border-radius:6px;
cursor:pointer;
margin-top:5px;
"

>

🗑 Excluir

</button>


</form>



</div>



@empty


<p>
Nenhuma imagem cadastrada.
</p>


@endforelse



</div>




</div>


@endsection