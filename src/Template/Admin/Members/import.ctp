<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?= __('Import members') ?></h2>
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
                <strong><?php echo __("Import Members"); ?></strong>
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
            <h3><?= __("Import members from a CSV file") ?></h3>
            <?php
                echo $this->Form->create($fileUpload, ['type' => 'file']);
            ?>
            <fieldset class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?= __('Members file to import') ?>:</label>
                    <div class="col-sm-10 relative">
                        <div class="input-group">
                            <span class="input-group-btn">
                                <label class="btn btn-primary btn-file" for="file_name">
                                    <?php  echo $this->Form->input('file_name', [
                                        'id' => 'file_name',
                                        'type' => 'file',
                                        'label' => false,
                                        'class' => 'form-control',
                                        'templates' => [
                                            'inputContainer' => '<div class="input required">{{content}}</div>'
                                        ]
                                    ]); ?>
                                    <?= __("Choose .csv file") ?> 
                                </label>
                            </span>
                            <span class="file-input-label"></span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="description"><?= __('Description') ?> <?= __('(optional)') ?>:</label>
                    <div class="col-sm-10">
                        <?php  echo $this->Form->input('description', [
                            'class' => 'form-control',
                            'label' => false,
                            'placeholder' => __('For example: Members who registered in the event last night')
                        ]); ?>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <a href="<?php echo $this->Url->build(['controller' => 'Members', 'action' => 'index']); ?>" class="btn btn-white">
                            <?= __('Cancel') ?>
                        </a>
                        <button class="btn btn-primary" type="submit"><?= __('Import') ?></button>
                    </div>
                </div>
                
           	</fieldset>
           	<?php
            	echo $this->Form->end();
            ?>
        </div>
    </div>
</div>
