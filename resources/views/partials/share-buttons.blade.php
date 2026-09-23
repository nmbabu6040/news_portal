@php
    $shareUrl = route('article.show', $article->slug);
    $shareTitle = urlencode($article->title);
    $encodedUrl = urlencode($shareUrl);
@endphp

<div class="share-buttons d-flex align-items-center gap-2 flex-wrap py-3 border-top border-bottom my-3">
    <span class="fw-bold small text-muted me-1"><i class="bi bi-share-fill"></i> শেয়ার করুন:</span>

    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $encodedUrl }}" target="_blank" rel="noopener"
        class="btn btn-sm btn-outline-primary" title="Facebook-এ শেয়ার করুন">
        <i class="bi bi-facebook"></i>
    </a>

    <a href="https://twitter.com/intent/tweet?url={{ $encodedUrl }}&text={{ $shareTitle }}" target="_blank"
        rel="noopener" class="btn btn-sm btn-outline-dark" title="X (Twitter)-এ শেয়ার করুন">
        <i class="bi bi-twitter-x"></i>
    </a>

    <a href="https://wa.me/?text={{ $shareTitle }}%20{{ $encodedUrl }}" target="_blank" rel="noopener"
        class="btn btn-sm btn-outline-success" title="WhatsApp-এ শেয়ার করুন">
        <i class="bi bi-whatsapp"></i>
    </a>

    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $encodedUrl }}" target="_blank" rel="noopener"
        class="btn btn-sm btn-outline-info" title="LinkedIn-এ শেয়ার করুন">
        <i class="bi bi-linkedin"></i>
    </a>

    <a href="https://t.me/share/url?url={{ $encodedUrl }}&text={{ $shareTitle }}" target="_blank" rel="noopener"
        class="btn btn-sm btn-outline-primary" title="Telegram-এ শেয়ার করুন">
        <i class="bi bi-telegram"></i>
    </a>

    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="copyShareLink(this)"
        data-url="{{ $shareUrl }}" title="লিংক কপি করুন">
        <i class="bi bi-link-45deg"></i> <span class="copy-label">লিংক কপি</span>
    </button>
</div>

<script>
    function copyShareLink(btn) {
        const url = btn.getAttribute('data-url');
        navigator.clipboard.writeText(url).then(function() {
            const label = btn.querySelector('.copy-label');
            const original = label.textContent;
            label.textContent = 'কপি হয়েছে!';
            setTimeout(function() {
                label.textContent = original;
            }, 2000);
        });
        trackShare();
    }

    function trackShare() {
        fetch('{{ route('article.share', $article->slug) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
        }).catch(() => {});
    }

    document.querySelectorAll('.share-buttons a[target="_blank"]').forEach(function(link) {
        link.addEventListener('click', trackShare);
    });
</script>
