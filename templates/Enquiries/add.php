<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Enquiry $enquiry
 */
?>
<h1 class="text-center my-5 pb-4 border-bottom border-4">Submit an Enquiry</h1>

<div class="small-container border rounded my-5 p-4 enquiries">
    <?= $this->Form->create($enquiry) ?>

    <?= $this->Form->control('name',
        ['label' => ['class' => 'form-label'], 'class' => 'form-control mb-4']) ?>
    <?= $this->Form->control('email',
        ['label' => ['class' => 'form-label'], 'class' => 'form-control mb-4']) ?>
    <?= $this->Form->control('subject',
        ['label' => ['class' => 'form-label'], 'class' => 'form-control mb-4']) ?>
    <?= $this->Form->control('description',
        ['label' => ['class' => 'form-label'], 'type' => 'textarea', 'rows' => '12', 'class' => 'form-control mb-4']) ?>

    <?= $this->Form->submit(__('Submit'), ['class' => 'btn btn-primary']) ?>

    <?= $this->Form->end() ?>
</div>
