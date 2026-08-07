@extends('layouts.catalogo')


@section('content')


<div class="container">



<h1 class="titulo">
Produtos
</h1>


<p class="subtitulo">
Confira nosso catálogo
</p>




<form 
method="GET"
class="form-pesquisa"
>


<input
type="text"
name="busca"
placeholder="Pesquisar produto..."
value="{{ request('busca') }}"
class="input"
>



<select
name="categoria"
class="input"
>


<option value="">
Todas categorias
</option>


@foreach($categorias as $categoria)


<option
value="{{ $categoria->id }}"
{{ request('categoria') == $categoria->id ? 'selected' : '' }}
>

{{ $categoria->nome }}

</option>


@endforeach


</select>




<button
type="submit"
class="btn"
>

Pesquisar

</button>



</form>






<div class="categorias">


@foreach($categorias as $categoria)


<a
href="{{ route('catalogo.index',['categoria'=>$categoria->id]) }}"
class="categoria"
>

{{ $categoria->nome }}

</a>


@endforeach


</div>






<div class="produtos">



@forelse($produtos as $produto)



<a
href="{{ route('catalogo.produto',$produto->id) }}"
style="
text-decoration:none;
color:inherit;
"
>


<div class="card">



@if($produto->imagens->count())


<img
src="{{ asset('storage/'.$produto->imagens->first()->imagem) }}"
alt="{{ $produto->nome }}"
>


@else


<div class="sem-imagem">

Sem imagem

</div>


@endif






<div class="info">



@if($produto->destaque)


<span class="destaque">

⭐ Destaque

</span>


@endif





<h2>

{{ $produto->nome }}

</h2>




<p>

Marca:
{{ $produto->marca ?? 'Sem marca' }}

</p>




<p>

Categoria:
{{ $produto->categoria?->nome ?? '---' }}

</p>




<div class="preco">

R$ {{ number_format($produto->preco,2,',','.') }}

</div>




</div>


</div>


</a>




@empty


<p>

Nenhum produto encontrado.

</p>


@endforelse



</div>



</div>



@endsection