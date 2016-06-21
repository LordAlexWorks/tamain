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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-right">
                                <?= $this->Statistics->displaySetOfStatistics(
                                    'positive',
                                    [
                                        [
                                            'percentage' => $allMembersGrowth['-1 month']['growth'],
                                            'value' => $allMembersGrowth['-1 month']['count'],
                                            'label' => __('last month')
                                        ],[
                                            'percentage' => $allMembersGrowth['-1 year']['growth'],
                                            'value' => $allMembersGrowth['-1 year']['count'],
                                            'label' => __('last year')
                                        ]
                                    ]
                                ); ?>
                            </div>

                            <h1 class="no-margins"><?= $allMembersGrowth['reference']['count'] ?></h1>
                        </div>
                    </div>
                    <small><?= __('members registered') ?></small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-success pull-right"><?= __('Total') ?></span>
                    <h5><?= __('Re-registration rate') ?></h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-right">
                                <?= $this->Statistics->displaySetOfStatistics(
                                    'positive',
                                    [
                                        [
                                            'percentage' => $reregistratedGrowth['-1 month']['growth'],
                                            'value' => $reregistratedGrowth['-1 month']['count'],
                                            'label' => __('last month')
                                        ],[
                                            'percentage' => $reregistratedGrowth['-1 year']['growth'],
                                            'value' => $reregistratedGrowth['-1 year']['count'],
                                            'label' => __('last year')
                                        ]
                                    ]
                                ); ?>
                            </div>
                            
                            <h1 class="no-margins">
                                <?= number_format($reregistrationRate, 0) ?>%
                            </h1>
                        </div>
                    </div>
                    <small>
                        <?= __('of members ({0}) renew their membership', $reregistratedGrowth['reference']['count']) ?>
                    </small>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="ibox-content ">
                <h5 class="m-b-md"><?= __('Most common job title') ?></h5>
                <h1 class="no-margins"><?= $mostCommonJob['value'] ?></h1>
                <small>
                    <?= number_format($mostCommonJobRate, 0) ?>%
                    <?= __('({0} members)', ($mostCommonJob['value_count'] ? $mostCommonJob['value_count'] : 0)) ?>
                </small>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="ibox-content ">
                <h5 class="m-b-md"><?= __('Average age') ?></h5>
                <h1 class="no-margins"><?= number_format($averageAge['age'], 0) ?></h1>
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
                    <h5>
                        <?= __('New members this month') ?>
                        <span class="label label-info pull-right"><?= __('Monthly') ?></span>
                    </h5>
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
                            <h1 class="no-margins"><?= $newMembersGrowth['reference']['count'] ?></h1>
                            <small><?= __('members') ?></small>
                        </div>
                        <div class="col-sm-8">
                            <div class="pull-right">
                                <?= $this->Statistics->displaySetOfStatistics(
                                    'positive',
                                    [
                                        [
                                            'percentage' => $newMembersGrowth['-1 month']['growth'],
                                            'value' => $newMembersGrowth['-1 month']['count'],
                                            'label' => __('last month')
                                        ],[
                                            'percentage' => $newMembersGrowth['-1 year']['growth'],
                                            'value' => $newMembersGrowth['-1 year']['count'],
                                            'label' => __('last year')
                                        ]
                                    ]
                                ); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox-content table-responsive">
                    <?php
                    // EXPORT
                    echo $this->Form->create(null, [
                        'url' => ['controller' => 'Members', 'action' => 'filter']
                    ]);
                    echo $this->Form->hidden('standardFilter', ['value' => 'newMembers']);
                        ?>
                        <button type="submit" class="btn btn-primary btn-block m-t"><i class="fa fa-file-excel-o"></i> <?= __('Export') ?></button>
                        <?php
                    echo $this->Form->end();
                    ?>

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
                    <h5>
                        <?= __('Soon to be deactivated') ?>
                        <span class="label label-info pull-right"><?= __('Monthly') ?></span>
                    </h5>
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
                    <?php 
                    $arrSoonDeactivate = $soonToDeactivateMembers->toArray();
                    ?>
                    <div class="row">
                        <div class="col-sm-6 col-md-3">
                            <h1 class="no-margins"><?= $soonToDeactivateGrowth['reference']['count'] ?></h1>
                            <small><?= __('members') ?></small>
                        </div>
                        <div class="col-sm-6 col-md-4 text-center">
                            <small><strong><?= (array_key_exists(1, $arrSoonDeactivate) ? count($arrSoonDeactivate[1]) : 0) ?></strong> <?= __('in 1st call') ?></small><br>
                            <small><strong><?= (array_key_exists(2, $arrSoonDeactivate) ? count($arrSoonDeactivate[2]) : 0) ?></strong> <?= __('in 2nd call') ?></small><br>
                            <small><strong><?= (array_key_exists(3, $arrSoonDeactivate) ? count($arrSoonDeactivate[3]) : 0) ?></strong> <?= __('in 3rd call') ?></small>
                        </div>
                        <div class="col-sm-12 col-md-5">
                            <div class="pull-right">
                                <?= $this->Statistics->displaySetOfStatistics(
                                    'negative',
                                    [
                                        [
                                            'percentage' => $soonToDeactivateGrowth['-1 month']['growth'],
                                            'value' => $soonToDeactivateGrowth['-1 month']['count'],
                                            'label' => __('last month')
                                        ],[
                                            'percentage' => $soonToDeactivateGrowth['-1 year']['growth'],
                                            'value' => $soonToDeactivateGrowth['-1 year']['count'],
                                            'label' => __('last year')
                                        ]
                                    ]
                                ); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox-content table-responsive">
                    <?php
                    // EXPORT
                    echo $this->Form->create(null, [
                        'url' => ['controller' => 'Members', 'action' => 'filter']
                    ]);
                    echo $this->Form->hidden('standardFilter', ['value' => 'soonToDeactivateMembers']);
                        ?>
                        <button type="submit" class="btn btn-primary btn-block m-t"><i class="fa fa-file-excel-o"></i> <?= __('Export') ?></button>
                        <?php
                    echo $this->Form->end();
                    ?>

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
                            $callColors = [ 1 => 'text-info', 2 => '', 3 => 'text-danger'];
                            for ($call = 1; $call <= 3; $call++):
                                $members = (array_key_exists($call, $arrSoonDeactivate) ? $arrSoonDeactivate[$call] : []);
                                foreach($members as $member):
                            ?>
                                <tr>
                                    <td class="text-center">
                                        <small class="<?= $callColors[$call] ?>">
                                            <i class="fa fa-calendar hidden-xs"></i>
                                            <?= date_format($member->memberships[0]->expires_on, 'd/m') ?>
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
                                        <small class="<?= $callColors[$call] ?>">#<?= $call ?></small>
                                    </td>
                                </tr>
                            <?php
                                endforeach;
                            endfor;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>
                        <?= __('Recently deactivated') ?>
                        <span class="label label-info pull-right"><?= __('Monthly') ?></span>
                    </h5>
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
                            <h1 class="no-margins"><?= $recentlyDeactivatedGrowth['reference']['count'] ?></h1>
                            <small><?= __('members') ?></small>
                        </div>
                        <div class="col-sm-8">
                            <div class="pull-right">
                                <?= $this->Statistics->displaySetOfStatistics(
                                    'negative',
                                    [
                                        [
                                            'percentage' => $recentlyDeactivatedGrowth['-1 month']['growth'],
                                            'value' => $recentlyDeactivatedGrowth['-1 month']['count'],
                                            'label' => __('last month')
                                        ],[
                                            'percentage' => $recentlyDeactivatedGrowth['-1 year']['growth'],
                                            'value' => $recentlyDeactivatedGrowth['-1 year']['count'],
                                            'label' => __('last year')
                                        ]
                                    ]
                                ); ?>
                            </div>
                        </div>
                    </div>
                </div>                
                <div class="ibox-content table-responsive">
                    <?php
                    // EXPORT
                    echo $this->Form->create(null, [
                        'url' => ['controller' => 'Members', 'action' => 'filter']
                    ]);
                    echo $this->Form->hidden('standardFilter', ['value' => 'recentlyDeactivatedMembers']);
                        ?>
                        <button type="submit" class="btn btn-primary btn-block m-t"><i class="fa fa-file-excel-o"></i> <?= __('Export') ?></button>
                        <?php
                    echo $this->Form->end();
                    ?>

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