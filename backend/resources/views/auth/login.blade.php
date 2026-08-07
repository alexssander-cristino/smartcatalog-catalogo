<x-guest-layout>


<div style="
text-align:center;
margin-bottom:30px;
">

    <h1 style="
    font-size:32px;
    font-weight:bold;
    color:#111827;
    ">
        Smart<span style="color:#2563eb;">Catalog</span>
    </h1>


    <p style="
    color:#6b7280;
    margin-top:8px;
    ">
        Acesse o painel administrativo
    </p>


</div>



<form method="POST" action="{{ route('login') }}">

@csrf




<!-- E-mail -->

<div>


<x-input-label
for="email"
value="E-mail"
/>



<x-text-input

id="email"

class="block mt-1 w-full"

type="email"

name="email"

:value="old('email')"

required

autofocus

autocomplete="username"

/>



<x-input-error

:messages="$errors->get('email')"

class="mt-2"

/>


</div>







<!-- Senha -->


<div class="mt-4">


<x-input-label

for="password"

value="Senha"

/>



<x-text-input

id="password"

class="block mt-1 w-full"

type="password"

name="password"

required

autocomplete="current-password"

/>



<x-input-error

:messages="$errors->get('password')"

class="mt-2"

/>



</div>








<!-- Lembrar -->


<div class="block mt-4">


<label
for="remember_me"
class="inline-flex items-center"
>


<input

id="remember_me"

type="checkbox"

class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"

name="remember"

>



<span class="ms-2 text-sm text-gray-600">

Lembrar de mim

</span>



</label>



</div>








<div class="flex items-center justify-between mt-6">





@if(Route::has('password.request'))


<a

class="underline text-sm text-gray-600 hover:text-gray-900"

href="{{ route('password.request') }}"

>

Esqueceu sua senha?

</a>



@endif






<x-primary-button>


Entrar


</x-primary-button>





</div>






@if(Route::has('register'))


<div style="
text-align:center;
margin-top:25px;
font-size:14px;
">


Ainda não possui conta?


<a

href="{{ route('register') }}"

style="
color:#2563eb;
font-weight:bold;
"

>

Criar conta

</a>



</div>


@endif





</form>



</x-guest-layout>