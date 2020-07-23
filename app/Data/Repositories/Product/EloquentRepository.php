<?php

namespace App\Data\Repositories\Product;

use App\Product;

/**
 * Class EloquentRepository
 * @package App\Data\Repositories\Product
 */
class EloquentRepository implements ProductRepository
{
    protected $product;

    public function __construct(Product $product)
    {
       $this->product = $product;
    }

    public function createProduct($attributes)
    {
        return $this->product->create($attributes);
    }

    public function getAllProducts()
    {
        return $this->product->all();
    }

    public function updateAProduct($product, $attributes)
    {
        return $product->update($attributes);
    }

    public function deleteAProduct($product)
    {
        return $product->delete();
    }
}
