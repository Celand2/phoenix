document.addEventListener('DOMContentLoaded', () => {
    const token = document.querySelector('meta[name="csrf-token"]')?.content;

    document.querySelectorAll('.claim-button').forEach((button) => {
        const updateCountdown = () => {
            const nextClaimAt = button.dataset.nextClaimAt;
            if (!nextClaimAt || !button.disabled) return;

            const remaining = new Date(nextClaimAt).getTime() - Date.now();
            if (remaining <= 0) {
                button.disabled = false;
                button.textContent = 'Reclamer';
                button.className = 'claim-button mt-4 rounded-lg px-4 py-2 font-bold bg-gold-400 text-ash-900 hover:bg-gold-600 animate-pulse';
                return;
            }

            const hours = Math.floor(remaining / 3600000);
            const minutes = Math.ceil((remaining % 3600000) / 60000);
            button.textContent = `Disponible dans ${hours}h ${minutes}min`;
        };

        updateCountdown();
        setInterval(updateCountdown, 30000);

        button.addEventListener('click', async () => {
            if (button.disabled) return;

            const response = await fetch(button.dataset.claimUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                },
            });
            const payload = await response.json();

            if (payload.success) {
                const balance = document.querySelector('#balance-gains');
                if (balance) balance.textContent = payload.balance_gains;
                button.disabled = true;
                button.dataset.nextClaimAt = new Date(Date.now() + 86400000).toISOString();
                updateCountdown();
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
});
