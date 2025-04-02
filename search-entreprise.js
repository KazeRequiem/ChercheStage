const searchInput = document.querySelector("#search");
const searchResults = document.querySelector(".candidatures-publiées");

function createCompanyList(data) {
    searchResults.innerHTML = ""; // Réinitialisez le contenu du conteneur

    if (data.length === 0) {
        // Si aucune entreprise n'est trouvée, afficher un message
        const noResultsMessage = document.createElement("p");
        noResultsMessage.textContent = "Aucune entreprise trouvée.";
        searchResults.appendChild(noResultsMessage);
        return;
    }

    data.forEach(company => {
        const listItem = document.createElement("div");
        listItem.setAttribute("class", "candidature-item");

        listItem.innerHTML = `
            <div>
                <h4>${company.name}</h4>
                <p>📍 ${company.location}</p>
                <p>✉️ ${company.email}</p>
                <p>☎️ ${company.phone}</p>
            </div>
            <div class="candidature-actions">
                <a href="modifier_entreprise.php" class="modifier">Modifier</a>
                <img src="assets/${company.logo}" alt="${company.name} Logo" class="company-logo">
            </div>
        `;

        searchResults.appendChild(listItem);
    });
}

searchInput.addEventListener("input", function () {
    const searchValue = this.value.toLowerCase();
    const filteredCompanies = companies.filter(company =>
        company.name.toLowerCase().includes(searchValue) ||
        company.location.toLowerCase().includes(searchValue) ||
        company.email.toLowerCase().includes(searchValue)
    );
    createCompanyList(filteredCompanies);
});

// Initialiser la liste des entreprises
createCompanyList(companies);