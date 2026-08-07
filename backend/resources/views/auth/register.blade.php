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
">

Crie sua conta administrativa

</p>


</div>



<form method="POST" action="{{ route('register') }}">

@csrf



<div>

<x-input-label
for="name"
value="Nome"
/>


<x-text-input
id="name"
class="block mt-1 w-full"
type="text"
name="name"
:value="old('name')"
required
autofocus
autocomplete="name"
/>


<x-input-error
:messages="$errors->get('name')"
class="mt-2"
/>


</div>





<div class="mt-4">


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
autocomplete="username"
/>


<x-input-error
:messages="$errors->get('email')"
class="mt-2"
/>


</div>





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
autocomplete="new-password"
/>


<x-input-error
:messages="$errors->get('password')"
class="mt-2"
/>


</div>





<div class="mt-4">


<x-input-label
for="password_confirmation"
value="Confirmar senha"
/>


<x-text-input
id="password_confirmation"
class="block mt-1 w-full"
type="password"
name="password_confirmation"
required
autocomplete="new-password"
/>


<x-input-error
:messages="$errors->get('password_confirmation')"
class="mt-2"
/>


</div>





<div class="flex items-center justify-between mt-6">


<a
class="underline text-sm text-gray-600 hover:text-gray-900"
href="{{ route('login') }}"
>

Já possui uma conta?

</a>




<x-primary-button>

Criar conta

</x-primary-button>



</div>



</form>


</x-guest-layout>