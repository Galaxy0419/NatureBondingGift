<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Enquiry $enquiry
 */
?>
<div class="column-responsive column-80">
    <div class="enquiries form content">
        <?= $this->Form->create() ?>
        <fieldset>
            <legend><?= __('Reply Enquiry') ?></legend>
            <table>
                <tr>
                    <th>Name:</th>
                    <td><?= $enquiry->name ?></td>
                </tr>
                <tr>
                    <th>Subject:</th>
                    <td><?= $enquiry->subject ?></td>
                </tr>
            </table>

            <br>

            <?= $this->Form->control('reply', ['label' => 'Reply Message','type' => 'textarea',
                'placeholder' => 'Please input the reply message without salutation and closing', 'style' => 'height: 256px']) ?>
        </fieldset>
        <?= $this->Form->button(__('Reply')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
