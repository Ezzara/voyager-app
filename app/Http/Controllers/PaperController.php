<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Paper Model
use App\Models\Papers;



class PaperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Papers::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'publish_date' => 'required|date',
        ]);
        $paper = Papers::create($validated);
        //returning response
        return response()->json($paper, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return Papers::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $paper = Papers::findOrFail($id);
        $validated = $request->validate([
            'title' => 'sometimes|required|string',
            'author' => 'sometimes|required|string',
            'publish_date' => 'sometimes|required|date',
        ]);
        $paper->update($validated);
        return response()->json($paper);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $paper = Papers::findOrFail($id);
        $paper->delete();
        return response()->json(null, 204);
    }
}
