
<!DOCTYPE html>
<html lang="en">
    <!-- START: Head-->
    <head>
        <meta charset="UTF-8">
        <title>Pick Admin</title>
        <link rel="shortcut icon" href="<?php echo base_url('dist/images/favicon.ico'); ?>" />
        <meta name="viewport" content="width=device-width,initial-scale=1"> 

        <!-- START: Template CSS-->
        <link rel="stylesheet" href="<?php echo base_url('dist/vendors/bootstrap/css/bootstrap.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('dist/vendors/jquery-ui/jquery-ui.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('dist/vendors/jquery-ui/jquery-ui.theme.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('dist/vendors/simple-line-icons/css/simple-line-icons.css'); ?>">        
        <link rel="stylesheet" href="<?php echo base_url('dist/vendors/flags-icon/css/flag-icon.min.css'); ?>">         
        <!-- END Template CSS-->


        <!-- START: Page CSS-->  
        <?= $this->renderSection('pagestyles') ?>
        <!-- END: Page CSS-->

        <!-- START: Custom CSS-->
        <link rel="stylesheet" href="<?php echo base_url('dist/css/main.css'); ?>">
        <!-- END: Custom CSS-->
    </head>
    <!-- END Head-->

    <!-- START: Body-->
    <body id="main-container" class="default  <?php echo $layout; ?> <?php echo $color; ?>">

        <!-- START: Pre Loader-->
        <div class="se-pre-con">
            <div class="loader"></div>
        </div>
        <!-- END: Pre Loader-->
       
        <!-- START: Main Content-->
      
                <?= $this->renderSection('content') ?>
    
        <!-- END: Content-->
  
        <script>
            var base_url = "<?= base_url('') ?>";
        </script>
        <!-- START: Template JS-->
        <script src="<?php echo base_url('dist/vendors/jquery/jquery-3.3.1.min.js'); ?>"></script>
        <script src="<?php echo base_url('dist/vendors/jquery-ui/jquery-ui.min.js'); ?>"></script>
        <script src="<?php echo base_url('dist/vendors/moment/moment.js'); ?>"></script>
        <script src="<?php echo base_url('dist/vendors/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>    
        <script src="<?php echo base_url('dist/vendors/slimscroll/jquery.slimscroll.min.js'); ?>"></script>
        <!-- END: Template JS-->


        <!-- START: Page JS-->
        <?= $this->renderSection('pagescript') ?>
        <!-- END: Page JS-->

        <!-- START: APP JS-->
        <script src="<?php echo base_url('dist/js/app.js'); ?>"></script>
        <!-- END: APP JS-->



    </body>
    <!-- END: Body-->
</html>
