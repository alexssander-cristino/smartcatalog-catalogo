<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class ProdutoController extends Controller
{


    public function index()
    {


        $produtos = Produto::with([
            'categoria',
            'imagens'
        ])
        ->orderBy('nome')
        ->get();



        return view(
            'admin.produtos.index',
            compact('produtos')
        );


    }







    public function create()
    {


        $categorias = Categoria::where('ativo', true)
            ->orderBy('nome')
            ->get();



        return view(
            'admin.produtos.create',
            compact('categorias')
        );


    }









    public function store(Request $request)
    {


        $request->validate([


            'categoria_id' => 'required|exists:categorias,id',

            'sku' => 'nullable|max:100',

            'nome' => 'required|max:255',

            'marca' => 'nullable|max:255',

            'descricao' => 'nullable|string',

            'preco' => 'required|numeric|min:0',

            'preco_promocional' => 'nullable|numeric|min:0',

            'estoque' => 'required|integer|min:0',

            'unidade' => 'nullable|max:20',

            'imagem' => 'nullable|image|max:2048',


        ]);







        $produto = Produto::create([



            'categoria_id' => $request->categoria_id,


            'sku' => $request->sku,


            'nome' => $request->nome,


            'marca' => $request->marca,


            'descricao' => $request->descricao,


            'preco' => $request->preco,


            'preco_promocional' => $request->preco_promocional,


            'estoque' => $request->estoque,


            'unidade' => $request->unidade,


            'ativo' => $request->boolean('ativo'),


            'destaque' => $request->boolean('destaque'),



        ]);










        /*
        |--------------------------------------------------------------------------
        | Upload da imagem principal
        |--------------------------------------------------------------------------
        */


        if($request->hasFile('imagem')){


            $arquivo = $request
                ->file('imagem')
                ->store(
                    'produtos',
                    'public'
                );



            $produto->imagens()->create([

                'imagem'=>$arquivo

            ]);



        }








        return redirect()

            ->route('admin.produtos.index')

            ->with(
                'success',
                'Produto cadastrado com sucesso.'
            );


    }












    public function show(Produto $produto)
    {


        $produto->load([

            'categoria',

            'imagens'

        ]);




        return view(

            'admin.produtos.show',

            compact('produto')

        );


    }












    public function edit(Produto $produto)
    {


        $produto->load([

            'imagens'

        ]);




        $categorias = Categoria::where('ativo', true)

            ->orderBy('nome')

            ->get();






        return view(

            'admin.produtos.edit',

            compact(

                'produto',

                'categorias'

            )

        );


    }












    public function update(Request $request, Produto $produto)
    {


        $request->validate([


            'categoria_id' => 'required|exists:categorias,id',

            'sku' => 'nullable|max:100',

            'nome' => 'required|max:255',

            'marca' => 'nullable|max:255',

            'descricao' => 'nullable|string',

            'preco' => 'required|numeric|min:0',

            'preco_promocional' => 'nullable|numeric|min:0',

            'estoque' => 'required|integer|min:0',

            'unidade' => 'nullable|max:20',

            'imagem' => 'nullable|image|max:2048',


        ]);









        $produto->update([



            'categoria_id' => $request->categoria_id,


            'sku' => $request->sku,


            'nome' => $request->nome,


            'marca' => $request->marca,


            'descricao' => $request->descricao,


            'preco' => $request->preco,


            'preco_promocional' => $request->preco_promocional,


            'estoque' => $request->estoque,


            'unidade' => $request->unidade,


            'ativo' => $request->boolean('ativo'),


            'destaque' => $request->boolean('destaque'),



        ]);









        /*
        |--------------------------------------------------------------------------
        | Adicionar nova imagem
        |--------------------------------------------------------------------------
        */


        if($request->hasFile('imagem')){


            $arquivo = $request

                ->file('imagem')

                ->store(
                    'produtos',
                    'public'
                );




            $produto->imagens()->create([


                'imagem'=>$arquivo


            ]);



        }









        return redirect()


            ->route('admin.produtos.index')


            ->with(
                'success',
                'Produto atualizado com sucesso.'
            );


    }












    public function destroy(Produto $produto)
    {



        foreach($produto->imagens as $imagem){



            if(
                Storage::disk('public')
                ->exists($imagem->imagem)
            ){



                Storage::disk('public')
                    ->delete($imagem->imagem);



            }



        }







        $produto->delete();







        return redirect()


            ->route('admin.produtos.index')


            ->with(
                'success',
                'Produto removido com sucesso.'
            );


    }



}