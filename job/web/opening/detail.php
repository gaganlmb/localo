<?php
include ('job-app.inc');
include ($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');

$openingId = $gWeb->getRequestParam('g_opening_id');
webgloo\common\Util::isEmpty('openingId', $openingId);

$organizationId = $gWeb->getRequestParam('g_org_id');
webgloo\common\Util::isEmpty('$organizationId', $organizationId);


$openingDao = new webgloo\job\dao\Opening();
$openingDBRow = $openingDao->getRecordOnId($openingId);
?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

    <head><title> <?php echo $openingDBRow['title']; ?> </title>


        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

        <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.3.0/build/cssgrids/grids-min.css">
        <!-- app css here -->
        <link rel="stylesheet" type="text/css" href="/css/main.css"/>

        <!-- include any javascript here -->


    </head>


    <body>

        <?php include($_SERVER['APP_WEB_DIR'] . '/inc/toolbar.inc') ?>

        <div id="body-wrapper">

            <div id="hd">
                <?php include($_SERVER['APP_WEB_DIR'] . '/inc/banner.inc') ?>
            </div>
            <div id="bd">
                <!-- grid DIV -->
                <div class="yui3-g">
                    <div class="yui3-u-5-24">
                        <?php include($_SERVER['APP_WEB_DIR'] . '/inc/left-panel.inc') ?>
                    </div> <!-- left unit -->

                    <div class="yui3-u-19-24">
                        <div id="main-panel">
                            <!-- include opening details -->
                            <?php
                            $html = '' ;
                            if(\webgloo\auth\FormAuthentication::tryAdminRole()){
                                $html = webgloo\job\html\template\Opening::getOrganizationDetail($openingDBRow);
                            } else {
                                $html = webgloo\job\html\template\Opening::getUserDetail($openingDBRow);
                            }
                            echo $html;
                            ?>
                        </div>

                    </div> <!-- main unit -->
                </div> <!-- GRID -->


            </div> <!-- bd -->



        </div> <!-- body wrapper -->

        <div id="ft">

           <?php include($_SERVER['APP_WEB_DIR'].'/inc/site-footer.inc') ?>


        </div>

    </body>
</html>




