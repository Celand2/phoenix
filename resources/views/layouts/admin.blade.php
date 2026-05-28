<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - Phoenix Traders</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('js/admin.js') }}" defer></script>
</head>
<body class="bg-ash-900 text-ash-50">
    <div class="min-h-screen md:flex">
        <aside class="border-b border-ash-600 bg-ash-800 p-4 md:fixed md:inset-y-0 md:w-64 md:border-b-0 md:border-r">
            <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-gold-400">Phoenix Admin</a>
            <nav class="mt-6 grid gap-2 text-sm text-ash-100">
                @foreach ([
                    'Dashboard' => route('admin.dashboard'),
                    'Categories' => route('admin.categories.index'),
                    'Trades' => route('admin.trades.index'),
                    'User trades' => route('admin.user-trades.index'),
                    'Depots' => route('admin.deposits.index'),
                    'Retraits' => route('admin.withdrawals.index'),
                    'Paiements' => route('admin.payment-methods.index'),
                    'Bonus' => route('admin.bonus-codes.index'),
                    'Users' => route('admin.users.index'),
                    'Parrainage' => route('admin.referrals.index'),
                    'Messages' => route('admin.messages.index'),
                    'Taux' => route('admin.exchange-rates.index'),
                    'Notifications' => route('admin.notifications.index'),
                ] as $label => $url)
                    <a class="rounded-lg px-3 py-2 hover:bg-crimson-600" href="{{ $url }}">{{ $label }}</a>
                @endforeach
            </nav>
        </aside>
        <main class="flex-1 md:ml-64">
            <header class="flex items-center justify-between border-b border-ash-600 bg-ash-800 px-6 py-4">
                <h1 class="text-lg font-semibold">@yield('title', 'Administration')</h1>
                <a class="rounded-lg bg-crimson-400 px-4 py-2 text-sm font-semibold text-white hover:bg-crimson-600" href="{{ route('admin.logout') }}">Deconnexion</a>
            </header>
            <section class="p-6">
                @if (session('status'))
                    <div class="mb-4 rounded-lg border border-gold-600 bg-gold-100 px-4 py-3 text-gold-800">{{ session('status') }}</div>
                @endif
                @if ($errors->any())
                    <div class="mb-4 rounded-lg border border-crimson-600 bg-crimson-100 px-4 py-3 text-crimson-800">{{ $errors->first() }}</div>
                @endif
                @yield('content')
            </section>
        </main>
    </div>
</body>
</html>
