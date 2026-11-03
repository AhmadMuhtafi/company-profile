(function () {
    var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function fmt(n) { return n.toLocaleString('id-ID'); }

    // Angka pada kotak ringkasan di beranda dihitung naik satu kali saat halaman dibuka.
    document.querySelectorAll('[data-count]').forEach(function (el) {
        var target = parseInt(el.getAttribute('data-count'), 10);
        var suffix = el.getAttribute('data-suffix') || '';
        if (isNaN(target)) { return; }
        if (reduce) { el.textContent = fmt(target) + suffix; return; }

        var start = null, duration = 1200;
        function step(ts) {
            if (start === null) { start = ts; }
            var p = Math.min((ts - start) / duration, 1);
            var eased = 1 - Math.pow(1 - p, 3);
            el.textContent = fmt(Math.round(target * eased)) + suffix;
            if (p < 1) { requestAnimationFrame(step); }
        }
        requestAnimationFrame(step);
    });

    // Mencegah kirim ganda pada formulir kontak.
    document.querySelectorAll('form[data-loading]').forEach(function (form) {
        form.addEventListener('submit', function () {
            var btn = form.querySelector('button[type="submit"]');
            if (!btn) { return; }
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" aria-hidden="true"></span>Mengirim';
        });
    });
})();
