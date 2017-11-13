function updateVisibleCatalogue(){
    switch(document.getElementById('intervType').value) {
        case "Culture":
            document.getElementById('Culture').style.display = "block";
            document.getElementById('Valeurs').style.display = "none";
            document.getElementById('Entreprise').style.display = "none";
            break;
        case "Entreprise":
            document.getElementById('Culture').style.display = "none";
            document.getElementById('Valeurs').style.display = "none";
            document.getElementById('Entreprise').style.display = "block";
            break;
        case "Valeurs":
            document.getElementById('Culture').style.display = "none";
            document.getElementById('Valeurs').style.display = "block";
            document.getElementById('Entreprise').style.display = "none";
            break;
        default :
            document.getElementById('Culture').style.display = "none";
            document.getElementById('Valeurs').style.display = "none";
            document.getElementById('Entreprise').style.display = "none";
            break;
    }
}

window.onload = function() {
    updateVisibleCatalogue();
}