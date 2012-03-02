<?php

    include ('sc-app.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/role/user.inc');

	use \com\indigloo\Url as Url ;
	use \com\indigloo\Logger as Logger ;
	use \com\indigloo\sc\auth\Login as Login ;

	$qUrl = Url::tryQueryParam('q');
	$qUrl = empty($qUrl) ? '/user/dashboard.php' : $qUrl;

	$answerId = Url::getQueryParam("id");
	$answerDao = new \com\indigloo\sc\dao\Answer();
	$answerDBRow = $answerDao->getOnId($answerId);

	if(!Login::isOwner($answerDBRow['login_id'])) {
		header("location : /qa/noowner.php");
		exit ;
	}

?>  

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

       <head><title>3mik.com - Delete a comment</title>
         

        <meta http-equiv="content-type" content="text/html"; charset="utf-8" />

		<link rel="stylesheet" type="text/css" href="/3p/bootstrap/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="/css/sc.css">
		
		<script type="text/javascript" src="/3p/jquery/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="/3p/bootstrap/js/bootstrap.js"></script>
		 
    </head>

    <body>
		<div class="container mh800">
			<div class="row">
				<div class="span12">
					<?php include($_SERVER['APP_WEB_DIR'] . '/inc/toolbar.inc'); ?>
				</div> 
				
			</div>
			
			<div class="row">
				<div class="span12">
					<?php include($_SERVER['APP_WEB_DIR'] . '/inc/banner.inc'); ?>
				</div>
			</div>
			
			
			<div class="row">
				<div class="span9">
					
					
					<div class="page-header">
						<h2> Delete Comment</h2>
					</div>
					<div class="alert">
					  <a class="close" data-dismiss="alert">×</a>
					  Please make sure that you really want to delete this comment.
					</div>
					
					<?php echo \com\indigloo\sc\html\Answer::getWidget(NULL,$answerDBRow); ?>
					
					<div>
					    <a class="btn btn-danger" href="/qa/form/delete.php">I am sure, Delete </a>
						<a class="btn" href="<?php echo $qUrl; ?>">Cancel</a>
					</div>

				</div>
			</div>
		</div> <!-- container -->

        <div id="ft">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
        </div>

    </body>
</html>