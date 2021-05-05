<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Enquiry $enquiry
 */
?>
<div class="column-responsive column-80">
    <div class="enquiries view content">
        <h3><?= h($enquiry->name) ?></h3>
        <table>
            <tr>
                <th><?= __('Id') ?></th>
                <td><?= $this->Number->format($enquiry->id) ?></td>
            </tr>
            <tr>
                <th><?= __('Status') ?></th>
                <td><?= h($enquiry->status) ?></td>
            </tr>
            <tr>
                <th><?= __('Create Date') ?></th>
                <td><?= h($enquiry->create_date) ?></td>
            </tr>
            <tr>
                <th><?= __('Name') ?></th>
                <td><?= h($enquiry->name) ?></td>
            </tr>
            <tr>
                <th><?= __('Email') ?></th>
                <td><?= h($enquiry->email) ?></td>
            </tr>
            <tr>
                <th><?= __('Subject') ?></th>
                <td><?= h($enquiry->subject) ?></td>
            </tr>
            <tr>
                <th><?= __('Description') ?></th>
                <td><?= h($enquiry->description) ?></td>
            </tr>
        </table>
    </div>
</div>
