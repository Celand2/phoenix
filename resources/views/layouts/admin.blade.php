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
<body class="bg-ash-900 text-ash-50" data-admin-layout>
    <div class="min-h-screen">
        <div class="fixed inset-0 z-30 hidden bg-ash-900/70 lg:hidden" data-admin-overlay></div>

        <aside
            id="admin-left-menu"
            class="fixed inset-y-0 left-0 z-40 w-72 -translate-x-full overflow-y-auto border-r border-ash-600 bg-ash-800 p-4 shadow-2xl transition-transform duration-200 data-[open=true]:translate-x-0 lg:w-64"
            data-admin-panel="left"
            data-open="false"
        >
            <div class="flex items-center justify-between gap-3">
                <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-gold-400">Phoenix Admin</a>
                <button
                    type="button"
                    class="grid size-10 place-items-center rounded-lg border border-ash-600 text-ash-100 hover:bg-ash-900"
                    data-admin-toggle="left"
                    aria-controls="admin-left-menu"
                    aria-expanded="false"
                    aria-label="Fermer le menu gauche"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <nav class="mt-6 grid gap-2 text-sm text-ash-100" aria-label="Navigation admin principale">
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

        <aside
            id="admin-right-menu"
            class="fixed inset-y-0 right-0 z-40 w-72 translate-x-full overflow-y-auto border-l border-ash-600 bg-ash-800 p-4 shadow-2xl transition-transform duration-200 data-[open=true]:translate-x-0 lg:w-80"
            data-admin-panel="right"
            data-open="false"
        >
            <div class="flex items-center justify-between gap-3">
                <h2 class="text-lg font-semibold text-gold-400">Actions rapides</h2>
                <button
                    type="button"
                    class="grid size-10 place-items-center rounded-lg border border-ash-600 text-ash-100 hover:bg-ash-900"
                    data-admin-toggle="right"
                    aria-controls="admin-right-menu"
                    aria-expanded="false"
                    aria-label="Fermer le menu droit"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <nav class="mt-6 grid gap-2 text-sm text-ash-100" aria-label="Actions admin rapides">
                @foreach ([
                    'Nouveau trade' => route('admin.trades.create'),
                    'Nouvelle categorie' => route('admin.categories.create'),
                    'Nouvelle methode' => route('admin.payment-methods.create'),
                    'Codes bonus' => route('admin.bonus-codes.index'),
                    'Depots en attente' => route('admin.deposits.index'),
                    'Retraits en attente' => route('admin.withdrawals.index'),
                    'Envoyer notification' => route('admin.notifications.index'),
                    'Messages clients' => route('admin.messages.index'),
                ] as $label => $url)
                    <a class="rounded-lg px-3 py-2 hover:bg-crimson-600" href="{{ $url }}">{{ $label }}</a>
                @endforeach
            </nav>
            <div class="mt-6 rounded-lg border border-ash-600 bg-ash-900 p-4">
                <p class="text-xs uppercase tracking-wide text-ash-400">Session</p>
                <a class="mt-3 inline-flex w-full items-center justify-center rounded-lg bg-crimson-400 px-4 py-2 text-sm font-semibold text-white hover:bg-crimson-600" href="{{ route('admin.logout') }}">Deconnexion</a>
            </div>
        </aside>

        <main class="min-h-screen transition-[margin] duration-200" data-admin-main>
            <header class="sticky top-0 z-20 flex items-center justify-between gap-3 border-b border-ash-600 bg-ash-800 px-4 py-4 md:px-6">
                <button
                    type="button"
                    class="grid size-10 shrink-0 place-items-center rounded-lg border border-ash-600 text-ash-100 hover:bg-ash-900"
                    data-admin-toggle="left"
                    aria-controls="admin-left-menu"
                    aria-expanded="false"
                    aria-label="Ouvrir le menu gauche"
                >
                    <span aria-hidden="true">&#9776;</span>
                </button>
                <h1 class="min-w-0 flex-1 truncate text-lg font-semibold">@yield('title', 'Administration')</h1>
                <button
                    type="button"
                    class="grid size-10 shrink-0 place-items-center rounded-lg border border-ash-600 text-ash-100 hover:bg-ash-900"
                    data-admin-toggle="right"
                    aria-controls="admin-right-menu"
                    aria-expanded="false"
                    aria-label="Ouvrir le menu droit"
                >
                    <span aria-hidden="true">&#8942;</span>
                </button>
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
