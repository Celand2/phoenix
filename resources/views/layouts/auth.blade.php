<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Connexion') - Phoenix Traders</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="grid min-h-screen place-items-center bg-ash-900 p-4 text-ash-50">
    <main class="w-full max-w-md rounded-lg border border-ash-600 bg-ash-800 p-6">
        <h1 class="mb-6 text-2xl font-bold text-gold-400">@yield('title', 'Phoenix Traders')</h1>
        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-crimson-100 p-3 text-crimson-800">{{ $errors->first() }}</div>
        @endif
        @yield('content')
    </main>
</body>
</html>
