<?php 
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
 
namespace App\Controller;
use Cake\Controller\Controller;
use Cake\ORM\TableRegistry;
use Cake\I18n\I18n;
use Cake\Network\Email\Email;
use Cake\I18n\Time;

use Cake\Event\Event;
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/$userActasen/controllers/pages-controller.html
 */

class MessageController extends AppController
{
	public $helpers = ['Form'];
	/**
	* Function which is call at very first when this controller load
	*/
    public function beforeFilter(Event $event)
    { 
        parent::beforeFilter($event);
		if($this->CheckGuestSession()==false)
		{
			return $this->redirect(['controller' => 'guests', 'action' => 'home']);
			exit();
		}
    }
    
	public function initialize()
    {
        parent::initialize();
		// Loaded EmailTemplate Model
		$SiteModel = TableRegistry::get('siteConfigurations');
		$siteConfiguration = $SiteModel->find('all')->first();
		$this->set('siteConfiguration', $siteConfiguration);
		
		$session = $this->request->session();
		$this->set('loggedin_user',$session->read('User.id'));
				
		$this->set('user_avail_bal', $this->getLoggedInUserBalance($session->read('User.id')));			
	}
	/**
	* Function to List the messages
	*/
	function getMessages($folder_status='pending',$request_booking_id=''){
		
		$this->viewBuilder()->layout('profile_dashboard');
		$session = $this->request->session();
		
		//ADD MODEL
		$BookingRequestsModel = TableRegistry::get('BookingRequests');
		$BookingChatsModel = TableRegistry::get('BookingChats');
		$UsersModel = TableRegistry::get('Users');
		
		$booking_id = convert_uudecode(base64_decode($request_booking_id));
		

		$userId = $session->read('User.id');
		$this->set(compact('userId','class_user'));
		



		$get_requests = $BookingRequestsModel->find('all')
		->where(["BookingRequests.user_id = $userId OR BookingRequests.sitter_id = $userId"])
		->contain(['BookingChats'=> ['queryBuilder' => function ($q) {
															return $q->order(['BookingChats.id' => 'DESC']);
														}
									]
		          ]
		)
		->select(['message','read_status','read_status_posted_by','folder_status_sitter','folder_status_guest','created_date','id','user_id','sitter_id','request_by_sitter_id'])
		->hydrate(false)->toArray();
		
		
		if(!empty($get_requests)){
			foreach($get_requests as $booking_key=>$booking_records){
				//SET WHICH IS ACT AS A SITTER AND WHICH IS ACT AS A GUEST IN THIS REQUEST
				if($userId==$booking_records['request_by_sitter_id'] && $userId==$booking_records['user_id']){
					
					$user_message_display_field = 'sitter_id'; // Set id for display user messages on each other threads //OLD sitter_id
					$fieldname = 'sitter';
					$userType = 'Sitter';
					$userActas = 'Guest';
					
					
				}else if($userId != $booking_records['request_by_sitter_id'] && $userId !=$booking_records['user_id']){
					
					$user_message_display_field = 'user_id'; // Set id for display user messages on each other threads
					$fieldname = 'sitter';
					$userType = 'Sitter';
					$userActas = 'Sitter';
					
					
				}else if($userId != $booking_records['request_by_sitter_id'] && $userId ==$booking_records['user_id']){
					
					$user_message_display_field = 'sitter_id'; // Set id for display user messages on each other threads
					$fieldname = 'guest';
					$userType = 'Basic';
					$userActas = 'Guest';
					
				}		
				
				
				$get_requests[$booking_key]['user'] = $UsersModel->find('all')
																->select(['Users.image','Users.id','Users.first_name','Users.last_name','Users.facebook_id','Users.is_image_uploaded'])
																->where(['Users.id' => $booking_records[$user_message_display_field]])
																->limit(1)->hydrate(false)->first();
				if($folder_status != $booking_records['folder_status_'.strtolower($userActas)]){
						unset($get_requests[$booking_key]);
						
				}
				
				
															
			}
		}
		$get_requests = array_values($get_requests);
		if(count($get_requests)>0){
			$default_booking_id = isset($get_requests[0]['id'])?$get_requests[0]['id']:'';
		}else{
			$default_booking_id = '';
		}
		
		if($booking_id != ''){
		
			$this->set('booking_id',$booking_id);
			
			$get_chats = $BookingChatsModel->find('all')
						->where(['BookingChats.booking_request_id' => $booking_id])
						->contain(['Users'])
						->select(['message','read_status','Users.image','created_at','user_role','user_id','Users.facebook_id','Users.is_image_uploaded'])
						->hydrate(false)->toArray();
			
			if(!empty($get_chats)){
				$BookingRequestsModel->query()
						->update()
						->set(['read_status' =>"read"])
						->where(['id' => $booking_id])
						->execute();
				
			}
			
		}else{
		    $booking_id = $default_booking_id;
			$this->set('booking_id',$booking_id);
			$get_chats = $BookingChatsModel->find('all')
						->where(['BookingChats.booking_request_id' => $booking_id])
						->contain(['Users'])
						->select(['message','read_status','Users.image','created_at','user_role','user_id','Users.facebook_id','Users.is_image_uploaded','Users.first_name','Users.last_name'])
						->hydrate(false)->toArray();
			if(!empty($get_chats)){
				$BookingRequestsModel->query()
						->update()
						->set(['read_status' =>"read"])
						->where(['id' => $booking_id])
						->execute();
			}
			
		}
		//GET BOOKING RECORDS FOR DISPLAY ON RIGHT HAND SIDE DIV
		
		$get_booking_requests_to_display = array();
		$total = 0;
		if(isset($booking_id) && $booking_id !=''){
			
                 $get_booking_requests_to_display = $BookingRequestsModel->find('all')
				->where(['BookingRequests.id'=>$booking_id])
				->contain(['BookingChats'=> ['queryBuilder' => function ($q) {
																	return $q->order(['BookingChats.id' => 'DESC']);
																}
											]
						  ]
				)
				->hydrate(false)->first();
				
			if(!empty($get_booking_requests_to_display)){
				  $get_booking_requests_to_display['user'] = $UsersModel->find('all',['contain'=>[
															'UserSitterHouses'
															
													            ]
														])
														->select(['Users.image','Users.id','Users.first_name','Users.last_name','Users.facebook_id','Users.is_image_uploaded','Users.date_added','UserSitterHouses.about_home_desc','Users.user_type'])
														
														->where(['Users.id' => $get_booking_requests_to_display[$user_message_display_field]])
														->limit(1)->hydrate(false)->first();
				    //Start sk				
					$guestUserData = $UsersModel->find('all',['contain'=>[
															    'UserSitterServices',
															    'UserPets'=>['UserPetGalleries']
															   ]
														]
												)
								   ->where(['Users.id' => $get_booking_requests_to_display['user_id']], ['Users.id' => 'integer[]'])
								   ->toArray();
								   
				   $sitterUserData = $UsersModel->find('all',['contain'=>[
												'UserSitterServices',
												'UserPets'=>['UserPetGalleries']
											   ]
										]
								)
				   ->where(['Users.id' => $get_booking_requests_to_display['sitter_id']], ['Users.id' => 'integer[]'])
				   ->toArray();
					//end sk
					 
			  }
			  //Start sk	
			  
			if(!empty($guestUserData[0]->user_pets) && isset($guestUserData[0]->user_pets)){
				// pr($get_booking_requests_to_display['guest_id_for_bookinig']); die;
				 $idPetsArr = explode(",",$get_booking_requests_to_display['guest_id_for_bookinig']);
				 $other_selected_pets = [];
				 $selected_pets = [];
				 $pets_name = [];
				 foreach($idPetsArr as $single_pet_id){
					 foreach($guestUserData[0]->user_pets as $single_pet){

						 if($single_pet_id == $single_pet->id){
							$pets_name[] = $single_pet->guest_name;
							$selected_pets[] = $single_pet;
							//$selected_pets['gBreed']=$single_pet->guest_breed;
						 }
					 }
				 }
				$BreedModel = TableRegistry::get('dog_breeds');
				$BreedData=$BreedModel->find('all')->toArray();
				foreach($BreedData as $k => $BreedDatas){
						$gBreed=$BreedDatas->breed_name;
						$AllBreedName[$k+1]=$gBreed;

				}
				$this->set("AllBreedName",$AllBreedName);
			 //echo "<pre>"; print_r($AllBreedName); 
			 //die;
		      $this->set("pets",$pets_name);
		      $this->set("selected_pets",$selected_pets);
		     
		     
		      //End sk
		    }
		   
		    //Start sk	
		    //echo $get_booking_requests_to_display['required_service'] ; die;
			if(!empty($sitterUserData[0]->user_sitter_services) && isset($sitterUserData[0]->user_sitter_services)){
				 
		     	$date1 = @$get_booking_requests_to_display['booknig_start_date'];
				$date2 = @$get_booking_requests_to_display['booking_end_date'];
				$diff = abs(strtotime($date2) - strtotime($date1));
				$years = floor($diff / (365*60*60*24));
				$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
				$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
				$total_days = $days+1;
		    
		       $selectedGuest = explode(",",@$get_booking_requests_to_display['guest_id_for_bookinig']);
			   $guest_num = count($selectedGuest);
			 
			 if($get_booking_requests_to_display['required_service'] == 'boarding'){
				 $day_rate = $sitterUserData[0]->user_sitter_services[0]->sh_day_rate;
				 $night_rate = $sitterUserData[0]->user_sitter_services[0]->sh_night_rate;
				 $total_days;
				 $day_total = $day_rate*$total_days;
				 $night_total = $night_rate*$total_days;
				 $guest_num;
				 $total = ($day_total+$night_total)*$guest_num;
		     }else if($get_booking_requests_to_display['required_service']  == 'house_sitting'){
				$hs_day_rate = $sitterUserData[0]->user_sitter_services[0]->gh_day_rate;
				$hs_night_rate = $sitterUserData[0]->user_sitter_services[0]->gh_night_rate;
				
				$day_total = $hs_day_rate*$total_days;
				$night_total = $hs_night_rate*$total_days;
				$total = ($day_total+$night_total)*$guest_num;
			 }else if($get_booking_requests_to_display['required_service']  == 'day_nigth_care'){
				 $day_rate = $sitterUserData[0]->user_sitter_services[0]->sh_day_rate;
				 $night_rate = $sitterUserData[0]->user_sitter_services[0]->sh_night_rate;
				 
				 $day_total = $day_rate*$total_days;
				 $night_total = $night_rate*$total_days;
				 
				 $total = ($day_total+$night_total)*$guest_num;
			 }else if($get_booking_requests_to_display['required_service']  == 'market_place'){
				 $mp_grooming_rate = $sitterUserData[0]->user_sitter_services[0]->mp_grooming_rate;
				 $mp_training_rate = $sitterUserData[0]->user_sitter_services[0]->mp_training_rate;
				 $mp_recreation_rate = $sitterUserData[0]->user_sitter_services[0]->mp_recreation_rate;
				 $mp_driving_rate = $sitterUserData[0]->user_sitter_services[0]->mp_driving_rate;
				 
				  $mp_grooming_total = $mp_grooming_rate*$total_days;
				  $mp_training_total = $mp_training_rate*$total_days;
				  $mp_recreation_total = $mp_recreation_rate*$total_days;
				  $mp_driving_total = $mp_driving_rate*$total_days;
				 
				 $total = ($mp_grooming_total+$mp_training_total+$mp_recreation_total+$mp_driving_total)*$guest_num; 
				 
			}else if($get_booking_requests_to_display['required_service']  == 'drop_in_visit'){
				
				 $drop_visit_rate = $sitterUserData[0]->user_sitter_services[0]->gh_drop_in_visit_rate;
				 $total = $drop_visit_rate*$total_days*$guest_num;
			 }
		  }
				 //End sk
				
		}//END
	    //echo $total;die;

		
		if($booking_id !=''){
			$get_Booking_requests = $BookingRequestsModel->find('all')
			->where(["BookingRequests.id"=>$booking_id])
			->select(['id','user_id','sitter_id','request_by_sitter_id'])
			->hydrate(false)->toArray();
			$get_Booking_requests;
		}

		 
		$this->set(compact('userId','userType','class_user','fieldname','userActas'));
		$this->set('get_chats',$request_booking_id);
		$this->set('get_requests',$get_requests);
		$this->set('get_Booking_requests',@$get_Booking_requests);
		$this->set('display_thread_folder_status',$folder_status);
		$this->set('total',$total);
		$this->set('get_booking_requests_to_display',$get_booking_requests_to_display);
	}
		
