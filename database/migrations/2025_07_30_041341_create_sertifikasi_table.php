    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void
        {
            Schema::create('sertifikasi', function (Blueprint $table) {
                $table->id();
                $table->string('nama_umkm')->nullable();
                $table->string('produk')->nullable();
                $table->string('status')->nullable();
                $table->string('pembina_1')->nullable(); // ini dari migration yang error tadi
                $table->timestamps();
            });
        }

        public function down(): void
        {
            Schema::dropIfExists('sertifikasi');
        }
    };
