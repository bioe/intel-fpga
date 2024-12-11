<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductGroupUpdateRequest;
use App\Models\Product;
use App\Models\ProductGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ProductGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Build Filter
        $filters = $this->filterSessions($request, 'product_groups', [
            'keyword' => '',
            'product' => '',
        ]);

        $list = ProductGroup::query()
        ->with('product')
        ->when(!empty($filters['keyword']), function ($q) use ($filters) {
            $q->orWhere('name', 'like', '%' . $filters['keyword'] . '%');
        })
        ->when(!empty($filters['product']), function ($q) use ($filters) {
            $q->where('product_id', $filters['product']);
        })
        ->filterSort($filters)
        ->paginate(config('table.per_page'));

        $products = Product::pluck('name', 'id');

        return Inertia::render('ProductGroup/Index', [
            'header' => ProductGroup::header(),
            'filters' => $filters,
            'list' => $list,
            'products' => $products,
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
    public function store(ProductGroupUpdateRequest $request)
    {
        return $this->update($request, null);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductGroup $productGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductGroup $productGroup = null)
    {
        $products = Product::pluck('name', 'id');

        if (null === $productGroup) {
            $data = new ProductGroup;
        } else {
            $data = $productGroup->load('product');
        }

        return Inertia::render('ProductGroup/Edit', [
            'data' => $data,
            'products' => $products,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductGroupUpdateRequest $request, ProductGroup $productGroup = null)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        
        if (null === $productGroup) {
            $data = ProductGroup::create($data);
            return Redirect::route('product_groups.edit', $data->id)->with('message', 'Product Group created successfully');
        } else {
            $productGroup->update($data);
            return Redirect::route('product_groups.edit', $productGroup->id)->with('message', 'Product Group updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductGroup $productGroup)
    {
        $productGroup->delete();
        return Redirect::route('product_groups.index')->with('message', 'Product Group deleted successfully');
    }
}
