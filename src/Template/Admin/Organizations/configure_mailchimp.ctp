<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?= __('Configure Mailchimp') ?></h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->Url->build('/admin'); ?>"><?= __('Home') ?></a>
            </li>
            <li class="active">
                <a href="<?php echo $this->Url->build(['controller' => 'Organizations', 'action' => 'configure-mailchimp']); ?>">
                    <?= __('Configure Mailchimp') ?>
                </a>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>
<?php echo $this->Flash->render(); ?>
<?php echo $this->Flash->render('auth'); ?>

<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?= __("Mailchimp settings") ?></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="alert alert-warning" role="alert">
                        <p><?= __('Please fill in the information below to use Mailchimp in your Organization.') ?></p>
                        <p><?= __('Attention: these settings are global for this organization, not for each administrator. That is, the changes you make will affect the entire organization "{0}".', $currentOrganization['name']) ?></p>
                    </div>

                    <?= $this->Form->create($organization, [
                         'templates'=>[
                             'inputContainer' => '{{content}}',
                             'label' => ''
                             ]
                    ]) ?>
                    <fieldset class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><?= __('Mailchimp API key') ?>:</label>
                            <div class="col-sm-10">
                                <?php  echo $this->Form->input('mailchimp_api_key', [
                                    'class' => 'form-control'
                                ]); ?>
                            </div>
                            <div class="col-sm-offset-2 col-sm-12" style="padding: 12px;">
                               <span class="help-block m-b-none text-danger">
                                   <a href="http://kb.mailchimp.com/integrations/api-integrations/about-api-keys" target="_blank"><?= __('Follow these instructions to obtain your API Key and come back here to fill it in.') ?></a>
                               </span> 
                            </div>
                        </div>
                        <br />
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><?= __('Mailchimp List ID') ?>:</label>
                            <div class="col-sm-10">
                                <?php  echo $this->Form->input('mailchimp_active_members_list', [
                                    'class' => 'form-control'
                                ]); ?>
                            </div>
                            <div class="col-sm-offset-2 col-sm-12" style="padding: 12px;">
                               <span class="help-block m-b-none text-danger">
                                   <a href="http://kb.mailchimp.com/lists/managing-subscribers/find-your-list-id" target="_blank"><?= __('Follow these instructions to obtain your List ID and come back here to fill it in.') ?></a>
                               </span> 
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <a href="<?php echo $this->Url->build(['controller' => 'Dashboards', 'action' => 'index']); ?>" class="btn btn-white">
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