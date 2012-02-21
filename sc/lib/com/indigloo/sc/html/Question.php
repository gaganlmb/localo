<?php

namespace com\indigloo\sc\html {

    use com\indigloo\Template as Template;
    use com\indigloo\Util as Util ;
    
    class Question {
        
		static function getLinkView($questionDBRow) {
			$html = NULL ;
			
			$view = new \stdClass;
			$view->id = $questionDBRow['id'] ;
			$view->title = $questionDBRow['title'] ;
			$view->createdOn = Util::formatDBTime($questionDBRow['created_on']);
			
			$template = $_SERVER['APP_WEB_DIR'].'/fragments/question/link-view.tmpl' ;
			$html = Template::render($template,$view);
			return $html ;
			
		}
		
		static function getEditBar($sessionUser,$questionDBRow) {
			
			$html = NULL ;
			
			if(is_null($sessionUser) ||  ($sessionUser->email != $questionDBRow['user_email'])) {
				return '' ;
			}
			
			$template = $_SERVER['APP_WEB_DIR'].'/fragments/question/edit-bar.tmpl' ;
			$view = new \stdClass;
			$view->id = $questionDBRow['id'];
			
			$html = Template::render($template,$view);
			return $html ;
						
		}
		
        static function getSummary($questionDBRow) {
           
		    $html = NULL ;
			$imagesJson = $questionDBRow['images_json'];
			$images = json_decode($imagesJson);
			
			$view = new \stdClass;
			$view->title = $questionDBRow['title'];
			$view->summary = $questionDBRow['description'];
			$view->id = $questionDBRow['id'];
			
				
			$view->userName = $questionDBRow['user_name'];
			$view->createdOn = Util::formatDBTime($questionDBRow['created_on']);
			$view->tags = $questionDBRow['tags'];
			
			$view->border = 'bbd5' ;

				
			if(sizeof($images) > 0) {
				
				$template = $_SERVER['APP_WEB_DIR'].'/fragments/tile/image.tmpl' ;
				
				/* image stuff */
				$image = $images[0] ;
				
				$view->originalName = $image->originalName;
				$view->bucket = $image->bucket;
				$view->storedName = $image->storeName;
				
				$newxy = Util::foldX($image->width,$image->height,200);
				
				$view->width = $newxy["width"];
				$view->height = $newxy["height"];
				
				/* image stuff end */
				$html = Template::render($template,$view);
				
			} else {
				
				$template = $_SERVER['APP_WEB_DIR'].'/fragments/tile/text.tmpl' ;
				$html = Template::render($template,$view);
			}
			
            return $html ;
			
        }
        
    }
    
}

?>
