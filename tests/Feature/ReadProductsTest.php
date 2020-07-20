<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_and_users_can_see_all_products()
    {
        $product = create('App\Product');

        $this->get('/api/products')
            ->assertSee($product->name);
    }

    /** @test */
    public function users_and_guests_view_a_single_product()
    {
        $product = create('App\Product');

        $this->get($product->path())
            ->assertSee($product->name);
    }
}
