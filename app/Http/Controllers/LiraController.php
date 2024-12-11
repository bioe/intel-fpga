<?php

namespace App\Http\Controllers;

use App\Imports\LiraImport;
use App\Models\Lira;
use App\Models\LiraBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class LiraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Build Filter
        $filters = $this->filterSessions($request, 'lira', [
            'keyword' => '',
        ]);

        // $list = LiraBatch::query()
        // ->when(!empty($filters['keyword']), function ($q) use ($filters) {
        //     $q->orWhere('id', 'like', '%' . $filters['keyword'] . '%')
        //       ->orWhere('user_id', 'like', '%' . $filters['keyword'] . '%');
        // })->paginate(config('table.per_page'));

        $list = LiraBatch::with('user') 
        ->when(!empty($filters['keyword']), function ($q) use ($filters) {
            $q->where(function($query) use ($filters) {
                $query->orWhere('lira_batches.id', 'like', '%' . $filters['keyword'] . '%')
                      ->orWhere('lira_batches.user_id', 'like', '%' . $filters['keyword'] . '%')
                      ->orWhereHas('user', function($query) use ($filters) {
                          $query->where('name', 'like', '%' . $filters['keyword'] . '%');
                      });
            });
        })
        ->paginate(config('table.per_page'));

        return Inertia::render('Lira/Index', [
            'header' => LiraBatch::header(),
            'filters' => $filters,
            'list' => $list,
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
    public function store(Request $request)
    {
        return $this->update($request, null);
    }

    /**
     * Display the specified resource.
     */
    public function show(Lira $lira)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lira $lira = null)
    {
        $data = $lira ?? new Lira;

        return Inertia::render('Lira/Edit', [
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lira $lira = null)
    {
        $data = $request->validate([
            //
        ]);

        if (null === $lira) {
            $newLira = Lira::create($data);
            return Redirect::route('lira.edit', $newLira->id)->with('message', 'Lira created successfully.');
        } else {
            $lira->update($data);
            return Redirect::route('lira.edit', $lira->id)->with('message', 'Lira updated successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lira $lira)
    {
        $lira->delete();
        return Redirect::route('lira.index')->with('message', 'Lira deleted successfully.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => [
                'required',
                'file'
            ],
        ]);

        try {

            Excel::import(new LiraImport, $request->file('file'));
            return Redirect::route('lira.index')->with('message', 'Excel imported successfully.');

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {

            $failures = $e->failures();
            $error_messages = [];
            foreach ($failures as $failure) {
                $failure->row(); 
                $failure->attribute(); 
                $failure->errors(); 
                $failure->values(); 
                foreach ($failure->errors() as $error) {
                    $error_messages[] = "Row " . $failure->row() . " - [" . $failure->values()[$failure->attribute()] . "] " . $error;
                }
            }
            return Redirect::back()->withErrors($error_messages);
             
        } catch (\Exception $e) {
            return Redirect::route('lira.index')->with('importErrors', ['general' => $e->getMessage()]);
        }
    }
}
