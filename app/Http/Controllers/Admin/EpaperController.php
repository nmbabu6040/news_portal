<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Epaper;
use Illuminate\Http\Request;

class EpaperController extends Controller
{
    public function index()
    {
        $epapers = Epaper::orderByDesc('edition_date')->paginate(20);
        return view('admin.epapers.index', compact('epapers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'edition_date' => 'required|date|unique:epapers,edition_date',
            'pdf' => 'required|file|mimes:pdf|max:20480',
        ]);

        $path = $request->file('pdf')->store('epapers', 'public');

        Epaper::create([
            'edition_date' => $data['edition_date'],
            'pdf_path' => $path,
        ]);

        return back()->with('status', 'ই-পেপার আপলোড হয়েছে');
    }

    public function destroy(Epaper $epaper)
    {
        $epaper->delete();
        return back()->with('status', 'ই-পেপার ডিলিট হয়েছে');
    }
}
