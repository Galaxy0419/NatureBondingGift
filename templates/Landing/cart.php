<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Photo[]|\Cake\Collection\CollectionInterface $photos
 * @var float $total
 */
?>

<div class="container mb-5">
    <h1 class="text-center my-5 pb-4 border-bottom border-4">Shopping Cart</h1>

    <div class="row">
        <div id="cart-list" class="col-9 list-group">
            <?php foreach ($photos as $photo): ?>
                <div id="<?= $photo->id ?>" class="list-group-item bg-light">
                    <div class="row">
                        <div class="col-3">
                            <?= $this->Html->image(WATERMARK_PHOTO_PATH . '/' . $photo->file_name, [
                                'alt' => $photo->file_name, 'class' => 'w-100',
                                'url' => 'img' . DS . WATERMARK_PHOTO_PATH . DS . $photo->file_name
                            ]) ?>
                        </div>

                        <div class="col-5">
                            <h5 class="fw-bold"><?= $photo->name ?></h5>
                            <p class="text-muted"><?= $photo->description ?></p>
                        </div>

                        <div class="col-2 text-center align-self-center">
                            <button class="btn btn-primary" onclick="removePhoto(<?= $photo->id ?>,
                                <?= $photo->discount_price === null ? $photo->price : $photo->discount_price ?>)">Remove</button>
                        </div>

                        <div class="col-2 text-center align-self-center fw-bold">
                            <?php
                                if ($photo->discount_price === null) {
                                    echo '$' . $this->Number->precision($photo->price, 2);
                                } else {
                                    echo '<s>$' . $this->Number->precision($photo->price, 2) . '</s>'
                                        . ' $' . $this->Number->precision($photo->discount_price, 2);
                                }
                            ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if ($total === 0.0): ?>
                <div class="list-group-item bg-light">
                    <h5 class="text-muted fw-bold text-center pt-2">No items in the cart currently</h5>
                </div>
            <?php endif; ?>

            <div id="clear-cart-button" class="list-group-item bg-light">
                <button class="btn btn-primary" onclick="clearCart()">Clear Cart</button>
            </div>
        </div>

        <div class="col-3 card bg-light pt-2 h-100 sticky-top">
            <h3 class="fw-bold">Checkout</h3>
            <hr>
            <p id="total" class="mb-0">Total: $<?= $this->Number->precision($total, 2) ?></p>
            <hr>
            <div id="paypal-button-container" class="text-center"></div>
        </div>
    </div>
</div>

<script src="https://www.paypal.com/sdk/js?client-id=Aadi2rCSz_LWQVPHtxqqo_dNVkGEM6V7pn58zOxgOhRGxwzZDlbzGmc5QW2iSpEWijf0-X497P_khFqJ&currency=AUD"></script>
<script>
    let total = <?= $this->Number->precision($total,2) ?>;

    paypal.Buttons({
        style:{
            color: 'gold',
            label: 'pay'
        },

        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{ amount: { value: total } }]
            });
        },

        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                // Show a success message to the buyer
                alert( details.payer.name.given_name + ' your order has been placed successfully!');
            });
        }
    }).render('#paypal-button-container');

    function getNoItemListGroupItem() {
        const textHeading = document.createElement('h5');
        textHeading.className = 'text-muted fw-bold text-center pt-2';
        textHeading.innerText = 'No items in the cart currently';

        const groupItemDiv = document.createElement('div');
        groupItemDiv.className = 'list-group-item bg-light';
        groupItemDiv.appendChild(textHeading);

        return groupItemDiv;
    }

    function removePhoto(photoId, price) {
        const xhr = new XMLHttpRequest();

        xhr.onload = function() {
            document.getElementById(photoId).remove();

            total = total - price;
            document.getElementById('total').innerHTML = `Total: \$${total.toFixed(2)}`;

            if (total === 0) {
                document.getElementById('cart-list').prepend(getNoItemListGroupItem());
            }
        };

        xhr.open('GET', `/landing/remove-from-cart/${photoId}`);
        xhr.send();
    }

    function clearCart() {
        const xhr = new XMLHttpRequest();

        xhr.onload = function() {
            document.getElementById('total').innerText = 'Total: $0.00';

            const cartTable = document.getElementById('cart-list');
            while (cartTable.firstChild.id !== 'clear-cart-button') {
                cartTable.removeChild(cartTable.firstChild);
            }

            document.getElementById('cart-list').prepend(getNoItemListGroupItem());
        };

        xhr.open('GET', '/landing/clear-cart');
        xhr.send();
    }
</script>
