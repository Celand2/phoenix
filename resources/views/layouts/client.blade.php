<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Client') - phenix Traders</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('js/client.js') }}" defer></script>
</head>
<body class="bg-gold-50 text-ash-900" data-client-layout>
    <div class="min-h-screen">
        <div class="fixed inset-0 z-30 hidden bg-ash-900/20 lg:hidden" data-client-overlay></div>

        <aside
            id="client-left-menu"
            class="fixed inset-y-0 left-0 z-40 w-72 -translate-x-full overflow-y-auto border-r border-gold-100 bg-white p-4 shadow-xl transition-transform duration-200 data-[open=true]:translate-x-0 lg:w-64"
            data-client-panel="left"
            data-open="false"
        >
            <div class="flex items-center justify-between gap-3">
                <a href="{{ route('client.dashboard') }}" class="text-xl font-bold text-ember-900">phenix Traders</a>
                <button
                    type="button"
                    class="grid size-10 place-items-center rounded-lg border border-gold-100 text-ash-600 hover:bg-gold-50"
                    data-client-toggle="left"
                    aria-controls="client-left-menu"
                    aria-expanded="false"
                    aria-label="Fermer le menu gauche"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <nav class="mt-6 grid gap-2 text-sm font-medium text-ash-600" aria-label="Navigation client principale">
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
                    <a class="rounded-lg px-3 py-2 transition-colors hover:bg-crimson-50 hover:text-crimson-600" href="{{ $url }}">{{ $label }}</a>
                @endforeach
            </nav>
        </aside>

        <aside
            id="client-right-menu"
            class="fixed inset-y-0 right-0 z-40 w-72 translate-x-full overflow-y-auto border-l border-gold-100 bg-white p-4 shadow-xl transition-transform duration-200 data-[open=true]:translate-x-0 lg:w-80"
            data-client-panel="right"
            data-open="false"
        >
            <div class="flex items-center justify-between gap-3">
                <h2 class="text-lg font-semibold text-ember-900">Raccourcis</h2>
                <button
                    type="button"
                    class="grid size-10 place-items-center rounded-lg border border-gold-100 text-ash-600 hover:bg-gold-50"
                    data-client-toggle="right"
                    aria-controls="client-right-menu"
                    aria-expanded="false"
                    aria-label="Fermer le menu droit"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <nav class="mt-6 grid gap-2 text-sm font-medium text-ash-600" aria-label="Raccourcis client">
                @foreach ([
                    'Acheter un trade' => route('client.trades.index'),
                    'Mes gains' => route('client.my-trades.index'),
                    'Faire un depot' => route('client.deposits.index'),
                    'Demander un retrait' => route('client.withdrawals.index'),
                    'Code bonus' => route('client.profile.index'),
                    'Contacter admin' => route('client.messages.index'),
                ] as $label => $url)
                    <a class="rounded-lg px-3 py-2 transition-colors hover:bg-crimson-50 hover:text-crimson-600" href="{{ $url }}">{{ $label }}</a>
                @endforeach
            </nav>
            <div class="mt-6 rounded-xl border border-gold-100 bg-gold-50 p-4">
                <p class="text-xs font-bold uppercase tracking-wider text-ash-400">Compte</p>
                <a class="mt-3 inline-flex w-full items-center justify-center rounded-lg bg-crimson-400 px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-crimson-600" href="/logout">Deconnexion</a>
            </div>
        </aside>

        <main class="min-h-screen transition-[margin] duration-200" data-client-main>
            <header class="sticky top-0 z-20 border-b border-gold-100 bg-white/95 px-4 py-4 backdrop-blur-sm">
                <div class="mx-auto flex max-w-7xl items-center justify-between gap-3">
                    <button
                        type="button"
                        class="grid size-10 shrink-0 place-items-center rounded-lg border border-gold-100 text-ash-600 hover:bg-gold-50"
                        data-client-toggle="left"
                        aria-controls="client-left-menu"
                        aria-expanded="false"
                        aria-label="Ouvrir le menu gauche"
                    >
                        <span aria-hidden="true">&#9776;</span>
                    </button>
                    <a href="{{ route('client.dashboard') }}" class="min-w-0 flex-1 truncate text-center text-xl font-bold text-ember-900">phenix Traders</a>
                    <button
                        type="button"
                        class="grid size-10 shrink-0 place-items-center rounded-lg border border-gold-100 text-ash-600 hover:bg-gold-50"
                        data-client-toggle="right"
                        aria-controls="client-right-menu"
                        aria-expanded="false"
                        aria-label="Ouvrir le menu droit"
                    >
                        <span aria-hidden="true">&#8942;</span>
                    </button>
                </div>
            </header>
            <section class="mx-auto max-w-7xl p-4 md:p-6">
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
</body>
</html>
