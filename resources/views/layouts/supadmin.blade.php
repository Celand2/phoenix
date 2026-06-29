<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - phenix Traders</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gold-50 text-ash-900">
    <div class="min-h-screen">
        <main class="min-h-screen">
            <header class="sticky top-0 z-20 flex items-center justify-between gap-3 border-b border-gold-100 bg-white/95 px-4 py-4 backdrop-blur-sm md:px-6">
                <h1 class="min-w-0 flex-1 truncate text-lg font-bold text-ash-900">@yield('title', 'Retraits')</h1>
                <a href="{{ route('admin.logout') }}" class="rounded-lg bg-crimson-400 px-4 py-2 text-sm font-semibold text-white hover:bg-crimson-600">
                    Déconnexion
                </a>
            </header>
            <section class="p-6">
                @if (session('status'))
                    <div class="mb-6 rounded-xl border border-gold-200 bg-gold-100 px-4 py-3 text-gold-800 shadow-sm">{{ session('status') }}</div>
                @endif
                @if ($errors->any())
                    <div class="mb-6 rounded-xl border border-crimson-200 bg-crimson-50 px-4 py-3 text-crimson-800 shadow-sm">{{ $errors->first() }}</div>
                @endif
                @yield('content')
            </section>
        </main>
    </div>
    <script>
        function copyToClipboard(text, button) {
            if (!navigator.clipboard) {
                alert('Votre navigateur ne supporte pas le presse-papiers.');
                return;
            }
            navigator.clipboard.writeText(text).then(() => {
                const original = button.innerText;
                button.innerText = 'Copié';
                button.disabled = true;
                setTimeout(() => {
                    button.innerText = original;
                    button.disabled = false;
                }, 1500);
            }).catch(() => {
                alert('Impossible de copier dans le presse-papiers.');
            });
        }
    </script>
</body>
</html>