	/**
	 * Funtion to get the chat detail
	*/
	
	function sendmessage(){
		
		$BookingChatsModel = TableRegistry::get('BookingChats');
		$BookingRequestsModel = TableRegistry::get('BookingRequests');
		
		$this->request->data = $_REQUEST;	
		
		$ChatData = $BookingChatsModel->newEntity();
		
		$booking_msg_id = $this->request->data['booking_message_id'];
		$chat_text = $this->request->data['chat_text'];
		$user_type = $this->request->data['user_type'];
		$user_id = $this->request->data['user_id'];
		$user_to = $this->request->data['user_to'];

		$ChatData->message = $chat_text;
		$ChatData->booking_request_id = $booking_msg_id;
		$ChatData->user_role = $user_type;
		$ChatData->user_id = $user_id;
		$ChatData->user_to = $user_to;
					
					
		if($BookingChatsModel->save($ChatData)){
			
			$this->request->data = $_REQUEST;	
			$id = $this->request->data['booking_message_id'];
			

			$get_chats = $BookingChatsModel->find('all')
						->where(['BookingChats.booking_request_id' => $id])
						->contain(['Users'])
						->select(['message','Users.image','created_at','user_role','user_id','Users.facebook_id','Users.is_image_uploaded'])
						->hydrate(false)->toArray();
			
			if($booking_msg_id !=''){
					
					//CHECK THAT PREVIOUS MESSAGE DONE BY THIS USER OR NOT, IF NOT THEN CHANGE STATUS UNREAD
					/*
					$BookingRequestsModel->query()
						->update()
						->set(['read_status' =>"unread",'read_status_posted_by' =>$user_type])
						->where(['id' => $booking_msg_id])
						->execute();*/


		
					$session = $this->request->session();
					$userId = $session->read('User.id');
					
					$BookingChatsModel->query()
						->update()
						->set(['read_status' =>"read"])
						->where(['booking_request_id' => $booking_msg_id ,'user_to' =>$userId])
						->execute();		
						
			}
			$this->set('get_chats',$get_chats);
		}
	}
		/**
	 * Funtion to get the chat detail
	 */
	 function autoLoadChat(){
	
		$this->request->data = $_REQUEST;	
		$id = $this->request->data['booking_id'];
		$BookingChatsModelModel = TableRegistry::get('BookingChats');
	
		$get_chats = $BookingChatsModelModel->find('all')
		->where(['BookingChats.booking_request_id' => $id])
		->contain(['Users'])
		->select(['message','Users.image','created_at','user_role','user_id','Users.facebook_id','Users.is_image_uploaded'])
		->hydrate(false)->toArray();
		//pr($get_chats);die;
		$this->set('get_chats',$get_chats);
		$this->render('sendmessage');	
	}
	
