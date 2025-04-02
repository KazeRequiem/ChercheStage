// Attendre que le document soit chargé
document.addEventListener('DOMContentLoaded', function() {
    // Écouter les clics sur les boutons "Supprimer"
    document.querySelectorAll('.candidature-item .supprimer').forEach(button => {
        button.addEventListener('click', function() {
            const candidatureItem = this.closest('.candidature-item');
            const offreId = candidatureItem.dataset.offreId; // Assurez-vous d'ajouter cet attribut data-offre-id dans votre template
            
            if (confirm('Êtes-vous sûr de vouloir supprimer ce favori ?')) {
                supprimerFavori(offreId, candidatureItem);
            }
        });
    });
    
    // Fonction pour supprimer un favori
    function supprimerFavori(offreId, element) {
        // Envoyer une requête DELETE à l'API
        fetch(`/path-to-your-controller/favoris.php/delete?id_offre=${offreId}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            },
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Supprimer l'élément du DOM
                element.remove();
                
                // Vérifier s'il reste des favoris
                const remainingFavoris = document.querySelectorAll('.candidature-item');
                if (remainingFavoris.length === 0) {
                    // S'il n'y a plus de favoris, afficher un message
                    const container = document.querySelector('.candidatures-favoris');
                    const message = document.createElement('p');
                    message.textContent = "Vous n'avez pas encore ajouté d'offres à vos favoris.";
                    container.appendChild(message);
                }
            } else {
                alert('Erreur lors de la suppression : ' + (data.message || 'Erreur inconnue'));
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue lors de la suppression du favori.');
        });
    }
});