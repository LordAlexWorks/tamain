<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo $user->isNew() ? __('Add user') : __('Edit user'); ?></h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->Url->build('/admin'); ?>"><?= __('Home') ?></a>
            </li>
            <li class="active">
                <a href="<?php echo $this->Url->build(['controller' => 'Users', 'action' => 'index']); ?>">
                    <?= __('Users') ?>
                </a>
            </li>
            <?php if (!$user->isNew()): ?>
                <li class="active">
                    <strong><?php echo $user->full_name; ?></strong>
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
                    <li class="active"><a data-toggle="tab" href="#tab-1"><?= __('User info') ?></a></li>
                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                             <?= $this->Form->create($user, [
                                 'templates'=>[
                                     'inputContainer' => '{{content}}',
                                     'label' => ''
                                     ]
                             ]) ?>
                            <fieldset class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><?= __('First Name') ?>:</label>
                                    <div class="col-sm-10">
                                        <?php  echo $this->Form->input('first_name', [
                                            'class' => 'form-control'
                                        ]); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><?= __('Last Name') ?>:</label>
                                    <div class="col-sm-10">
                                        <?php  echo $this->Form->input('last_name', [
                                            'class' => 'form-control'
                                        ]); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><?= __('Username') ?>:</label>
                                    <div class="col-sm-10">
                                        <?php  echo $this->Form->input('username', [
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
                                <?php if (!$user->isNew()): ?>
                                    <div class="col-sm-offset-2" style="padding: 5px;">
                                       <span class="help-block m-b-none text-danger">
                                           <?= __('Note: Keep password blank if you do not want to change it') ?>
                                       </span> 
                                    </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><?= __('Password') ?>:</label>
                                    <div class="col-sm-10">
                                        <?php  echo $this->Form->input('password', [
                                            'class' => 'form-control',
                                            'type' => 'password',
                                            'value' => '',
                                            'autocomplete' => 'off'
                                        ]); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><?= __('Confirm Password') ?>:</label>
                                    <div class="col-sm-10">
                                        <?php  echo $this->Form->input('confirm_password', [
                                            'class' => 'form-control',
                                            'type' => 'password',
                                            'value' => '',
                                            'autocomplete' => 'off'
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