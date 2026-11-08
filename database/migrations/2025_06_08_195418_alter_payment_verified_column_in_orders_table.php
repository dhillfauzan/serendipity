<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    // 1. Tambahkan kolom baru
    \DB::statement("ALTER TABLE orders ADD COLUMN payment_verified_new TIMESTAMP NULL AFTER payment_verified");
    
    // 2. Copy data yang valid (skip nilai 0)
    \DB::statement("UPDATE orders SET payment_verified_new = FROM_UNIXTIME(payment_verified) WHERE payment_verified > 0");
    
    // 3. Hapus kolom lama
    \DB::statement("ALTER TABLE orders DROP COLUMN payment_verified");
    
    // 4. Rename kolom baru
    \DB::statement("ALTER TABLE orders CHANGE COLUMN payment_verified_new payment_verified TIMESTAMP NULL");
}

public function down()
{
    \DB::statement("ALTER TABLE orders ADD COLUMN payment_verified_old INTEGER NULL AFTER payment_verified");
    \DB::statement("UPDATE orders SET payment_verified_old = UNIX_TIMESTAMP(payment_verified)");
    \DB::statement("ALTER TABLE orders DROP COLUMN payment_verified");
    \DB::statement("ALTER TABLE orders CHANGE COLUMN payment_verified_old payment_verified INTEGER NULL");
}
};
