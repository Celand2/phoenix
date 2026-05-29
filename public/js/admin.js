document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('form[data-confirm]').forEach((form) => {
        form.addEventListener('submit', (event) => {
            if (!confirm(form.dataset.confirm)) {
                event.preventDefault();
            }
        });
    });

    const layout = document.querySelector('[data-admin-layout]');
    const main = document.querySelector('[data-admin-main]');
    const overlay = document.querySelector('[data-admin-overlay]');
    const panels = {
        left: document.querySelector('[data-admin-panel="left"]'),
        right: document.querySelector('[data-admin-panel="right"]'),
    };
    const toggles = document.querySelectorAll('[data-admin-toggle]');
    const desktopQuery = window.matchMedia('(min-width: 1024px)');
    const storageKey = 'phoenix-admin-panels';
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

    state.left = typeof savedState.left === 'boolean' ? savedState.left : desktopQuery.matches;
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

        document.querySelectorAll(`[data-admin-toggle="${side}"]`).forEach((button) => {
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
            const side = button.dataset.adminToggle;
            updatePanel(side, !state[side]);
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

    const proofModal = document.querySelector('[data-proof-modal]');
    if (proofModal) {
        const proofImage = proofModal.querySelector('[data-proof-image]');
        const closeModal = () => {
            proofModal.classList.add('hidden');
            proofModal.classList.remove('flex');
        };

        document.querySelectorAll('[data-proof-trigger]').forEach((trigger) => {
            trigger.addEventListener('click', () => {
                proofImage.src = trigger.dataset.proofTrigger;
                proofModal.classList.remove('hidden');
                proofModal.classList.add('flex');
            });
        });

        proofModal.querySelector('[data-proof-close]')?.addEventListener('click', closeModal);
        proofModal.addEventListener('click', (event) => {
            if (event.target === proofModal) closeModal();
        });
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') closeModal();
        });
    }
});