	/**
	 * Funtion to get the chat detail
	 */
	 function autoLoadThreads(){
	
		$this->request->data = $_REQUEST;	
		$id = $this->request->data['booking_id'];
		$folder_status = $this->request->data['folder_status'];
		
		$session = $this->request->session();
		//ADD MODEL
		$BookingRequestsModel = TableRegistry::get('BookingRequests');
		$BookingChatsModel = TableRegistry::get('BookingChats');
		$UsersModel = TableRegistry::get('Users');
		
		$booking_id =$id;
		
		$userId = $session->read('User.id');
		$this->set(compact('userId','class_user'));
		
		$get_requests = $BookingRequestsModel->find('all')
		->where(["BookingRequests.user_id = $userId OR BookingRequests.sitter_id = $userId"])
		->contain(['BookingChats'=> ['queryBuilder' => function ($q) {
															return $q->order(['BookingChats.id' => 'DESC']);
														}
									]
		          ]
		)
		->select(['message','read_status','read_status_posted_by','folder_status_sitter','folder_status_guest','created_date','id','user_id','sitter_id','request_by_sitter_id'])
		->hydrate(false)->toArray();
		
		
		if(!empty($get_requests)){
			foreach($get_requests as $booking_key=>$booking_records){
				//SET WHICH IS ACT AS A SITTER AND WHICH IS ACT AS A GUEST IN THIS REQUEST
				if($userId==$booking_records['request_by_sitter_id'] && $userId==$booking_records['user_id']){
					
					$user_message_display_field = 'sitter_id'; // Set id for display user messages on each other threads //OLD sitter_id
					$fieldname = 'sitter';
					$userType = 'Sitter';
					$userActas = 'Guest';
					
					
				}else if($userId != $booking_records['request_by_sitter_id'] && $userId !=$booking_records['user_id']){
					
					$user_message_display_field = 'user_id'; // Set id for display user messages on each other threads
					$fieldname = 'sitter';
					$userType = 'Sitter';
					$userActas = 'Sitter';
					
					
				}else if($userId != $booking_records['request_by_sitter_id'] && $userId ==$booking_records['user_id']){
					
					$user_message_display_field = 'sitter_id'; // Set id for display user messages on each other threads
					$fieldname = 'guest';
					$userType = 'Basic';
					$userActas = 'Guest';
					
				}		
				
				
				$get_requests[$booking_key]['user'] = $UsersModel->find('all')
																->select(['Users.image','Users.id','Users.first_name','Users.last_name','Users.facebook_id','Users.is_image_uploaded'])
																->where(['Users.id' => $booking_records[$user_message_display_field]])
																->limit(1)->hydrate(false)->first();
				if($folder_status != $booking_records['folder_status_'.strtolower($userActas)]){
						unset($get_requests[$booking_key]);
						
				}
				
				
															
			}
		}
		$get_requests = array_values($get_requests);
		//pr($get_requests); die;
		
		$this->set(compact('userId','userType','class_user','fieldname','userActas'));
		$this->set('get_chats',$booking_id);
		$this->set('get_requests',$get_requests);
	//	$this->set('folder_status',$folder_status);
		$this->set('display_thread_folder_status',$folder_status);
	}
	
