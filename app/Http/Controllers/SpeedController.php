<?php

namespace App\Http\Controllers;

use App\Imports\SpeedImport;
use App\Models\Speed;
use App\Models\SpeedBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class SpeedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Build Filter
        $filters = $this->filterSessions($request, 'speed', [
            'keyword' => '',
        ]);

        $list = SpeedBatch::with('user')
            ->when(!empty($filters['keyword']), function ($q) use ($filters) {
                $q->where(function ($query) use ($filters) {
                    $query->orWhere('speed_batches.id', 'like', '%' . $filters['keyword'] . '%')
                        ->orWhere('speed_batches.user_id', 'like', '%' . $filters['keyword'] . '%')
                        ->orWhereHas('user', function ($query) use ($filters) {
                            $query->where('name', 'like', '%' . $filters['keyword'] . '%');
                        });
                });
            })
            ->paginate(config('table.per_page'));

        return Inertia::render('Speed/Index', [
            'header' => SpeedBatch::header(),
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
    public function show(Speed $speed)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Speed $speed = null)
    {
        $data = $speed ?? new Speed;

        return Inertia::render('Speed/Edit', [
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Speed $speed = null)
    {
        $data = $request->validate([
            //
        ]);

        if (null === $speed) {
            $newSpeed = Speed::create($data);
            return Redirect::route('speed.edit', $newSpeed->id)->with('message', 'Speed created successfully.');
        } else {
            $speed->update($data);
            return Redirect::route('speed.edit', $speed->id)->with('message', 'Speed updated successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Speed $speed)
    {
        $speed->delete();
        return Redirect::route('speed.index')->with('message', 'Speed deleted successfully.');
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

            Excel::import(new SpeedImport, $request->file('file'));
            return Redirect::route('speed.index')->with('message', 'Excel imported successfully.');
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
            return Redirect::route('speed.index')->with('importErrors', ['general' => $e->getMessage()]);
        }
    }
}
