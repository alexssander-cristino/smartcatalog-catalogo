@extends('admin.layouts.app')

@section('content')

<div class="header">

    <h1>Categorias</h1>

    <br>

    <a href="{{ route('admin.categorias.create') }}"
       style="
        display:inline-block;
        background:#2563eb;
        color:#fff;
        padding:10px 20px;
        border-radius:6px;
        text-decoration:none;
       ">

        + Nova Categoria

    </a>

</div>



@if(session('success'))

<div class="card"
style="
margin-bottom:20px;
background:#dcfce7;
border:1px solid #22c55e;
color:#166534;
">

{{ session('success') }}

</div>

@endif



<div class="card">

<table
width="100%"
cellpadding="12"
style="border-collapse:collapse;">

<thead>

<tr
style="background:#f3f4f6;">

<th align="left">
Nome
</th>

<th align="left">
Descrição
</th>

<th align="center">
Status
</th>

<th align="center">
Ações
</th>

</tr>

</thead>


<tbody>

@forelse($categorias as $categoria)

<tr style="border-top:1px solid #ddd;">

<td>

{{ $categoria->nome }}

</td>


<td>

{{ $categoria->descricao }}

</td>


<td align="center">

@if($categoria->ativo)

<span style="color:green;font-weight:bold;">
Ativo
</span>

@else

<span style="color:red;font-weight:bold;">
Inativo
</span>

@endif

</td>



<td align="center">

<a
href="{{ route('admin.categorias.edit',$categoria) }}"
style="
background:#2563eb;
color:white;
padding:6px 12px;
border-radius:5px;
text-decoration:none;
">

Editar

</a>



<form
action="{{ route('admin.categorias.destroy',$categoria) }}"
method="POST"
style="display:inline;">

@csrf
@method('DELETE')

<button
onclick="return confirm('Deseja excluir esta categoria?')"
style="
background:#dc2626;
color:white;
border:none;
padding:6px 12px;
border-radius:5px;
cursor:pointer;
">

Excluir

</button>

</form>

</td>

</tr>

@empty

<tr>

<td colspan="4" align="center">

Nenhuma categoria cadastrada.

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

@endsection