	/**
	 * Funtion to get the chat detail
	 */
	 function moveFolder(){
	
		$this->request->data = $_REQUEST;	
		
		$booking_msg_id = convert_uudecode(base64_decode($this->request->data['booking_id']));
		$data_user = convert_uudecode(base64_decode($this->request->data['data_user']));
		$folder_status = 'archieved';
		
		$BookingRequestsModel = TableRegistry::get('BookingRequests');
				
		if($BookingRequestsModel->query()
						->update()
						->set(['folder_status_'.$data_user =>$folder_status])
						->where(['id' => $booking_msg_id])
						->execute()){
							
			/*SEND MESSAGE FUNCTIONALITY FOR BOOKING DECLINED */
			
			$get_requests = $BookingRequestsModel->find('all')
			->where(["BookingRequests.id = $booking_msg_id"])
			->first();
				   
			$get_user_communications_details = $this->getUserCommunicationDetails($get_requests->user_id);
			
			if(!empty($get_user_communications_details)){

				  if($get_user_communications_details['communication']['booking_declined'] == 1){

					$to_mobile_number = $get_user_communications_details['communication']['phone_notification'];

					$country_code = $get_user_communications_details['country_code'];
					
					$message_body = BOOKING_DECLINED_MESSAGE; 
					
					$send_message = $this->sendMessages($to_mobile_number, $message_body,$country_code);   

				 }

			}
			/*SEND MESSAGE FUNCTIONALITY FOR BOOKING DECLINED */
			
			/*SEND EMAIL FUNCTIONALITY FOR BOOKING DECLINED */
			
			$replace = array('{name}','{email}');
			
			$with = array($get_requests->first_name." ".$get_requests->last_name,$get_user_communications_details['first_name']." ".$get_user_communications_details['first_name']);
			
			$this->send_email('',$replace,$with,'booking_request_declined',$userEmail);
			/*SEND EMAIL FUNCTIONALITY FOR BOOKING DECLINED */
			
			echo "success";
		}else{
			echo "failed";	
		}
					
		die;
	}
	
	
	/**
	 * Funtion to get the chat detail
	 */
/*	 function getUserMessageCount(){
	
		$BookingRequestsModel = TableRegistry::get('BookingRequests');
		$BookingChatsModelModel = TableRegistry::get('BookingChats');
		
		$UsersModel = TableRegistry::get('Users');
		
		$session = $this->request->session();
		$userType = $session->read('User.user_type');
			
		$condition_field = $userType == 'Sitter'?'sitter_id':'user_id';
		$fieldname = $userType == 'Sitter'?'folder_status_sitter':'folder_status_guest';
		
		$userId = $session->read('User.id');
		
		
		$get_requests = $BookingRequestsModel->find('all')
		->where(["BookingRequests.user_id = $userId OR BookingRequests.sitter_id = $userId",'BookingRequests.folder_status_guest = "pending" || BookingRequests.folder_status_sitter = "pending"'])
		->select(['id'])
		->hydrate(false)->toArray();
				
		
		$get_chat_requests = $BookingChatsModelModel->find('all')
		->where(["BookingChats.user_to = $userId",'BookingChats.read_status' => 'unread'])
		->select(['id'])
		->hydrate(false)->toArray();
		
		//pr($get_chat_requests);
		//echo count($get_requests); die;
		
		$displayMessage = array();
			
		if(!empty($get_requests)){
			echo count($get_requests)+count($get_chat_requests);
		}else{
			echo 0;
		}
		die;
			
		
	}*/
	

