// Confirm before removing a product from the cart
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', event => {
        const action = event.target.querySelector('button').innerText.trim();
        if (action === 'Retirer' || action === 'Supprimer') {
            if (!confirm('Êtes-vous sûr de vouloir continuer cette action ?')) {
                event.preventDefault();
            }
        }
    });
});
