<?php

namespace Tests\Feature;
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product; // Ensure this line is present
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_create_products()
    {
        $response = $this->post(route('products.store'), []);
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_view_products()
    {
        $product = Product::factory()->create();
        $response = $this->get(route('products'));
        $response->assertSee($product->name);
    }
}
