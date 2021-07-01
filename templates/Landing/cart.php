<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Photo[]|\Cake\Collection\CollectionInterface $photos
 * @var int $total
 */
?>

<div class="small-container mb-5">
    <h1 class="text-center my-5 pb-4 border-bottom border-4">Shopping Cart</h1>

    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Preview</th>
            <th>Actions</th>
            <th>Price</th>
        </tr>
        </thead>

        <tbody id="photos-in-cart">
        <?php foreach ($photos as $photo): ?>
            <tr id="<?= $photo->id ?>">
                <td><?= $photo->name ?></td>
                <td>
                    <?= $this->Html->image(WATERMARK_PHOTO_PATH . '/' . $photo->file_name, [
                        'alt' => $photo->file_name, 'width' => 256,
                        'url' => 'img' . DS . WATERMARK_PHOTO_PATH . DS . $photo->file_name
                    ]) ?>
                </td>
                <td class="actions" onclick="removePhoto(<?= $photo->id ?>, <?= $photo->discount_price === null ? $photo->price : $photo->discount_price ?>)">Delete</td>
                <td>$<?= $this->Number->precision(is_null($photo->discount_price) ? $photo->price : $photo->discount_price, 2) ?></td>
            </tr>
        <?php endforeach; ?>

        <tr id="sum-table-row" class="success">
            <td colspan=3>Total</td>
            <td id="sum-table-data">$<?= $this->Number->precision($total,2) ?></td>
        </tr>
        </tbody>
    </table>

    <button class="button float-right" onclick="clearCart()">Clear Cart</button>
    <div id="paypal-button-container" class="text-center"></div>
</div>

<script src="https://www.paypal.com/sdk/js?client-id=Aadi2rCSz_LWQVPHtxqqo_dNVkGEM6V7pn58zOxgOhRGxwzZDlbzGmc5QW2iSpEWijf0-X497P_khFqJ&currency=AUD"></script>
<script>
    let total = parseFloat(<?= $this->Number->precision($total,2) ?>);

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

    function removePhoto(photoId, price) {
        const xhr = new XMLHttpRequest();

        xhr.onload = function() {
            document.getElementById(photoId).remove();

            total = total - price;
            document.getElementById('sum-table-data').innerHTML = `\$${total.toFixed(2)}`;
        };

        xhr.open('GET', `/landing/remove-from-cart/${photoId}`);
        xhr.send();
    }

    function clearCart() {
        const xhr = new XMLHttpRequest();

        xhr.onload = function() {
            document.getElementById('sum-table-data').innerText = '$0.00';
            const cartTable = document.getElementById('photos-in-cart');
            while (cartTable.firstChild.id !== 'sum-table-row') {
                cartTable.removeChild(cartTable.firstChild);
            }
        };

        xhr.open('GET', '/landing/clear-cart');
        xhr.send();
    }
</script>
