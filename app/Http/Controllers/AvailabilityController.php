<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Availability;
use Illuminate\Support\Facades\Auth;

class AvailabilityController extends Controller
{
    public function index()
    {
        $availabilities = Auth::user()->availabilities()->latest()->get();
        return view('instructor.availabilities.index', compact('availabilities'));
    }

    // Show form to create availability
    public function create()
    {
        return view('instructor.availabilities.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'mode' => 'required|in:online,in-person',
            'city' => 'nullable|string|max:255',
            'days' => 'required|array',
            'days.*' => 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'time_slots' => 'required|array',
            'time_slots.*' => 'string',
        ]);

        Auth::user()->availabilities()->create([
            'mode' => $request->mode,
            'city' => $request->city,
            'days' => json_encode($request->days),
            'time_slots' => json_encode($request->time_slots),
        ]);

        return redirect()->route('availabilities.index')->with('success', 'Availability added successfully.');
    }
    public function edit(Availability $availability)
    {
        $this->authorize('update', $availability);
        return view('instructor.availabilities.edit', compact('availability'));
    }
    public function update(Request $request, Availability $availability)
    {
        $this->authorize('update', $availability);

        $request->validate([
            'mode' => 'required|in:online,in-person',
            'city' => 'nullable|string|max:255',
            'days' => 'required|array',
            'days.*' => 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'time_slots' => 'required|array',
            'time_slots.*' => 'string',
        ]);

        $availability->update([
            'mode' => $request->mode,
            'city' => $request->city,
            'days' => json_encode($request->days),
            'time_slots' => json_encode($request->time_slots),
        ]);

        return redirect()->route('availabilities.index')->with('success', 'Availability updated successfully.');
    }
    public function destroy(Availability $availability)
    {
        $this->authorize('delete', $availability);
        $availability->delete();
        return redirect()->route('availabilities.index')->with('success', 'Availability deleted successfully.');
    }
}
