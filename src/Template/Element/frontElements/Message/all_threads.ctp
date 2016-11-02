<?php
	if(!empty($get_requests)){
		//pr($get_requests[0]['id']); die;
		foreach($get_requests as $req_data){
			
			$req_id = trim(@$req_data['id']);
			$folder_status = @$req_data['folder_status_'.trim($fieldname)];
		
		if(isset($req_data['booking_chats']) && !empty($req_data['booking_chats'])){
			$activeClass = '';
		
		}else{
			$activeClass = 'active-book';
		}
		if(isset($req_data['read_status']) && ($req_data['read_status'] =='unread' && $req_data['read_status_posted_by'] !=$userType)){
		    $badges ='<div class="new-badge">NEW</div>';
			$activeClass = 'active-book';
		}else{
		    $badges ='';
			$activeClass = '';
		}
		//echo "($folder_status==$display_thread_folder_status)";
		if($folder_status==$display_thread_folder_status){		
		
	?>
  <div id="tr_<?php echo $req_id; ?>"  onclick="get_req_data(<?php echo "'".$folder_status."','".base64_encode(convert_uuencode($req_id))."'";?>);" class="book-now-setion-inner <?php echo $activeClass; ?>">
	<div class="row">
	  <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 ">
			<div class="book-now-img ">	
            	  
		 		 <?php if(($req_data['user']['facebook_id']) !="" && ($req_data['user']['is_image_uploaded'])==0){ ?>
			     <img 
					class="img-circle img-responsive" 
					alt="<?php echo __('Profile Picture'); ?>" 
					src="<?php if($req_data['user']['image'] != ""){echo $req_data['user']['image'];}else{echo $req_data['user']['image']='prof_photo.png';} ?>"> 
		   
		   <?php }else{ ?>
			
				<img 
					class="img-circle img-responsive"  
					alt="<?php echo __('Profile Picture'); ?>" 
					src="<?php echo HTTP_ROOT.'img/uploads/'.($req_data['user']['image'] != ''?$req_data['user']['image']:'prof_photo.png'); ?>"> 					   
			<?php  } ?>
			
		</div>
            <div class="book-now-name">
         <?php echo $badges; ?>
		  <p><?php echo $req_data['user']['first_name']." ".substr($req_data['user']['last_name'],0,1);?>		  </p>
		  
			 
		
		</div>
      </div> 	      
	 		<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
				<div class="book-now-name">
		  <p><?php 
				if(isset($req_data['booking_chats']) && !empty($req_data['booking_chats'])){
					echo substr($req_data['booking_chats'][0]['message'],0,50)."..."; 
				}else{
					echo substr($req_data['message'],0,50)."..."; 
				}
			
			if(!empty($selected_pets)){
					$pet=1;
                    foreach($selected_pets as $single_guest){ ?>
						<span><?php echo ucwords(@$single_guest->guest_name);
							if($pet>1){
								echo ", ";
							}
						?></span>
			<?php
					$pet++;
				}
			} ?>	
		  </p>
		</div>        
	        	<div class="book-now-name rate-box">
                                	<div class="bnn-trashbox">
            	<div class="row">

                	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-8">
                    	 <p>   <?php echo date("h:i A",strtotime($req_data['created_date'])); ?> 
            <?php echo date("M d",strtotime($req_data['created_date'])); ?> </p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-4">
                    	 <?php if($req_data['folder_status_'.strtolower($userActas)]=='current'){ 
						if(strtolower($userActas)=='sitter'){
							$rated_id = 'user_id';
						}else{
							$rated_id = 'sitter_id';
						}
					  ?>
							<a href="<?php echo HTTP_ROOT.'dashboard/review/'.base64_encode(convert_uuencode($req_id)).'/'.base64_encode(convert_uuencode($req_data[$rated_id]))?>">
								<button class="btn  bt-now">
									<i class="fa fa-star">
									</i>
									 <?php echo $this->requestAction('app/get-translate/'.base64_encode('Rate now')); ?> 
								</button>
							</a>
			<?php } ?>
			
			<?php if($req_data['folder_status_'.strtolower($userActas)]=='pending'){ ?>
					<a class="trash_thread" href="javascript:void(0)" data-user-type="<?php echo base64_encode(convert_uuencode(strtolower($userActas))); ?>" data-rel="<?php echo base64_encode(convert_uuencode($req_id)); ?>">
						<button class="btn bt-now">
							<i class="fa fa-trash-o" aria-hidden="true"></i></i>
							 <?php echo $this->requestAction('app/get-translate/'.base64_encode('Trash')); ?> 
						</button>
					</a>
					<img style="display:none" src="<?php echo HTTP_ROOT; ?>img/ajax_wait.gif" id="move_to_folder" class="img-responsive" alt="message">
			<?php } ?>
                    </div>
                    </div>
                </div>
            
		</div>
	  </div>
 	</div>
  </div>
  
  <?php }
  }
   ?>
  
  <?php 
  }else{ ?>
	<div class="book-now-setion-inner ">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="book-now-name">
				  <p>
					 <?php echo $this->requestAction('app/get-translate/'.base64_encode('No chat found!')); ?> 
				  </p>
				</div>
			</div>
		</div>
	</div>		
  <?php } 
  
  ?>
