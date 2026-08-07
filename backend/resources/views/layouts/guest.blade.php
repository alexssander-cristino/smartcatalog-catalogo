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

    min-height:100vh;

    background:
    linear-gradient(
        135deg,
        #111827,
        #2563eb
    );

    display:flex;

    justify-content:center;

    align-items:center;

}




.container{

    width:100%;

    max-width:420px;

    padding:20px;

}




.logo{

    text-align:center;

    color:white;

    font-size:32px;

    font-weight:bold;

    margin-bottom:25px;

}



.logo span{

    color:#93c5fd;

}





.card{

    background:white;

    padding:35px;

    border-radius:16px;

    box-shadow:
    0 10px 30px rgba(0,0,0,.25);

}




h1{

    text-align:center;

    margin-bottom:25px;

    color:#111827;

}




label{

    display:block;

    margin-bottom:6px;

    color:#374151;

    font-weight:bold;

}





input{

    width:100%;

    padding:12px;

    border-radius:8px;

    border:1px solid #d1d5db;

    margin-bottom:15px;

    font-size:15px;

}



input:focus{

    outline:none;

    border-color:#2563eb;

}





button{

    width:100%;

    background:#2563eb;

    color:white;

    border:none;

    padding:13px;

    border-radius:8px;

    font-size:16px;

    font-weight:bold;

    cursor:pointer;

}



button:hover{

    background:#1d4ed8;

}





a{

    color:#2563eb;

    text-decoration:none;

}





.links{

    margin-top:20px;

    text-align:center;

    font-size:14px;

}



</style>


</head>


<body>


<div class="container">



<div class="logo">

Smart<span>Catalog</span>

</div>



<div class="card">


{{ $slot }}


</div>


</div>


</body>


</html>