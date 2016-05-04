<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                        <img alt="image" class="img-circle" width="50" height="50"
                             src="<?php echo $this->request->webroot; ?>img/admin.jpeg" />
                    </span>
                    <span class="clear"> 
                        <span class="block m-t-xs"> 
                            <strong class="font-bold" style="color: #fff;">
                                <?php 
                                $session = $this->request->session();
                                echo $session->read('Auth.User.first_name').
                                        ' '.$session->read('Auth.User.last_name'); 
                                ?>
                            </strong>
                    </span> 
                </div>
            </li>
            <li class="<?php echo $this->request->controller == 'Users' ? 'active' : ''; ?>">
                <a href="<?php echo $this->Url->build([
                    'controller' => 'Users',
                    'action' => 'index'
                    ]); ?>">
                    <i class="fa fa-users"></i> 
                    <span class="nav-label"><?= __("Users") ?></span> 
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
                            <?= __("Add New") ?>
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
                            <?= __("Users List") ?>
                        </a>
                    </li>
                </ul>
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
                            <?= __("Import Members") ?>
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
            
        </ul>

    </div>
</nav>