<?php

	use com\indigloo\Configuration as Config;

	$answerDao = new \com\indigloo\sc\dao\Answer() ;
		
	$filter = array($answerDao::EMAIL => $gSessionUser->email);
	$total = $answerDao->getTotalCount($filter);

	$pageSize =	Config::getInstance()->get_value("user.page.items");
	$paginator = new \com\indigloo\ui\Pagination($qparams,$total,$pageSize);	
	$answerDBRows = $answerDao->getPaged($paginator,$filter);

?>

<div id="comment">
	<h1>Comments</h1>
	<?php 
		$startId = NULL ;
		$endId = NULL ;

		if(sizeof($answerDBRows) > 0 ) { 
			$startId = $answerDBRows[0]['id'] ;
			$endId =   $answerDBRows[sizeof($answerDBRows)-1]['id'] ;
		}	

		foreach($answerDBRows as $answerDBRow){
			echo \com\indigloo\sc\html\Answer::getWidget($gSessionUser,$answerDBRow);
		}

	?>

</div>

<?php $paginator->render('/user/dashboard.php',$startId,$endId);  ?>
