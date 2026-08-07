@extends('admin.layouts.app')


@section('content')


<div class="card">



@if(session('status'))

<div style="
background:#dcfce7;
color:#166534;
padding:12px;
border-radius:8px;
margin-bottom:20px;
">

{{ session('status') }}

</div>

@endif





<h1 style="
font-size:28px;
font-weight:bold;
margin-bottom:25px;
">

👤 Meu Perfil

</h1>





<form 
method="POST"
action="{{ route('profile.update') }}"
enctype="multipart/form-data"
>


@csrf

@method('PATCH')





<div style="
text-align:center;
margin-bottom:25px;
">



@if(auth()->user()->foto)


<img

src="{{ asset('storage/'.auth()->user()->foto) }}"

style="
width:120px;
height:120px;
border-radius:50%;
object-fit:cover;
"

>


@else


<div style="
width:120px;
height:120px;
border-radius:50%;
background:#2563eb;
color:white;
display:flex;
align-items:center;
justify-content:center;
font-size:40px;
margin:auto;
">

{{ strtoupper(substr(auth()->user()->name,0,1)) }}

</div>


@endif





<br><br>


<label>

Foto de perfil

</label>


<br>


<input

type="file"

name="foto"

accept="image/*"

style="
margin-top:10px;
"

>



</div>








<label>

Nome

</label>


<input

type="text"

name="name"

value="{{ old('name', auth()->user()->name) }}"

required

style="
width:100%;
padding:12px;
border:1px solid #d1d5db;
border-radius:8px;
margin-top:6px;
margin-bottom:20px;
"

>


@error('name')

<p style="color:red">

{{ $message }}

</p>

@enderror







<label>

E-mail

</label>


<input

type="email"

name="email"

value="{{ old('email', auth()->user()->email) }}"

required

style="
width:100%;
padding:12px;
border:1px solid #d1d5db;
border-radius:8px;
margin-top:6px;
margin-bottom:20px;
"

>


@error('email')

<p style="color:red">

{{ $message }}

</p>

@enderror







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

💾 Salvar alterações


</button>




</form>



</div>








<div class="card" style="margin-top:25px;">



<h2 style="
font-size:22px;
font-weight:bold;
margin-bottom:20px;
">

🔒 Alterar senha

</h2>





<form

method="POST"

action="{{ route('password.update') }}"

>


@csrf

@method('PUT')





<input

type="password"

name="current_password"

placeholder="Senha atual"

style="
width:100%;
padding:12px;
border:1px solid #d1d5db;
border-radius:8px;
margin-bottom:15px;
"

>






<input

type="password"

name="password"

placeholder="Nova senha"

style="
width:100%;
padding:12px;
border:1px solid #d1d5db;
border-radius:8px;
margin-bottom:15px;
"

>






<input

type="password"

name="password_confirmation"

placeholder="Confirmar nova senha"

style="
width:100%;
padding:12px;
border:1px solid #d1d5db;
border-radius:8px;
margin-bottom:20px;
"

>




<button

type="submit"

style="
background:#16a34a;
color:white;
border:none;
padding:12px 25px;
border-radius:8px;
font-weight:bold;
cursor:pointer;
"

>

🔑 Atualizar senha


</button>



</form>


</div>







<div class="card" style="margin-top:25px;">


<h2 style="
color:#dc2626;
margin-bottom:15px;
">

⚠️ Excluir conta

</h2>



<p style="margin-bottom:20px;">

Essa ação é permanente e removerá sua conta.

</p>




<form

method="POST"

action="{{ route('profile.destroy') }}"

>


@csrf

@method('DELETE')



<button

type="submit"

style="
background:#dc2626;
color:white;
border:none;
padding:12px 25px;
border-radius:8px;
font-weight:bold;
cursor:pointer;
"

>

🗑 Excluir minha conta


</button>


</form>



</div>



@endsection