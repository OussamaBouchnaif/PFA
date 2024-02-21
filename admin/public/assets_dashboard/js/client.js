//fct pour la visibilité du code 
function mouseoverPass(clientId) {
    let obj = document.getElementById('password_' + clientId);
    obj.type = 'text';
}

function mouseoutPass(clientId) {
    let obj = document.getElementById('password_' + clientId);
    obj.type = 'password';
}

//message desactiver client
function confirmDesactivation(clientId) {
if (confirm("Êtes-vous sûr de vouloir désactiver le compte de ce client ?")) {
    
    console.log("Le compte client avec l'ID " + clientId + " a été désactivé.");
} else {
    document.getElementById('toggle_' + clientId).checked = false;
}

}

//bare de recherche par email
function searchByEmail() {
    let input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementsByTagName("table")[0];
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[2]; 
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

