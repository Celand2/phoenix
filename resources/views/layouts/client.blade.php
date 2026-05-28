<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Client') - Phoenix Traders</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('js/client.js') }}" defer></script>
</head>
<body class="bg-ash-900 text-ash-50">
    <div class="min-h-screen">
        <header class="sticky top-0 z-10 border-b border-ash-600 bg-ash-800/95 px-4 py-4">
            <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-3">
                <a href="{{ route('client.dashboard') }}" class="text-xl font-bold text-gold-400">Phoenix Traders</a>
                <nav class="flex flex-wrap gap-2 text-sm text-ash-100">
                    @foreach ([
                        'Dashboard' => route('client.dashboard'),
                        'Trades' => route('client.trades.index'),
                        'Mes trades' => route('client.my-trades.index'),
                        'Depots' => route('client.deposits.index'),
                        'Retraits' => route('client.withdrawals.index'),
                        'Parrainage' => route('client.referrals.index'),
                        'Messages' => route('client.messages.index'),
                        'Notifications' => route('client.notifications.index'),
                        'Profil' => route('client.profile.index'),
                    ] as $label => $url)
                        <a class="rounded-lg px-3 py-2 hover:bg-crimson-600" href="{{ $url }}">{{ $label }}</a>
                    @endforeach
                </nav>
                <a class="rounded-lg bg-crimson-400 px-4 py-2 text-sm font-semibold text-white hover:bg-crimson-600" href="/logout">Deconnexion</a>
            </div>
        </header>
        <main class="mx-auto max-w-7xl p-4 md:p-6">
            @if (session('status'))
                <div class="mb-4 rounded-lg border border-gold-600 bg-gold-100 px-4 py-3 text-gold-800">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="mb-4 rounded-lg border border-crimson-600 bg-crimson-100 px-4 py-3 text-crimson-800">{{ $errors->first() }}</div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>
