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
    font-family:Arial, Helvetica, sans-serif;
}



body{

    background:#f8fafc;
    color:#1f2937;

}





/* HEADER */


.header{

    background:#111827;
    color:white;
    padding:20px 0;

}



.header-content{

    max-width:1200px;
    margin:auto;
    padding:0 30px;

    display:flex;
    justify-content:space-between;
    align-items:center;

}



.logo{

    font-size:28px;
    font-weight:bold;

}



.logo span{

    color:#60a5fa;

}






/* CONTAINER */


.container{

    max-width:1200px;
    margin:auto;
    padding:30px;

}







/* TITULOS */


.titulo{

    font-size:38px;
    font-weight:bold;
    margin-bottom:8px;

}



.subtitulo{

    color:#6b7280;
    font-size:18px;

}






/* PESQUISA */


.form-pesquisa{

    margin:30px 0;

    display:flex;

    gap:10px;

    flex-wrap:wrap;

}



.input{

    flex:1;

    min-width:220px;

    padding:13px;

    border-radius:8px;

    border:1px solid #d1d5db;

    font-size:15px;

    background:white;

}





.btn{

    background:#2563eb;

    color:white;

    border:none;

    padding:13px 25px;

    border-radius:8px;

    cursor:pointer;

    font-weight:bold;

}



.btn:hover{

    background:#1d4ed8;

}






/* CATEGORIAS */


.categorias{

    display:flex;

    gap:10px;

    flex-wrap:wrap;

    margin-bottom:35px;

}



.categoria{

    background:#111827;

    color:white;

    padding:10px 18px;

    border-radius:30px;

    text-decoration:none;

    transition:.2s;

}



.categoria:hover{

    background:#2563eb;

}






/* PRODUTOS */


.produtos{

    display:grid;

    grid-template-columns:
    repeat(auto-fill,minmax(260px,1fr));

    gap:25px;

}





.card{

    background:white;

    border-radius:15px;

    overflow:hidden;

    box-shadow:
    0 4px 15px rgba(0,0,0,.08);

    transition:.2s;

}



.card:hover{

    transform:translateY(-5px);

}





.card img{

    width:100%;

    height:260px;

    object-fit:cover;

}





.sem-imagem{

    height:260px;

    background:#e5e7eb;

    display:flex;

    justify-content:center;

    align-items:center;

    color:#6b7280;

}






.info{

    padding:20px;

}



.info h2{

    font-size:21px;

    margin-bottom:10px;

}



.info p{

    color:#6b7280;

}



.preco{

    margin-top:15px;

    font-size:25px;

    font-weight:bold;

    color:#16a34a;

}






.destaque{

    display:inline-block;

    background:#facc15;

    padding:6px 12px;

    border-radius:20px;

    font-size:13px;

    font-weight:bold;

    margin-bottom:10px;

}






/* RESPONSIVO */


@media(max-width:600px){


.header-content{

    padding:0 15px;

}


.logo{

    font-size:22px;

}


.container{

    padding:20px;

}


.titulo{

    font-size:30px;

}


}




</style>



</head>



<body>




<header class="header">


<div class="header-content">


<div class="logo">

Smart<span>Catalog</span>

</div>


</div>


</header>





@yield('content')





</body>


</html>