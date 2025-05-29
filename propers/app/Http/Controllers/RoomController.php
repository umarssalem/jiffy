<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the rooms.
     */
    // public function index()
    // {
    //     // The Okipa table handles the rendering
    //     return view('rooms.index');
    // }

    /**
     * Show the form for editing the specified room.
     */
    // public function edit(Room $room)
    // {
    //     return view('rooms.edit', compact('room'));
    // }

    /**
     * Update the specified room in storage.
     */
    // public function update(Request $request, Room $room)
    // {
    //     // $validated = $request->validate([
    //     //     'property_id' => 'required|exists:properties,id',
    //     //     'max' => 'required|integer|min:1',
    //     //     'price' => 'required|numeric|min:0',
    //     // ]);

    //     // $room->update($validated);

    //     return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
    // }

    /**
     * Display the specified room.
     */
    // public function show(Room $room)
    // {
    //     return view('rooms.show', compact('room'));
    // }

    /**
     * Remove the specified room from storage.
     */
    // public function destroy(Room $room)
    // {
    //     $room->delete();

    //     return redirect()->route('rooms.index')->with('success', 'Room deleted successfully.');
    // }
}
