<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->fetch('meta') ?>
    
    <?= $this->Html->css(['bootstrap.min']) ?>
    <?= $this->fetch('pluginCss') ?>
    <?= $this->Html->css(['animate', 'style', 'custom']) ?>
    <?= $this->fetch('css') ?>
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
</head>
<body>
    <div id="wrapper">
        <?php echo $this->element('sidebar_navigation'); ?>
        <div id="page-wrapper" class="gray-bg">
            <?php echo $this->element('header_navigation'); ?>
            <?= $this->fetch('content') ?>
            <!--Footer-->
            <div class="footer">
                <div class="pull-right">
                </div>
                <div>
                    <strong>Copyright</strong> Tamarin &copy; <?php echo date('Y'); ?>
                </div>
            </div>
        </div>
    </div>
    
     <?= $this->Html->script([
         'jquery-2.1.1', 
         'bootstrap.min.js',
         'plugins/metisMenu/jquery.metisMenu',
         'plugins/slimscroll/jquery.slimscroll.min',
         'plugins/validate/jquery.validate.min',
         'inspinia',
         'custom'
         ]); ?>
    <?= $this->fetch('pluginJs') ?>
    <?= $this->fetch('scriptBottom') ?>
    <script>
        jQuery(document).ready(function($) {
            if ($('table.table-stripped').length){
               $("table.table-stripped tbody tr:odd").css({backgroundColor: '#f7f7f7'}); 
            }
        });
    </script>
</body>

</html>
