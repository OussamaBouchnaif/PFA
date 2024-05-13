document.addEventListener('DOMContentLoaded', function() {


    
    document.querySelector('#wishlistbody').addEventListener('click', function(e) {
        // Check if the clicked element has the class 'delete-wishCamera'
        if (e.target.closest('.delete-wishCamera')) {
            e.preventDefault();
            const button = e.target.closest('.delete-wishCamera');
            const favoritId = button.dataset.id;

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
                    fetch(`/delete/wishCamera/${favoritId}`, {
                        method: 'GET', 
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Server responded with a non-200 status');
                        }
                        return response.text();
                    })
                    .then(html => {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Your camera has been deleted.",
                            icon: "success"
                        });
                        document.querySelector('tbody').innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: "Error!",
                            text: "There was a problem deleting your camera.",
                            icon: "error"
                        });
                    });
                }
            });
        }
    });
});