<?php $this->start('pluginCss'); ?>
<?= $this->Html->css(['plugins/footable/footable.core']) ?>
<?php $this->end(); ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?= __("Dashboard") ?></h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->Url->build('/admin'); ?>"><?= __("Home") ?></a>
            </li>
            <li class="active">
                <strong><?= __("Dashboard") ?></strong>
            </li>
        </ol>
    </div>
</div>
<?php echo $this->Flash->render(); ?>
<?php echo $this->Flash->render('auth'); ?>
<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-success pull-right"><?= __('Total') ?></span>
                    <h5><?= __('Registered members') ?></h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?= $metrics['numRegisteredMembers'] ?></h1>
                    <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div>
                    <small><?= __('Members registered') ?></small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-info pull-right"><?= __('Annual') ?></span>
                    <h5><?= __('Re-registration rate') ?></h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-6">
                            <h1 class="no-margins">60%</h1>
                        </div>
                        <div class="col-md-6">
                            <div class="stat-percent font-bold text-info">2% <i class="fa fa-level-up"></i> <small> <?= __('last month') ?></small></div>
                            <div class="font-bold text-navy">44% <i class="fa fa-level-up"></i> <small> <?= __('last year') ?></small></div>
                        </div>
                    </div>
                    <small><?= __('renew their membership') ?></small>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="ibox-content ">
                <h5 class="m-b-md"><?= __('Most common job title') ?></h5>
                <h1 class="no-margins">Co-Fondatrice</h1>
                <small>14% <?= __('({0} members)', 20) ?></small>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="ibox-content ">
                <h5 class="m-b-md"><?= __('Average age') ?></h5>
                <h1 class="no-margins">35</h1>
                <small><?= __('years-old') ?></small>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content text-center">
                    <br><br><br><br><br>
                    PICTURE HERE
                    <br><br><br><br><br>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">             
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?= __('New members this month') ?></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-4">
                            <h1 class="no-margins"><?= $metrics['numNewMembers'] ?></h1>
                            <small><?= __('members') ?></small>
                        </div>
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="stat-percent font-bold text-navy">2% <i class="fa fa-level-up"></i> <small> <?= __('last month') ?></small></div>
                            </div>
                            <div class="row">
                                <div class="stat-percent font-bold text-info">44% <i class="fa fa-level-up"></i> <small> <?= __('last year') ?></small></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox-content table-responsive">
                    <button class="btn btn-primary btn-block m-t"><i class="fa fa-file-excel-o"></i> <?= __('Export') ?></button>
                    <table class="table table-hover no-margins">
                        <thead>
                            <tr>
                                <th class="col-sm-3 text-center">
                                    <?= __('Date') ?>
                                </th>
                                <th class="col-xs-9 col-sm-4">
                                    <?= __('Name') ?>
                                </th>
                                <th class="col-sm-5 hidden-xs">
                                    <?= __('Job') ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($newMembers as $member):
                            ?>
                                <tr>
                                    <td class="text-center">
                                        <small>
                                            <i class="fa fa-calendar hidden-xs"></i>
                                            <?= date_format($member->created, 'd/m') ?>
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            <?php echo $this->Html->link($member->full_name,
                                                ['controller' => 'Members', 'action' => 'edit', $member->id]); ?>
                                        </small>
                                        <small class="visible-xs-block"><?= $member->job ?></small>
                                    </td>
                                    <td class="hidden-xs">
                                        <small><?= $member->job ?></small>
                                    </td>
                                </tr>
                            <?php
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">             
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?= __('Soon to expire') ?></h5>
                    <div class="ibox-tools">
                        <a class="text-navy"><i class="fa fa-file-excel-o text-navy"></i><span class="sr-only"><?= __('Export') ?></span></a>
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-6 col-md-4">
                            <h1 class="no-margins">15</h1>
                            <small><?= __('members') ?></small>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <small><strong>8</strong> <?= __('in 1st call') ?></small><br>
                            <small><strong>2</strong> <?= __('in 2nd call') ?></small><br>
                            <small><strong>5</strong> <?= __('in 3rd call') ?></small>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="row">
                                <div class="stat-percent font-bold text-navy">2% <i class="fa fa-level-up"></i> <small> <?= __('last month') ?></small></div>
                            </div>
                            <div class="row">
                                <div class="stat-percent font-bold text-info">4% <i class="fa fa-level-up"></i> <small> <?= __('last year') ?></small></div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="ibox-content table-responsive">
                    <button class="btn btn-primary btn-block m-t"><i class="fa fa-file-excel-o"></i> <?= __('Export') ?></button>
                    <table class="table table-hover no-margins">
                        <thead>
                            <tr>
                                <th class="col-xs-3 text-center">
                                    <?= __('Expirat.') ?>
                                </th>
                                <th class="col-xs-7 col-sm-4">
                                    <?= __('Name') ?>
                                </th>
                                <th class="col-sm-3 hidden-xs">
                                    <?= __('Joined in') ?>
                                </th>
                                <th class="col-xs-2 text-center">
                                    <?= __('Call') ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($newMembers as $member):
                            ?>
                                <tr>
                                    <td class="text-center">
                                        <small>
                                            <i class="fa fa-calendar hidden-xs"></i>
                                            <?= date_format($member->created, 'd/m') ?>
                                        </small>
                                    </td>
                                    <td>
                                        <small><strong><?= $member->full_name ?></strong></small>
                                        <small class="visible-xs-block">
                                            <?= __('Joined in {0}', date_format($member->created, 'd/m/Y')) ?>
                                        </small>
                                    </td>
                                    <td class="hidden-xs">
                                        <small>
                                            <?= date_format($member->created, 'd/m/Y') ?>
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <small class="text-info">#2</small>
                                        <!-- navy danger -->
                                    </td>
                                </tr>
                            <?php
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?= __('Recently expired') ?></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-4">
                            <h1 class="no-margins"><?= $metrics['numRecentlyDeactivatedMembers'] ?></h1>
                            <small><?= __('members') ?></small>
                        </div>
                        <div class="col-sm-8">

                            <div class="row">
                                <div class="stat-percent font-bold text-navy">2% <i class="fa fa-level-up"></i> <small> <?= __('last month') ?></small></div>
                            </div>
                            <div class="row">
                                <div class="stat-percent font-bold text-info">44% <i class="fa fa-level-up"></i> <small> <?= __('last year') ?></small></div>

                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="ibox-content table-responsive">
                    <button class="btn btn-primary btn-block m-t"><i class="fa fa-file-excel-o"></i> <?= __('Export') ?></button>
                    <table class="table table-hover no-margins">
                        <thead>
                            <tr>
                                <th class="col-xs-3 text-center">
                                    <?= __('Expirat.') ?>
                                </th>
                                <th class="col-xs-9 col-sm-6">
                                    <?= __('Name') ?>
                                </th>
                                <th class="col-sm-3 hidden-xs">
                                    <?= __('Joined in') ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($recentlyDeactivatedMembers as $member):
                            ?>
                                <tr>
                                    <td class="text-center">
                                        <small>
                                            <i class="fa fa-calendar hidden-xs"></i>
                                            <?= date_format($member->memberships[0]->expires_on, 'd/m') ?>
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            <?php echo $this->Html->link($member->full_name,
                                                ['controller' => 'Members', 'action' => 'edit', $member->id]); ?>
                                        </small>
                                        <small class="visible-xs-block">
                                            <?= __('Joined in {0}', date_format($member->created, 'd/m/Y')) ?>
                                        </small>
                                    </td>
                                    <td class="hidden-xs">
                                        <small>
                                            <?= date_format($member->created, 'd/m/Y') ?>
                                        </small>
                                    </td>
                                </tr>
                            <?php
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>