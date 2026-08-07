<!DOCTYPE html>
<html lang="pt-BR">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>
SmartCatalog
</title>


<style>


*{

    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', Arial, sans-serif;

}



body{

    display:flex;
    min-height:100vh;
    background:#f1f5f9;

}





/* ==========================
   SIDEBAR
========================== */


.sidebar{


    width:270px;


    min-height:100vh;


    background:
    linear-gradient(
        180deg,
        #111827,
        #1e293b
    );


    color:white;


    padding:25px 20px;


    position:fixed;


}





.logo{


    display:flex;


    align-items:center;


    gap:12px;


    margin-bottom:40px;


}




.logo-icon{


    width:50px;


    height:50px;


    background:#2563eb;


    border-radius:50%;


    display:flex;


    align-items:center;


    justify-content:center;


    color:white;


    font-size:22px;


    font-weight:bold;


}





.logo h2{


    font-size:22px;


    font-weight:700;


}




.logo p{


    font-size:13px;


    color:#94a3b8;


    margin-top:4px;


}







.menu-title{


    color:#94a3b8;


    font-size:12px;


    text-transform:uppercase;


    margin-bottom:12px;


}







.sidebar a{


    display:flex;


    align-items:center;


    gap:12px;


    color:#e5e7eb;


    text-decoration:none;


    padding:13px 15px;


    border-radius:10px;


    margin-bottom:8px;


    transition:.3s;


}






.sidebar a:hover{


    background:#2563eb;


    color:white;


    transform:translateX(5px);


}









/* ==========================
   LOGOUT
========================== */


.logout{


    position:absolute;


    bottom:25px;


    left:20px;


    right:20px;


}





.logout form{


    width:100%;


}






.logout button{


    width:100%;


    display:flex;


    align-items:center;


    justify-content:center;


    gap:10px;


    background:#dc2626;


    color:white;


    border:none;


    border-radius:10px;


    padding:13px;


    font-size:15px;


    cursor:pointer;


    transition:.3s;


}






.logout button:hover{


    background:#b91c1c;


    transform:translateY(-2px);


}





.logout .arrow{


    font-size:20px;


    font-weight:bold;


}











/* ==========================
   CONTEÚDO
========================== */


.content{


    margin-left:270px;


    width:calc(100% - 270px);


    padding:35px;


}






.header{


    background:white;


    padding:25px;


    border-radius:16px;


    margin-bottom:25px;


    box-shadow:
    0 4px 15px rgba(0,0,0,.06);


}






.card{


    background:white;


    padding:25px;


    border-radius:16px;


    box-shadow:
    0 4px 15px rgba(0,0,0,.06);


}





button{


    font-family:inherit;


}







/* ==========================
   RESPONSIVO
========================== */


@media(max-width:800px){



.sidebar{


    width:80px;


    padding:20px 10px;


}



.logo h2,

.logo p,

.sidebar a span{


    display:none;


}




.content{


    margin-left:80px;


    width:calc(100% - 80px);


    padding:20px;


}



}






</style>


</head>





<body>





<div class="sidebar">





<div class="logo">



@if(auth()->user()->foto)


<img

src="{{ asset('storage/'.auth()->user()->foto) }}"

style="
width:50px;
height:50px;
border-radius:50%;
object-fit:cover;
border:3px solid #2563eb;
"

>


@else


<div class="logo-icon">


{{ strtoupper(substr(auth()->user()->name,0,1)) }}


</div>


@endif






<div>


<h2>
SmartCatalog
</h2>


<p>

{{ auth()->user()->name }}

</p>


</div>


</div>







<div class="menu-title">

Menu

</div>







<a href="{{ route('admin.dashboard') }}">


<span>
📊
</span>


<span>
Dashboard
</span>


</a>







<a href="{{ route('admin.categorias.index') }}">


<span>
📂
</span>


<span>
Categorias
</span>


</a>







<a href="{{ route('admin.produtos.index') }}">


<span>
📦
</span>


<span>
Produtos
</span>


</a>







<a href="{{ route('profile.edit') }}">


<span>
👤
</span>


<span>
Meu Perfil
</span>


</a>







<div class="logout">


<form method="POST" action="{{ route('logout') }}">


@csrf



<button type="submit">


<span class="arrow">
↪
</span>


Sair


</button>


</form>


</div>





</div>









<div class="content">


@yield('content')


</div>






</body>

</html>