<?php

namespace App\Http\Controllers;

use App\Http\Requests\LineItemManagerUpdateRequest;
use App\Models\LineitemManager;
use App\Models\Lira;
use App\Models\Product;
use App\Models\ProductGroup;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LineItemManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //Build Filter
        $filters = $this->filterSessions($request, 'lineitem_manager', [
            'keyword' => ''
        ]);

        $list = LineitemManager::query()->with(['product_type', 'product_group', 'product', 'user'])->when(!empty($filters['keyword']), function ($q) use ($filters) {
            $q->orWhere('module', 'like', '%' . $filters['keyword'] . '%');
        })->filterSort($filters)->paginate(config('table.per_page'));

        return Inertia::render('LineitemManager/Index', [
            'header' => LineitemManager::header(),
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
    public function store(LineItemManagerUpdateRequest $request)
    {
        return $this->update($request, null);
    }

    /**
     * Display the specified resource.
     */
    public function show(LineitemManager $lineitemManager)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LineitemManager $lineitemManager = null)
    {
        $products = Product::pluck('name', 'id');
        $productGroups = ProductGroup::pluck('name', 'id');
        $modules = ['LIRA Data (Speed)'];
        $columns = (new Lira)->getTableColumns();

        if (null === $lineitemManager) {
            $data = new LineitemManager;
        } else {
            $data = $lineitemManager;
        }

        return Inertia::render('LineitemManager/Edit', [
            'data' => $data,
            'products' => $products,
            'productGroups' => $productGroups,
            'modules' => $modules,
            'columns' => $columns
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LineItemManagerUpdateRequest $request, LineitemManager $lineitemManager = null)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        if (null === $lineitemManager) {
            $data = LineitemManager::create($data);
            return Redirect::route('lineitem_managers.edit', $data->id)->with('message', 'Line Item created successfully');
        } else {
            $lineitemManager->update($data);
            return Redirect::route('lineitem_managers.edit', $lineitemManager->id)->with('message', 'Line Item updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LineitemManager $lineitemManager)
    {
        $lineitemManager->delete();
        return Redirect::route('lineitem_managers.index')->with('message', 'Line Item deleted successfully');
    }
}
