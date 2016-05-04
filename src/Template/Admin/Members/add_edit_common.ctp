<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo $member->isNew() ? __('Add member') : __('Edit member'); ?></h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->Url->build('/admin'); ?>"><?= __('Home') ?></a>
            </li>
            <li class="active">
                <a href="<?php echo $this->Url->build(['controller' => 'Members', 'action' => 'index']); ?>">
                    <?= __('Members') ?>
                </a>
            </li>
            <?php if (!$member->isNew()): ?>
                <li class="active">
                    <strong><?php echo $member->full_name; ?></strong>
                </li>
            <?php else: ?>
                <li class="active">
                    <strong><?php echo __('New'); ?></strong>
                </li>
            <?php endif; ?>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>
<?php echo $this->Flash->render(); ?>
<?php echo $this->Flash->render('auth'); ?>
<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab-1"><?= __('Member info') ?></a></li>
                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                             <?= $this->Form->create($member, [
                                 'templates'=>[
                                     'inputContainer' => '{{content}}',
                                     'label' => ''
                                     ]
                             ]) ?>
                            <fieldset class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><?= __('First Name') ?>:</label>
                                    <div class="col-sm-10">
                                        <?php  echo $this->Form->input('firstname', [
                                            'class' => 'form-control'
                                        ]); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><?= __('Last Name') ?>:</label>
                                    <div class="col-sm-10">
                                        <?php  echo $this->Form->input('lastname', [
                                            'class' => 'form-control'
                                        ]); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><?= __('Email') ?>:</label>
                                    <div class="col-sm-10">
                                        <?php  echo $this->Form->input('email', [
                                            'class' => 'form-control',
                                            'type' => 'email'
                                        ]); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><?= __('Birthdate') ?>:</label>
                                    <div class="col-sm-10">
                                        <?php  echo $this->Form->input('birthdate', [
                                            'minYear' => date('Y') - 70,
                                            'maxYear' => date('Y') - 10,
                                        ]); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><?= __('Job') ?>:</label>
                                    <div class="col-sm-10">
                                        <?php  echo $this->Form->input('job', [
                                            'class' => 'form-control'
                                        ]); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><?= __('Company') ?>:</label>
                                    <div class="col-sm-10">
                                        <?php  echo $this->Form->input('company', [
                                            'class' => 'form-control'
                                        ]); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><?= __('Twitter') ?>:</label>
                                    <div class="col-sm-10">
                                        <?php  echo $this->Form->input('twitter', [
                                            'class' => 'form-control'
                                        ]); ?>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><?= __('Status') ?>:</label>
                                    <div class="col-sm-4">
                                        <?php  echo $this->Form->input('active', [
                                            'class' => 'form-control',
                                            'type' => 'select',
                                            'default' => 1,
                                            'options' => [0 => __('Inactive'), 1 => __('Active')]
                                        ]); ?>
                                    </div>
                                </div>

                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a href="<?php echo $this->Url->build(['controller' => 'Users', 'action' => 'index']); ?>" class="btn btn-white">
                                            <?= __('Cancel') ?>
                                        </a>
                                        <button class="btn btn-primary" type="submit"><?= __('Save') ?></button>
                                    </div>
                                </div>
                            </fieldset>
                            <?php echo $this->Form->end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>