<?php

namespace App\Http\Controllers;

use App\Data\Repositories\Product\ProductRepository;
use App\Product;

class ProductsController extends Controller
{
    protected $product_repository;

    public function __construct(ProductRepository $product_repository)
    {
        $this->middleware('auth:api')->except(['index', 'show']);

        $this->product_repository = $product_repository;
    }

    public function index()
    {
        $products = $this->product_repository->getAllProducts();

        return response()->json([
            'products' => $products,
        ], 200);
    }

    public function store()
    {
        $product = $this->product_repository->createProduct();

        return response()->json([
            'product' => $product,
        ], 201);
    }

    public function show(Product $product)
    {
        return response()->json([
            'product' => $product,
        ], 200);
    }

    public function update(Product $product)
    {
        $this->authorize('update', $product);

        $data = $this->product_repository->updateAProduct();

        $product->update($data);

        return response()->json([
            'product' => $product,
        ], 201);
    }

    public function destroy(Product $product)
    {
        $this->authorize('update', $product);

        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully',
            'product' => $product,
        ], 201);
    }
}
