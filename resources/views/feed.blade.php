<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<rss version="2.0">
<channel>
    <title>নিউজ পোর্টাল</title>
    <link>{{ route('home') }}</link>
    <description>বাংলাদেশ ও বিশ্বের সর্বশেষ সংবাদ</description>
    <language>bn</language>
    @foreach($articles as $article)
    <item>
        <title>{{ $article->title }}</title>
        <link>{{ route('article.show', $article->slug) }}</link>
        <description>{{ $article->excerpt }}</description>
        <pubDate>{{ $article->published_at->toRssString() }}</pubDate>
        <guid>{{ route('article.show', $article->slug) }}</guid>
    </item>
    @endforeach
</channel>
</rss>
