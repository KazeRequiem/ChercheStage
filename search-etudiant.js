const searchInput = document.querySelector("#search");
const searchResults = document.querySelector(".candidatures-publiées");

window.addEventListener("load", function () {
    const searchNameInput = document.getElementById("search");

    if (searchNameInput) {
        searchNameInput.value = "";
    }
});

function createEtudiantList(data) {
    searchResults.innerHTML = ""; // Réinitialiser les résultats

    if (data.length === 0) {
        // Si aucun étudiant n'est trouvé, afficher un message
        const noResultsMessage = document.createElement("p");
        noResultsMessage.textContent = "Aucun étudiant trouvé.";
        searchResults.appendChild(noResultsMessage);
        return;
    }

    data.forEach(etudiant => {
        const listItem = document.createElement("div");
        listItem.setAttribute("class", "candidature-item");

        listItem.innerHTML = `
            <div>
                <h4>${etudiant.lastName}</h4>
                <p>🧑‍🎓 ${etudiant.firstName}</p>
                <p>📄 ${etudiant.promotion}</p>
                <p>📍 ${etudiant.location}</p>
            </div>
            <div>
                <a href="${etudiant.editLink}" class="modifier">Modifier</a>
            </div>
        `;

        searchResults.appendChild(listItem);
    });
}

searchInput.addEventListener("input", function () {
    const searchValue = this.value.toLowerCase();
    const filteredEtudiants = etudiants.filter(etudiant =>
        etudiant.firstName.toLowerCase().includes(searchValue) ||
        etudiant.lastName.toLowerCase().includes(searchValue) ||
        etudiant.promotion.toLowerCase().includes(searchValue)
    );
    createEtudiantList(filteredEtudiants);
});

// Initialiser la liste des étudiants
createEtudiantList(etudiants);