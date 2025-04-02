// Réinitialiser les champs de recherche dans le header ou la page actuelle après le chargement de la page
window.addEventListener("load", function () {
    const currentPage = window.location.pathname; // Récupère le chemin de la page actuelle

    // Réinitialisation pour la page "gestion_entreprise"
    if (currentPage.includes("gestion_entreprise.php")) {
        const searchNameInput = document.getElementById("searchName");
        if (searchNameInput) {
            searchNameInput.value = ""; // Réinitialise le champ "Rechercher une entreprise"
        }
    }

    // Réinitialisation pour d'autres pages si nécessaire
    const searchHeaderNameInput = document.getElementById("searchName");
    const searchHeaderLocationInput = document.getElementById("searchLocation");

    if (searchHeaderNameInput) {
        searchHeaderNameInput.value = ""; // Réinitialise le champ "Nom" dans le header
    }

    if (searchHeaderLocationInput) {
        searchHeaderLocationInput.value = ""; // Réinitialise le champ "Localisation" dans le header
    }
});

function createEntrepriseList(data) {
    const searchResults = document.querySelector(".candidatures-publiées");
    searchResults.innerHTML = ""; // Réinitialisez le contenu du conteneur

    if (data.length === 0) {
        // Si aucune entreprise n'est trouvée, afficher un message
        const noResultsMessage = document.createElement("p");
        noResultsMessage.textContent = "Aucune entreprise trouvée.";
        searchResults.appendChild(noResultsMessage);
        return;
    }

    data.forEach(entreprise => {
        const listItem = document.createElement("div");
        listItem.setAttribute("class", "candidature-item");

        listItem.innerHTML = `
            <div>
                <h4>${entreprise.name}</h4>
                <p>📍 ${entreprise.location}</p>
                <p>✉️ ${entreprise.email}</p>
                <p>☎️ ${entreprise.phone}</p>
            </div>
            <div class="candidature-actions">
                <a href="${entreprise.link}" class="voir-plus">Voir plus</a>
                <img src="${entreprise.logo}" alt="${entreprise.name} Logo" class="company-logo">
            </div>
        `;

        searchResults.appendChild(listItem);
    });
}

const searchInput = document.querySelector("#search");
if (searchInput) {
    searchInput.addEventListener("input", function () {
        const searchValue = this.value.toLowerCase();
        const filteredEntreprises = entreprises.filter(entreprise =>
            entreprise.name.toLowerCase().includes(searchValue) ||
            entreprise.location.toLowerCase().includes(searchValue) ||
            entreprise.email.toLowerCase().includes(searchValue)
        );
        createEntrepriseList(filteredEntreprises);
    });
}

// Initialiser la liste des entreprises
if (typeof entreprises !== "undefined") {
    createEntrepriseList(entreprises);
}