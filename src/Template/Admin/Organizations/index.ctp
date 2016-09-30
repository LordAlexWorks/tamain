<?php $this->start('pluginCss'); ?>
    <?= $this->Html->css(['plugins/footable/footable.core']) ?>
<?php $this->end(); ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?= __("Organizations list") ?></h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->Url->build('/admin'); ?>"><?= __("Home") ?></a>
            </li>
            <li class="active">
                <strong><?= __("Organizations") ?></strong>
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
                    <h5><?= __("List of Organizations") ?></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <a href="<?php echo $this->Url->build(['controller' => 'Organizations', 'action' => 'add']); ?>"
                        class="btn btn-primary">
                        <?= __('Add organization') ?>
                    </a>
                    
                    <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="8">
                        <thead>
                            <tr>
                                <th data-toggle="true"><?= $this->Paginator->sort('id') ?></th>
                                <th><?= $this->Paginator->sort('name') ?></th>
                                <th><?= __("Actions") ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($organizations as $organization): ?>
                                <tr>
                                    <td><?= $this->Number->format($organization->id) ?></td>
                                    <td><?= h($organization->name) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link('<i class="fa fa-edit"></i>',
                                                ['action' => 'edit', $organization->id],
                                                ['class' => 'btn btn-white', 'escape' => false]) ?>
                                        <?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', 
                                                ['action' => 'delete', $organization->id], 
                                                ['confirm' => __('Are you sure you want to delete # {0}?', $organization->id), 
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