	  function getUserMessageCount(){
	
		$BookingRequestsModel = TableRegistry::get('BookingRequests');
		$BookingChatsModelModel = TableRegistry::get('BookingChats');
		
		$UsersModel = TableRegistry::get('Users');
		
		$session = $this->request->session();
		$userType = $session->read('User.user_type');
			
		$condition_field = $userType == 'Sitter'?'sitter_id':'user_id';
		$fieldname = $userType == 'Sitter'?'folder_status_sitter':'folder_status_guest';
		
		$userId = $session->read('User.id'); 
		
		/*
		$get_requests = $BookingRequestsModel->find('all')
		->where(["BookingRequests.user_id = $userId OR BookingRequests.sitter_id = $userId",'BookingRequests.folder_status_guest = "pending" || BookingRequests.folder_status_sitter = "pending"'])
		->select(['id'])
		->hydrate(false)->toArray(); */
		
		
		
		$get_requests = $BookingRequestsModel->find('all')
		->where(["BookingRequests.user_id = $userId OR BookingRequests.sitter_id = $userId", 'BookingRequests.folder_status_guest = "pending" || BookingRequests.folder_status_sitter = "pending"'])
		->contain(['BookingChats'=> ['queryBuilder' => function ($q) {
															return $q->where(['BookingChats.read_status' => 'unread'])
															->order(['BookingChats.id' => 'DESC']);
														}
									]
		         ]
		)
		->select(['message','read_status','read_status_posted_by','folder_status_sitter','folder_status_guest','created_date','id','user_id','sitter_id','request_by_sitter_id'])
		->hydrate(false)->toArray();
				
		$chatArr = array();
		$reqArr = array();
		
		
		
		//echo count($get_chat_requests); die;
		if(!empty($get_requests)){

			foreach($get_requests as $k=>$v){
				
				if(!empty($v['booking_chats'])){
					
					foreach($v['booking_chats'] as $chatRec){

						if($chatRec['user_to'] == $userId){
							$chatArr[] = $chatRec;

						}

					}
				
				}else{
					
					if($userId == $v['user_id'] && trim($v['folder_status_guest'])=="pending"){
					
					 $reqArr[] = $v;
					
					}else if($userId == $v['sitter_id'] && trim($v['folder_status_sitter'])=="pending"){
					
					 $reqArr[] = $v;
					 	
					}
				}
			}
		}
		
				
		if(!empty(@$reqArr)){
			$gr_total =  count(@$reqArr);
		}else{
			$gr_total=0;
		}
		
		if(!empty(@$chatArr)){
			$grc_total = count(@$chatArr);
		}else{
			$grc_total=0;
		}

		$final_Count = $grc_total + $gr_total;
		echo $final_Count;
		die;
	}
	
	
	function autoLoadJd(){
		
		$folder_status=isset($_REQUEST['folder_status'])?$_REQUEST['folder_status']:'pending';
		$request_booking_id=$_REQUEST['booking_id'];
		
		$this->viewBuilder()->layout('');
		$session = $this->request->session();
		
		//ADD MODEL
		$BookingRequestsModel = TableRegistry::get('BookingRequests');
		$BookingChatsModel = TableRegistry::get('BookingChats');
		$UsersModel = TableRegistry::get('Users');
		
		$booking_id = convert_uudecode(base64_decode($request_booking_id));
		
		$userId = $session->read('User.id');
		$this->set(compact('userId','class_user'));
		
		$get_requests = $BookingRequestsModel->find('all')
		->where(["BookingRequests.user_id = $userId OR BookingRequests.sitter_id = $userId"])
		->contain(['BookingChats'=> ['queryBuilder' => function ($q) {
															return $q->order(['BookingChats.id' => 'DESC']);
														}
									]
		          ]
		)
		->select(['message','read_status','read_status_posted_by','folder_status_sitter','folder_status_guest','created_date','id','user_id','sitter_id','request_by_sitter_id'])
		->hydrate(false)->toArray();
		
		
		if(!empty($get_requests)){
			foreach($get_requests as $booking_key=>$booking_records){
				//SET WHICH IS ACT AS A SITTER AND WHICH IS ACT AS A GUEST IN THIS REQUEST
				if($userId==$booking_records['request_by_sitter_id'] && $userId==$booking_records['user_id']){
					
					$user_message_display_field = 'sitter_id'; // Set id for display user messages on each other threads //OLD sitter_id
					$fieldname = 'sitter';
					$userType = 'Sitter';
					$userActas = 'Guest';
					
					
				}else if($userId != $booking_records['request_by_sitter_id'] && $userId !=$booking_records['user_id']){
					
					$user_message_display_field = 'user_id'; // Set id for display user messages on each other threads
					$fieldname = 'sitter';
					$userType = 'Sitter';
					$userActas = 'Sitter';
					
					
				}else if($userId != $booking_records['request_by_sitter_id'] && $userId ==$booking_records['user_id']){
					
					$user_message_display_field = 'sitter_id'; // Set id for display user messages on each other threads
					$fieldname = 'guest';
					$userType = 'Basic';
					$userActas = 'Guest';
					
				}		
				
				
				$get_requests[$booking_key]['user'] = $UsersModel->find('all')
																->select(['Users.image','Users.id','Users.first_name','Users.last_name','Users.facebook_id','Users.is_image_uploaded'])
																->where(['Users.id' => $booking_records[$user_message_display_field]])
																->limit(1)->hydrate(false)->first();
				if($folder_status != $booking_records['folder_status_'.strtolower($userActas)]){
						unset($get_requests[$booking_key]);
						
				}
				
				
															
			}
		}
		$get_requests = array_values($get_requests);
		
		if(count($get_requests)>0){
			$default_booking_id = $get_requests[0]['id'];
		}else{
			$default_booking_id = '';
		}
		
		if($booking_id != ''){
		
			$this->set('booking_id',$booking_id);
			
			$get_chats = $BookingChatsModel->find('all')
						->where(['BookingChats.booking_request_id' => $booking_id])
						->contain(['Users'])
						->select(['message','read_status','Users.image','created_at','user_role','user_id','Users.facebook_id','Users.is_image_uploaded'])
						->hydrate(false)->toArray();
			
			if(!empty($get_chats)){
				$BookingRequestsModel->query()
						->update()
						->set(['read_status' =>"read"])
						->where(['id' => $booking_id])
						->execute();
				
			}
			
		}else{
		    $booking_id = $default_booking_id;
			$this->set('booking_id',$booking_id);
			$get_chats = $BookingChatsModel->find('all')
						->where(['BookingChats.booking_request_id' => $booking_id])
						->contain(['Users'])
						->select(['message','read_status','Users.image','created_at','user_role','user_id','Users.facebook_id','Users.is_image_uploaded','Users.first_name','Users.last_name'])
						->hydrate(false)->toArray();
			if(!empty($get_chats)){
				$BookingRequestsModel->query()
						->update()
						->set(['read_status' =>"read"])
						->where(['id' => $booking_id])
						->execute();
			}
			
		}
		//GET BOOKING RECORDS FOR DISPLAY ON RIGHT HAND SIDE DIV
		
		$get_booking_requests_to_display = array();
		$total = 0;
		if(isset($booking_id) && $booking_id !=''){
			
                 $get_booking_requests_to_display = $BookingRequestsModel->find('all')
				->where(['BookingRequests.id'=>$booking_id])
				->contain(['BookingChats'=> ['queryBuilder' => function ($q) {
																	return $q->order(['BookingChats.id' => 'DESC']);
																}
											]
						  ]
				)
				->hydrate(false)->first();
				
			if(!empty($get_booking_requests_to_display)){
				  $get_booking_requests_to_display['user'] = $UsersModel->find('all',['contain'=>[
															'UserSitterHouses'
															
													            ]
														])
														->select(['Users.image','Users.id','Users.first_name','Users.last_name','Users.facebook_id','Users.is_image_uploaded','Users.date_added','UserSitterHouses.about_home_desc','Users.user_type'])
														
														->where(['Users.id' => $get_booking_requests_to_display[$user_message_display_field]])
														->limit(1)->hydrate(false)->first();
				    //Start sk				
					$guestUserData = $UsersModel->find('all',['contain'=>[
															    'UserSitterServices',
															    'UserPets'=>['UserPetGalleries']
															   ]
														]
												)
								   ->where(['Users.id' => $get_booking_requests_to_display['user_id']], ['Users.id' => 'integer[]'])
								   ->toArray();
								   
				   $sitterUserData = $UsersModel->find('all',['contain'=>[
												'UserSitterServices',
												'UserPets'=>['UserPetGalleries']
											   ]
										]
								)
				   ->where(['Users.id' => $get_booking_requests_to_display['sitter_id']], ['Users.id' => 'integer[]'])
				   ->toArray();
					//end sk
					 
			  }
			  //Start sk	
			  
			if(!empty($guestUserData[0]->user_pets) && isset($guestUserData[0]->user_pets)){
				// pr($get_booking_requests_to_display['guest_id_for_bookinig']); die;
				 $idPetsArr = explode(",",$get_booking_requests_to_display['guest_id_for_bookinig']);
				 $selected_pets = [];
				 $pets_name = [];
				 foreach($idPetsArr as $single_pet_id){
					 foreach($guestUserData[0]->user_pets as $single_pet){
						 if($single_pet_id == $single_pet->id){
							$pets_name[] = $single_pet->guest_name;
							$selected_pets[] = $single_pet;
						 }
					 }
				 }
				 $BreedModel = TableRegistry::get('dog_breeds');
				$BreedData=$BreedModel->find('all')->toArray();
				foreach($BreedData as $k => $BreedDatas){
						$gBreed=$BreedDatas->breed_name;
						$AllBreedName[$k+1]=$gBreed;

				}
				$this->set("AllBreedName",$AllBreedName);
		      $this->set("pets",$pets_name);
		      $this->set("selected_pets",$selected_pets);
		     
		      //End sk
		    }
		   
		    //Start sk	
		    //echo $get_booking_requests_to_display['required_service'] ; die;
			if(!empty($sitterUserData[0]->user_sitter_services) && isset($sitterUserData[0]->user_sitter_services)){
				 
		        $date1 = @$get_booking_requests_to_display['booknig_start_date'];
				$date2 = @$get_booking_requests_to_display['booking_end_date'];
				$diff = abs(strtotime($date2) - strtotime($date1));
				$years = floor($diff / (365*60*60*24));
				$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
				echo "days"; $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
				//$total_days = $days;
		   		$total_days = $days+1;

		       $selectedGuest = explode(",",@$get_booking_requests_to_display['guest_id_for_bookinig']);
			   $guest_num = count($selectedGuest);
			 
			 if($get_booking_requests_to_display['required_service'] == 'boarding'){
				 $day_rate = $sitterUserData[0]->user_sitter_services[0]->sh_day_rate;
				 $night_rate = $sitterUserData[0]->user_sitter_services[0]->sh_night_rate;
				 
				 $day_total = $day_rate*$total_days;
				 $night_total = $night_rate*$total_days;
				  
				 $total = ($day_total+$night_total)*$guest_num;
		     }else if($get_booking_requests_to_display['required_service']  == 'house_sitting'){
				$hs_day_rate = $sitterUserData[0]->user_sitter_services[0]->gh_day_rate;
				$hs_night_rate = $sitterUserData[0]->user_sitter_services[0]->gh_night_rate;
				
				$day_total = $hs_day_rate*$total_days;
				$night_total = $hs_night_rate*$total_days;
				$total = ($day_total+$night_total)*$guest_num;
			 }else if($get_booking_requests_to_display['required_service']  == 'day_nigth_care'){
				 $day_rate = $sitterUserData[0]->user_sitter_services[0]->sh_day_rate;
				 $night_rate = $sitterUserData[0]->user_sitter_services[0]->sh_night_rate;
				 
				 $day_total = $day_rate*$total_days;
				 $night_total = $night_rate*$total_days;
				 
				 $total = ($day_total+$night_total)*$guest_num;
			 }else if($get_booking_requests_to_display['required_service']  == 'market_place'){
				 $mp_grooming_rate = $sitterUserData[0]->user_sitter_services[0]->mp_grooming_rate;
				 $mp_training_rate = $sitterUserData[0]->user_sitter_services[0]->mp_training_rate;
				 $mp_recreation_rate = $sitterUserData[0]->user_sitter_services[0]->mp_recreation_rate;
				 $mp_driving_rate = $sitterUserData[0]->user_sitter_services[0]->mp_driving_rate;
				 
				  $mp_grooming_total = $mp_grooming_rate*$total_days;
				  $mp_training_total = $mp_training_rate*$total_days;
				  $mp_recreation_total = $mp_recreation_rate*$total_days;
				  $mp_driving_total = $mp_driving_rate*$total_days;
				 
				 $total = ($mp_grooming_total+$mp_training_total+$mp_recreation_total+$mp_driving_total)*$guest_num; 
				 
			}else if($get_booking_requests_to_display['required_service']  == 'drop_in_visit'){
				
				 $drop_visit_rate = $sitterUserData[0]->user_sitter_services[0]->gh_drop_in_visit_rate;
				 $total = $drop_visit_rate*$total_days*$guest_num;
			 }
		  }
				 //End sk
				
		}//END
	    //echo $total;die;	
	  //  pr($get_requests); die;
		$this->set(compact('userId','userType','class_user','fieldname','userActas'));
		$this->set('get_chats',$request_booking_id);
		$this->set('get_requests',$get_requests);
		$this->set('display_thread_folder_status',$folder_status);
		$this->set('total',$total);
		$this->set('get_booking_requests_to_display',$get_booking_requests_to_display);
		$this->render("../Element/frontElements/Message/job_detail");
	}
	

}
?>
