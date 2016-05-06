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
                    <li><a data-toggle="tab" href="#tab-2"><?= __('Membership') ?></a></li>
                </ul>
                <div class="tab-content">
                    <?= $this->Form->create($member, [
                         'templates'=>[
                             'inputContainer' => '{{content}}',
                             'label' => ''
                             ]
                     ]) ?>

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
                                        <a href="<?php echo $this->Url->build(['controller' => 'Members', 'action' => 'index']); ?>" class="btn btn-white">
                                            <?= __('Cancel') ?>
                                        </a>
                                        <button class="btn btn-primary" type="submit"><?= __('Save') ?></button>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>

                    <div id="tab-2" class="tab-pane hide">
                        <div class="panel-body">
                             
                            <fieldset class="form-horizontal">
                                <div id="groupMembership">
                                    <?php
                                        // $default_date = Time::now();
                                        // $default_date->addYear(1);

                                        $input_options = [
                                            "minYear" => date('Y') - 3,
                                            "maxYear" => date('Y') + 60,
                                            "default" => strtotime(date('d/m/Y') . ' + 1 year'),
                                            "day"=> [
                                                "class" => "form-control"
                                            ],"month"=> [
                                                "class" => "form-control"
                                            ],"year"=> [
                                                "class" => "form-control"
                                            ],"hour"=> [
                                                "class" => "form-control"
                                            ],"minute"=> [
                                                "class" => "form-control"
                                            ]
                                        ];
                                    ?>
                                    
                                    <?php
                                    $num_memberships = count($member->memberships);

                                    // FIRST MEMBERSHIP
                                    if ($num_memberships < 1) { ?>
                                        <div class="alert alert-warning">
                                            <?= __('Note: Default membership (below) is for 1 year from today, but you can change it to any other date.') ?>
                                        </div>
                                        <div id="new-membership-field">
                                            <div class="col-sm-12">
                                                <h3><?= __('New membership') ?></h3>
                                            </div>

                                            <div class="form-group form-inline">
                                                <label class="col-sm-2 control-label"><?= __('Expires on') ?>:</label>
                                                <div class="col-sm-10">
                                                    <?php  echo $this->Form->input("memberships.0.expires_on", $input_options); ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }

                                    // EXISTING MEMBERSHIPS
                                    for ($i = 0; $i < $num_memberships; $i++): ?>
                                        <div class="membership-form">
                                            <div class="col-sm-12">
                                                <h3><?= __('Membership #{0, number}', $member->memberships[$i]->id) ?></h3>
                                                <?php echo $this->Form->input("memberships.$i.id", [
                                                    "type" => "hidden",
                                                    "value" => $member->memberships[$i]->id
                                                ]); ?>
                                            </div>

                                            <div class="form-group form-inline">
                                                <label class="col-sm-2 control-label"><?= __('Expires on') ?>:</label>
                                                <div class="col-sm-10">
                                                    <?php  echo $this->Form->input("memberships.$i.expires_on", $input_options); ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    endfor;
                                    ?>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button id="btnAddMembership" class="btn btn-secondary" data-member="<?= $member->id ?>">
                                            <?= __('Add membership') ?>
                                        </button>
                                    </div>
                                </div>

                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a href="<?php echo $this->Url->build(['controller' => 'Members', 'action' => 'index']); ?>" class="btn btn-white">
                                            <?= __('Cancel') ?>
                                        </a>
                                        <button class="btn btn-primary" type="submit"><?= __('Save') ?></button>
                                    </div>
                                </div>
                                
                            </fieldset>
                            
                        </div>
                    </div>

                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->start('pluginJs'); ?>
    <?php echo $this->Html->script([
        // 'plugins/momentjs/moment-with-locales',
        // 'plugins/datetimepicker/bootstrap-datetimepicker',
    ]); ?>
<?php $this->end(); ?>

<?php $this->start('scriptBottom'); ?>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            // Duplicate field to add membership
            $('#btnAddMembership').click(function(e){
                e.preventDefault();

                var memberId = $(this).data("member");

                // Clone form
                $new_form = $('.membership-form').last().clone();

                // Change title
                $new_form.find("h3").text("New membership");

                // Remove membership parameter from existing memberships
                // So that it's not overwritten by this new field
                $new_form.find("select").attr("name", function( i, val ) {
                    return val.replace(/[0-9]+/g, function(m) {
                        return parseInt(m) + 1;
                    });
                });
                
                $new_form.appendTo("#groupMembership").removeClass("hide");
                return false;
            });

            // Switch tabs
            $('.nav-tabs a').on("click",function(){
                var $tab = $($(this).attr("href"));

                if ($tab) {
                    $('.nav-tabs li').removeClass("active");
                    $(this).parent("li").addClass("active");

                    $('.tab-pane').removeClass("active").addClass("hide");
                    $tab.removeClass("hide").addClass("active");
                }
            });

            // Datepicker
            // $('.datepicker').datetimepicker();
        });
    </script>
<?php $this->end(); ?>