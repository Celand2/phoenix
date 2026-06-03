<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Connexion') - phenix Traders</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="grid min-h-screen place-items-center bg-gold-50 p-4 text-ash-900">
    <main class="w-full max-w-md rounded-2xl border border-gold-100 bg-white p-8 shadow-xl">
        <h1 class="mb-8 text-center text-3xl font-bold text-ember-900">@yield('title', 'phenix Traders')</h1>
        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-crimson-200 bg-crimson-50 p-4 text-sm font-medium text-crimson-800 shadow-sm">
                {{ $errors->first() }}
            </div>
        @endif
        @yield('content')
    </main>
</body>
</html>
