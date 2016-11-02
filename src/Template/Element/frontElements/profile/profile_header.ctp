<!--[Header Area Start]-->
<?php 
echo $this->Html->script(['Front/messages.js']); ?>
<header class="smaller">
<div class="head-wrap">
<div class="container-fluid">
  <div class="row">
      <div class="col-lg-5 col-md-4 col-sm-12 col-xs-12">   
      	<div class="new-mob-area">      
      <!--Logo Area-->
          <div class="logo-area">
                          <div class="desk-logo">
                             <?php if($sitelogo != null){?>
                              <a href="<?php echo HTTP_ROOT; ?>" title="Sitter Guide"><img src="<?php echo HTTP_ROOT; ?>img/uploads/<?php echo $sitelogo;?>"  alt="<?php echo $this->requestAction('app/get-translate/'.base64_encode('Sitter Guide')); ?>"></a>
								<?php }else{?>
								 <a href="<?php echo HTTP_ROOT; ?>" title="Sitter Guide"><img src="<?php echo HTTP_ROOT; ?>img/logo.jpg"  alt="<?php echo $this->requestAction('app/get-translate/'.base64_encode('Sitter Guide')); ?>"></a>
								<?php } ?>
							</div>
                          <div class="mob-logo">
                              <a class="logo" href="<?php echo HTTP_ROOT; ?>" title="<?php echo $this->requestAction('app/get-translate/'.base64_encode('Sitter Guide'));?>"><img src="<?php echo HTTP_ROOT; ?>img/create_logo.png"  alt="<?php echo $this->requestAction('app/get-translate/'.base64_encode('Sitter Guide')); ?>"></a>
                            </div>                                
                        </div>                        
         <!--Logo End--> 
             <div class="top-search">
				<div class="search-box">
					<?php echo $this->element('frontElements/Search/header_search_form'); ?>
				</div>
              </div> 
              
                <!--- New Toggle for mobile device Start --> 
                  <!--- New Toggle for mobile device End --> 
              <?php // echo $this->element('frontElements/common/mob_language_switcher'); ?>              
              <div id="new-nav">
                   <img src="http://betasoftdev.com/sitterguide_test/img/toggle-nav.png" id="changer" onclick="changeImage(this)"> 
              </div>
              <div id="nav-inner" data-toggle="dropdown">
              	     <?php 
                        $cont = $this->request->params['controller'];
                        $act = $this->request->params['action'];
                 if(($cont != 'Guests') || ($cont != 'guests' && $act != 'home')){
               
                  ?>                
                <?php } ?>
              	<?php 
                       $session = $this->request->session(); 
    	               $user = $session->read('User');
				       $calendar_limits =$session->read('calendar_limits','yes');
                       $user_type = $session->read('User.user_type');
					?>
                  <ul class="nav navbar-nav">
                      <!--  <li class="active">
						   <a href="#"> <?php echo $this->requestAction('app/get-translate/'.base64_encode('Get Free Sitting or Minding')); ?></a>
                       </li>                                
                        -->
                        <?php
                        if($user_type == 'Basic'){ ?>
                        <li class="select"> 
                                                
                              <a  href="<?php echo HTTP_ROOT.'become-a-sitter' ;?>"><?php echo $this->requestAction('app/get-translate/'.base64_encode('Become a sitter')); ?></a>
                        </li>
                        <?php } ?> 
                       <li  class="dropdown">
						   <a  id="droplog3" href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->requestAction('app/get-translate/'.base64_encode('Profile')); ?>	<i class="fa fa-caret-down" aria-hidden="true"></i>
	   </a>
						
						<div class="dropdown-menu currency-drop drop-profile" id="dropcont3">                                       
							  <ul class="c-list c-list-2">  
								
								<li>
									<a href="<?php echo HTTP_ROOT.'dashboard/front-dashboard'; ?>">
										<span><img src="<?php echo HTTP_ROOT.'img/uploads/'.($user['image'] != ''?$user['image']:'prof_photo.png');?>" alt="" class="img-circle_pre">  
										</span>
										<span class="pro-txt">
										<?php echo $user['name']; ?>
										</span>
									</a>
								</li>
								<li>
								  <a href="<?php echo HTTP_ROOT.'dashboard/dashboard-details'; ?>"><i class="fa fa-dashboard"></i> <?php echo $this->requestAction('app/get-translate/'.base64_encode('Dashboard')); ?></a>
								</li>
								
								<li>
									<a href="<?php echo HTTP_ROOT.'tracker'; ?>"><i class="fa fa-question-circle"></i> <?php echo $this->requestAction('app/get-translate/'.base64_encode('Tracker')); ?></a>
								</li>
								
								<li>
									<a href="<?php echo HTTP_ROOT.'Message/get-messages' ?>"><i class="fa fa-envelope"></i> <?php echo $this->requestAction('app/get-translate/'.base64_encode('Inbox & Bookings')); ?></a>
								</li>

	
							 
                              <?php
                              
							  if($user_type == 'Sitter'){ ?>

								<li>
									<a href="<?php echo HTTP_ROOT.'dashboard/calendar' ?>"><i class="fa fa-calendar"></i> <?php echo $this->requestAction('app/get-translate/'.base64_encode('Calendar')); ?></a>
								</li>

								<?php } ?>

								
								
								<li>
									<a href="<?php echo HTTP_ROOT ;?>guests/logout"><i class="fa fa-power-off"></i> <?php echo $this->requestAction('app/get-translate/'.base64_encode('Logout')); ?></a>
								</li>
												
							</ul>
                         </div>
                      </li>
                       <!--MESSAGE LI START -->
                     <li  class="dropdown">
						  <a  id="droplog3" href="<?php echo HTTP_ROOT.'Message/get-messages/pending'; ?>" > <?php echo $this->requestAction('app/get-translate/'.base64_encode('Message')); ?>   <!--class="dropdown-toggle" data-toggle="dropdown"--> 
							<span class="badge myNewCount"></span>
						  </a>
						</a>
						<!--<div class="dropdown-menu currency-drop drop-profile message-width  hidden-xs " id="dropcont3">
						  <ul id="myNewMsgs" class="c-list c-list-2">
						  
						  </ul>
						</div>-->
						</li>  <!--MESSAGE LI CLOSED -->

                      
                      <li><a href="<?php echo HTTP_ROOT.'help'; ?>"> <?php echo $this->requestAction('app/get-translate/'.base64_encode('Help')); ?> <i class="fa fa-question-circle" aria-hidden="true"></i> </a></li>
                                  
                      <li class="dd-country last-drop">
						  <a href="#"  data-toggle="dropdown">
                           <img src="<?php echo HTTP_ROOT.'img/flags/'.$currentLocal.'.png' ;?>" alt=""> <span class="lang-txt"><?php echo ucwords($currentLocal); ?></span> </a>
							<?php echo $this->element('frontElements/common/language_switcher'); ?>
                       </li>
                  </ul> 
                
              </div>
               <!--Dashboard drawee button Start-->
         <?php 
				$cont = $this->request->params['controller'];
				$act = $this->request->params['action'];
		 if((strtolower($cont) != 'guests') || (strtolower($cont) != 'guests' && strtolower($act) != 'home')){
	   
		  ?>
		<button type="button" class="navbar-toggle navbar-toggle-sidebar collapsed" style="float:left"> <?php echo $this->requestAction('app/get-translate/'.base64_encode('&nbsp')); ?> </button>
		<?php } ?>
        <!--Dashboard drawee button End-->            
        </div>
        </div>
        <!--/Mobile country Dropdown-->
        
     
        
        <div class="col-lg-7 col-md-8 col-sm-12 col-xs-12 desk-nav">
          <div class="topnav-area">
            <nav class="navbar">
              <div class="navbar-header">
          
                
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
              </div>
              
              <div class="collapse navbar-collapse" id="myNavbar">
                 <ul class="nav navbar-nav">
                       <!-- <li class="active">
						   <a href="#"> <?php echo $this->requestAction('app/get-translate/'.base64_encode('Get Free Sitting or Minding')); ?></a>
                       </li>    -->                             
                    <?php  if($user_type == 'Basic'){ ?>
                        <li class="select"> 
                                                
                              <a  href="<?php echo HTTP_ROOT.'become-a-sitter' ;?>"><?php echo $this->requestAction('app/get-translate/'.base64_encode('Become a sitter')); ?></a>
                        </li>
                        <?php } ?> 
                       <li  class="dropdown">
						   <a  id="droplog3" href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->requestAction('app/get-translate/'.base64_encode('Profile')); ?> <i class="fa fa-caret-down" aria-hidden="true"></i>

						   </a>
						
						<div class="dropdown-menu currency-drop drop-profile" id="dropcont3">                                       
							  <ul class="c-list c-list-2">  
								
								<li>
									<a href="<?php echo HTTP_ROOT.'dashboard/front-dashboard'; ?>">
										<span><img src="<?php echo HTTP_ROOT.'img/uploads/'.($user['image'] != ''?$user['image']:'prof_photo.png');?>" alt="" class="img-circle_pre">  
										</span>
										<span class="pro-txt">
										<?php echo $user['name']; ?>
										</span>
									</a>
								</li>
								<li>
								  <a href="<?php echo HTTP_ROOT.'dashboard/dashboard-details'; ?>"><i class="fa fa-dashboard"></i> <?php echo $this->requestAction('app/get-translate/'.base64_encode('Dashboard')); ?></a>
								</li>
								
								<li>
									<a href="<?php echo HTTP_ROOT.'tracker'; ?>"><i class="fa fa-question-circle"></i> <?php echo $this->requestAction('app/get-translate/'.base64_encode('Tracker')); ?></a>
								</li>
								
								<li>
									<a href="<?php echo HTTP_ROOT.'Message/get-messages' ?>"><i class="fa fa-envelope"></i> <?php echo $this->requestAction('app/get-translate/'.base64_encode('Inbox & Bookings')); ?></a>
								</li>

	
							  <?php 
							  $session=$this->request->session();
							  $calendar_limits =$session->read('calendar_limits','yes');
                              $user_type = $session->read('User.user_type');
                              

                              
							  if($user_type == 'Sitter'){ ?>

								<li>
									<a href="<?php echo HTTP_ROOT.'dashboard/calendar' ?>"><i class="fa fa-calendar"></i> <?php echo $this->requestAction('app/get-translate/'.base64_encode('Calendar')); ?></a>
								</li>

								<?php } ?>
