<?php

// tests/Unit/ProductTest.php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_product_can_be_created()
    {
        $product = Product::factory()->create();
        $this->assertDatabaseHas('products', ['name' => $product->name]);
    }

    /** @test */
    public function product_name_is_required()
    {
        $this->expectException(\Illuminate\Validation\ValidationException::class);

        Product::create([
            'name' => null,
            'description' => 'Test description',
            'price' => 10.00,
            'category_id' => 1
        ]);
    }
}