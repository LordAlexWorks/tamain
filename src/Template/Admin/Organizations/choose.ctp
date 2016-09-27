<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?= __('Choose organization') ?></h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->Url->build('/admin'); ?>"><?= __('Home') ?></a>
            </li>
            <li class="active">
                <a href="<?php echo $this->Url->build(['controller' => 'Organizations', 'action' => 'index']); ?>">
                    <?= __('Organizations') ?>
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
        <div class="col-lg-12 text-center">
            <form method="post">
                <?php
                foreach ($loggedInUser['organizations'] as $organization): ?>

                    <a href="<?php echo $this->Url->build(['controller' => 'Organizations', 'action' => 'choose', $organization['id']]); ?>" class="btn btn-info btn-lg">
                        <?= $organization['name'] ?>
                    </a>
                    <br /><br />
                    <?php
                endforeach;
                ?>
            </form>

            <?php
            if (count($loggedInUser['organizations']) < 1):
                echo '<p>' . __('Currently, you are not the administrator of any organizations.') . '</p>';
            endif;
            ?>

            <br />

            <a href="<?php echo $this->Url->build(['controller' => 'Organizations', 'action' => 'add']); ?>"
                class="btn btn-primary">
                <?= __('Create new organization') ?>
            </a>
        </div>
    </div>
</div>