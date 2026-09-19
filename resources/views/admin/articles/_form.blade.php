<div class="mb-3">
    <label class="form-label">শিরোনাম</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $article->title ?? '') }}" required>
</div>
<div class="mb-3">
    <label class="form-label">সংক্ষিপ্ত বিবরণ</label>
    <textarea name="excerpt" class="form-control" rows="2">{{ old('excerpt', $article->excerpt ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label class="form-label">বিস্তারিত</label>
    <textarea name="content" class="form-control" rows="8" required>{{ old('content', $article->content ?? '') }}</textarea>
</div>
<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">ক্যাটাগরি</label>
        <select name="category_id" class="form-select" required>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" @selected(old('category_id', $article->category_id ?? '') == $cat->id)>{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">স্ট্যাটাস</label>
        <select name="status" class="form-select">
            <option value="draft" @selected(old('status', $article->status ?? '') == 'draft')>ড্রাফট</option>
            <option value="published" @selected(old('status', $article->status ?? '') == 'published')>প্রকাশিত</option>
        </select>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">থাম্বনেইল</label>
        <input type="file" name="thumbnail" class="form-control">
    </div>
</div>
<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">আর্টিকেলের ধরন</label>
        <select name="type" class="form-select" id="articleType">
            <option value="article" @selected(old('type', $article->type ?? 'article') == 'article')>সাধারণ আর্টিকেল</option>
            <option value="gallery" @selected(old('type', $article->type ?? '') == 'gallery')>ফটো গ্যালারি</option>
            <option value="video" @selected(old('type', $article->type ?? '') == 'video')>ভিডিও</option>
        </select>
    </div>
    <div class="col-md-8 mb-3">
        <label class="form-label">ভিডিও URL (YouTube এমবেড লিংক, শুধু ভিডিও টাইপের জন্য)</label>
        <input type="url" name="video_url" class="form-control" value="{{ old('video_url', $article->video_url ?? '') }}" placeholder="https://www.youtube.com/embed/...">
    </div>
</div>
<div class="mb-3">
    <label class="form-label">গ্যালারির ছবি যুক্ত করুন (একাধিক নির্বাচন করা যায়, শুধু গ্যালারি টাইপের জন্য)</label>
    <input type="file" name="gallery_photos[]" class="form-control" multiple accept="image/*">
    @if(isset($article) && $article->photos->count())
        <div class="d-flex gap-2 mt-2 flex-wrap">
            @foreach($article->photos as $photo)
                <div class="position-relative">
                    <img src="{{ asset('storage/'.$photo->image_path) }} → {{ $photo->image_url }}" style="width:80px;height:80px;object-fit:cover;" class="rounded border">
                    <form action="{{ route('admin.photos.destroy', $photo) }}" method="POST" class="position-absolute top-0 end-0">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger py-0 px-1" onclick="return confirm('ডিলিট করবেন?')">×</button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
</div>
<div class="form-check mb-3">
    <input type="checkbox" name="is_featured" class="form-check-input" value="1" @checked(old('is_featured', $article->is_featured ?? false))>
    <label class="form-check-label">ফিচার্ড আর্টিকেল</label>
</div>
<div class="mb-3">
    <label class="form-label">ট্যাগ (কমা দিয়ে আলাদা করুন)</label>
    <input type="text" name="tags" class="form-control"
        value="{{ old('tags', isset($article) ? $article->tags->pluck('name')->implode(', ') : '') }}"
        placeholder="যেমন: নির্বাচন, ঢাকা, অর্থনীতি">
    @if(isset($tags) && $tags->count())
        <small class="text-muted">বিদ্যমান ট্যাগ: {{ $tags->pluck('name')->implode(', ') }}</small>
    @endif
</div>
