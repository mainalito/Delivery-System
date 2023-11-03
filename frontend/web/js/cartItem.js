$(document).ready(function () {
    const cartQuantity = $('#cart-count')
    // Using a delegated event handler if elements are dynamically loaded
    $(document).on('click', '.add-to-cart', function (e) {
        e.preventDefault(); // Prevent the default link click action
        var productId = $(this).attr('data-id'); // Using attr instead of data
        var url = $(this).attr('href'); // Using attr to get the href value
        // Check if productId and url are not undefined or null
        console.log(url, productId)
        if (productId && url) {
            $.ajax({
                url: url,
                type: 'POST',
                data: {id: productId},
                success: function (response) {
                    // alert('Success!'); // Handle success
                    cartQuantity.text(parseInt(cartQuantity.text() || 0) + 1)
                    if (response.success === true) {
                        Swal.fire(
                            'Good job!',
                            'Added to Cart',
                            'success'
                        )
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('There was an error adding the items to the cart.'); // Handle error
                }
            });
        }
    });
});

