
document.addEventListener('DOMContentLoaded', function() {
    var addToCartForm = document.getElementById('addToCartForm');
    var cartContainer = document.getElementById('cartitems');

    if (addToCartForm) {
        addToCartForm.addEventListener('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            fetch('/addToCart', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (cartContainer && data.html) {
                    cartContainer.innerHTML = data.html;
                    $('#modal_box').modal('hide');
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Your Camera has been added',
                        showConfirmButton: false,
                        timer: 2000,
                        customClass: {
                            popup: 'my-custom-popup-class', 
                            
                        }
                    });
                } else {
                    alert(data.message || "An unexpected error occurred.");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Error communicating with the server.");
            });
        });
    }

    if (cartContainer) {
        cartContainer.addEventListener('click', function(e) {
            if (e.target && e.target.closest('.cart_remove a')) {
                e.preventDefault();
                var deleteUrl = e.target.closest('.cart_remove a').getAttribute('href');
                
                // Nouveau Swal pour demander confirmation
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Effectuer la requête AJAX si la suppression est confirmée
                        fetch(deleteUrl, {
                            method: 'GET', // Adaptez selon la méthode attendue par votre backend
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success && cartContainer) {
                                cartContainer.innerHTML = data.html;
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your camera   has been deleted.",
                                    icon: "success"
                                });
                            } else {
                                alert(data.message || "An unexpected error occurred.");
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert("Error communicating with the server.");
                        });
                    }
                });
            }
        });
    }
});

