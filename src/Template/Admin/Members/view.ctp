<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?= __('View member') ?></h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->Url->build('/admin'); ?>"><?= __('Home') ?></a>
            </li>
            <li class="active">
                <a href="<?php echo $this->Url->build(['controller' => 'Members', 'action' => 'index']); ?>">
                    <?= __('Members') ?>
                </a>
            </li>
            <li class="active">
                <strong><?php echo $member->full_name; ?></strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>
<?php echo $this->Flash->render(); ?>
<?php echo $this->Flash->render('auth'); ?>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab-1"><?= __('Member info') ?></a></li>
                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <th><?= __('Id') ?></th>
                                    <td><?= $this->Number->format($member->id) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('First Name') ?></th>
                                    <td><?= h($member->firstname) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Last Name') ?></th>
                                    <td><?= h($member->lastname) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Email') ?></th>
                                    <td><?= h($member->email) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Job') ?></th>
                                    <td><?= h($member->job) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Company') ?></th>
                                    <td><?= h($member->company) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Twitter') ?></th>
                                    <td><?= h($member->twitter) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Birthdate') ?></th>
                                    <td><?= h($member->birthdate) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Active') ?></th>
                                    <td>
                                        <i class="fa <?php echo $member->active ? 'fa-check text-navy' : 'fa-times text-danger'; ?>"></i>
                                        <?= $member->active ? __('Yes') : __('No'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?= __('Actions') ?></th>
                                    <td class="actions">
                                        <?= $this->Html->link('<i class="fa fa-edit"></i>',
                                                ['action' => 'edit', $member->id],
                                                ['class' => 'btn btn-white', 'escape' => false]) ?>
                                        <?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', 
                                                ['action' => 'delete', $member->id], 
                                                ['confirm' => __('Are you sure you want to delete # {0}?', $member->id), 
                                                    'class' => 'btn btn-white', 'escape' => false]) ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
