<?php

	$questionDao = new \com\indigloo\sc\dao\Question();
	$questionDBRows = $questionDao->getOnSearchIds($arrayIds) ;

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

       <head><title> 3mik.com - Search Results  </title>
         

		<meta http-equiv="Content-Type" content="text/html"; charset="utf-8">

        <link rel="stylesheet" type="text/css" href="/3p/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="/css/sc.css">
		<script type="text/javascript" src="/3p/jquery/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="/3p/bootstrap/js/bootstrap.js"></script>
		<script type="text/javascript" src="/3p/jquery/masonary/jquery.masonry.min.js"></script>
	    
		
		<script type="text/javascript">
			/* column width = css width + margin */
			$(document).ready(function(){
				var $container = $('#tiles');
				$container.imagesLoaded(function(){
					$container.masonry({
						itemSelector : '.tile'
						
					});
				});
			});
		</script>
		
    </head>

     <body class="">
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
				<div class="span11">
					<div class="page-header">
						<h2> Search Results </h2>
					</div>

					<div id="tiles">
						<?php
							foreach($questionDBRows as $questionDBRow) {
								$html = \com\indigloo\sc\html\Question::getSummary($questionDBRow);
								echo $html ;
						
							}
						?>
						   
					</div><!-- tiles -->

				</div> 
				<div class="span1">
					<!-- sidebar -->
				</div>
			</div>
			
			
		</div>  <!-- container -->
              
       
        <div id="ft">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
        </div>

    </body>
</html>