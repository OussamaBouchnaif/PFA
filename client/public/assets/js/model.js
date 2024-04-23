document.addEventListener('DOMContentLoaded', function () {
    setupQuickViewButtons(); // Initialiser pour la première charge de page
    var defaultValue = [100, 1000];  // Valeurs par défaut si 'price' n'est pas définie
    var inputVal = $("#amount").val();

    // Vérifie si 'inputVal' contient une plage de prix valide
    var prices = inputVal ? inputVal.replace(/\$/g, '').split(' - ').map(Number) : defaultValue;

    // Initialisation du slider avec les valeurs extraites ou les valeurs par défaut
    $("#slider-range").slider({
        range: true,
        min: 0,
        max: 2000,
        values: [prices[0], prices[1]],
        slide: function(event, ui) {
            $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
        },
        change: function(event, ui) {
            $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
            $('#price-filter-form').submit(); // Soumet le formulaire automatiquement
        }
    });

    // Définir la valeur initiale du champ 'amount' si elle n'était pas préremplie
    if (!inputVal) {
        $("#amount").val("$" + defaultValue[0] + " - $" + defaultValue[1]);
    }

    // Initialisation du champ de montant
    $("#amount").val("$" + $("#slider-range").slider("values", 0) + " - $" + $("#slider-range").slider("values", 1));

    // Correction du sélecteur pour la soumission automatique du formulaire de résolution
    $('input[type="radio"][name="res"]').change(function() {
        $('#res-filter-form').submit(); // Soumet le formulaire de filtre de résolution
    });
    $('#shorts').change(function() {
        $(this).closest('form').submit(); // Soumet le formulaire de tri
    });
});
    // Gestion des clics sur les filtres de catégorie
    /*document.querySelectorAll('.widget_dropdown_categories a').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            var categorie = this.getAttribute('href').split('categorie=')[1];
            fetchData({ 'categorie': categorie });
        });
    });

    // Gestion des clics sur les filtres de taille
    document.querySelectorAll('.widget_size a').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelectorAll('.widget_size a').forEach(function(otherLink) {
                otherLink.classList.remove('active');
            });
    
           
            this.classList.add('active');
            var angle = this.getAttribute('href').split('angle=')[1];
            
            fetchData({ 'angle': angle });
        });
    });
   
   
    document.querySelectorAll('#res-filter-form .form-check-input').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            let formData = {};
            document.querySelectorAll('#res-filter-form .form-check-input:checked').forEach(function(input) {
                if (!formData['res']) {
                    formData['res'] = [];
                }
                formData['res'].push(input.nextElementSibling.textContent.trim());
            });
            fetchData(formData);
        });
    });
   

    $('#shorts').change(function() {
        var selectedOption = this.options[this.selectedIndex];

        var valuer =  selectedOption.value;
        if(valuer === 'date')
            order = 'dateAjout';
        else if(valuer === 'prix')
        {
            order = 'prix';
        }
        fetchData({ 'orderby': order });
    });*/
// Fonction fetchData avec la logique de réinitialisation des boutons de visualisation rapide
function fetchData(criteria) {
    var url = new URL('/camera/search', window.location.origin);
    Object.keys(criteria).forEach(key => url.searchParams.append(key, criteria[key]));
    //document.getElementById('loadingSpinner').style.display = 'flex';
    //document.getElementById('results-container').style.filter = 'blur(2px)';
    fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.text())
    .then(html => {
        document.getElementById('results-container').innerHTML = html;
        setupQuickViewButtons(); // Ré-initialiser après la mise à jour AJAX
        //document.getElementById('loadingSpinner').style.display = 'none';
        //document.getElementById('results-container').style.filter = 'none';
        
    })
    .catch(error => {
        console.error('Error:', error)
        document.getElementById('results-container').innerHTML = error;
        //document.getElementById('loadingSpinner').style.display = 'none';
        //document.getElementById('results-container').style.filter = 'none';
    });
}


function setupQuickViewButtons() {
    document.querySelectorAll('.addcart').forEach(button => {
        button.addEventListener('click', function() {
            var name = this.getAttribute('data-name');
            var price = this.getAttribute('data-price');
            var description = this.getAttribute('data-description');
            var image = this.getAttribute('data-image');
            var id = this.getAttribute('data-camera');

            // Mise à jour du contenu du modal
            document.querySelector('#modal_box .modal_title h2').textContent = name;
            document.querySelector('#idcamera').value = id;
            document.querySelector('#modal_box .modal_price .new_price').textContent = "$" + price;
            document.querySelector('#modal_box .modal_description p').textContent = description;
            document.querySelector('#modal_box .modal_zoom_gallery .product_zoom_thumb img').src = image;
            
        });
    });
}
