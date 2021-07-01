<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DetilInvestor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detil_investor', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('investor_id');
            $table->integer('tipe_pengguna')->nullable();
            $table->integer('jenis_badan_hukum')->nullable();
            $table->string('nama_investor',191)->nullable();
            $table->string('no_ktp_investor',191)->nullable();
            $table->string('no_npwp_investor',191)->nullable();
            $table->string('tempat_lahir_investor',191)->nullable();
            $table->string('tgl_lahir_investor',50)->nullable();
            $table->integer('jenis_kelamin_investor')->nullable();
            $table->integer('status_kawin_investor')->nullable();
            $table->text('alamat_investor')->nullable();
            $table->integer('provinsi_investor')->nullable();
            $table->string('kota_investor',5)->nullable();
            $table->integer('kode_pos_investor')->nullable();
            $table->integer('status_rumah_investor')->nullable();
            $table->string('phone_investor',191)->nullable()->unique();
            $table->integer('agama_investor')->nullable();
            $table->integer('pekerjaan_investor')->nullable();
            $table->string('bidang_pekerjaan',5)->nullable();
            $table->integer('online_investor')->nullable();
            $table->integer('pendapatan_investor')->nullable();
            $table->integer('asset_investor')->nullable();
            $table->integer('pengalaman_investor')->nullable();
            $table->integer('pendidikan_investor')->nullable();
            $table->string('bank_investor',5)->nullable();
            $table->string('pic_investor',191)->nullable();
            $table->string('pic_ktp_investor',191)->nullable();
            $table->string('pic_user_ktp_investor',191)->nullable();
            $table->string('pasangan_investor',191)->nullable();
            $table->string('pasangan_email',191)->nullable();
            $table->string('pasangan_tempat_lhr',191)->nullable();
            $table->string('pasangan_tgl_lhr',50)->nullable();
            $table->integer('pasangan_jenis_kelamin')->nullable();
            $table->string('pasangan_ktp',50)->nullable();
            $table->string('pasangan_npwp',50)->nullable();
            $table->string('pasangan_phone',191)->nullable();
            $table->text('pasangan_alamat')->nullable();
            $table->integer('pasangan_provinsi')->nullable();
            $table->string('pasangan_kota',5)->nullable();
            $table->integer('pasangan_kode_pos')->nullable();
            $table->integer('pasangan_agama')->nullable();
            $table->integer('pasangan_pekerjaan')->nullable();
            $table->string('pasangan_bidang_pekerjaan',5)->nullable();
            $table->integer('pasangan_online')->nullable();
            $table->integer('pasangan_pendapatan')->nullable();
            $table->integer('pasangan_pengalaman')->nullable();
            $table->integer('pasangan_pendidikan')->nullable();
            $table->string('nama_perwakilan',191)->nullable();
            $table->string('no_ktp_perwakilan',191)->nullable();
            // $table->string('phone_investor')->nullable()->unique();
            // $table->string('pasangan_investor')->nullable();
            // $table->string('pasangan_phone')->nullable();
            $table->string('job_investor',191)->nullable();
            // $table->string('alamat_investor')->nullable();
            $table->string('rekening',191)->nullable();
            $table->string('bank',191)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detil_investor');
    }
}
