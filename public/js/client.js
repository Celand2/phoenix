document.addEventListener('DOMContentLoaded', () => {
    const token = document.querySelector('meta[name="csrf-token"]')?.content;

    document.querySelectorAll('.claim-button').forEach((button) => {
        const updateCountdown = () => {
            const nextClaimAt = button.dataset.nextClaimAt;
            if (!nextClaimAt || !button.disabled) return;

            const remaining = new Date(nextClaimAt).getTime() - Date.now();
            if (remaining <= 0) {
                button.disabled = false;
                button.textContent = 'Trade';
                button.className = 'claim-button mt-4 rounded-lg px-4 py-2 font-bold bg-gold-400 text-ash-900 hover:bg-gold-600 animate-pulse';
                return;
            }

            const hours = Math.floor(remaining / 3600000);
            const minutes = Math.ceil((remaining % 3600000) / 60000);
            button.textContent = `Prochain Trade : ${hours}h ${minutes}m`;
        };

        updateCountdown();
        setInterval(updateCountdown, 30000);

        button.addEventListener('click', async () => {
            if (button.disabled) return;

            const originalContent = button.innerHTML;
            const dailyGainUsd = parseFloat(button.dataset.dailyGain || '0');
            const rate = parseFloat(button.dataset.rate || '1');
            const currency = button.dataset.currency || 'USD';
            const dailyGainLocal = dailyGainUsd * rate;
            
            // Simulation de trade
            button.disabled = true;
            button.classList.add('relative', 'overflow-hidden');
            
            const formatValue = (val) => {
                const decimals = currency === 'FBU' ? 0 : 2;
                return val.toLocaleString('fr-FR', {
                    minimumFractionDigits: decimals,
                    maximumFractionDigits: decimals,
                }) + ' ' + currency;
            };

            const runAnimation = () => {
                return new Promise((resolve) => {
                    let current = 0;
                    const duration = 2500; // Un peu plus long pour l'effet
                    const start = Date.now();
                    
                    const animate = () => {
                        const elapsed = Date.now() - start;
                        const progress = Math.min(elapsed / duration, 1);
                        
                        // Easing out function (plus dramatique)
                        const easeOutQuart = t => 1 - (--t) * t * t * t;
                        current = dailyGainLocal * easeOutQuart(progress);
                        
                        button.innerHTML = `
                            <div class="flex flex-col items-center">
                                <span class="text-[10px] uppercase tracking-[0.2em] opacity-80 leading-none mb-1">Trading en cours...</span>
                                <span class="text-xl font-black text-gold-950">${formatValue(current)}</span>
                            </div>
                        `;
                        
                        if (progress < 1) {
                            requestAnimationFrame(animate);
                        } else {
                            resolve();
                        }
                    };
                    requestAnimationFrame(animate);
                });
            };

            try {
                // On lance l'animation et la requête en parallèle pour plus de fluidité
                const [response] = await Promise.all([
                    fetch(button.dataset.claimUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json',
                        },
                    }),
                    runAnimation()
                ]);

                const payload = await response.json();

                if (payload.success) {
                    const balance = document.querySelector('#balance-gains');
                    if (balance) balance.textContent = payload.balance_gains;
                    
                    button.innerHTML = 'Succès !';
                    button.className = 'claim-button flex w-full items-center justify-center rounded-2xl py-4 text-lg font-black transition-all lg:w-auto lg:px-10 bg-green-500 text-white';
                    
                    setTimeout(() => {
                        button.dataset.nextClaimAt = new Date(Date.now() + 86400000).toISOString();
                        updateCountdown();
                    }, 2000);
                } else {
                    button.innerHTML = originalContent;
                    button.disabled = false;
                    alert(payload.message || 'Erreur lors du claim');
                }
            } catch (error) {
                button.innerHTML = originalContent;
                button.disabled = false;
                console.error(error);
            }
        });
    });

    const proofInput = document.querySelector('[data-proof-input]');
    const proofPreview = document.querySelector('[data-proof-preview]');
    proofInput?.addEventListener('change', () => {
        const file = proofInput.files?.[0];
        if (!file || !proofPreview) return;

        proofPreview.src = URL.createObjectURL(file);
        proofPreview.classList.remove('hidden');
    });

    const converter = document.querySelector('[data-money-converter]');
    if (converter) {
        const methodSelect = converter.querySelector('[data-money-method]');
        const preview = converter.querySelector('[data-money-preview]');
        const detailsContent = converter.querySelector('[data-details-content]');

        const formatLocal = (value, currency) => {
            const decimals = currency === 'FBU' ? 0 : 2;
            return new Intl.NumberFormat('fr-FR', {
                minimumFractionDigits: decimals,
                maximumFractionDigits: decimals,
            }).format(value) + ' ' + currency;
        };

        const updateConversion = () => {
            const option = methodSelect?.selectedOptions?.[0];
            if (!option) return;

            const rate = parseFloat(option.dataset.rate || '1');
            const currency = option.dataset.currency || 'USD';
            const amountUsd = parseFloat(preview?.dataset.amountUsd || '0');

            if (preview) {
                if (currency === 'USD') {
                    preview.textContent = 'Equivalent: ' + amountUsd.toFixed(2) + ' USD';
                } else {
                    const local = Math.round(amountUsd * rate * 100) / 100;
                    preview.textContent = 'Equivalent: ' + formatLocal(local, currency) + ' (' + amountUsd.toFixed(2) + ' USD)';
                }
            }

            if (detailsContent) {
                detailsContent.textContent = option.dataset.details || 'Aucun detail disponible.';
            }
        };

        methodSelect?.addEventListener('change', updateConversion);
        updateConversion();
    }
    
    const layout = document.querySelector('[data-client-layout]');
    const main = document.querySelector('[data-client-main]');
    const overlay = document.querySelector('[data-client-overlay]');
    const panels = {
        left: document.querySelector('[data-client-panel="left"]'),
        right: document.querySelector('[data-client-panel="right"]'),
    };
    const toggles = document.querySelectorAll('[data-client-toggle]');
    const desktopQuery = window.matchMedia('(min-width: 1024px)');
    const storageKey = 'phenix-client-panels';
    const state = {
        left: false,
        right: false,
    };

    if (!layout || !main || !overlay || !panels.left || !panels.right) {
        return;
    }

    const savedState = (() => {
        try {
            return JSON.parse(localStorage.getItem(storageKey)) || {};
        } catch {
            return {};
        }
    })();

    state.left = typeof savedState.left === 'boolean' ? savedState.left : false;
    state.right = typeof savedState.right === 'boolean' ? savedState.right : false;

    const persistState = () => {
        localStorage.setItem(storageKey, JSON.stringify(state));
    };

    const setPanelState = (side, isOpen, shouldPersist = true) => {
        if (!panels[side]) {
            return;
        }

        state[side] = isOpen;
        panels[side].dataset.open = String(isOpen);

        document.querySelectorAll(`[data-client-toggle="${side}"]`).forEach((button) => {
            button.setAttribute('aria-expanded', String(isOpen));
        });

        if (shouldPersist) {
            persistState();
        }
    };

    const syncLayout = () => {
        const hasMobilePanel = !desktopQuery.matches && (state.left || state.right);
        overlay.classList.toggle('hidden', !hasMobilePanel);
        document.body.classList.toggle('overflow-hidden', hasMobilePanel);

        main.classList.toggle('lg:ml-64', state.left);
        main.classList.toggle('lg:mr-80', state.right);
    };

    const updatePanel = (side, isOpen, shouldPersist = true) => {
        setPanelState(side, isOpen, shouldPersist);
        syncLayout();
    };

    toggles.forEach((button) => {
        button.addEventListener('click', () => {
            const side = button.dataset.clientToggle;
            updatePanel(side, !state[side]);
        });
    });

    // Close panels when clicking a link inside them
    Object.values(panels).forEach((panel) => {
        panel.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => {
                const side = panel.dataset.clientPanel;
                if (!desktopQuery.matches) {
                    updatePanel(side, false);
                }
            });
        });
    });

    overlay.addEventListener('click', () => {
        updatePanel('left', false, false);
        updatePanel('right', false, false);
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && (state.left || state.right)) {
            updatePanel('left', false);
            updatePanel('right', false);
        }
    });

    desktopQuery.addEventListener('change', syncLayout);

    updatePanel('left', state.left, false);
    updatePanel('right', state.right, false);
});
