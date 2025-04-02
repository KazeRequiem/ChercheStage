const searchInput = document.querySelector("#search");
const searchResults = document.querySelector(".candidatures-publiées");

function createEntrepriseList(data) {
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
                <p>⭐ ${entreprise.rating}</p>
                <p>👥 ${entreprise.candidates} candidatures</p>
            </div>
            <div class="candidature-actions">
                <a href="${entreprise.link}" class="voir-plus">Voir plus</a>
                <img src="${entreprise.logo}" alt="${entreprise.name} Logo" class="company-logo">
            </div>
        `;

        searchResults.appendChild(listItem);
    });
}

searchInput.addEventListener("input", function () {
    const searchValue = this.value.toLowerCase();
    const filteredEntreprises = entreprises.filter(entreprise =>
        entreprise.name.toLowerCase().includes(searchValue) ||
        entreprise.location.toLowerCase().includes(searchValue) ||
        entreprise.email.toLowerCase().includes(searchValue)
    );
    createEntrepriseList(filteredEntreprises);
});

// Initialiser la liste des entreprises
createEntrepriseList(entreprises);