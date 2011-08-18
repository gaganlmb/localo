<?php
include 'job-app.inc';
include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
//check if user has customer admin role or not
include($_SERVER['APP_WEB_DIR'] . '/inc/admin/role.inc');

use webgloo\auth\FormAuthentication;
use webgloo\job\html\Link;
use webgloo\common\Url;

//This method will throw an error
$adminVO = FormAuthentication::getLoggedInAdmin();
$organizationId = $adminVO->organizationId;

$gstatus = $gWeb->getRequestParam('g_status');
if (empty($gstatus)) {
    $gstatus = '*';
}

//all ui status filters
$uifilters = array('*' => 'All', 'A' => 'Active', 'E' => 'Expired', 'S' => 'Suspended', 'C' => 'Closed');

//input sanity check
if (!in_array($gstatus, array_keys($uifilters))) {
    trigger_error('Unknown status filter on UI', E_USER_ERROR);
}


$flinks = array();
foreach ($uifilters as $code => $name) {
    $link = Url::addQueryParameters($_SERVER['REQUEST_URI'], array('g_status' => $code));
    $flinks[$code] = $link;
}

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

    <head><title> <?php echo $adminVO->company; ?> Job Openings</title>


        <meta http-equiv="content-type" content="text/html;" />

        <link rel="stylesheet" type="text/css" href="/css/grids-min.css">
        <link rel="stylesheet" type="text/css" href="/css/jquery/flick/jquery-ui-1.8.14.custom.css">
        <!-- app css here -->
        <link rel="stylesheet" type="text/css" href="/css/main.css">

        <script type="text/javascript" src="/js/jquery-1.6.2.min.js"></script>
        <!-- jquery UI and css -->
        <script type="text/javascript" src="/js/jquery-ui-1.8.14.custom.min.js"></script>
        <script type="text/javascript" src="/js/main.js"></script>
        

    </head>


    <body>
    <?php include($_SERVER['APP_WEB_DIR'] . '/inc/toolbar.inc'); ?>

        <div id="body-wrapper">

            <div id="hd">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/banner.inc'); ?>
            </div>
            <div id="bd">
                <!-- grid DIV -->
                <div class="yui3-g">
                    <div class="yui3-u-5-24">
                    <?php include($_SERVER['APP_WEB_DIR'] . '/inc/left-panel.inc'); ?>

                    </div> <!-- left unit -->


                    <div class="yui3-u-19-24">
                        <div id="main-panel">
                            <h2> Post a job </h2>


                            <p class="help-text">
                                Please fill in the details below and post your job opening.

                            </p>
                            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/form/message.inc'); ?>


                            <div id="form-wrapper">
                                <form id="web-form1" class="web-form" name="web-form1" action="/opening/post/create.php" enctype="multipart/form-data"  method="POST">

                                    <div class="error">    </div>

                                    <table class="form-table">


                                        <tr>
                                            <td class="field"> Bounty<span class="red-label">*</span></td>
                                            <td>
                                                <input type="text" name="bounty" maxlength="6" class="required width-1" title="&gt;&nbsp;Bounty is a required field" value="<?php echo $sticky->get('bounty','10000'); ?>"/>
                                            </td>
                                        </tr>

                                         <tr>
                                            <td> Valid for</td>
                                            <td> <?php echo $comboBox;  ?> </td>
                                        </tr>

                                        <!-- location - fill in with default company location -->
                                        <tr>
                                            <td class="field"> Location<span class="red-label">*</span></td>
                                            <td>
                                                <input type="text" name="location" maxlength="32" class="required width-1" title="&gt;&nbsp;Location is a required field" value="<?php echo $sticky->get('location', 'Bangalore'); ?>"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="field"> Title<span class="red-label">*</span></td>
                                            <td>
                                                <input type="text" name="title" maxlength="100" class="required width-2" title="&gt;&nbsp;Title is a required field" value="<?php echo $sticky->get('title'); ?>"/>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td> &nbsp; </td>
                                            <td>  <span> Must have skills </span> <br> <textarea  name="skill" class="height-1 width-2" cols="50" rows="4" ><?php echo $sticky->get('skill'); ?></textarea> </td>
                                        </tr>

                                        <tr>
                                            <td> &nbsp; </td>
                                            <td><span> Description </span> <br>  <textarea  name="description" class="width-2" cols="50" rows="10" ><?php echo $sticky->get('description'); ?></textarea> </td>
                                        </tr>




                                    </table>



                                    <div class="button-container">
                                        <button type="submit" name="save" value="Save" onclick="this.setAttribute('value','Save');" ><span>Save</span></button>
                                        <button type="button" name="cancel" onClick="javascript:go_back('http://www.test2.com');"><span>Cancel</span></button>
                                    </div>


                                    <!-- hidden fields -->
                                    <input type="hidden" name="organization_id" value="<?php echo $adminVO->organizationId ?>" />
                                    <input type="hidden" name="created_by" value="<?php echo $adminVO->email; ?>" />
                                    <input type="hidden" name="organization_name" value="<?php echo $adminVO->company; ?>" />

                                    <div style="clear: both;"></div>

                                </form>
                            </div> <!-- form wrapper -->


                        </div>
                    </div> <!-- main unit -->
                </div> <!-- GRID -->


            </div> <!-- bd -->



        </div> <!-- body wrapper -->

        <div id="ft">
        <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>

        </div>

    </body>
</html>




