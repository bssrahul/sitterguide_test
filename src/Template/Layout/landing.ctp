<!DOCTYPE html>
<?php $languageSession = $this->request->session(); ?>
<html lang="<?php echo $languageSession->read('requestedLanguage'); ?>" xml:lang="<?php echo $languageSession->read('requestedLanguage'); ?>">
   <head>
		
		<meta charset="utf-8">
		<meta http-equiv="content-language" content="<?php echo $languageSession->read('requestedLanguage'); ?>" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		
		
		
		<title><?php echo SITE_TITLE; ?></title>
		
		
		<?php echo isset($metaTag)?$metaTag:''; ?>
		<?php 

			echo $this->Html->css(['font/fonts/css/font-awesome.min.css','Front/custom-style.css','Front/owl.carousel.css','Front/lang/'.$languageSession->read('requestedLanguage').'.css','Front/bootstrap.min.css','Front/style.css','Front/developer.css','Front/dist/imageselect.css','Front/hint.css','Front/jquery-ui.css','Front/search-result.css','Front/availabilityCalendar .css']); 
			
			echo $this->Html->script(['Front/jquery.min.js','Front/jquery.validate.js','Front/owl.carousel.min.js','Front/dist/jquery.imgareaselect.js','Front/dist/jquery.form.js','Front/jquery-ui.js','Front/search-filter.js']);
		
			if($sitefavicon != null){ ?>
				<link rel=icon href="<?php echo HTTP_ROOT.'img/uploads/'.$sitefavicon; ?>" type="image/png">
			<?php } else {?>
				<link rel=icon href="<?php echo HTTP_ROOT; ?>img/create_logo.png" type="image/png">
			<?php } ?>

    <!-- Script for jquery UI slider issue resolved on mobile device-->		
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
          
    </head>
    
    <body id="page-top" data-spy="scroll" class="drawer drawer--left">
		<!--[content area Start]-->
		<?php 
			if($this->request->action=="home"){
				echo $this->element('frontElements/guests/how_works_dropdown');
			}			

			$session = $this->request->session();
            $user_session = $session->read('User.id');
			/*ELEMENTS FOR DISPLAY SESSION ERROR AND SUCCESS MSGS */
             echo $this->element('frontElements/common/response_msg');
             if($user_session){
             	 echo $this->element('frontElements/profile/profile_header');
             }else{
			    echo $this->element('frontElements/common/header');	
             }
            echo $this->fetch('content');	
            echo $this->element('frontElements/common/footer');
            echo $this->element('frontElements/common/help_center');
		?>
		<!--[content area end]-->
        <link href='https://fonts.googleapis.com/css?family=Raleway:400,100,100italic,200,200italic,300,300italic,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic' rel='stylesheet' type='text/css'> 
    </body>
    <?php echo $this->element('frontElements/common/reference'); ?>
</html>
