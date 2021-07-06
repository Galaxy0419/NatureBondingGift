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
            <?= $this->Html->link(__('List Photos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="photos form content">
            <?= $this->Form->create($photo, ['type' => 'file']) ?>
            <fieldset>
                <legend><?= __('Add Photo') ?></legend>
                <?= $this->Html->link('Add', '/categories/add', ['class' => 'button', 'style' => 'float:right']) ?>
                <?= $this->Form->control('category_id', ['options' => $categories]) ?>
                <?= $this->Form->control('name') ?>
                <?= $this->Form->control('description') ?>
                <?= $this->Form->control('price') ?>
                <?= $this->Form->control('file', ['label' => 'Choose a Photo',
                    'type' => 'file', 'accept' => 'image/jpeg,image/png', 'id' => 'file-upload-control', 'error' => false]) ?>
                <img src="#" alt="Photo Preview" width="480" height="270" id="preview-image" style="display: none; object-fit: contain">
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<script>
    document.getElementById('file-upload-control').addEventListener('change', (ev) => {
        const previewImg = document.getElementById('preview-image');
        previewImg.src = window.URL.createObjectURL(ev.target.files[0]);
        previewImg.style.display = '';
    })
</script>
