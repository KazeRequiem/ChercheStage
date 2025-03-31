document.querySelectorAll('.resolve-button').forEach(button => {
    button.addEventListener('click', () => {
        const row = button.closest('tr');
        const etatCell = row.querySelector('.etat');

        if (etatCell.textContent === 'Non résolu') {
            etatCell.textContent = 'Résolu';
            button.textContent = 'Marquer comme non résolu';
        } else {
            etatCell.textContent = 'Non résolu';
            button.textContent = 'Marquer comme résolu';
        }
    });
});