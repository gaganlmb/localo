<?php
namespace com\indigloo\sc\controller{


	use \com\indigloo\Util as Util;
    use \com\indigloo\Url;
	use \com\indigloo\Configuration as Config ;
	use \com\indigloo\Constants as Constants;
    use \com\indigloo\ui\form\Message as FormMessage;
    use \com\indigloo\ui\form\Sticky;

 
	
    class Post {
        
        function process($params,$options) {
            $file = $_SERVER['APP_WEB_DIR']. '/view/item.php' ;
            
            if(is_null($params) || empty($params))
                trigger_error("Required params is null or empty", E_USER_ERROR);

			$questionId = Util::getArrayKey($params,"item_id");
			$questionDao = new \com\indigloo\sc\dao\Question();
			$questionDBRow = $questionDao->getOnId($questionId);

			$imagesJson = $questionDBRow['images_json'];
			$images = json_decode($imagesJson);
			
			$linksJson = $questionDBRow['links_json'];
			$links = json_decode($linksJson);

			$answerDao = new \com\indigloo\sc\dao\Answer();
			$answerDBRows = $answerDao->getOnQuestionId($questionId);
			
			$gWeb = \com\indigloo\core\Web::getInstance();
			$sticky = new Sticky($gWeb->find(Constants::STICKY_MAP,true));
			$loginId = NULL ;

			if(is_null($gSessionLogin)) {
				$login = \com\indigloo\sc\auth\Login::tryLoginInSession();
				if(!is_null($login)) {
					$loginId = $login->id ;
				}
			}

			$loginUrl = "/user/login.php?q=".$_SERVER['REQUEST_URI'];
			$formErrors = FormMessage::render(); 
			include($file);
        }
    }
}
?>
