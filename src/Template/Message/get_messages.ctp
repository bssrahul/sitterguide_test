<?php 
    echo $this->Html->css(['Front/jquery-ui.css','Front/search-result.css']); 
	echo $this->Html->script(['Front/messages.js']); 
?>
<div class="col-md-9 col-lg-10 col-sm-8 lg-width80" id="content">
<div class="container-fluid">
  <div class="row">
  	<div class="db-top-bar-header bg-title">
    	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
      <h3><span class="fa fa-envelope">  </span><span style="margin-left:15px"><?php echo $this->requestAction('app/get-translate/'.base64_encode('Inbox')); ?></span>  </h3>
    </div>
    	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
      <ol class="breadcrumb text-right">
        <li> <?php echo $this->requestAction('app/get-translate/'.base64_encode('You are here'));?> : 
        </li>
        <li>
          <a href="#"><?php echo $this->requestAction('app/get-translate/'.base64_encode('Home'));?>
          </a>
        </li>
        <li class="active"><?php echo $this->requestAction('app/get-translate/'.base64_encode('Inbox'));?>
        </li>
      </ol>
    </div>
    </div>
  </div>
  </div>
  <?php if(!empty($get_requests[0]['message'])){ ?>
	
	
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="message-full-wrapper">
        <div class="top-message-strip">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 ">
              <ul class="list-inline display-block">
                <li>
                  <p class="head-inbox">
                    <span> 
                      <i class="fa fa-inbox">
                      </i>
                    </span><?php echo $this->requestAction('app/get-translate/'.base64_encode('Inbox'));?> 
                  </p>
                </li>
                           
              </ul>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
				
              <div class="input-group s-top-width">
				                  
              </div>
              <!-- /input-group -->
            </div>
          </div>
        </div>
        
        <div class="container-fluid">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 message-pad-right-0 message-pad-left-0">
              <div id="content-md" class="cscroll">
					<div class="book-now-setion-wrapper allthreads">
						<?php echo $this->element('frontElements/Message/all_threads'); ?>
					</div>
				</div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 border-left1px">
              <?php echo $this->element('frontElements/Message/static_controls'); ?>
              <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12 col-xs-12 message-pad-left-0">
                  <div class="chat-wrapper">
                    <div class="chat-title1"><?php echo $this->requestAction('app/get-translate/'.base64_encode('To'));?> : 
                      <span> 
                        <b>
							<?php echo (@$get_booking_requests_to_display['user']['first_name'] !='')? @$get_booking_requests_to_display['user']['first_name'] : ""; ?> 
							<?php echo (@$get_booking_requests_to_display['user']['last_name'] !='')? ucwords(substr(@$get_booking_requests_to_display['user']['last_name'],0,1)) : ""; ?> 
                        </b>
                        
                         <button id="refresh_chat" data-rel="<?php echo @$booking_id; ?>" class="btn btn-ref">
                          <i class="fa fa-refresh"></i>
                        </button>
                        
                      </span>
                    </div>
                    <div id="//content-m" class="chatscroll">
                      <div id="scroll" class="chat-wrapper-inner positi">
                        <div class="container-fluid list_chat_ul">
						  <?php echo $this->element('frontElements/Message/ajax_chat_response'); ?>
                        </div>
                      </div>
                    </div>
                    <?php echo $this->element('frontElements/Message/chat_form'); ?>
                  </div>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12 jd">
					<?php echo $this->element('frontElements/Message/job_detail'); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <?php }else{ ?>
	
	<div class="row">
   
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	
			  <div style="margin-bottom:30px !important" class="message-full-wrapper">
	
				<div class="top-message-strip">
	
				  <div class="row">
					
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 ">
					  
					  <ul class="list-inline display-block">
						<li>
						  <p class="head-inbox">
							<span> 
							  <i class="fa fa-inbox">
							  </i>
							</span> <?php echo $this->requestAction('app/get-translate/'.base64_encode('Inbox'));?> 
						  </p>
						</li>
								   
					  </ul>
	
					</div>
					
					
					</div>
				</div>
			</div>
				<div class="container-fluid" style="background: rgb(255, 255, 255) none repeat scroll 0% 0%; width: 100%; margin-top: -30px; height: 580px; padding: 20px;">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<h5><?php echo $this->requestAction('app/get-translate/'.base64_encode('No'));?>  <?php echo ucwords($display_thread_folder_status); ?>&nbsp;<?php echo $this->requestAction('app/get-translate/'.base64_encode('Booking found'));?> </h5>
						</div>
					</div>
				</div>		
		</div>
	</div>				
  <?php } ?>	  
</div>



	<?php  if(@$booking_id !=''){ ?>


	<script>
		var booking_id = '<?php echo @$booking_id; ?>';
		var new_booking_id = '<?php echo base64_encode(convert_uuencode(@$booking_id)); ?>';
		var folder_status = '<?php echo @$display_thread_folder_status; ?>';
		
		$(function(){
			
			//SCRIPT FOR CHATS AUTOLOAD
			setInterval(function(){
				var actionURL = ajax_url+"message/auto-load-chat/";
				if(booking_id !=''){

					$.ajax({
						url: actionURL,//AJAX URL WHERE THE LOGIC HAS BUILD
						data:{booking_id,booking_id},//ALL SUBMITTED DATA FROM THE FORM
							 
						success:function(res)
						{
							$('div.list_chat_ul').html(res);
							
						}
					});
				}
			}, 2000);
			//SCRIPT FOR THREADS AUTOLOAD
			setInterval(function(){
				var actionURL = ajax_url+"message/auto-load-threads/";
				if(booking_id !=''){

					$.ajax({
						url: actionURL,//AJAX URL WHERE THE LOGIC HAS BUILD
						data:{booking_id:booking_id,folder_status:folder_status},//ALL SUBMITTED DATA FROM THE FORM
							 
						success:function(res)
						{
							$('div.allthreads').html(res);
							
						}
					});
				}
			}, 15000);
			
			//SCRIPT FOR JOB DETAIL AUTOLOAD
			setInterval(function(){
				var actionURL = ajax_url+"message/auto-load-jd/";
				if(booking_id !=''){

					$.ajax({
						url: actionURL,//AJAX URL WHERE THE LOGIC HAS BUILD
						data:{folder_status:folder_status,booking_id:new_booking_id},//ALL SUBMITTED DATA FROM THE FORM
							 
						success:function(res)
						{
							$('div.jd').html(res);
							
						}
					});
				}
			}, 15000);
		});
	</script>
	<?php }  ?>

<style>
.bt-now {
  padding: 5px !important;
}
</style>

