const searchInput = document.querySelector("#search");
const searchResults = document.querySelector(".candidatures-publiées");

window.addEventListener("load", function () {
    const searchNameInput = document.getElementById("search");

    if (searchNameInput) {
        searchNameInput.value = "";
    }
});

function createOfferList(data) {
    searchResults.innerHTML = ""; // Réinitialisez le contenu du conteneur

    if (data.length === 0) {
        // Si aucune offre n'est trouvée, afficher un message
        const noResultsMessage = document.createElement("p");
        noResultsMessage.textContent = "Aucune offre trouvée.";
        searchResults.appendChild(noResultsMessage);
        return;
    }

    data.forEach(offer => {
        const listItem = document.createElement("div");
        listItem.setAttribute("class", "candidature-item");

        listItem.innerHTML = `
            <div>
                <h4>${offer.title}</h4>
                <p>🏢 ${offer.company}</p>
                <p>📍 ${offer.location}</p>
                <p>💼 ${offer.contractType}</p>
                <p>💰 ${offer.salary}</p>
            </div>
            <div class="candidature-actions">
                <a href="${offer.editLink}" class="modifier">Modifier</a>
                <img src="${offer.logo}" alt="${offer.company} Logo" class="company-logo">
            </div>
        `;

        searchResults.appendChild(listItem);
    });
}

searchInput.addEventListener("input", function () {
    const searchValue = this.value.toLowerCase();
    const filteredOffers = offers.filter(offer =>
        offer.title.toLowerCase().includes(searchValue) ||
        offer.company.toLowerCase().includes(searchValue) ||
        offer.location.toLowerCase().includes(searchValue)
    );
    createOfferList(filteredOffers);
});

// Initialiser la liste des offres
createOfferList(offers);