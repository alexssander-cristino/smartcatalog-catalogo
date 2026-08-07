@extends('admin.layouts.app')


@section('content')



<div class="header">

<h1>
Dashboard
</h1>

<p style="color:#64748b;margin-top:8px;">
Visão geral do SmartCatalog
</p>

</div>






<div style="
display:grid;
grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
gap:20px;
">





<div class="card">


<h3>
📦 Produtos
</h3>


<h1 style="margin-top:15px;">
{{ $totalProdutos }}
</h1>


<p style="color:#64748b;">
Produtos cadastrados
</p>


</div>







<div class="card">


<h3>
📂 Categorias
</h3>


<h1 style="margin-top:15px;">
{{ $totalCategorias }}
</h1>


<p style="color:#64748b;">
Categorias cadastradas
</p>


</div>








<div class="card">


<h3>
✅ Ativos
</h3>


<h1 style="margin-top:15px;">
{{ $produtosAtivos }}
</h1>


<p style="color:#64748b;">
Produtos ativos
</p>


</div>








<div class="card">


<h3>
⚠️ Estoque baixo
</h3>


<h1 style="margin-top:15px;">
{{ $estoqueBaixo }}
</h1>


<p style="color:#64748b;">
Produtos com pouco estoque
</p>


</div>





</div>








<br>







<div class="card">


<h2>
Últimos produtos cadastrados
</h2>


<br>



<table style="
width:100%;
border-collapse:collapse;
">



<tr style="
background:#f8fafc;
text-align:left;
">


<th style="padding:12px;">
Produto
</th>


<th>
Categoria
</th>


<th>
Preço
</th>


<th>
Estoque
</th>


</tr>





@forelse($ultimosProdutos as $produto)



<tr>


<td style="padding:12px;">

{{ $produto->nome }}

</td>



<td>

{{ $produto->categoria->nome ?? '-' }}

</td>



<td>

R$ {{ number_format($produto->preco,2,',','.') }}

</td>



<td>

{{ $produto->estoque }}

</td>


</tr>




@empty


<tr>

<td colspan="4" style="padding:20px;text-align:center;">

Nenhum produto cadastrado.

</td>

</tr>



@endforelse




</table>


</div>






@endsection