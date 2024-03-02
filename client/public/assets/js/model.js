document.addEventListener('DOMContentLoaded', function () {
    // Gestion de la recherche par catégorie avec AJAX
    document.querySelectorAll('.widget_sub_categories a').forEach(function (categoryLink) {
        categoryLink.addEventListener('click', function (e) {
            e.preventDefault();
            const categoryId = this.getAttribute('data-id'); // Utiliser data-id pour les liens de catégorie
            
            fetch(`/search`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('results-container').innerHTML = html;
                    // Une fois les nouveaux éléments chargés, réinitialiser les écouteurs pour la vue rapide
                    setupQuickViewButtons();
                })
                .catch(error => console.error('Error loading the cameras:', error));
        });

    });

    // Fonction pour configurer les boutons de vue rapide
    function setupQuickViewButtons() {
        document.querySelectorAll('.quick_view').forEach(button => {
            button.addEventListener('click', function() {
                var name = this.getAttribute('data-name');
                var price = this.getAttribute('data-price');
                var description = this.getAttribute('data-description');
                var image = this.getAttribute('data-image');
                
                // Mise à jour du contenu du modal
                document.querySelector('#modal_box .modal_title h2').textContent = name;
                document.querySelector('#modal_box .modal_price .new_price').textContent = "$" + price;
                document.querySelector('#modal_box .modal_description p').textContent = description;
                document.querySelector('#modal_box .modal_zoom_gallery .product_zoom_thumb img').src = image;
            });
        });
    }

    // Configurer initialement les boutons de vue rapide
    setupQuickViewButtons();
});
