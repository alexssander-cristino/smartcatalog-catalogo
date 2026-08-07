@extends('admin.layouts.app')


@section('content')


<div class="header">

    <h1>
        Produtos
    </h1>

</div>



<a href="{{ route('admin.produtos.create') }}"
style="
background:#2563eb;
color:white;
padding:12px 20px;
border-radius:8px;
text-decoration:none;
font-weight:bold;
display:inline-block;
margin-bottom:20px;
">

+ Novo Produto

</a>





@if(session('success'))

<div style="
background:#dcfce7;
color:#166534;
padding:12px;
border-radius:8px;
margin-bottom:20px;
">

{{ session('success') }}

</div>

@endif






<div style="
display:grid;
grid-template-columns:repeat(auto-fill,minmax(280px,1fr));
gap:20px;
">



@forelse($produtos as $produto)



<div class="card"
style="
position:relative;
">





{{-- IMAGEM --}}

@if($produto->imagens->count())


<img
src="{{ asset('storage/'.$produto->imagens->first()->imagem) }}"
style="
width:100%;
height:220px;
object-fit:cover;
border-radius:10px;
margin-bottom:15px;
"
>


@else


<div style="
height:220px;
background:#f1f5f9;
border-radius:10px;
display:flex;
align-items:center;
justify-content:center;
color:#64748b;
margin-bottom:15px;
">

Sem imagem

</div>


@endif







{{-- DESTAQUE --}}

@if($produto->destaque)

<span style="
background:#fef3c7;
color:#92400e;
padding:5px 12px;
border-radius:20px;
font-size:13px;
">

⭐ Destaque

</span>

@endif







<h2 style="
margin-top:12px;
font-size:20px;
">

{{ $produto->nome }}

</h2>





<p style="
color:#64748b;
margin-top:5px;
">

Marca:
<strong>
{{ $produto->marca ?? '---' }}
</strong>

</p>





<p>

Categoria:

<strong>

{{ $produto->categoria?->nome ?? '---' }}

</strong>

</p>






<h3 style="
margin-top:10px;
color:#2563eb;
">

R$
{{ number_format($produto->preco,2,',','.') }}

</h3>






<p>

Estoque:

<strong>

{{ $produto->estoque }}

</strong>


</p>







@if($produto->ativo)


<span style="
background:#dcfce7;
color:#166534;
padding:5px 12px;
border-radius:20px;
font-size:13px;
">

Ativo

</span>



@else


<span style="
background:#fee2e2;
color:#991b1b;
padding:5px 12px;
border-radius:20px;
font-size:13px;
">

Inativo

</span>


@endif







<br><br>





<div>


<a href="{{ route('admin.produtos.show',$produto) }}"
style="
background:#0f766e;
color:white;
padding:8px 12px;
border-radius:6px;
text-decoration:none;
font-size:14px;
">

👁 Ver

</a>





<a href="{{ route('admin.produtos.edit',$produto) }}"
style="
background:#2563eb;
color:white;
padding:8px 12px;
border-radius:6px;
text-decoration:none;
font-size:14px;
">

✏ Editar

</a>





<form
method="POST"
action="{{ route('admin.produtos.destroy',$produto) }}"
style="
display:inline;
"
>


@csrf

@method('DELETE')



<button
type="submit"
onclick="return confirm('Deseja excluir este produto?')"
style="
background:#dc2626;
color:white;
border:none;
padding:8px 12px;
border-radius:6px;
cursor:pointer;
font-size:14px;
">

🗑 Excluir

</button>


</form>



</div>





</div>



@empty


<div class="card">

Nenhum produto cadastrado.

</div>


@endforelse



</div>



@endsection