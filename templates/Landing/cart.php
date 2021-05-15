<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Photo[]|\Cake\Collection\CollectionInterface $photos
 * @var int $total
 */
?>

<div class="small-container">
    <h2 class="title">Shopping Cart</h2>

    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Preview</th>
            <th>Actions</th>
            <th>Price</th>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($photos as $photo): ?>
            <tr>
                <td><?= $photo->name ?></td>
                <td>
                    <?= $this->Html->image(WATERMARK_PHOTO_PATH . '/' . $photo->file_name, [
                        'alt' => $photo->file_name, 'width' => 256,
                        'url' => 'img' . DS . WATERMARK_PHOTO_PATH . DS . $photo->file_name
                    ]) ?>
                </td>
                <td class="actions">
                    <?= $this->Html->link(__('Delete'), ['action' => 'removePhotoFromCart', $photo->id]) ?>
                </td>
                <td>$<?= $this->Number->precision(is_null($photo->discount_price) ? $photo->price : $photo->discount_price, 2) ?></td>
            </tr>
        <?php endforeach; ?>

        <tr class="success">
            <td>Total</td>
            <td colspan=2/>
            <td>$<?= $this->Number->precision($total,2) ?></td>
        </tr>
        </tbody>
    </table>

    <div class="container-responsive" style="text-align: right">

        <?= $this->Html->link(__('Clear Cart'), ['action' => 'clearCart'], ['class' => 'clear']) ?>
    </div>
    

    <div id="paypal-button-container" style="text-align: center"> </div>

  
    <script src="https://www.paypal.com/sdk/js?client-id=Aadi2rCSz_LWQVPHtxqqo_dNVkGEM6V7pn58zOxgOhRGxwzZDlbzGmc5QW2iSpEWijf0-X497P_khFqJ&currency=AUD"></script>

    <script>
        paypal.Buttons({
            style:{
                color: 'gold',
                label: 'pay'
            },
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '<?= $this->Number->precision($total,2) ?>'
                        }
                    }]
                });
            },

            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    // Show a success message to the buyer
                    alert( details.payer.name.given_name + ' your order has been placed successfully!');
                });
            }
        }).render('#paypal-button-container');
    </script>
</div>

<br><br><br><br>
