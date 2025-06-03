<?php

namespace App\Http\Controllers;

use App\Models\Season;
use Exception;
use Illuminate\Http\Request;

class SeasonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('season.index', [
            'seasons' => Season::orderBy('name', 'asc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($season)
    {
        return view('season.create', [
            'seasons' => Season::all(),
            'season' => $season
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $season)
    {
        try {
            Season::create([
                'name' => $request->name,
            ]);
            return redirect()->route('season.index', ['season' => $season])->with('success', 'Season created successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Nama season sudah ada.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Season $season)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($season, $id)
    {
        $seasonEdit = Season::where('id', $id)->first();
        return view('season.edit', [
            'season' => $season,
            'seasonEdit' => $seasonEdit
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $season, $id)
    {
        try {
            $seasonUpdate = Season::where('id', $id)->first();
            if ($season == $seasonUpdate->name) {
                $seasonUpdate->update([
                    'name' => $request->name,
                ]);
                // return $seasonUpdate->name;
                return redirect('/' . $seasonUpdate->name . '/season')->with('success', 'Season Edit successfully.');
            } else {
                $seasonUpdate->update([
                    'name' => $request->name,
                ]);
                return redirect()->route('season.index', ['season' => $season])->with('success', 'Season edit successfully.');
            }
        } catch (Exception $e) {
            return redirect('/' . $season . '/season/' . $id . '/edit')->with('error', 'Nama season sudah ada.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($season, $id)
    {
        Season::where('id', $id)->delete();
        return response()->json(['success' => true, 'message' => 'Season deleted successfully.']);
        // return redirect()->route('season.index', ['season' => $season])->with('success', 'Season deleted successfully.');
    }
}
