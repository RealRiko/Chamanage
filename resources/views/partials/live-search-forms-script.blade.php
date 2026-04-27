{{-- Listing search: fetch filtered HTML and swap a fragment (no full page reload). --}}
<script>
(function () {
    document.addEventListener('DOMContentLoaded', function () {
        var debounceMs = 320;
        document.querySelectorAll('form[data-listing-live]').forEach(function (form) {
            var rootId = form.getAttribute('data-listing-root');
            if (!rootId) {
                return;
            }
            var searchInput = form.querySelector('input[name="search"]');
            var root = document.getElementById(rootId);
            if (!searchInput || !root) {
                return;
            }
            var timer;
            searchInput.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                }
            });
            searchInput.addEventListener('input', function () {
                clearTimeout(timer);
                timer = setTimeout(function () {
                    var params = new URLSearchParams(new FormData(form));
                    var action = form.getAttribute('action') || '';
                    var base = action.split('#')[0];
                    var qs = params.toString();
                    var fetchUrl = qs ? (base + (base.indexOf('?') !== -1 ? '&' : '?') + qs) : base;
                    fetch(fetchUrl, {
                        credentials: 'same-origin',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html'
                        }
                    })
                        .then(function (r) {
                            return r.text();
                        })
                        .then(function (html) {
                            var doc = new DOMParser().parseFromString(html, 'text/html');
                            var next = doc.getElementById(rootId);
                            if (next) {
                                root.innerHTML = next.innerHTML;
                            }
                        })
                        .catch(function (err) {
                            console.error('Listing fetch failed:', err);
                        });
                }, debounceMs);
            });
        });
    });
})();
</script>
