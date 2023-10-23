<?php
/** @var array $cartItems * */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Cart';
\yii\web\YiiAsset::register($this);
?>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Cart Items</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mt-3">
                            <thead>
                            <tr>
                                <th>Product</th>
                                <th>Image</th>
                                <th>Unit Price</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($cartItems as $item): ?>
                                <tr data-id="<?= $item['product_id'] ?>"
                                    data-url="<?= Url::to(['/cart-item/change-quantity']) ?>">
                                    <td><?= $item['product_name'] ?></td>
                                    <td><?= Html::img('@web/' . $item['image'], ['class' => 'w-25 h-25']); ?></td>
                                    <td><?= $item['price'] ?></td>
                                    <td><input type="number" min="1" class="form-control item-quantity"
                                               value="<?= $item['quantity'] ?>"></td>
                                    <td><?= number_format($item['total_price']) ?></td>
                                    <td><?= Html::a('Delete',
                                            ['/cart-item/delete', 'id' => $item['product_id']],
                                            ['class' => 'btn btn-danger', 'data-method' => 'post', 'data-confirm' => 'Are you sure you want to remove this product from cart?']

                                        ) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header">Cart Summary</div>
                <div class="card-body">
                    <div style="display: flex;  justify-content: space-between" class="mb-4">
                        <h5 class="font-weight-bold">SubTotal</h5>
                        <span id="sub-total">KSh <?= number_format($totalSum, 2) ?></span>
                    </div>
                    <?php if (!empty($cartItems)): ?>
                        <?= Html::a('Checkout', ['/order-address/checkout'], ['class' => 'btn btn-primary', 'style' => 'display:block; width:100%;', 'data-method' => 'post']) ?>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>


</div>
<script>
    $(document).ready(function () {
        const cartQuantity = $('#cart-count')
        const itemQuantity = $('.item-quantity')
        const total = $('.total');
        // Using a delegated event handler if elements are dynamically loaded
        $(document).on('click', '.add-to-cart', function (e) {
            e.preventDefault(); // Prevent the default link click action
            var productId = $(this).attr('data-id'); // Using attr instead of data
            var url = $(this).attr('href'); // Using attr to get the href value
            // Check if productId and url are not undefined or null
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
        itemQuantity.change(ev => {
            const $this = $(ev.target);
            let tr = $this.closest('tr');
            const tdTotalPrice = $this.closest('td').next(); // td containing total price
            const id = tr.data('id');
            const url = tr.data('url');
            $.ajax({
                url: url,
                type: 'POST',
                data: {id: id, quantity: $this.val()},
                success: function (result) {

                    // Update cart quantity and individual item's total price
                    cartQuantity.text(result.quantity);
                    tdTotalPrice.text(result.price);
                    $('#sub-total').text(result.totalSum);


                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('There was an error updating the cart item quantity.'); // Adjusted error message
                }
            });
        });
    });

</script>