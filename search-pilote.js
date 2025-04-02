const searchInput = document.querySelector("#search");
const searchResults = document.querySelector(".candidatures-publiées");

window.addEventListener("load", function () {
    const searchNameInput = document.getElementById("search");

    if (searchNameInput) {
        searchNameInput.value = "";
    }
});

function createPiloteList(data) {

    if (data.length === 0) {
        // Si aucun pilote n'est trouvé, afficher un message
        const noResultsMessage = document.createElement("p");
        noResultsMessage.textContent = "Aucun pilote trouvé.";
        searchResults.appendChild(noResultsMessage);
        return;
    }

    data.forEach(pilote => {
        const listItem = document.createElement("div");
        listItem.setAttribute("class", "candidature-item");

        listItem.innerHTML = `
            <div>
                <h4>${pilote.title}</h4>
                <p>🧑‍🎓 ${pilote.firstName}</p>
                <p>📄 ${pilote.promotion}</p>
                <p>📍 ${pilote.location}</p>
            </div>
            <div>
                <a href="${pilote.editLink}" class="modifier">Modifier</a>
            </div>
        `;

        searchResults.appendChild(listItem);
    });
}

searchInput.addEventListener("input", function () {
    const searchValue = this.value.toLowerCase();
    const filteredPilotes = pilotes.filter(pilote =>
        pilote.firstName.toLowerCase().includes(searchValue) ||
        pilote.promotion.toLowerCase().includes(searchValue)
    );
    createPiloteList(filteredPilotes);
});

createPiloteList(pilotes);