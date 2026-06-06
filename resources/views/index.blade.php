<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phenix Traders | Elite Investment Platform</title>
    <!-- Elegant Typography -->
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com"> -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- ght@700;800&family=Outfit:wght@300;400;600&display=swap" rel="stylesheet"> -->
    <style>
        :root {
            --fire: #E8420A;
            --fire-rgb: 232, 66, 10;
            --ember: #F47820;
            --gold: #F5A623;
            --cream: #FFF8F0;
            --sand: #F9F0E3;
            --text: #2D1B08;
            --white: #FFFFFF;
            --transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--cream);
            color: var(--text);
            /* line-height: 1.6;<link href="https://fonts.googleapis.com/css2?family=Syne:w */
            overflow-x: hidden;
        }

        h1, h2, h3, .brand {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            line-height: 1.1;
        }

        ul {
            list-style: none;
        }

        a {
            text-decoration: none;
            color: inherit;
            transition: var(--transition);
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* Navigation */
        .header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(255, 248, 240, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(245, 166, 35, 0.1);
            transition: var(--transition);
        }

        .header.scrolled {
            padding: 0.5rem 0;
            box-shadow: 0 10px 30px rgba(45, 27, 8, 0.05);
        }

        .nav-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 80px;
        }

        .brand {
            font-size: 1.5rem;
            color: var(--fire);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            letter-spacing: -0.02em;
        }

        .brand span {
            color: var(--gold);
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 2.5rem;
        }

        .nav-link {
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--text);
            opacity: 0.8;
        }

        .nav-link:hover {
            opacity: 1;
            color: var(--fire);
        }

        .nav-auth {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .btn {
            padding: 0.8rem 1.8rem;
            border-radius: 12px;
            font-weight: 600px;
            font-size: 0.95rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            white-space: nowrap;
        }

        .btn-outline {
            border: 2px solid rgba(232, 66, 10, 0.2);
            color: var(--fire);
        }

        .btn-outline:hover {
            background: rgba(232, 66, 10, 0.05);
            border-color: var(--fire);
        }

        .btn-primary {
            background: var(--fire);
            color: var(--white);
            box-shadow: 0 8px 20px rgba(var(--fire-rgb), 0.25);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(var(--fire-rgb), 0.35);
            background: #d13b09;
        }

        .hamburger {
            display: none;
            flex-direction: column;
            gap: 6px;
            cursor: pointer;
            padding: 0.5rem;
        }

        .hamburger span {
            width: 28px;
            height: 2px;
            background: var(--fire);
            transition: var(--transition);
        }

        /* Hero Section */
        .hero {
            padding: 100px 0 140px;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -10%;
            right: -10%;
            width: 50%;
            height: 80%;
            background: radial-gradient(circle, rgba(245, 166, 35, 0.15) 0%, transparent 70%);
            z-index: -1;
            filter: blur(80px);
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 4rem;
            align-items: center;
        }

        .hero-content h1 {
            font-size: clamp(3rem, 8vw, 5rem);
            margin-bottom: 1.5rem;
            color: var(--text);
        }

        .hero-content h1 span {
            background: linear-gradient(135deg, var(--fire), var(--gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-content p {
            font-size: 1.25rem;
            color: #5D4A3A;
            margin-bottom: 2.5rem;
            max-width: 600px;
        }

        .hero-actions {
            display: flex;
            gap: 1.2rem;
            margin-bottom: 4rem;
        }

        .hero-stats {
            display: flex;
            gap: 4rem;
            padding: 2.5rem;
            background: var(--white);
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(45, 27, 8, 0.04);
            border: 1px solid rgba(245, 166, 35, 0.1);
        }

        .stat-item h3 {
            font-size: 2.5rem;
            color: var(--fire);
            margin-bottom: 0.2rem;
        }

        .stat-item p {
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #A38F7F;
            margin-bottom: 0;
        }

        /* About Section */
        .section-padding {
            padding: 120px 0;
        }

        .about {
            background: var(--sand);
            border-radius: 60px 60px 0 0;
        }

        .section-header {
            text-align: center;
            max-width: 700px;
            margin: 0 auto 60px;
        }

        .badge {
            display: inline-block;
            padding: 0.5rem 1.2rem;
            background: rgba(232, 66, 10, 0.1);
            color: var(--fire);
            border-radius: 100px;
            font-weight: 800;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            margin-bottom: 1.5rem;
        }

        .section-header h2 {
            font-size: clamp(2rem, 5vw, 3.5rem);
            margin-bottom: 1.5rem;
        }

        .about-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2.5rem;
        }

        .about-card {
            background: var(--white);
            padding: 3rem;
            border-radius: 32px;
            transition: var(--transition);
            border: 1px solid transparent;
        }

        .about-card:hover {
            transform: translateY(-10px);
            border-color: var(--gold);
            box-shadow: 0 30px 60px rgba(232, 66, 10, 0.08);
        }

        .card-icon {
            width: 64px;
            height: 64px;
            background: var(--cream);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
            color: var(--fire);
        }

        .about-card h4 {
            font-family: 'Syne', sans-serif;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .about-card p {
            color: #7A6655;
        }

        /* Referrals Section */
        .referrals {
            background: var(--white);
        }

        .steps-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 3rem;
            margin-top: 4rem;
        }

        .step-item {
            text-align: center;
            position: relative;
        }

        .step-number {
            width: 80px;
            height: 80px;
            background: var(--cream);
            border: 2px solid var(--gold);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Syne', sans-serif;
            font-size: 2rem;
            color: var(--fire);
            margin: 0 auto 2rem;
            z-index: 2;
            position: relative;
        }

        .commission-box {
            margin-top: 60px;
            background: linear-gradient(135deg, var(--fire), var(--ember));
            border-radius: 40px;
            padding: 4rem;
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 4rem;
        }

        .commission-content h3 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .levels {
            display: flex;
            gap: 2rem;
        }

        .level-item {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 1.5rem 2.5rem;
            border-radius: 20px;
            text-align: center;
        }

        .level-item .perc {
            font-family: 'Syne', sans-serif;
            font-size: 2rem;
            display: block;
        }

        /* Footer */
        .footer {
            background: var(--sand);
            padding: 100px 0 50px;
            border-top: 1px solid rgba(245, 166, 35, 0.1);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1fr;
            gap: 4rem;
            margin-bottom: 80px;
        }

        .footer-logo {
            margin-bottom: 1.5rem;
        }

        .footer-desc {
            color: #7A6655;
            max-width: 300px;
        }

        .footer-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.2rem;
            margin-bottom: 2rem;
            color: var(--text);
        }

        .footer-links li {
            margin-bottom: 1rem;
        }

        .footer-links a {
            color: #7A6655;
            font-weight: 500;
        }

        .footer-links a:hover {
            color: var(--fire);
            padding-left: 5px;
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .social-icon {
            width: 44px;
            height: 44px;
            background: var(--white);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--fire);
            border: 1px solid rgba(245, 166, 35, 0.1);
        }

        .footer-bottom {
            padding-top: 40px;
            border-top: 1px solid rgba(245, 166, 35, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #A38F7F;
            font-size: 0.9rem;
        }

        /* Mobile Menu */
        .mobile-menu {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: var(--cream);
            z-index: 999;
            display: flex;
            flex-direction: column;
            padding: 100px 2rem;
            transform: translateY(-100%);
            transition: var(--transition);
        }

        .mobile-menu.active {
            transform: translateY(0);
        }

        .mobile-links {
            display: flex;
            flex-direction: column;
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .mobile-links a {
            font-size: 2rem;
            font-family: 'Syne', sans-serif;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .hero-grid {
                grid-template-columns: 1fr;
                text-align: center;
            }
            .hero-content p {
                margin-left: auto;
                margin-right: auto;
            }
            .hero-actions {
                justify-content: center;
            }
            .hero-stats {
                justify-content: center;
            }
            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .nav-links, .nav-auth {
                display: none;
            }
            .hamburger {
                display: flex;
            }
            .steps-container {
                grid-template-columns: 1fr;
            }
            .commission-box {
                flex-direction: column;
                padding: 3rem 2rem;
                text-align: center;
            }
            .levels {
                flex-wrap: wrap;
                justify-content: center;
            }
            .hero-stats {
                flex-direction: column;
                gap: 2rem;
            }
            .footer-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate {
            opacity: 0;
        }

        .animate.visible {
            animation: fadeIn 0.8s forwards ease-out;
        }

        .delay-1 { animation-delay: 0.2s; }
        .delay-2 { animation-delay: 0.4s; }
        .delay-3 { animation-delay: 0.6s; }
    </style>
</head>
<body>

    <!-- Navigation -->
    <header class="header">
        <div class="container nav-wrapper">
            <a href="/" class="brand">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 2L19 11H29L21 17L24 26L16 20L8 26L11 17L3 11H13L16 2Z" fill="var(--fire)"/>
                </svg>
                PHENIX<span>TRADERS</span>
            </a>

            <nav class="nav-links">
                <a href="#about" class="nav-link">About</a>
                <a href="#referrals" class="nav-link">Referrals</a>
            </nav>

            <div class="nav-auth" id="auth-desktop">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-outline">Connexion</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                @else
                    <a href="{{ route('client.dashboard') }}" class="btn btn-primary">Dashboard</a>
                @endguest
            </div>

            <div class="hamburger" onclick="toggleMenu()">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </header>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <nav class="mobile-links">
            <a href="#about" onclick="toggleMenu()">About</a>
            <a href="#referrals" onclick="toggleMenu()">Referrals</a>
        </nav>
        <div class="nav-auth-mobile" style="display: flex; flex-direction: column; gap: 1rem;">
            @guest
                <a href="{{ route('login') }}" class="btn btn-outline">Connexion</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
            @else
                <a href="{{ route('client.dashboard') }}" class="btn btn-primary">Dashboard</a>
            @endguest
        </div>
    </div>

    <main>
        <!-- Hero Section -->
        <section class="hero">
            <div class="container hero-grid">
                <div class="hero-content animate">
                    <h2>Renaître pour <span>Gagner</span>.</h2>
                    <p>Découvrez la plateforme d'investissement nouvelle génération. Sécurisée, transparente et conçue pour une croissance exponentielle de votre capital.</p>
                    <div class="hero-actions">
                        @guest
                            <a href="{{ route('register') }}" class="btn btn-primary">Ouvrir un compte</a>
                        @else
                            <a href="{{ route('client.dashboard') }}" class="btn btn-primary">Accéder au Dashboard</a>
                        @endguest
                        <a href="#about" class="btn btn-outline">En savoir plus</a>
                    </div>
                    <div class="hero-stats">
                        <div class="stat-item">
                            <h3>12K+</h3>
                            <p>Investisseurs</p>
                        </div>
                        <div class="stat-item">
                            <h3>$4.2M</h3>
                            <p>Actifs Gérés</p>
                        </div>
                        <div class="stat-item">
                            <h3>99.9%</h3>
                            <p>Uptime</p>
                        </div>
                    </div>
                </div>
                <div class="hero-visual animate delay-1">
                    <div style="width: 100%; aspect-ratio: 1; background: linear-gradient(45deg, var(--sand), var(--white)); border-radius: 40px; position: relative; display: flex; align-items: center; justify-content: center; overflow: hidden; box-shadow: 0 40px 80px rgba(45,27,8,0.1);">
                        <div style="width: 60%; height: 60%; background: var(--fire); border-radius: 50%; filter: blur(60px); opacity: 0.2; position: absolute; top: 10%; left: 10%;"></div>
                        <div style="width: 50%; height: 50%; background: var(--gold); border-radius: 50%; filter: blur(50px); opacity: 0.15; position: absolute; bottom: 10%; right: 10%;"></div>
                        <svg width="200" height="200" viewBox="0 0 24 24" fill="none" stroke="var(--fire)" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.8;">
                            <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="section-padding about">
            <div class="container">
                <div class="section-header animate">
                    <span class="badge">Notre Vision</span>
                    <h2>La transparence au cœur du trading.</h2>
                    <p>Phenix Traders n'est pas seulement une plateforme, c'est un écosystème conçu pour les investisseurs modernes qui exigent sécurité et performance.</p>
                </div>
                <div class="about-grid">
                    <div class="about-card animate delay-1">
                        <div class="card-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </div>
                        <h4>Sécurité Maximale</h4>
                        <p>Vos fonds sont protégés par des protocoles de cryptage de pointe et une gestion rigoureuse des actifs.</p>
                    </div>
                    <div class="about-card animate delay-2">
                        <div class="card-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        <h4>Support 24/7</h4>
                        <p>Une équipe d'experts dédiée est à votre disposition jour et nuit pour répondre à toutes vos questions.</p>
                    </div>
                    <div class="about-card animate delay-3">
                        <div class="card-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                        </div>
                        <h4>Présence Mondiale</h4>
                        <p>Plus de 40 pays nous font confiance pour la gestion de leurs investissements numériques.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Referrals Section -->
        <section id="referrals" class="section-padding referrals">
            <div class="container">
                <div class="section-header animate">
                    <span class="badge">Programme de Parrainage</span>
                    <h2>Gagnez ensemble.</h2>
                    <p>Invitez vos amis et construisez un revenu passif durable grâce à notre programme de parrainage multi-niveaux.</p>
                </div>
                <div class="steps-container">
                    <div class="step-item animate delay-1">
                        <div class="step-number">1</div>
                        <h3>Obtenez votre lien</h3>
                        <p>Inscrivez-vous et récupérez votre lien unique dans votre dashboard.</p>
                    </div>
                    <div class="step-item animate delay-2">
                        <div class="step-number">2</div>
                        <h3>Invitez vos contacts</h3>
                        <p>Partagez votre lien sur vos réseaux sociaux ou directement avec vos amis.</p>
                    </div>
                    <div class="step-item animate delay-3">
                        <div class="step-number">3</div>
                        <h3>Percevez vos gains</h3>
                        <p>Recevez des commissions instantanées sur chaque investissement de vos filleuls.</p>
                    </div>
                </div>

                <div class="commission-box animate">
                    <div class="commission-content">
                        <h3>Jusqu'à 15% de commission</h3>
                        <p>Un système généreux récompensant votre réseau sur 3 niveaux de profondeur.</p>
                        @guest
                            <a href="{{ route('register') }}" class="btn btn-primary" style="margin-top: 2rem; background: var(--white); color: var(--fire);">Commencer maintenant</a>
                        @else
                            <a href="{{ route('client.dashboard') }}" class="btn btn-primary" style="margin-top: 2rem; background: var(--white); color: var(--fire);">Mon Lien de Parrainage</a>
                        @endguest
                    </div>
                    <div class="levels">
                        <div class="level-item">
                            <span class="perc">10%</span>
                            <span>Niveau 1</span>
                        </div>
                        <div class="level-item">
                            <span class="perc">3%</span>
                            <span>Niveau 2</span>
                        </div>
                        <div class="level-item">
                            <span class="perc">1%</span>
                            <span>Niveau 3</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <a href="/" class="brand footer-logo">
                        <svg width="24" height="24" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16 2L19 11H29L21 17L24 26L16 20L8 26L11 17L3 11H13L16 2Z" fill="var(--fire)"/>
                        </svg>
                        PHENIX<span>TRADERS</span>
                    </a>
                    <p class="footer-desc">Redéfinir l'investissement pour une nouvelle ère de prospérité numérique.</p>
                    <div class="social-links">
                        <a href="#" class="social-icon">X</a>
                        <a href="#" class="social-icon">TG</a>
                        <a href="#" class="social-icon">DC</a>
                    </div>
                </div>
                <div>
                    <h5 class="footer-title">Plateforme</h5>
                    <ul class="footer-links">
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#referrals">Referrals</a></li>
                        <li><a href="#">Security</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="footer-title">Compte</h5>
                    <ul class="footer-links">
                        @guest
                            <li><a href="{{ route('login') }}">Connexion</a></li>
                            <li><a href="{{ route('register') }}">Inscription</a></li>
                        @else
                            <li><a href="{{ route('client.dashboard') }}">Dashboard</a></li>
                            <li><a href="{{ route('client.profile.index') }}">Profil</a></li>
                        @endguest
                    </ul>
                </div>
                <div>
                    <h5 class="footer-title">Légal</h5>
                    <ul class="footer-links">
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Cookie Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 phenix Traders. Tous droits réservés.</p>
                <p>Designed for Excellence</p>
            </div>
        </div>
    </footer>

    <script>
        // Simulation Auth logic
        const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};

        // Header scroll effect
        window.addEventListener('scroll', () => {
            const header = document.querySelector('.header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Mobile Menu Toggle
        function toggleMenu() {
            const menu = document.getElementById('mobileMenu');
            const hamburger = document.querySelector('.hamburger');
            menu.classList.toggle('active');
            
            // Animation for hamburger could be added here
        }

        // Simple Intersection Observer for Animations
        const observerOptions = {
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.animate').forEach(el => observer.observe(el));
    </script>
</body>
</html>
