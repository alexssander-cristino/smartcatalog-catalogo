@extends('admin.layouts.app')


@section('content')


<div class="header">

<h1>
Detalhes do Produto
</h1>

</div>





<div style="
display:grid;
grid-template-columns:350px 1fr;
gap:25px;
">






{{-- IMAGENS --}}

<div class="card">


<h2>
Imagens
</h2>


<br>


@if($produto->imagens->count())


<div style="
display:grid;
grid-template-columns:repeat(2,1fr);
gap:15px;
">


@foreach($produto->imagens as $imagem)


<div>


<img
src="{{ asset('storage/'.$imagem->imagem) }}"
style="
width:100%;
height:150px;
object-fit:cover;
border-radius:10px;
"
>


</div>


@endforeach


</div>



@else


<div style="
padding:30px;
text-align:center;
color:#64748b;
">

Nenhuma imagem cadastrada

</div>



@endif


</div>









{{-- INFORMAÇÕES --}}


<div class="card">


<h2>
{{ $produto->nome }}
</h2>


<br>



<table style="
width:100%;
border-collapse:collapse;
">



<tr>

<td style="padding:10px;font-weight:bold;">
Código
</td>

<td>
{{ $produto->codigo ?? '-' }}
</td>

</tr>





<tr>

<td style="padding:10px;font-weight:bold;">
Marca
</td>

<td>
{{ $produto->marca ?? '-' }}
</td>

</tr>





<tr>

<td style="padding:10px;font-weight:bold;">
Categoria
</td>

<td>
{{ $produto->categoria->nome ?? '-' }}
</td>

</tr>





<tr>

<td style="padding:10px;font-weight:bold;">
Preço
</td>

<td>
R$ {{ number_format($produto->preco,2,',','.') }}
</td>

</tr>





<tr>

<td style="padding:10px;font-weight:bold;">
Estoque
</td>

<td>
{{ $produto->estoque }}
</td>

</tr>





<tr>

<td style="padding:10px;font-weight:bold;">
Status
</td>


<td>


@if($produto->ativo)

<span style="
background:#dcfce7;
color:#166534;
padding:5px 12px;
border-radius:20px;
">

Ativo

</span>


@else


<span style="
background:#fee2e2;
color:#991b1b;
padding:5px 12px;
border-radius:20px;
">

Inativo

</span>


@endif



</td>


</tr>





<tr>

<td style="padding:10px;font-weight:bold;">
Destaque
</td>


<td>


@if($produto->destaque)

⭐ Sim

@else

Não

@endif


</td>


</tr>




</table>




<br>


<h3>
Descrição
</h3>


<p style="
margin-top:10px;
color:#475569;
line-height:1.6;
">

{{ $produto->descricao ?? 'Sem descrição cadastrada.' }}

</p>






<br>




<a
href="{{ route('admin.produtos.edit',$produto) }}"
style="
background:#2563eb;
color:white;
padding:12px 20px;
border-radius:8px;
text-decoration:none;
"
>

✏ Editar Produto

</a>




<a
href="{{ route('admin.produtos.index') }}"
style="
margin-left:10px;
background:#64748b;
color:white;
padding:12px 20px;
border-radius:8px;
text-decoration:none;
"
>

← Voltar

</a>



</div>





</div>




@endsection