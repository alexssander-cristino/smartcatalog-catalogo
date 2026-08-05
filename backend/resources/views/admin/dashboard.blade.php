@extends('admin.layouts.app')


@section('content')


<div class="header">

<h1>
Dashboard
</h1>

<p>
Visão geral do catálogo
</p>

</div>




<div style="
display:grid;
grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
gap:20px;
">



<div class="card">

<h3>
Produtos
</h3>

<h1>
{{ $dados['produtos'] }}
</h1>

</div>




<div class="card">

<h3>
Categorias
</h3>

<h1>
{{ $dados['categorias'] }}
</h1>

</div>




<div class="card">

<h3>
Produtos Ativos
</h3>

<h1>
{{ $dados['ativos'] }}
</h1>

</div>




<div class="card">

<h3>
Estoque Baixo
</h3>

<h1>
{{ $dados['estoque_baixo'] }}
</h1>

</div>



</div>


@endsection