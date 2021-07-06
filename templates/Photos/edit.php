<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Photo $photo
 */
?>

<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $photo->id],
                ['confirm' => __('Are you sure you want to delete "{0}"?', $photo->name), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Photos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="photos form content">
            <?= $this->Form->create($photo, ['type' => 'file']) ?>
            <fieldset>
                <legend><?= __('Edit Photo') ?></legend>
                <?= $this->Html->link('Add', '/categories/add', ['class' => 'button', 'style' => 'float:right']) ?>
                <?= $this->Form->control('category_id', ['options' => $categories]) ?>
                <?= $this->Form->control('name') ?>
                <?= $this->Form->control('description') ?>
                <?= $this->Form->control('price', ['id' => 'price']) ?>
                <?= $this->Form->control('discount_price', ['id' => 'discount-price']) ?>
                <?= $this->Form->control('Discount Percentage', ['id' => 'discount-percentage']) ?>
                <?= $this->Form->control('file', ['label' => 'Choose a Photo',
                    'type' => 'file', 'accept' => 'image/jpeg,image/png', 'id' => 'file-upload-control', 'error' => false]) ?>
                <img src="#" alt="Photo Preview" width="480" height="270" id="preview-image" style="display: none; object-fit: contain">
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end()?>
        </div>
    </div>
</div>

<script>
    const price = document.getElementById('price')
    const discountPrice = document.getElementById('discount-price')
    const discountPercentage = document.getElementById('discount-percentage')

    price.addEventListener('change', () => {
        discountPrice.value = '';
        discountPercentage.value = '';
    });

    discountPrice.addEventListener('change', () => {
        if (price.value !== "") {
            console.log(price.value);
            console.log(discountPrice.value);
            if (discountPrice.value < price.value) {
                discountPercentage.value = (1 - discountPrice.value / price.value) * 100;
            } else {
                alert('Discount price must be less than original price!');
            }
        } else {
            alert("Original price is empty. Please enter original price first.")
        }
    });

    discountPercentage.addEventListener('change', () => {
        if (price.value !== "") {
            if (discountPercentage.value > 0 && discountPercentage.value < 100) {
                discountPrice.value = price.value * (1 - discountPercentage.value / 100);
            } else {
                alert('Discount percentage must be between 0 and 100!');
            }
        } else {
            alert("Original price is empty. Please enter original price first.")
        }
    });

    document.getElementById('file-upload-control').addEventListener('change', (ev) => {
        const previewImg = document.getElementById('preview-image');
        previewImg.src = window.URL.createObjectURL(ev.target.files[0]);
        previewImg.style.display = '';
    })
</script>
