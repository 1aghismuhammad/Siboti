<?php

namespace App\Http\Controllers;

use App\Models\ProgressRecord;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ProgressRecordController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        if (! auth()->user()->hasRole('trainer')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'weight' => ['nullable', 'numeric'],
            'height' => ['nullable', 'numeric'],
            'waist' => ['nullable', 'numeric'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        ProgressRecord::create([
            'user_id' => $request->user_id,
            'weight' => $request->weight,
            'height' => $request->height,
            'muscle_mass' => null,
            'fat_percentage' => null,
            'notes' => $request->notes,
        ]);

        return back()->with('success', 'Progres member berhasil disimpan.');
    }
}
