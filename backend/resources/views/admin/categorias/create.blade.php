@extends('admin.layouts.app')

@section('content')

<div class="header">

<h1>

Nova Categoria

</h1>

</div>



<div class="card">

<form
method="POST"
action="{{ route('admin.categorias.store') }}">

@csrf


<label>

Nome

</label>

<br>

<input
type="text"
name="nome"
value="{{ old('nome') }}"
required
style="
width:100%;
padding:10px;
margin-top:5px;
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
padding:10px;
margin-top:5px;
height:120px;
">{{ old('descricao') }}</textarea>


<br><br>


<label>

<input
type="checkbox"
name="ativo"
value="1"
checked>

Categoria ativa

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

Salvar

</button>



<a
href="{{ route('admin.categorias.index') }}"
style="
margin-left:15px;
text-decoration:none;
">

Cancelar

</a>


</form>

</div>

@endsection