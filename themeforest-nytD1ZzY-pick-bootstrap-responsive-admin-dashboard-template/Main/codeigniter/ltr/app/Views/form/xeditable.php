<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- START: Breadcrumbs-->
<div class="row ">
    <div class="col-12  align-self-center">
        <div class="sub-header mt-3 py-3  align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">Form X-Editable</h4></div>

            <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Form</li>
                <li class="breadcrumb-item active"><a href="#">X-Editable</a></li>
            </ol>
        </div>
    </div>
</div>
<!-- END: Breadcrumbs-->

<!-- START: Card Data-->
<div class="row">
    <div class="col-12 mt-3">
        <div class="card">

            <div class="card-body">
                <table id="user" class="table table-bordered table-striped" style="clear: both">
                    <tbody> 
                        <tr>         
                            <td class="w-50">Simple text field</td>
                            <td class="w-50"><a href="#" id="username" data-type="text" data-pk="1" data-title="Enter username">superuser</a></td>
                        </tr>
                        <tr>         
                            <td>Empty text field, required</td>
                            <td><a href="#" id="firstname" data-type="text" data-pk="1" data-placement="right" data-placeholder="Required" data-title="Enter your firstname"></a></td>
                        </tr>  
                        <tr>         
                            <td>Select, local array, custom display</td>
                            <td><a href="#" id="sex" data-type="select" data-pk="1" data-value="" data-title="Select sex"></a></td>
                        </tr>
                        <tr>         
                            <td>Select, remote array, no buttons</td>
                            <td><a href="#" id="group" data-type="select" data-pk="1" data-value="" data-title="Select group">Admin</a></td>
                        </tr> 
                        <tr>         
                            <td>Select, error while loading</td>
                            <td><a href="#" id="status" data-type="select" data-pk="1" data-value=""  data-title="Select status">Active</a></td>
                        </tr> 


                        <tr>         
                            <td>Combodate (date)</td>
                            <td><a href="#" id="dob" data-type="combodate" data-value="1984-05-15" data-format="YYYY-MM-DD" data-viewformat="DD/MM/YYYY" data-template="D / MMM / YYYY" data-pk="1"  data-title="Select Date of birth"></a></td>
                        </tr> 
                        <tr>         
                            <td>Combodate (datetime)</td>
                            <td><a href="#" id="event" data-type="combodate" data-template="D MMM YYYY  HH:mm" data-format="YYYY-MM-DD HH:mm" data-viewformat="MMM D, YYYY, HH:mm" data-pk="1"  data-title="Setup event date and time"></a></td>
                        </tr> 



                        <tr>         
                            <td>Textarea, buttons below. Submit by <i>ctrl+enter</i></td>
                            <td><a href="#" id="comments" data-type="textarea" data-pk="1" data-placeholder="Your comments here..." data-title="Enter comments">awesome user!</a></td>
                        </tr> 

                        <tr>         
                            <td>Checklist</td>
                            <td><a href="#" id="fruits" data-type="checklist" data-value="2,3" data-title="Select fruits"></a></td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div> 

    </div>
</div>
<!-- END: Card DATA-->
<?= $this->endSection() ?>

<?= $this->section('pagestyles') ?>
<!-- START: Page CSS-->
<link rel="stylesheet"  href="<?php echo base_url('dist/vendors/x-editable/css/bootstrap-editable.css'); ?>">
<!-- END: Page CSS-->
<?= $this->endSection() ?>

<?= $this->section('pagescript') ?>
<!-- START: Page JS-->
<script src="<?php echo base_url('dist/vendors/x-editable/js/bootstrap-editable.min.js'); ?>"></script>
<script src="<?php echo base_url('dist/js/xeditable.script.js'); ?>"></script>
<!-- END: Page JS-->
<?= $this->endSection() ?>

