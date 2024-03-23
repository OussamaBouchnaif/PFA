$(document).ready(function() {
    $('#myTable').DataTable({
        "language": {
            "emptyTable": "Aucun élément trouvé",
            "info": "Affichage _START_ à _END_ sur _TOTAL_ éléments",
            "infoEmpty": "Aucune donnée disponible",
            "search": "Rechercher:",
            "paginate": {
                "first": "Premier",
                "last": "Dernier",
                "next": "Suivant",
                "previous": "Précédent"
            }
        }
    });
});
