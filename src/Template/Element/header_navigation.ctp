<div class="row border-bottom">
    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li>
                <h2 class="m-r-sm welcome-message"><?= __("Welcome to Girlz in Web's Admin Panel") ?></h2>
            </li>
            <li>
                <a href="<?php echo $this->Url->build([
                        'controller' => 'Users', 'action' => 'logout']);
                    ?>">
                    <i class="fa fa-sign-out"></i> Log out
                </a>
            </li>
        </ul>

    </nav>
</div>