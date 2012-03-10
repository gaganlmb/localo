<!DOCTYPE html>
<html>

    <head>
	    <title> 3mik.com - share and discover shopping items in India  </title>
        <?php include($_SERVER['APP_WEB_DIR'] . '/inc/meta.inc'); ?>
      	   
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

                //show options on hover
                $('.tile .options').hide();
                $('.tile').mouseenter(function() { $(this).find('.options').toggle(); });
                $('.tile').mouseleave(function() { $(this).find('.options').toggle(); }); 

            });
		</script>
		
    </head>

     <body class="dark-body">
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
					<div id="tiles">
						<?php

							$startId = NULL ;
							$endId = NULL ;	

							if(sizeof($questionDBRows) > 0 ) { 
								$startId = $questionDBRows[0]['id'] ;
								$endId =  $questionDBRows[sizeof($questionDBRows)-1]['id'] ;
							}	

							foreach($questionDBRows as $questionDBRow) {
								$html = \com\indigloo\sc\html\Question::getSummary($questionDBRow);
								echo $html ;
						
							}
						?>
						   
					</div><!-- tiles -->

					<?php $paginator->render('/',$startId,$endId);  ?>
                   <div id="feedback" class="vertical">
						<a href="/share/feedback.php">
							Y O U R    
							<br />
							<br />
						    F E E D B A C K 	
						</a>
					</div>	<!-- feedback -->
 
				</div> 
			</div> <!-- row -->
			
			
		</div>  <!-- container -->
              
       
        <div id="ft">
            <?php include($_SERVER['APP_WEB_DIR'] . '/inc/site-footer.inc'); ?>
        </div>

    </body>
</html>
