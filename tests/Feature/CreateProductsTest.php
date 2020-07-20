<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guests_may_not_create_threads()
    {
        $this->withExceptionHandling();

        $this->post('/api/products')
            ->assertRedirect('/api/login');
    }

    /** @test */
    function a_user_can_create_a_product()
    {
        $header = $this->signIn();

        $attributes = [
            'name' => 'Samsung Gz',
            'brand' => 'Samsung',
            'image' => 'http//awesome',
            'price' => 847,
            'description' => 'This is awesome'
        ];

        $this->post('/api/products', $attributes, $header);

        $this->assertDatabaseHas('products', $attributes);
    }

    /** @test */
    public function a_product_requires_a_name()
    {
        $this->withExceptionHandling();

        $headers = $this->signIn();

        $attributes = factory('App\Product')->raw(['name' => '']);

        $this->post('/api/products', $attributes, $headers)->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_product_requires_a_brand()
    {
        $this->withExceptionHandling();

        $headers = $this->signIn();

        $attributes = factory('App\Product')->raw(['brand' => '']);

        $this->post('/api/products', $attributes, $headers)->assertSessionHasErrors('brand');
    }

    /** @test */
    public function a_product_requires_a_price()
    {
        $this->withExceptionHandling();

        $headers = $this->signIn();

        $attributes = factory('App\Product')->raw(['price' => '']);

        $this->post('/api/products', $attributes, $headers)
            ->assertSessionHasErrors('price');
    }

    /** @test */
    public function a_product_requires_an_image()
    {
        $this->withExceptionHandling();

        $header = $this->signIn();

        $attributes = factory('App\Product')->raw(['image' => '']);

        $this->post('/api/products', $attributes, $header)
            ->assertSessionHasErrors('image');
    }

    /** @test */
    public function a_product_requires_a_description()
    {
        $this->withExceptionHandling();

        $header = $this->signIn();

        $attributes = factory('App\Product')->raw(['description' => '']);

        $this->post('/api/products', $attributes, $header)
            ->assertSessionHasErrors('description');
    }

    /** @test */
    function unauthorized_users_may_not_delete_product()
    {
        $this->withExceptionHandling();

        $header = $this->signIn();

        $product = create('App\Product');

        $this->delete($product->path(), [], $header)
            ->assertStatus(403);
    }

    /** @test */
    function authorized_user_can_delete_product()
    {
        $user = create('App\User');

        $token = $user->createAccessToken();
        $header = ['Authorization' => "Bearer $token"];

        $product = create('App\Product', ['owner_id' => $user->id]);

        $this->delete($product->path(), [], $header);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);

    }
}
