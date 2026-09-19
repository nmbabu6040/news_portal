<?php

namespace App\Http\Controllers;

use App\Models\Epaper;

class EpaperController extends Controller
{
    public function index()
    {
        $epapers = Epaper::orderByDesc('edition_date')->paginate(20);
        $latest = $epapers->first();

        return view('epaper', compact('epapers', 'latest'));
    }
}
