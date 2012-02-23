<?php

    //sc/user/dashboard.php
    include ('sc-app.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
    include($_SERVER['APP_WEB_DIR'] . '/inc/role/user.inc');
	
    use com\indigloo\Util as Util;
    use com\indigloo\ui\form\Sticky;
    use com\indigloo\Constants as Constants;
    use com\indigloo\ui\form\Message as FormMessage;
     
    $sticky = new Sticky($gWeb->find(Constants::STICKY_MAP,true));
    
	if(is_null($gSessionUser)) {
		$gSessionUser = \com\indigloo\auth\User::getUserInSession();
	}
	
	$userId = $gSessionUser->id ;
    $userDao = new \com\indigloo\sc\dao\User() ;
	$userDBRow = $userDao->getonId($userId);
	
	$questionDao = new \com\indigloo\sc\dao\Question() ;
	$questionDBRows = $questionDao->getAllOnUserEmail($gSessionUser->email);
	
	$answerDao = new \com\indigloo\sc\dao\Answer() ;
	$answerDBRows = $answerDao->getAllOnUserEmail($gSessionUser->email);
	
	
?>  

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

       <head><title> 3mik.com - page of <?php echo $userDBRow['first_name']; ?>  </title>
    

        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
		<link rel="stylesheet" type="text/css" href="/3p/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="/css/sc.css">
		<script type="text/javascript" src="/3p/jquery/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="/3p/bootstrap/js/bootstrap.js"></script>
		<script>
			$(document).ready(function(){

			});

		</script>

       
    </head>

    <body>
		<div class="container">
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
				<div class="span12">
					<div class="page-header">
						<h2> <?php echo $gSessionUser->firstName; ?> </h2>
					</div>
					<?php echo \com\indigloo\sc\html\User::getProfile($gSessionUser,$userDBRow) ; ?>
				</div>
			</div>

			<div class="row">
				<div class="span9">
					<div class="tabbable mt20">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#post" data-toggle="tab">Posts</a></li>
							<li><a href="#comment" data-toggle="tab">Comments</a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="post">
								<h1>Posts</h1>
								<?php 
									foreach($questionDBRows as $questionDBRow){
										echo \com\indigloo\sc\html\Question::getWidget($questionDBRow);
									}
								?>
								
							</div>
							<div class="tab-pane" id="comment">
								<h1>Comments</h1>
								<?php 
									foreach($answerDBRows as $answerDBRow){
										echo \com\indigloo\sc\html\Answer::getWidget($gSessionUser,$answerDBRow);
									}
								?>

							</div>
						</div>	
					</div> <!-- tab wrapper -->

				</div>
			</div>
		</div> <!-- container -->
		
        <div id="ft">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
        </div>

    </body>
</html>
