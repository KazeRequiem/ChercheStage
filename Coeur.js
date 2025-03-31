function toggleFavorite(icon) {
    const img = icon.querySelector('.favorite-icon-img');
    const explosion = icon.querySelector('.explosion');

    icon.classList.add('clicked');
    setTimeout(() => {
        icon.classList.remove('clicked');
    }, 500);

    if (img.src.includes('coeur.png')) {
        img.src = 'assets/coeur-rempli.png';
        img.alt = 'Retirer des favoris';
    } else {
        img.src = 'assets/coeur.png';
        img.alt = 'Ajouter aux favoris';
    }
}