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

    <?= $this->Html->link(__('Clear'), ['action' => 'clearCart'], ['class' => 'button']) ?>
</div>

<br><br><br><br>
