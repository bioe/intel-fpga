<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Models\ProductType; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Build Filter
        $filters = $this->filterSessions($request, 'products', [
            'keyword' => '',
            'product_type' => '',
        ]);

        $list = Product::query()
            ->with('productType')
            ->when(!empty($filters['keyword']), function ($q) use ($filters) {
                $q->orWhere('name', 'like', '%' . $filters['keyword'] . '%');
            })
            ->when(!empty($filters['product_type']), function ($q) use ($filters) {
                $q->where('product_type_id', $filters['product_type']);
            })
            ->filterSort($filters)
            ->paginate(config('table.per_page'));
        
        $productTypes = ProductType::pluck('name', 'id');

        return Inertia::render('Product/Index', [
            'header' => Product::header(),
            'filters' => $filters,
            'list' => $list,
            'productTypes' => $productTypes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->edit(null);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductUpdateRequest $request)
    {
        return $this->update($request, null);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product = null)
    {
        $productTypes = ProductType::pluck('name', 'id');

        if (null === $product) {
            $data = new Product;
        } else {
            $data = $product->load('productType');
        }

        return Inertia::render('Product/Edit', [
            'data' => $data,
            'productTypes' => $productTypes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, Product $product = null)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        if (null === $product) {
            $data = Product::create($data);
            return Redirect::route('products.edit', $data->id)->with('message', 'Product created successfully');
        } else {
            $product->update($data);
            return Redirect::route('products.edit', $product->id)->with('message', 'Product updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return Redirect::route('products.index')->with('message', 'Product deleted successfully');
    }
}
