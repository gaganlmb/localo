<?php
    //sc/user/profile/form/edit.php
    
    include 'sc-app.inc';
    include($_SERVER['APP_WEB_DIR'] . '/inc/header.inc');
	include($_SERVER['APP_WEB_DIR'] . '/inc/role/user.inc');


    
    use com\indigloo\ui\form as Form;
    use com\indigloo\Constants as Constants ;
    
    if (isset($_POST['save']) && ($_POST['save'] == 'Save')) {
        
        $fhandler = new Form\Handler('web-form-1', $_POST);
        $fhandler->addRule('first_name', 'First Name', array('required' => 1, 'maxlength' => 32));
        $fhandler->addRule('last_name', 'Last Name', array('required' => 1, 'maxlength' => 32));
        
        $fvalues = $fhandler->getValues();
        $ferrors = $fhandler->getErrors();
    
        
        if ($fhandler->hasErrors()) {
            $locationOnError = '/user/profile/edit.php' ;
            $gWeb->store(Constants::STICKY_MAP, $fvalues);
            $gWeb->store(Constants::FORM_ERRORS,$fhandler->getErrors());
            
            header("location: " . $locationOnError);
            exit(1);
        } else {
			
			if(is_null($gSessionUser)) {
				$gSessionUser = \com\indigloo\auth\User::getUserInSession();
			}
			
            $userDao= new \com\indigloo\sc\dao\user();
			$code = $userDao->update($gSessionUser->id,$fvalues['first_name'], $fvalues['last_name']) ;
            
            if ($code == com\indigloo\mysql\Connection::ACK_OK ) {
                header("location: /user/dashboard.php ");

            }else {
                $message = sprintf("DB Error: (code is %d) please try again!",$code);
                $gWeb->store(Constants::STICKY_MAP, $fvalues);
                $gWeb->store(Constants::FORM_ERRORS,array($message));
                $locationOnError = '/user/profile/edit.php' ;
                header("location: " . $locationOnError);
                exit(1);
            }
            
        }
    }
?>