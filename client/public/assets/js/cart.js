
document.addEventListener('DOMContentLoaded', function() {
    var addToCartForm = document.getElementById('addToCartForm');
    var cartContainer = document.getElementById('cartitems');
    var itemCountSpan = document.querySelector('#item_cart'); 
    var FavoritCountSpan = document.querySelector('#item_favorit'); 

    document.querySelectorAll('.add-to-wishlist').forEach(function(item) {
        item.addEventListener('click', function(e) {
            const cameraId = this.dataset.id;
            console.log('script loaded', cameraId);
    
            fetch(`/add/${cameraId}`, {
                method: 'GET',  
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',  
                    'Accept': 'application/json'  
                }
            })
            .then(response => {
                if (response.status === 401) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Connexion Requise',
                        confirmButtonText: '<a href="/login">Se Connecter</a>',
                        confirmButtonColor: '#3085d6',
                        footer: '<a href="/login">Cliquez ici pour vous connecter</a>'
                    });
                    return Promise.reject('Login required'); // Stop the chain with rejection
                } else if (response.status === 409) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Already Added',
                        text: 'This item is already in your wishlist.',
                        footer: '<a href="/wish/list">Click here to view your wishlist</a>'
                    });
                    return Promise.reject('Already added'); // Stop the chain with rejection
                } else if (!response.ok) {
                    return Promise.reject('Some error occurred');
                }
                return response.json();
            })
            .then(data => {
                FavoritCountSpan.textContent = data.totalFavorit;
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
                console.log(data.totalFavorit);
            })
            .catch(error => {
                console.log('Error:', error);
            });
        });
    });
    

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
                    
                    itemCountSpan.textContent = data.totalItems; 
                    
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
                        
                        fetch(deleteUrl, {
                            method: 'GET', 
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success && cartContainer) {
                                cartContainer.innerHTML = data.html;
                                
                                itemCountSpan.textContent = data.totalItems; 
                                
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

