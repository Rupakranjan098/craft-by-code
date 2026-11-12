<script nonce="{{ $cspNonce ?? '' }}">
(function () {
    var storageKey = 'cbc_theme';

    function resolveTheme() {
        try {
            var saved = localStorage.getItem(storageKey);
            if (saved === 'dark' || saved === 'light') {
                return saved;
            }
        } catch (e) {}

        return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches
            ? 'dark'
            : 'light';
    }

    function applyTheme(theme) {
        var root = document.documentElement;
        var isDark = theme === 'dark';
        root.classList.toggle('dark', isDark);
        root.style.colorScheme = isDark ? 'dark' : 'light';
        root.setAttribute('data-theme', theme);
    }

    applyTheme(resolveTheme());

    document.addEventListener('click', function (event) {
        var trigger = event.target && event.target.closest ? event.target.closest('[data-theme-toggle]') : null;
        if (!trigger) {
            return;
        }
        var next = document.documentElement.classList.contains('dark') ? 'light' : 'dark';
        applyTheme(next);
        try {
            localStorage.setItem(storageKey, next);
        } catch (e) {}
    });
})();
</script>

