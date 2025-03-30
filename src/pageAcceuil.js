document.addEventListener("DOMContentLoaded", () => {
    const bleuSpan = document.querySelector(".bleu");
    const bleuContainer = document.querySelector(".bleu-container");
    const texts = ["job", "stage", "alternance", "contrat"];
    let index = 0;

    // Fonction ultra-simplifiée pour mesurer la largeur du texte
    function mesureTexte(texte) {
        // Crée temporairement un span invisible pour mesurer la largeur
        const tempSpan = document.createElement("span");
        tempSpan.style.visibility = "hidden";
        tempSpan.style.position = "absolute";
        tempSpan.style.fontSize = "5rem"; // Même taille que le texte original
        tempSpan.style.fontFamily = "Poppins, sans-serif"; // Même police
        tempSpan.textContent = texte;
        document.body.appendChild(tempSpan);
        
        const largeur = tempSpan.offsetWidth;
        document.body.removeChild(tempSpan);
        
        return largeur;
    }

    // Ajuste la largeur initiale
    bleuContainer.style.width = mesureTexte(texts[0]) + "px";

    setInterval(() => {
        // Animation de sortie vers le haut (ton code original)
        bleuSpan.classList.add("hidden", "transition");
        
        setTimeout(() => {
            index = (index + 1) % texts.length;
            bleuSpan.textContent = texts[index];
            
            // Ajuste la largeur du conteneur (nouveau code)
            bleuContainer.style.width = mesureTexte(texts[index]) + "px";
            
            // Réinitialise la position (ton code original)
            bleuSpan.classList.remove("hidden");
            bleuSpan.classList.add("appear");
            
            setTimeout(() => {
                bleuSpan.classList.remove("appear");
            }, 500);
        }, 500);
    }, 4000);
});