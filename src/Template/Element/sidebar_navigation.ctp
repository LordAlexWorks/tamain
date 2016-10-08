<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <span class="clear"> 
                        <span class="block m-t-xs"> 
                            <strong class="font-bold" style="color: #fff;">
                                <?php
                                echo $loggedInUser['full_name'];
                                ?>
                            </strong>
                    </span>
                    <br />

                    <?php
                    if (!isset($currentOrganization) || !$currentOrganization): ?>
                        <a class="dropdown-toggle" href="<?php echo $this->Url->build([ 'controller' => 'Organizations', 'action' => 'choose' ]); ?>">
                            <span class="text-muted text-xs block">
                                <?= __('Choose organization') ?>
                                &nbsp; <span class="fa fa-angle-right"></span>
                            </span>
                        </a>
                        <?php
                    else: ?>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-haspopup="true" aria-expanded="false">
                            <span id="organization_name" class="text-muted text-xs block">
                                <?= $currentOrganization->name ?>
                                <b class="caret"></b>
                            </span>
                        </a>

                        <ul class="dropdown-menu animated fadeInRight m-t-xs" aria-labelledby="organization_name">
                            <?php
                            if ($loggedInUser['organizations']->count() > 1):
                                foreach ($loggedInUser['organizations'] as $organization):
                                    if ($organization['id'] == $currentOrganization->id) {
                                        continue;
                                    }
                                    ?>
                                    <li><a href="<?php echo $this->Url->build([ 'controller' => 'Organizations', 'action' => 'choose', $organization['id'] ]); ?>"><?= $organization['name'] ?></a></li>
                                    <?php
                                endforeach;
                                ?>
                                <li class="divider"></li>
                                <?php
                            endif;
                            ?>
                            <li><a href="<?php echo $this->Url->build([ 'controller' => 'Organizations', 'action' => 'index' ]); ?>"><?= __('Manage organizations') ?></a></li>
                        </ul>
                        <?php
                    endif;
                    ?>
                </div>
            </li>
            <li class="<?php echo $this->request->controller == 'Dashboard' ? 'active' : ''; ?>">
                <a href="<?php echo $this->Url->build([
                    'controller' => 'Dashboards',
                    'action' => 'index'
                    ]); ?>">
                    <i class="fa fa-area-chart"></i> 
                    <span class="nav-label"><?= __("Dashboard") ?></span> 
                </a>
            </li>
            <li class="<?php echo $this->request->controller == 'Members' ? 'active' : ''; ?>">
                <a href="<?php echo $this->Url->build([
                    'controller' => 'Members',
                    'action' => 'index'
                    ]); ?>">
                    <i class="fa fa-gears"></i> 
                    <span class="nav-label">Members</span> 
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse
                    <?php echo $this->request->controller == 'Members' ? 'in' : ''; ?>
                    ">
                    <li>
                        <a href="<?php echo $this->Url->build([
                            'controller' => 'Members',
                            'action' => 'add'
                            ]); ?>"
                            class="<?php echo $this->request->controller == 'Members' 
                                    && $this->request->action == 'add'? 'active' : ''; ?>"
                            >
                            <?= __("Add New") ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $this->Url->build([
                            'controller' => 'Members',
                            'action' => 'import'
                            ]); ?>"
                            class="<?php echo $this->request->controller == 'Members' 
                                    && $this->request->action == 'import'? 'active' : ''; ?>"
                            >
                            <?= __("Import") ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $this->Url->build([
                            'controller' => 'Members',
                            'action' => 'filter'
                            ]); ?>"
                            class="<?php echo $this->request->controller == 'Members' 
                                    && $this->request->action == 'filter'? 'active' : ''; ?>"
                            >
                            <?= __("Filter and Export") ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $this->Url->build([
                            'controller' => 'Members',
                            'action' => 'index'
                            ]); ?>"
                            class="<?php echo $this->request->controller == 'Members' 
                                    && $this->request->action == 'index'? 'active' : ''; ?>"
                            >
                            <?= __("Members List") ?>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="<?php echo $this->request->controller == 'Users' ? 'active' : ''; ?>">
                <a href="<?php echo $this->Url->build([
                    'controller' => 'Users',
                    'action' => 'index'
                    ]); ?>">
                    <i class="fa fa-users"></i> 
                    <span class="nav-label"><?= __("Administrator area") ?></span> 
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse
                    <?php echo $this->request->controller == 'Users' ? 'in' : ''; ?>
                    ">
                    <li>
                        <a href="<?php echo $this->Url->build([
                            'controller' => 'Users',
                            'action' => 'add'
                            ]); ?>"
                            class="<?php echo $this->request->controller == 'Users' 
                                    && $this->request->action == 'add'? 'active' : ''; ?>"
                            >
                            <?= __("Add New Admin") ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $this->Url->build([
                            'controller' => 'Users',
                            'action' => 'index'
                            ]); ?>"
                            class="<?php echo $this->request->controller == 'Users' 
                                    && $this->request->action == 'index'? 'active' : ''; ?>"
                            >
                            <?= __("Admin List") ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $this->Url->build([
                            'controller' => 'Organizations',
                            'action' => 'configure-mailchimp'
                            ]); ?>"
                            class="<?php echo $this->request->controller == 'Organizations' 
                                    && $this->request->action == 'configure-mailchimp'? 'active' : ''; ?>"
                            >
                            <?= __("Configure Mailchimp") ?>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>

    </div>
</nav>