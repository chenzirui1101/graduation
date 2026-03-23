<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // 关联用户
            $table->string('title', 191); // 商品标题
            $table->integer('category_id'); // 分类ID
            $table->decimal('price', 10, 2); // 价格
            $table->string('cover_img'); // 封面图
            $table->text('description'); // 商品描述
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
