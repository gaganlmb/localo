<?php
include ('job-app.inc');
include ($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');

$openingId = $gWeb->getRequestParam('g_opening_id');
webgloo\common\Util::isEmpty('openingId', $openingId);

$openingDao = new webgloo\job\dao\Opening();
$openingDBRow = $openingDao->getRecordOnId($openingId);
$html = webgloo\job\html\template\Opening::getUserDetail($openingDBRow,false);

echo $html;

?>
