<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | NUMERO
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('pedidos', 'numero')) {

            // Primeiro cria permitindo NULL
            Schema::table('pedidos', function (Blueprint $table) {

                $table->string('numero')
                    ->nullable()
                    ->after('id');

            });

            // Preenche os pedidos que já existem
            DB::statement("
                UPDATE pedidos
                SET numero = 'PED-' || id
                WHERE numero IS NULL
            ");

            // Agora torna obrigatório
            Schema::table('pedidos', function (Blueprint $table) {

                $table->string('numero')
                    ->nullable(false)
                    ->change();

            });

            // Cria índice único
            Schema::table('pedidos', function (Blueprint $table) {

                $table->unique('numero');

            });
        }


        /*
        |--------------------------------------------------------------------------
        | CLIENTE
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('pedidos', 'cliente')) {

            Schema::table('pedidos', function (Blueprint $table) {

                $table->string('cliente')
                    ->nullable()
                    ->after('numero');

            });
        }


        /*
        |--------------------------------------------------------------------------
        | OBSERVAÇÃO
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('pedidos', 'observacao')) {

            Schema::table('pedidos', function (Blueprint $table) {

                $table->text('observacao')
                    ->nullable()
                    ->after('cliente');

            });
        }


        /*
        |--------------------------------------------------------------------------
        | VALOR TOTAL
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('pedidos', 'valor_total')) {

            Schema::table('pedidos', function (Blueprint $table) {

                $table->decimal('valor_total', 10, 2)
                    ->default(0)
                    ->after('observacao');

            });
        }


        /*
        |--------------------------------------------------------------------------
        | STATUS
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('pedidos', 'status')) {

            Schema::table('pedidos', function (Blueprint $table) {

                $table->string('status')
                    ->default('emitido')
                    ->after('valor_total');

            });
        }


        /*
        |--------------------------------------------------------------------------
        | EMITIDO EM
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('pedidos', 'emitido_em')) {

            Schema::table('pedidos', function (Blueprint $table) {

                $table->timestamp('emitido_em')
                    ->nullable()
                    ->after('status');

            });
        }
    }


    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {

            if (Schema::hasColumn('pedidos', 'numero')) {
                $table->dropUnique(['numero']);
                $table->dropColumn('numero');
            }

            if (Schema::hasColumn('pedidos', 'cliente')) {
                $table->dropColumn('cliente');
            }

            if (Schema::hasColumn('pedidos', 'observacao')) {
                $table->dropColumn('observacao');
            }

            if (Schema::hasColumn('pedidos', 'valor_total')) {
                $table->dropColumn('valor_total');
            }

            if (Schema::hasColumn('pedidos', 'status')) {
                $table->dropColumn('status');
            }

            if (Schema::hasColumn('pedidos', 'emitido_em')) {
                $table->dropColumn('emitido_em');
            }

        });
    }
};
