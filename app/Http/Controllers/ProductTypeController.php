<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductTypeUpdateRequest;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //Build Filter
        $filters = $this->filterSessions($request, 'product_types', [
            'keyword' => ''
        ]);

        $list = ProductType::query()->when(!empty($filters['keyword']), function ($q) use ($filters) {
            $q->orWhere('name', 'like', '%' . $filters['keyword'] . '%');
        })->filterSort($filters)->paginate(config('table.per_page'));

        return Inertia::render('ProductType/Index', [
            'header' => ProductType::header(),
            'filters' => $filters,
            'list' => $list
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
    public function store(ProductTypeUpdateRequest $request)
    {
        return $this->update($request, null);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductType $productType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductType $productType = null)
    {
        if (null === $productType) {
            $data = new ProductType;
        } else {
            $data = $productType;
        }

        return Inertia::render('ProductType/Edit', [
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductTypeUpdateRequest $request, ProductType $productType = null)
    {
        $data = $request->validated();
        if (null === $productType) {
            $data = ProductType::create($data);
            return Redirect::route('product_types.edit', $data->id)->with('message', 'Product Type created successfully');
        } else {
            $productType->update($data);
            return Redirect::route('product_types.edit', $productType->id)->with('message', 'Product Type updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductType $productType)
    {
        $productType->delete();
        return Redirect::route('product_types.index')->with('message', 'Product Type deleted successfully');
    }
}
