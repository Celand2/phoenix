<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Phoenix Traders - Investissez dans l'avenir</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gold-50 text-ash-900 font-sans">
        <!-- Header / Nav -->
        <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gold-100">
            <div class="mx-auto max-w-7xl px-4 py-4 flex items-center justify-between">
                <a href="/" class="text-2xl font-black text-crimson-600 tracking-tighter">PHOENIX TRADERS</a>
                <nav class="hidden md:flex items-center gap-8">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/client/dashboard') }}" class="text-sm font-bold text-ash-600 hover:text-crimson-600 transition-colors">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-bold text-ash-600 hover:text-crimson-600 transition-colors">Connexion</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="rounded-xl bg-crimson-400 px-6 py-2.5 text-sm font-black text-white shadow-lg shadow-crimson-200 hover:bg-crimson-600 transition-all active:scale-95">Commencer</a>
                            @endif
                        @endauth
                    @endif
                </nav>
                <!-- Mobile Trigger (simplified for now) -->
                <div class="md:hidden text-ash-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </div>
            </div>
        </header>

        <main>
            <!-- Hero Section -->
            <section class="relative overflow-hidden bg-gradient-to-br from-crimson-600 via-ember-500 to-gold-400 py-24 lg:py-32">
                <div class="absolute inset-0 opacity-10 mix-blend-overlay">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_-20%,#fff,transparent)]"></div>
                </div>
                
                <div class="mx-auto max-w-7xl px-4 relative">
                    <div class="max-w-3xl">
                        <h1 class="text-5xl font-black tracking-tight text-white lg:text-7xl leading-none">
                            Faites renaître votre <span class="text-gold-200">patrimoine</span> de ses cendres.
                        </h1>
                        <p class="mt-8 text-xl text-ember-50 leading-relaxed max-w-2xl">
                            Rejoignez la plateforme de trading d'élite. Des rendements journaliers garantis, un système de parrainage puissant et une sécurité de pointe pour vos investissements.
                        </p>
                        <div class="mt-12 flex flex-wrap gap-4">
                            <a href="{{ route('register') }}" class="rounded-2xl bg-white px-8 py-5 text-lg font-black text-crimson-600 shadow-2xl hover:bg-gold-50 transition-all active:scale-95">
                                Créer mon compte gratuit
                            </a>
                            <a href="#features" class="rounded-2xl border-2 border-white/30 bg-white/10 px-8 py-5 text-lg font-bold text-white backdrop-blur-sm hover:bg-white/20 transition-all">
                                En savoir plus
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Decorative shape -->
                <div class="absolute bottom-0 right-0 -mb-24 hidden lg:block">
                    <div class="h-96 w-96 rounded-full bg-gold-400/20 blur-3xl"></div>
                </div>
            </section>

            <!-- Features Section -->
            <section id="features" class="py-24 bg-white">
                <div class="mx-auto max-w-7xl px-4">
                    <div class="text-center mb-16">
                        <h2 class="text-sm font-black uppercase tracking-[0.2em] text-crimson-600">Pourquoi nous ?</h2>
                        <p class="mt-4 text-4xl font-black text-ash-900 tracking-tight">L'excellence au service de vos gains.</p>
                    </div>

                    <div class="grid gap-12 md:grid-cols-3">
                        <div class="group">
                            <div class="mb-6 inline-flex size-14 items-center justify-center rounded-2xl bg-gold-50 text-gold-600 transition-colors group-hover:bg-gold-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-black text-ash-900">Gains Journaliers</h3>
                            <p class="mt-4 text-ash-500 leading-relaxed">Réclamez vos profits toutes les 24h sur vos investissements actifs. Une croissance constante et prévisible.</p>
                        </div>

                        <div class="group">
                            <div class="mb-6 inline-flex size-14 items-center justify-center rounded-2xl bg-crimson-50 text-crimson-600 transition-colors group-hover:bg-crimson-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-black text-ash-900">Parrainage 3 Niveaux</h3>
                            <p class="mt-4 text-ash-500 leading-relaxed">Développez votre réseau et touchez des commissions sur trois niveaux de profondeur. Un levier de gains exceptionnel.</p>
                        </div>

                        <div class="group">
                            <div class="mb-6 inline-flex size-14 items-center justify-center rounded-2xl bg-ember-50 text-ember-600 transition-colors group-hover:bg-ember-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-black text-ash-900">Sécurité & Retraits</h3>
                            <p class="mt-4 text-ash-500 leading-relaxed">Vos fonds sont protégés par nos algorithmes. Les retraits sont traités avec soin par nos administrateurs.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Stats section -->
            <section class="bg-gold-50 py-24">
                <div class="mx-auto max-w-7xl px-4 flex flex-col items-center text-center">
                    <p class="text-6xl font-black text-crimson-600">+10,000</p>
                    <p class="mt-2 text-sm font-bold uppercase tracking-widest text-ash-400">Traders actifs nous font confiance</p>
                </div>
            </section>
        </main>

        <footer class="bg-ash-900 py-12 text-ash-400">
            <div class="mx-auto max-w-7xl px-4 flex flex-col md:flex-row justify-between items-center gap-8">
                <div>
                    <span class="text-xl font-black text-white tracking-tighter">PHOENIX TRADERS</span>
                    <p class="mt-2 text-sm">L'avenir du trading social et automatisé.</p>
                </div>
                <div class="flex gap-8 text-sm font-medium">
                    <a href="#" class="hover:text-gold-400 transition-colors">Termes</a>
                    <a href="#" class="hover:text-gold-400 transition-colors">Confidentialité</a>
                    <a href="#" class="hover:text-gold-400 transition-colors">Contact</a>
                </div>
                <div class="text-xs">
                    &copy; 2026 Phoenix Traders. Tous droits réservés.
                </div>
            </div>
        </footer>
    </body>
</html>
