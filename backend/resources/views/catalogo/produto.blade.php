@extends('layouts.catalogo')


@section('content')


<div class="container">


<div style="
background:white;
padding:30px;
border-radius:15px;
box-shadow:0 4px 15px #0002;
">


@if($produto->imagens->count())


<img
src="{{ asset('storage/'.$produto->imagens->first()->imagem) }}"
style="
width:100%;
max-width:500px;
height:450px;
object-fit:cover;
border-radius:15px;
"
>


@else


<div class="sem-imagem">

Sem imagem

</div>


@endif





<h1 style="
margin-top:25px;
">

{{ $produto->nome }}

</h1>




@if($produto->destaque)

<span class="destaque">

⭐ Destaque

</span>

@endif





<p style="
margin-top:15px;
font-size:18px;
">

Marca:
{{ $produto->marca ?? '---' }}

</p>




<p>

Categoria:
{{ $produto->categoria->nome ?? '---' }}

</p>




<h2 class="preco">

R$ {{ number_format($produto->preco,2,',','.') }}

</h2>





<p style="
margin-top:20px;
font-size:17px;
">

{{ $produto->descricao }}

</p>





<a
href="{{ route('catalogo.index') }}"
style="
display:inline-block;
margin-top:30px;
background:#111827;
color:white;
padding:12px 25px;
border-radius:8px;
text-decoration:none;
"
>

← Voltar ao catálogo

</a>



</div>


</div>



@endsection