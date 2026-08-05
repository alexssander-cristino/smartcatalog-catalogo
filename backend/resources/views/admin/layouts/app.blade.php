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
    font-family:Arial, sans-serif;
}


body{

    display:flex;
    background:#f3f4f6;

}



/* MENU */

.sidebar{

    width:250px;
    height:100vh;
    background:#111827;
    color:white;
    padding:20px;

}



.sidebar h2{

    margin-bottom:30px;

}



.sidebar a{

    display:block;
    color:white;
    text-decoration:none;
    padding:12px;
    border-radius:6px;
    margin-bottom:8px;

}


.sidebar a:hover{

    background:#374151;

}




/* CONTEUDO */

.content{

    flex:1;
    padding:30px;

}



.header{

    background:white;
    padding:20px;
    border-radius:10px;
    margin-bottom:20px;

}



.card{

    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 2px 8px #0002;

}


</style>


</head>


<body>



<div class="sidebar">


<h2>
SmartCatalog
</h2>


<a href="/admin/dashboard">
Dashboard
</a>


<a href="#">
Categorias
</a>


<a href="#">
Produtos
</a>


<form method="POST" action="/logout">

@csrf

<button style="
background:none;
border:none;
color:white;
cursor:pointer;
padding:12px;
font-size:16px;
">

Sair

</button>


</form>


</div>





<div class="content">


@yield('content')


</div>




</body>

</html>