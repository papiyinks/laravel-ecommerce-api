<?php

namespace App\Data\Repositories\Product;

/**
 * Interface ProductRepository
 * @package App\Data\Repositories\Product
 */
interface ProductRepository
{
    /**
     * @return mixed
     */
    public function createProduct();

    public function getAllProducts();

    public function updateAProduct();
}
