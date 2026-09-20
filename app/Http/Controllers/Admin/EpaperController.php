<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Epaper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function update(Request $request, Epaper $epaper)
    {
        $data = $request->validate([
            'edition_date' => 'required|date|unique:epapers,edition_date,' . $epaper->id,
            'pdf' => 'nullable|file|mimes:pdf|max:20480',
        ]);

        $epaper->edition_date = $data['edition_date'];

        // নতুন PDF আপলোড করলে পুরনো ফাইলটা ডিলিট করে নতুনটা বসানো হচ্ছে
        if ($request->hasFile('pdf')) {
            Storage::disk('public')->delete($epaper->pdf_path);
            $epaper->pdf_path = $request->file('pdf')->store('epapers', 'public');
        }

        $epaper->save();

        return back()->with('status', 'ই-পেপার আপডেট হয়েছে');
    }

    public function destroy(Epaper $epaper)
    {
        Storage::disk('public')->delete($epaper->pdf_path);
        $epaper->delete();
        return back()->with('status', 'ই-পেপার ডিলিট হয়েছে');
    }
}
