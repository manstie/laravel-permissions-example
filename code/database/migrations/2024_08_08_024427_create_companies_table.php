<?php

use App\Models\Company;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->string('trading_name', 255)->nullable();
            $table->string('abn', 14)->nullable();
            $table->string('acn', 11)->nullable();
            $table->string('invoice_email', 320)->nullable();
            $table->string('phone', 45)->nullable();
            $table->string('fax', 45)->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->foreign('company_id')->references('id')->on('companies');
        });

        Company::insert([
            'id' => Company::ADMIN_ID,
            'name' => 'Admin Company',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
