<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::latest()->paginate(10);
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug',
            'print_rate_card' => 'nullable|mimes:pdf,jpg,png|max:10240',
            'digital_media_kit' => 'nullable|mimes:pdf,jpg,png|max:10240',
        ]);

        $data = [
            'title' => $request->title,
            'slug' => $request->slug ? Str::slug($request->slug) : Str::slug($request->title),
            'content' => $request->content,
            'content_en' => $request->content_en,
            'content_bn' => $request->content_bn,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('print_rate_card')) {
            $data['print_rate_card'] = $request->file('print_rate_card')->store('pages', 'public');
        }

        if ($request->hasFile('digital_media_kit')) {
            $data['digital_media_kit'] = $request->file('digital_media_kit')->store('pages', 'public');
        }

        Page::create($data);

        return redirect()->route('admin.pages.index')->with('status', 'পেজটি সফলভাবে তৈরি হয়েছে।');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug,' . $page->id,
            'print_rate_card' => 'nullable|mimes:pdf,jpg,png|max:10240',
            'digital_media_kit' => 'nullable|mimes:pdf,jpg,png|max:10240',
        ]);

        $data = [
            'title' => $request->title,
            'slug' => $request->slug ? Str::slug($request->slug) : Str::slug($request->title),
            'content' => $request->content,
            'content_en' => $request->content_en,
            'content_bn' => $request->content_bn,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('print_rate_card')) {
            if ($page->print_rate_card) Storage::disk('public')->delete($page->print_rate_card);
            $data['print_rate_card'] = $request->file('print_rate_card')->store('pages', 'public');
        }

        if ($request->hasFile('digital_media_kit')) {
            if ($page->digital_media_kit) Storage::disk('public')->delete($page->digital_media_kit);
            $data['digital_media_kit'] = $request->file('digital_media_kit')->store('pages', 'public');
        }

        $page->update($data);

        return redirect()->route('admin.pages.index')->with('status', 'পেজটি আপডেট করা হয়েছে।');
    }

    public function destroy(Page $page)
    {
        if ($page->print_rate_card) Storage::disk('public')->delete($page->print_rate_card);
        if ($page->digital_media_kit) Storage::disk('public')->delete($page->digital_media_kit);

        $page->delete();
        return redirect()->route('admin.pages.index')->with('status', 'পেজটি মুছে ফেলা হয়েছে।');
    }
}
