<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Phoenix Traders') }} - L'excellence en Trading</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-50 text-slate-900 font-sans selection:bg-crimson-100 selection:text-crimson-700">
        <!-- Header / Nav -->
        <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-lg border-b border-slate-200">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="size-8 bg-crimson-600 rounded-lg flex items-center justify-center">
                            <svg class="size-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        <span class="text-xl font-black text-slate-900 tracking-tight italic uppercase">Phoenix<span class="text-crimson-600">Traders</span></span>
                    </div>

                    <nav class="hidden md:flex items-center gap-8">
                        <a href="#about" class="text-sm font-semibold text-slate-600 hover:text-crimson-600 transition-colors">À propos</a>
                        <a href="#features" class="text-sm font-semibold text-slate-600 hover:text-crimson-600 transition-colors">Fonctionnalités</a>
                        @auth
                            <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('client.dashboard') }}" class="inline-flex items-center justify-center rounded-full bg-slate-900 px-5 py-2 text-sm font-bold text-white hover:bg-slate-800 transition-all">
                                Tableau de bord
                            </a>
                        @else
                            <div class="flex items-center gap-4">
                                <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-crimson-600">Connexion</a>
                                <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-full bg-crimson-600 px-5 py-2 text-sm font-bold text-white shadow-lg shadow-crimson-200 hover:bg-crimson-700 transition-all hover:-translate-y-0.5">
                                    Commencer
                                </a>
                            </div>
                        @endauth
                    </nav>

                    <div class="md:hidden">
                        <button type="button" class="text-slate-600">
                            <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <main>
            <!-- Hero Section -->
            <section class="relative pt-20 pb-32 overflow-hidden">
                <div class="absolute inset-0 -z-10 bg-[radial-gradient(45rem_50rem_at_top,theme(colors.crimson.50),white)]"></div>
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="lg:grid lg:grid-cols-12 lg:gap-12 items-center">
                        <div class="lg:col-span-7">
                            <div class="inline-flex items-center gap-2 rounded-full bg-crimson-50 px-3 py-1 text-sm font-bold text-crimson-600 ring-1 ring-inset ring-crimson-600/10 mb-8">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-crimson-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-crimson-500"></span>
                                </span>
                                Plateforme de Trading Nouvelle Génération
                            </div>
                            <h1 class="text-5xl font-black tracking-tight text-slate-900 sm:text-7xl leading-[1.1]">
                                Multipliez vos actifs avec <span class="text-crimson-600">intelligence</span>.
                            </h1>
                            <p class="mt-8 text-xl text-slate-600 leading-relaxed max-w-2xl">
                                Phoenix Traders offre une expérience de trading simplifiée, sécurisée et hautement rentable. Profitez de nos algorithmes avancés et de notre système de parrainage unique.
                            </p>
                            <div class="mt-10 flex flex-wrap gap-4">
                                @guest
                                    <a href="{{ route('register') }}" class="rounded-2xl bg-crimson-600 px-8 py-4 text-lg font-bold text-white shadow-xl shadow-crimson-200 hover:bg-crimson-700 transition-all active:scale-95">
                                        Ouvrir un compte
                                    </a>
                                @else
                                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('client.dashboard') }}" class="rounded-2xl bg-slate-900 px-8 py-4 text-lg font-bold text-white shadow-xl hover:bg-slate-800 transition-all active:scale-95">
                                        Accéder au Dashboard
                                    </a>
                                @endguest
                                <a href="#about" class="rounded-2xl bg-white px-8 py-4 text-lg font-bold text-slate-700 ring-1 ring-slate-200 hover:bg-slate-50 transition-all">
                                    En savoir plus
                                </a>
                            </div>
                        </div>
                        <div class="hidden lg:block lg:col-span-5">
                            <div class="relative">
                                <div class="absolute -inset-1 rounded-[2rem] bg-gradient-to-tr from-crimson-600 to-amber-400 opacity-20 blur-2xl"></div>
                                <div class="relative bg-white rounded-[2rem] p-8 shadow-2xl ring-1 ring-slate-900/5">
                                    <div class="space-y-6">
                                        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
                                            <div class="flex items-center gap-3">
                                                <div class="size-10 bg-emerald-500 rounded-full flex items-center justify-center text-white">
                                                    <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                                </div>
                                                <div>
                                                    <p class="text-xs font-bold text-slate-400 uppercase">Profit Journalier</p>
                                                    <p class="text-lg font-black text-slate-900">+2.45%</p>
                                                </div>
                                            </div>
                                            <div class="text-emerald-500 font-bold">Détails</div>
                                        </div>
                                        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
                                            <div class="flex items-center gap-3">
                                                <div class="size-10 bg-crimson-500 rounded-full flex items-center justify-center text-white">
                                                    <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                </div>
                                                <div>
                                                    <p class="text-xs font-bold text-slate-400 uppercase">Solde Total</p>
                                                    <p class="text-lg font-black text-slate-900">$12,450.00</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- About Section -->
            <section id="about" class="py-24 bg-white border-y border-slate-100">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="grid lg:grid-cols-2 gap-16 items-center">
                        <div>
                            <h2 class="text-sm font-black uppercase tracking-[0.2em] text-crimson-600 mb-4">À propos de Phoenix</h2>
                            <p class="text-4xl font-black text-slate-900 tracking-tight mb-6">Une vision claire pour votre liberté financière.</p>
                            <div class="space-y-6 text-lg text-slate-600 leading-relaxed">
                                <p>
                                    Phoenix Traders est né de la volonté de démocratiser l'accès aux marchés financiers performants. Notre plateforme combine expertise humaine et intelligence algorithmique pour générer des profits stables.
                                </p>
                                <p>
                                    Nous croyons en la transparence et en la puissance de la communauté. C'est pourquoi nous avons mis en place un système de parrainage équitable qui récompense ceux qui aident à faire grandir l'écosystème Phoenix.
                                </p>
                            </div>
                            <div class="mt-10 grid grid-cols-2 gap-8 border-t border-slate-100 pt-10">
                                <div>
                                    <p class="text-3xl font-black text-slate-900">99.9%</p>
                                    <p class="text-sm text-slate-500 font-medium">Uptime plateforme</p>
                                </div>
                                <div>
                                    <p class="text-3xl font-black text-slate-900">24/7</p>
                                    <p class="text-sm text-slate-500 font-medium">Support expert</p>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-4 pt-12">
                                <div class="aspect-square rounded-3xl bg-slate-100 overflow-hidden">
                                    <img src="https://images.unsplash.com/photo-1611974717482-9905261c149d?auto=format&fit=crop&q=80&w=400" alt="Trading" class="object-cover w-full h-full grayscale hover:grayscale-0 transition-all duration-500">
                                </div>
                                <div class="aspect-[4/5] rounded-3xl bg-crimson-600"></div>
                            </div>
                            <div class="space-y-4">
                                <div class="aspect-[4/5] rounded-3xl bg-slate-900 flex items-end p-6">
                                    <p class="text-white font-black text-xl leading-tight">L'innovation au cœur de nos algorithmes.</p>
                                </div>
                                <div class="aspect-square rounded-3xl bg-slate-100 overflow-hidden">
                                    <img src="https://images.unsplash.com/photo-1642390233410-aa3348e307f0?auto=format&fit=crop&q=80&w=400" alt="Crypto" class="object-cover w-full h-full grayscale hover:grayscale-0 transition-all duration-500">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Features -->
            <section id="features" class="py-24 bg-slate-50">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="text-center max-w-3xl mx-auto mb-20">
                        <h2 class="text-sm font-black uppercase tracking-[0.2em] text-crimson-600 mb-4">Fonctionnalités Clés</h2>
                        <p class="text-4xl font-black text-slate-900 tracking-tight">Tout ce dont vous avez besoin pour réussir votre trading.</p>
                    </div>

                    <div class="grid md:grid-cols-3 gap-8">
                        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm hover:shadow-xl transition-all border border-slate-100 group">
                            <div class="size-16 bg-crimson-50 rounded-2xl flex items-center justify-center text-crimson-600 mb-8 group-hover:bg-crimson-600 group-hover:text-white transition-all">
                                <svg class="size-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <h3 class="text-xl font-black text-slate-900 mb-4">Profits Automatisés</h3>
                            <p class="text-slate-600 leading-relaxed">Investissez dans nos plans de trading et laissez nos algorithmes travailler pour vous. Des rendements calculés et versés quotidiennement.</p>
                        </div>

                        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm hover:shadow-xl transition-all border border-slate-100 group">
                            <div class="size-16 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 mb-8 group-hover:bg-blue-600 group-hover:text-white transition-all">
                                <svg class="size-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                            </div>
                            <h3 class="text-xl font-black text-slate-900 mb-4">Programme de Parrainage</h3>
                            <p class="text-slate-600 leading-relaxed">Gagnez des commissions sur 3 niveaux (5%, 3%, 1%) pour chaque nouvel investisseur que vous parrainez dans l'écosystème.</p>
                        </div>

                        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm hover:shadow-xl transition-all border border-slate-100 group">
                            <div class="size-16 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 mb-8 group-hover:bg-emerald-600 group-hover:text-white transition-all">
                                <svg class="size-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                            </div>
                            <h3 class="text-xl font-black text-slate-900 mb-4">Sécurité Maximale</h3>
                            <p class="text-slate-600 leading-relaxed">La sécurité de vos fonds est notre priorité absolue. Nous utilisons des protocoles de cryptage de pointe et une validation manuelle des retraits.</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="bg-slate-900 pt-20 pb-10 text-slate-400">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-4 gap-12 mb-16">
                    <div class="col-span-2">
                        <div class="flex items-center gap-2 mb-6">
                            <div class="size-8 bg-crimson-600 rounded-lg flex items-center justify-center">
                                <svg class="size-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </div>
                            <span class="text-xl font-black text-white tracking-tight italic uppercase">Phoenix<span class="text-crimson-600">Traders</span></span>
                        </div>
                        <p class="text-lg max-w-sm">Redéfinir le futur de l'investissement social et du trading automatisé pour tous.</p>
                    </div>
                    <div>
                        <h4 class="text-white font-bold mb-6">Liens Rapides</h4>
                        <ul class="space-y-4">
                            <li><a href="#about" class="hover:text-white transition-colors">À propos</a></li>
                            <li><a href="#features" class="hover:text-white transition-colors">Fonctionnalités</a></li>
                            <li><a href="{{ route('login') }}" class="hover:text-white transition-colors">Connexion</a></li>
                            <li><a href="{{ route('register') }}" class="hover:text-white transition-colors">Inscription</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-white font-bold mb-6">Légal</h4>
                        <ul class="space-y-4">
                            <li><a href="#" class="hover:text-white transition-colors">Conditions d'utilisation</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Politique de confidentialité</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Avertissement de risque</a></li>
                        </ul>
                    </div>
                </div>
                <div class="pt-8 border-t border-slate-800 text-sm flex flex-col md:flex-row justify-between items-center gap-4">
                    <p>&copy; {{ date('Y') }} Phoenix Traders. Tous droits réservés.</p>
                    <div class="flex gap-6">
                        <a href="#" class="hover:text-white transition-colors">Twitter</a>
                        <a href="#" class="hover:text-white transition-colors">Telegram</a>
                        <a href="#" class="hover:text-white transition-colors">Discord</a>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