<!-- 
								<li>
									<a href="<?php echo HTTP_ROOT.'dashboard/front-dashboard'; ?>"><i class="fa fa-user"></i> <?php echo $this->requestAction('app/get-translate/'.base64_encode('Profile')); ?></a>
								</li>
								 -->
								<li>
									<a href="<?php echo HTTP_ROOT ;?>guests/logout"><i class="fa fa-power-off"></i> <?php echo $this->requestAction('app/get-translate/'.base64_encode('Logout')); ?></a>
								</li>
												
							</ul>
                         </div>
                      </li>
                       <!--MESSAGE LI START -->
                     <li  class="dropdown">
						  <a  id="droplog3" href="<?php echo HTTP_ROOT.'Message/get-messages/pending'; ?>" > <?php echo $this->requestAction('app/get-translate/'.base64_encode('Message')); ?>   <!--class="dropdown-toggle" data-toggle="dropdown"--> 
							<span class="badge myNewCount"></span>
						  </a>
						</a>
						<!--<div class="dropdown-menu currency-drop drop-profile message-width  hidden-xs " id="dropcont3">
						  <ul id="myNewMsgs" class="c-list c-list-2">
						  
						  </ul>
						</div>-->
						</li>  <!--MESSAGE LI CLOSED -->

                      
                      <li><a href="<?php echo HTTP_ROOT.'help'; ?>"> <?php echo $this->requestAction('app/get-translate/'.base64_encode('Help')); ?> <i class="fa fa-question-circle" aria-hidden="true"></i> </a></li>
                                  
                      <li class="dd-country last-drop">
						  <a href="#"  data-toggle="dropdown">
                           <img src="<?php echo HTTP_ROOT.'img/flags/'.$currentLocal.'.png' ;?>" alt=""> <span class="lang-txt"><?php echo ucwords($currentLocal); ?></span> </a>
							<?php echo $this->element('frontElements/common/language_switcher'); ?>
                       </li>
                  </ul> 
              </div>
            </nav>
          </div>
        </div>
                        <!--end-->



    </div>
</div>
                  
</div>
</header>

<script> 
	$(document).ready(function(){
    	$("#new-nav").click(function(){
        	$("#nav-inner").slideToggle("slow");
	    });
	});
	
   function changeImage(element) {
         var right = "http://betasoftdev.com/sitterguide_test/img/toggle-nav.png";
         var left = "http://betasoftdev.com/sitterguide_test/img/toogle-close.png";
         element.src = element.bln ? right : left;
         element.bln = !element.bln;
     }

  
</script>
<style>
.img-circle_pre{
	height:15px;
	width:15px;
	border-radius:50%;
	border:1px solid #000;
}
.pro-txt{
	margin-right:10px;

}
</style>