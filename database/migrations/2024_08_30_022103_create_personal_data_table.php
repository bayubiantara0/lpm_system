<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Create the addresses table first
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('provinsi');
            $table->string('kab_kota');
            $table->string('kecamatan');
            $table->string('kelurahan_desa');
            $table->string('alamat', 255);
            $table->string('rt', 3)->nullable();
            $table->string('rw', 3)->nullable();
            $table->timestamps();
        });

        // Then create the personal_data table
        Schema::create('personal_data', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->unsignedBigInteger('nik')->unique();
            $table->unsignedBigInteger('nomor_kartu_keluarga')->unique();
            $table->string('foto_ktp_path')->nullable();
            $table->string('foto_kartu_keluarga_path')->nullable();
            $table->unsignedTinyInteger('umur')->check('umur >= 25');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->foreignId('address_id')->constrained('addresses')->onDelete('cascade');
            $table->unsignedBigInteger('penghasilan_sebelum_pandemi')->nullable();
            $table->unsignedBigInteger('penghasilan_setelah_pandemi')->nullable();
            $table->enum('alasan_membutuhkan_bantuan', [
                'Kehilangan pekerjaan',
                'Kepala keluarga',
                'Tergolong fakir/miskin',
                'Lainnya'
            ])->nullable();
            $table->string('alasan_lainnya')->nullable();
            $table->timestamps();

            // Indexes for faster searching
            $table->index('nik');
            $table->index('nomor_kartu_keluarga');
        });
    }

    public function down(): void
    {
        // Drop the personal_data table first, as it references addresses
        Schema::dropIfExists('personal_data');
        
        // Then drop the addresses table
        Schema::dropIfExists('addresses');
    }
};
