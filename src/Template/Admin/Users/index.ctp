<?php $this->start('pluginCss'); ?>
    <?= $this->Html->css(['plugins/footable/footable.core']) ?>
<?php $this->end(); ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Users list</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->Url->build('/admin'); ?>">Home</a>
            </li>
            <li class="active">
                <strong>Users</strong>
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
                    <h5>Listing of Admin Users</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="8">
                        <thead>
                            <tr>
                                <th data-toggle="true"><?= $this->Paginator->sort('id') ?></th>
                                <th><?= $this->Paginator->sort('username') ?></th>
                                <th><?= $this->Paginator->sort('email') ?></th>
                                <th data-hide="all"><?= $this->Paginator->sort('first_name') ?></th>
                                <th data-hide="all"><?= $this->Paginator->sort('last_name') ?></th>
                                <th data-hide="all"><?= $this->Paginator->sort('active') ?></th>
                                <th data-hide="all"><?= $this->Paginator->sort('created') ?></th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= $this->Number->format($user->id) ?></td>
                                    <td><?= h($user->username) ?></td>
                                    <td><?= h($user->email) ?></td>
                                    <td><?= h($user->first_name) ?></td>
                                    <td><?= h($user->last_name) ?></td>
                                    <td>
                                        <i class="fa <?php echo $user->active ? 'fa-check text-navy' : 'fa-times text-danger'; ?>"></i>
                                    </td>
                                    <td><?= h($user->created) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link('<i class="fa fa-edit"></i>',
                                                ['action' => 'edit', $user->id],
                                                ['class' => 'btn btn-white', 'escape' => false]) ?>
                                        <?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', 
                                                ['action' => 'delete', $user->id], 
                                                ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 
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
