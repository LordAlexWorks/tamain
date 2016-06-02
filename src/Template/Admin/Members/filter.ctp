<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?= __('Filter members') ?></h2>
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
                <strong><?php echo __("Filter Members"); ?></strong>
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
            <h3><?= __("Filter members") ?></h3>
            <br />

            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?= __('Standard filters') ?></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <?php
                        echo $this->Form->create();
                    ?>

                    <fieldset class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-12 col-md-10 col-lg-6">
                                <?php 
                                $this->Form->templates([
                                    'nestingLabel' => '<div class="input-group"><span class="input-group-addon">{{input}}</span> <label{{attrs}} class="form-control border-none">{{text}}</label></div>'
                                ]);

                                echo $this->Form->radio('standardFilter', [
                                        'newMembers' => __("New members (created after {0})",$newMembersDate),
                                        'pastMembers' => __("Past members (all memberships expired before {0})", $pastMembersDate),
                                        'activeMembers' => __("Currently active members (all memberships active from {0} on)", date('d/m/Y'))
                                ]); ?>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <a href="<?php echo $this->Url->build(['controller' => 'Members', 'action' => 'index']); ?>" class="btn btn-white">
                                    <?= __('Cancel') ?>
                                </a>

                                <button class="btn btn-primary" type="submit">
                                    <?= __('Export') ?>
                                </button>
                            </div>
                        </div>

                    </fieldset>
                    <?php
                        echo $this->Form->end();
                    ?>
                </div>
            </div>

            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?= __('Custom filters') ?></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <?php
                        echo $this->Form->create();
                    ?>

                    <fieldset class="form-horizontal">
                        <div class="col-sm-12">
                            <h3><?= __('By period of active membership') ?></h3>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><?= __('Active from this date on') ?>:</label>
                            <div class="col-sm-10">
                                <?php  echo $this->Form->input('min_date', [
                                    'id' => 'min_date',
                                    'type' => 'date',
                                    'label' => false,
                                    "default" => strtotime(date('Y-m-d') . ' - 30 days'),
                                    "minYear" => date('Y') - 3,
                                    "maxYear" => date('Y') + 60,
                                ]); ?>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <a href="<?php echo $this->Url->build(['controller' => 'Members', 'action' => 'index']); ?>" class="btn btn-white">
                                    <?= __('Cancel') ?>
                                </a>

                                <button class="btn btn-primary" type="submit">
                                    <?= __('Export') ?>
                                </button>
                            </div>
                        </div>

                    </fieldset>
                    <?php
                        echo $this->Form->end();
                    ?>
                </div>
            </div>
        
        </div>
    </div>
</div>