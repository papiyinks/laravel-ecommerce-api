<?php

namespace App\Data\Repositories\Product;

use App\Product;
use Illuminate\Support\Facades\Auth;

/**
 * Class EloquentRepository
 * @package App\Data\Repositories\Product
 */
class EloquentRepository implements ProductRepository
{
    /**
     * @return mixed
     */
    public function createProduct()
    {
        request()->validate([
            'name' => 'required|string',
            'brand' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|string',
            'description' => 'required|string'
        ]);

        $product = Product::create([
            'owner_id' => Auth::id(),
            'name' => request('name'),
            'brand' => request('brand'),
            'price' => request('price'),
            'image' => request('image'),
            'description' => request('description'),
        ]);

        return $product;
    }

    public function getAllProducts()
    {
        $products = Product::all();

        return $products;
    }

    public function updateAProduct()
    {
        $data = request()->validate([
            'name' => 'required|string',
            'brand' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|string',
            'description' => 'required|string'
        ]);

        return $data;
    }
}
