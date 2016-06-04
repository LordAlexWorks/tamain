<?php $this->start('pluginCss'); ?>
    <?= $this->Html->css(['plugins/footable/footable.core']) ?>
<?php $this->end(); ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?= __("Members list") ?></h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->Url->build('/admin'); ?>"><?= __("Home") ?></a>
            </li>
            <li class="active">
                <strong><?= __("Members") ?></strong>
            </li>
        </ol>
    </div>
</div>
<?php echo $this->Flash->render(); ?>
<?php echo $this->Flash->render('auth'); ?>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?= __("List of members") ?></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content table-responsive">
                    <p><small><?= __('Click in the headers to order by column.') ?></small></p>

                    <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="8">
                        <thead>
                            <tr>
                                <th data-toggle="true" class="hidden-xs hidden-sm"><?= $this->Paginator->sort('id') ?></th>
                                <th><?= $this->Paginator->sort('firstname', __('First name')) ?></th>
                                <th><?= $this->Paginator->sort('lastname', __('Last name')) ?></th>
                                <th class="hidden-xs hidden-sm"><?= $this->Paginator->sort('email') ?></th>
                                <th class="hidden-xs hidden-sm"><?= $this->Paginator->sort('birthdate') ?></th>
                                <th class="hidden-xs hidden-sm"><?= $this->Paginator->sort('job') ?></th>
                                <th class="hidden-xs hidden-sm"><?= $this->Paginator->sort('company') ?></th>
                                <th class="hidden-xs hidden-sm"><?= $this->Paginator->sort('twitter') ?></th>
                                <th data-hide="all"><?= $this->Paginator->sort('active') ?></th>
                                <th><?= __("Actions") ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($members as $member): ?>
                                <tr>
                                    <td class="hidden-xs hidden-sm"><?= $this->Number->format($member->id) ?></td>
                                    <td><?= h($member->firstname) ?></td>
                                    <td><?= h($member->lastname) ?></td>
                                    <td class="hidden-xs hidden-sm"><?= h($member->email) ?></td>
                                    <td class="hidden-xs hidden-sm"><?= h($member->birthdate) ?></td>
                                    <td class="hidden-xs hidden-sm"><?= h($member->job) ?></td>
                                    <td class="hidden-xs hidden-sm"><?= h($member->company) ?></td>
                                    <td class="hidden-xs hidden-sm"><?php
                                        if (($member->twitter) && !empty($member->twitter)) {
                                            echo $this->Html->link('<i class="fa fa-twitter"></i>',
                                                $member->twitter,
                                                ['class' => 'btn btn-white', 'escape' => false]);
                                        } ?>
                                    </td>
                                    <td>
                                        <i class="fa <?php echo $member->has_active_membership ? 'fa-check text-navy' : 'fa-times text-danger'; ?>"></i>
                                    </td>
                                    <td class="actions">
                                        <?= $this->Html->link('<i class="fa fa-eye"></i>',
                                                ['action' => 'view', $member->id],
                                                ['class' => 'btn btn-white', 'escape' => false]) ?>
                                        <?= $this->Html->link('<i class="fa fa-edit"></i>',
                                                ['action' => 'edit', $member->id],
                                                ['class' => 'btn btn-white', 'escape' => false]) ?>
                                        <?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', 
                                                ['action' => 'delete', $member->id], 
                                                ['confirm' => __('Are you sure you want to delete # {0}?', $member->id), 
                                                    'class' => 'btn btn-white', 'escape' => false]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                                </tbody>
                            </table>
                             <?php echo $this->element('pagination'); ?>
                        </div>
                    </div>
                </div>
            </div>
</div>
<?php $this->start('pluginJs'); ?>
    <?php echo $this->Html->script([
        'plugins/pace/pace.min', 'plugins/footable/footable.all.min'
    ]); ?>
<?php $this->end(); ?>
