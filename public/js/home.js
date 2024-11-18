
    $(document).ready(function() {
        // Function to show the overlay loader
        function showLoader() {
            $('.overlay-loader').show();
        }

        // Function to hide the overlay loader
        function hideLoader() {
            $('.overlay-loader').hide();
        }


        function showToast(message) {
        var $toast = $('#toast');
        $toast.text(message); // Set the message content
        $toast.removeClass('hidden');
    }

        function hideToast() {
            var $toast = $('#toast');
            $toast.addClass('hidden');
        }

        // Add to cart
        $('.add-to-cart-button').click(function(e) {
            e.preventDefault();

            var $button = $(this);
            var $spinner = $button.find('.spinner');
            var $buttonText = $button.find('.button-text');
            $button.addClass('loading'); // Add a loading class to style the button

            // Hide the button text and display the spinner
            $buttonText.hide();
            $spinner.show();
            // showLoader()
            var productId = $(this).data('product-id');
            var quantity = $(this).data('quantity');

            $.ajax({
                type: 'POST',
                url: '{{ route('add-to-cart') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId,
                    quantity: quantity
                },
                success: function(response) {
                    // hideLoader()
                    $spinner.hide();
                    $buttonText.show();
                    $button.removeClass('loading');
                    $('.cart-quantity').text(response.cartItemCount);


                     // Show the toast message
                     showToast('Item added to Cart!');

                    // Hide the toast message after a few seconds (e.g., 3 seconds)
                    setTimeout(function () {
                        hideToast();
                    }, 3000);
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        });

        // Increase or decrease quantity
        $('.minus, .plus').click(function() {
            // showLoader()


            var $button = $(this);
            var $spinner = $button.find('.spinner');
            var $buttonText = $button.find('.button-text');
            $button.addClass('loading'); // Add a loading class to style the button

            // Hide the button text and display the spinner
            $buttonText.hide();
            $spinner.show();


            var productId = $(this).data('product-id');
            var quantityInput = $('input.qty[data-product-id="' + productId + '"]');
            var newQuantity = parseInt(quantityInput.val());

            if ($(this).hasClass('plus')) {
                newQuantity++;
            } else if ($(this).hasClass('minus') && newQuantity > 1) {
                newQuantity--;
            }

            $.ajax({
                type: 'POST',
                url: '{{ route('update-cart') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId,
                    quantity: newQuantity
                },
                success: function(response) {
                    // hideLoader()
                    // $spinner.hide();
                    // $buttonText.show();
                    // $button.removeClass('loading');


                    quantityInput.val(newQuantity);
                    // $('.product-subtotal[data-product-id="' + productId + '"]').html(response.itemSubtotal);
                    // $('.cart-total').html(response.cartTotal);

                    quantityInput.val(newQuantity);
                    $('.product-subtotal[data-product-id="' + productId + '"]').html(
                        response.itemSubtotal);

                    // Update the cart total by replacing the old value with the new one
                    $('.cart-total').html(response.cartTotal);

                     // Show the toast message
                    showToast('Cart updated!');

                    // Hide the toast message after a few seconds (e.g., 3 seconds)
                    setTimeout(function () {
                        hideToast();
                    }, 3000);
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        });

        // Remove an item
        $('.remove-item').click(function(e) {
            e.preventDefault();
            var productId = $(this).data('product-id');
            showLoader()

            $.ajax({
                type: 'POST',
                url: '{{ route('remove-from-cart') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId
                },
                success: function(response) {
                    hideLoader()

                    // Remove the item from the page
                    $('.cart-item[data-product-id="' + productId + '"]').remove();
                    // console.log("🚀 ~ file: scripts.blade.php:102 ~ $ ~ ('.cart-item[data-product-id="' + productId + '"]'):", '.cart-item[data-product-id="' + productId + '"]')

                    // Update the cart total
                    $('.cart-total').html(response.cartTotal);
                     // Show the toast message
                    showToast('Item removed from cart!');

                    // Hide the toast message after a few seconds (e.g., 3 seconds)
                    setTimeout(function () {
                        hideToast();
                    }, 3000);
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        });

        // Clear the cart
        $('.clear-cart').click(function(e) {
            e.preventDefault();
            showLoader()

            $.ajax({
                type: 'POST',
                url: '{{ route('clear-cart') }}',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    hideLoader()

                    $('.cart-item').remove();
                    $('.cart-total').html(response.cartTotal); // Show the toast message
                    showToast('Cart cleared!');

                    // Hide the toast message after a few seconds (e.g., 3 seconds)
                    setTimeout(function () {
                        hideToast();
                    }, 3000);
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        });
    });
