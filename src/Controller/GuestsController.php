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
use Cake\Datasource\ConnectionManager;



require_once(ROOT . DS  . 'vendor' . DS  . 'Facebook' . DS . 'src' . DS . 'Facebook' . DS . 'autoload.php');
use Facebook;

use Cake\Event\Event;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */

class GuestsController extends AppController
{
	public $helpers = ['Form'];
	/**
	* Function which is call at very first when this controller load
	*/
     public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
		if($this->CheckGuestSession() && ($this->request->action == 'login' || $this->request->action == 'signup' || $this->request->action=="forgotPassword"))
		{
			$this->setErrorMessage($this->stringTranslate(base64_encode('You can not access this page because you are already loggedin.')));
			return $this->redirect(['controller' => 'Guests', 'action' => 'home']);
		}
		if(!$this->CheckGuestSession() && in_array($this->request->action,array('profile','profileEdit','addUserPet'))){
			return $this->redirect(['controller' => 'Guests','action'=>'home']);
			
		}
    }
	public function initialize()
    {

		parent::initialize();
		// Loaded EmailTemplate Model
		$SiteModel = TableRegistry::get('siteConfigurations');
		$siteConfiguration = $SiteModel->find('all')->first();
		$this->set('siteConfiguration', $siteConfiguration);
		

		$sliderModel = TableRegistry::get('Sliders');
		$sliderVideo = $sliderModel->find('all')->first();
		$this->set('sliderVideo', $sliderVideo);
		
	}
	/**Function for landing page
	*/
	function home(){
		
		$this->viewBuilder()->layout('landing');
		$UserModel=TableRegistry::get('Users');
        $session = $this->request->session();
        if($_GET['uid']){

        	$user_id=$_GET['uid'];
        	$getUserData=$UserModel->find('all')->where(['id'=>$user_id])->toArray();
        	//echo "<pre>"; print_r($getUserData[0]);die;

        	$session->write('User.id', $getUserData[0]->id);
			$session->write('User.email', $getUserData[0]->email);

			$session->write('User.user_type', $getUserData[0]->user_type);

			$session->write('User.name', ucwords($getUserData[0]->first_name." ".substr($getUserData[0]->last_name,0,1)));
            $session->write('User.facebook_id', $getUserData[0]->facebook_id);
			$session->write('User.is_image_uploaded', $getUserData[0]->is_image_uploaded);
			$session->write('User.image', $getUserData[0]->image);
			$session->write('User.last_login', $getUserData[0]->last_login);
			$session->write('User.user_type', $getUserData[0]->user_type);
			
			$session->write('User.address1', $getUserData[0]->address);
			$session->write('User.address2', $getUserData[0]->address2);
			$session->write('User.zip', $getUserData[0]->zip);
			$session->write('User.city', $getUserData[0]->city);
			$session->write('User.state', $getUserData[0]->state);
			$session->write('User.country', $getUserData[0]->country);
        }
		$currentLang = $session->read('requestedLanguage');
		if(!isset($currentLang) && empty($currentLang)){

			$this->setGuestStore("en","Guests","index");
		}
        $UserBlogsModel = TableRegistry::get('UserBlogs');
		$servicesModel = TableRegistry::get('Services');
		
		$blogsInfo = $UserBlogsModel->find('all', ['order' => ['UserBlogs.modified' => 'desc']]) ->limit(3)->where(['UserBlogs.featured' =>1])->where(['UserBlogs.status' =>1])->toArray();
		$this->set('blogsInfo',$blogsInfo);
		
		$servicesInfo = $servicesModel->find('all', ['order' => ['Services.created' => 'desc']]) ->limit(5)->where(['Services.status' =>1])->toArray();
		$this->set('servicesInfo',$servicesInfo);
		
        //Fetch Data Leading-sitting
		$UsersModel=TableRegistry :: get('Users');
		$FavourateModel=TableRegistry :: get('UserSitterFavourites');
		$favourateData = $FavourateModel->find('all', [
		'fields' => [
					'sitter_id' => 'UserSitterFavourites.sitter_id',
					'count_favourate' => 'COUNT(UserSitterFavourites.sitter_id)',
					
					],
					 'order' => ['count_favourate' => 'DESC'],
					 'limit'=>'6',
					'group' => ['UserSitterFavourites.sitter_id'],
					])->contain(['Users'])->toArray();
				
		$favUsersdata=array();
		foreach($favourateData as $favourate){
			
				$sitter_id=$favourate->sitter_id;
				$fav_no=$favourate->count_favourate;
			  $favUsersdata[] = $UsersModel->find('all',['contain'=>[
														'UserAboutSitters',
														'UserRatings','UserSitterServices'
													]]
											)
							   ->where(['Users.id' => $sitter_id])
							   ->toArray();
			
		}
		$this->set('FavUsersdata',$favUsersdata);
		/*For getting a  distance form another user's*/
		
		$sourceLocationLatitude = '30.7399738';
		$sourceLocationLongitude = '76.7567368';
		$query='SELECT
						  id, (
							3959 * acos (
							  cos ( radians('.$sourceLocationLatitude.') )
							  * cos( radians( latitude ) )
							  * cos( radians( longitude ) - radians('.$sourceLocationLongitude.') )
							  + sin ( radians('.$sourceLocationLatitude.') )
							  * sin( radians( latitude ) )
							)
						  ) AS distance
						FROM users
						
						ORDER BY distance';
			$connection = ConnectionManager::get('default');
			$results = $connection->execute($query)->fetchAll('assoc');	//RETURNS ALL USER ID WITH DISTANSE 			
			$finalDistanceArr=array();
			foreach($results as $result){
				foreach($favUsersdata as $favData){
						$selUserData=$favData[0]->id;
						if(in_array($selUserData,$result)){
							
							$finalDistanceArr[]=$result;
						}
				}
			}
			if(!empty($finalDistanceArr)){
				$idArr = array();
				$distanceAssociation = array();
				foreach($finalDistanceArr as $resultsValue){
						$idArr[] = $resultsValue['id']; //STORE ALL ID INTO AN ARRAY
						//STORE ALL DISTANCE ALONG WITH USER ID AS KEY INTO AN ARRAY
						$distanceAssociation[$resultsValue['id']] = $resultsValue['distance'];
				}
				$this->set('distanceAssociation',$distanceAssociation);	
			}
		
		if(!empty($session->read("User.id"))){
			$userId = $session->read("User.id");
			 $userPetsModel = TableRegistry::get('UserPets');
			 $userPetsData = $userPetsModel->find('all')->where(['user_id'=>$userId])->toArray();
			 $this->set("sitter_guests_info",$userPetsData);
		}
		//Fetch data how works
		$worksModel = TableRegistry::get('HowWorks');
		$workdata = $worksModel->find('all', ['conditions' =>['HowWorks.category' => 'How_it_works']])->order(['modified'=>'desc']) ->limit(3)->where(['status' => 1])->toArray();
		$this->set('works_data',$workdata);

		//Fetch data why choose
		$chooseData = $worksModel->find('all',['conditions'=>['HowWorks.category'=>'why_choose_us']])->order(['modified'=>'desc']) ->limit(4)->where(['status' => 1])->toArray();
		$this->set('choose_data',$chooseData);

		//Fetch data news updates
		$news_data = $worksModel->find('all',['conditions'=>['HowWorks.category'=>'news_updates']])->order(['modified'=>'desc']) ->limit(3)->where(['status' => 1])->toArray();
		$this->set('news_data',$news_data);
		
	}
	
	/**
	* Function of guest login
	*/
	function login()
	{
		$this->viewBuilder()->layout('landing');
		// Loaded Admin Model
		$UsersModel = TableRegistry::get('Users');
	
		
		//CODE FOR MULTILIGUAL START
		$this->i18translation($UsersModel);
		//CODE FOR MULTILIGUAL END
		$UserData = $UsersModel->newEntity();
		$this->request->data = @$_REQUEST;
		
	    if(isset($this->request->data['Users']['email']) && !empty($this->request->data['Users']['email']))
		{
			$data=$this->request->data;
			$error=$this->validate_login($data);
			
			if(count($error) == 0)
			{
				$session = $this->request->session();
				$email = trim($this->request->data['Users']['email']);
				$password = md5(trim($this->request->data['Users']['password']));
				$getValidUserData = 	$UsersModel->find('all',
											['conditions' => ['Users.email' => $email,'Users.password' => $password]]
										);

				if($getValidUserData->count()>0)
				{
					$getUserData =  $getValidUserData->first();	
					if($getUserData->status==0){
						if ($this->request->is('ajax')) {
						  	echo 'Error:'.$this->stringTranslate(base64_encode('Email not verified yet.Kindly verify your email.'));
						  	die;
						}else{
							$this->setErrorMessage($this->stringTranslate(base64_encode('Email not verified yet.Kindly verify your email.')));
						}
					}else{
						
						$UserData->id = $getUserData->id;
						$UserData->last_login = date('Y-m-d h:i:s');
						$UserData->avail_status = "Login";
					 
						$UsersModel->save($UserData);
					 
						$session->write('User.id', $getUserData->id);
						$session->write('User.email', $getUserData->email);

						$session->write('User.user_type', $getUserData->user_type);

						$session->write('User.name', ucwords($getUserData->first_name." ".substr($getUserData->last_name,0,1)));
                        $session->write('User.facebook_id', $getUserData->facebook_id);
						$session->write('User.is_image_uploaded', $getUserData->is_image_uploaded);
						$session->write('User.image', $getUserData->image);
						$session->write('User.last_login', $getUserData->last_login);
						$session->write('User.user_type', $getUserData->user_type);
						
						$session->write('User.address1', $getUserData->address);
						$session->write('User.address2', $getUserData->address2);
						$session->write('User.zip', $getUserData->zip);
						$session->write('User.city', $getUserData->city);
						$session->write('User.state', $getUserData->state);
						$session->write('User.country', $getUserData->country);
						
						$this->setSuccessMessage($this->stringTranslate(base64_encode('You have successfully logged in.')));
						if ($this->request->is('ajax')) {
							echo 'Success:'.$this->stringTranslate(base64_encode('Successfully Authenticated, Please wait..'));
							die;
						}else{
							return $this->redirect(['controller' => 'Guests', 'action' => 'home']);	
						}
					}	
				}else{
						if($this->request->is('ajax')){
						  	echo 'Error:'.$this->stringTranslate(base64_encode('Authentication Failed! Please try again.'));
						  	die;
						}else{
							$this->setErrorMessage($this->stringTranslate(base64_encode('Authentication Failed! Please try again.')));
						}
			
				}

			}else{
				$this->set('loginerror',$error);
				$this->set('totalError',count($error));
				$this->set('signupdata',$data);
			}

		}
			$fb = new \Facebook\Facebook([
			'app_id' => FACEBOOK_APP_ID, // Replace {app-id} with your app id
			'app_secret' => FACEBOOK_SECRET,
			'default_graph_version' => 'v2.2',
			]);

			$helper = $fb->getRedirectLoginHelper();

			$permissions = ['email']; // Optional permissions
			$loginUrl = $helper->getLoginUrl(HTTP_ROOT.'guests/signup-with-facebook', $permissions);

			if($this->request->action=='login'){
				
				$this->set('loginWithFacebook', '<a class="signup-fb" href="' . htmlspecialchars($loginUrl) . '"><i class="fa fa-facebook-square"></i> Login with Facebook!</a>');
				$this->set('facebookUrl',$loginUrl);
				
			}else{
				$this->set('loginWithFacebook', '<a class="signup-fb" href="' . htmlspecialchars($loginUrl) . '"><i class="fa fa-facebook-square"></i> Signup with Facebook!</a>');
				$this->set('facebookUrl',$loginUrl);
			} 
			
	        
	
	}
	
	/**Function for Validate Lgon data
	*/
	function validate_login($data)
	{
		$errors=array();
		//Validation for email
		if(trim($data['Users']['email'])=='')
		{
			$errors['email'][]=$this->stringTranslate(base64_encode("This is required field"))."\n";
		}
		else
		{
			$checkEmail=explode('@',$data['Users']['email']);
			if($this->isValidEmail($data['Users']['email'])==0){
				$errors['email'][] = $this->stringTranslate(base64_encode("Please enter a valid email address"))."\n";
			}
		}
		
		//Validation for password
		if(trim($data['Users']['password'])=='')
		{
			$errors['password'][]=$this->stringTranslate(base64_encode("This is required field"))."\n";
		}		
		return $errors;
	}
	
	/**Function for forgot password
	*/
	function forgotPassword(){
		$this->viewBuilder()->layout('landing');
		// Loaded Admin Model
		$UsersModel = TableRegistry::get('Users');
		//CODE FOR MULTILIGUAL START
		$this->i18translation($UsersModel);
		//CODE FOR MULTILIGUAL END
		
		$this->request->data = @$_REQUEST;
		if(isset($this->request->data['Users']['email']) && !empty($this->request->data['Users']['email'])){
	
			$getUserData = $UsersModel->find('all',['conditions' => ['Users.email' => $this->request->data['Users']['email']]])->first();
			if(empty($getUserData)){
				$this->setErrorMessage($this->stringTranslate(base64_encode("Email id not register with us, try again")));

			  //  echo "Error:".$this->stringTranslate(base64_encode("Email id not register with us, try again")); die;
			  
			}else{
			    $UserData = $UsersModel->newEntity();
			    $UserData->id = $getUserData->id;
				$new_password = $this->RandomStringGenerator(8);
				$UserData->pwd_token = md5($new_password);
				
             
				if($UsersModel->save($UserData))
				{
					
					$uid = base64_encode($getUserData->email);
					$link = HTTP_ROOT.'Guests/reset-password/'.$uid.'/'.$UserData->pwd_token;
					$linkOnMail = '<a href="'.$link.'" target="_blank">'.$this->stringTranslate(base64_encode("Click here to reset password")).'.</a>';
					
					$replace = array('{fullname}','{email}','{link}');
					if($getUserData->first_name !='' || $getUserData->last_name !=""){
						$name = $getUserData->first_name." ".$getUserData->last_name;
					}else{
						$name = "Guest";
					}
					$with = array($name,$getUserData->email, $linkOnMail);
					
					$this->send_email('',$replace,$with,'forgot_password',$getUserData->email);		
					
				     
						$this->setSuccessMessage($this->stringTranslate(base64_encode('Password reset link has been sent over registered email address.')));
						
	                return $this->redirect(['controller' => 'Guests', 'action' => 'forgot-success']);   
				}
            }
		}
	}
	
	
	public function forgotSuccess(){
		$this->viewBuilder()->layout('landing');
				
	}
	
	/**Function for Reset Password
	*/ 
	function resetPassword($uid=null,$key = null)
	{
		$this->viewBuilder()->layout('landing');
		$session = $this->request->session();
		// Loaded Admin Model
		$UsersModel = TableRegistry::get('Users');
		//CODE FOR MULTILIGUAL START
		$this->i18translation($UsersModel);
		//CODE FOR MULTILIGUAL END
		
		$UserData = $UsersModel->newEntity();
		$this->request->data = @$_REQUEST;
		$uid = base64_decode($uid);
		if($uid !=""){
			$this->set("email",$uid);
		}else{
			$uid = $this->request->data['Users']['email'];
			$this->set("email",$uid);
		}
		
		if($key !=""){
			$this->set("key",$key);
		}else{
			$key = $this->request->data['Users']['key'];
			$this->set("key",$key);
		}
		
		$count=$UsersModel->find("all",["conditions"=>['Users.email'=>$uid,'Users.pwd_token'=>$key]])->first();
		
		if(isset($count->email) &&  $count->pwd_token==$key)
		{

			if(isset($this->request->data['Users']) && !empty($this->request->data['Users'])){
			
				$data = $this->request->data;
				$error=$this->validate_resetPwd($data);
				if(count($error) == 0)
				{
				
					$UserData->password = md5($this->request->data['Users']['password']);
					$UserData->org_password =$this->data['Member']['password'];
					$UserData->status = 1;
					$UserData->pwd_token = '';
					$UserData->id = $count->id;
					
					$UsersModel->save($UserData);              
					
					$getUserData = 	$UsersModel->find('all',
											['conditions' => ['Users.email' => $uid]]
										)->toArray();
					//echo "<pre>"; print_r($getUserData);die;
					$session->write('User.id', $getUserData[0]->id);
					$session->write('User.email', $getUserData[0]->email);
					$session->write('User.user_type', $getUserData[0]->user_type);
					$session->write('User.name', ucwords($getUserData[0]->first_name." ".substr($getUserData[0]->last_name,0,1)));
	                $session->write('User.facebook_id', $getUserData[0]->facebook_id);
					$session->write('User.is_image_uploaded', $getUserData[0]->is_image_uploaded);
					$session->write('User.image', $getUserData[0]->image);
					$session->write('User.last_login', $getUserData[0]->last_login);
					$session->write('User.user_type', $getUserData[0]->user_type);
					$session->write('User.address1', $getUserData[0]->address);
					$session->write('User.address2', $getUserData[0]->address2);
					$session->write('User.zip', $getUserData[0]->zip);
					$session->write('User.city', $getUserData[0]->city);
					$session->write('User.state', $getUserData[0]->state);
					$session->write('User.country', $getUserData[0]->country);


					$replace = array('{full_name}');
					$with = array($count->first_name." ".$count->last_name);
					$this->send_email('',$replace,$with,'user_reset_password',$count->email);
					
					$this->setSuccessMessage($this->stringTranslate(base64_encode("Password has been reset successfully")));
					
					 return $this->redirect(['controller' => 'Guests', 'action' => 'home']); 
			    }else{
					$this->set('loginerror',$error);
					$this->set('totalError',count($error));
					$this->set('signupdata',$data);
				}
			}	
		}else{
			$this->setErrorMessage($this->stringTranslate(base64_encode("Reset password link has been expired")));
			return $this->redirect(['controller' => 'Guests', 'action' => 'home']);
		}
	}
	
	/**
	* Function for Validate RESET PASSWORD
	*/
	function validate_resetPwd($data)
	{
		
		$errors=array();
				
		if(trim($data['Users']['password'])=="")
		{
			$errors['password'][]=$this->stringTranslate(base64_encode("Please enter your password"))."\n";
		}
		else 
		{
			$length=strlen($data['Users']['password']);
			if($length < 6)
			{
				$errors['password'][]=$this->stringTranslate(base64_encode("Please enter minimum 6 characters"))."\n";
			}
		}
		if(trim($data['Users']['re_password'])=="")
		{
			$errors['re_password'][]=$this->stringTranslate(base64_encode("Please enter your Confirm password"))."\n";
		}
		else 
		{
			if($data['Users']['password'] != $data['Users']['re_password'])
			{
				$errors['re_password'][]=$this->stringTranslate(base64_encode("Password does not match"));
			}
		}	
		
		return $errors;
	}
	
	/**Function for logout
	*/	
	function logout(){
		
		// Loaded Session Component
		$session = $this->request->session();
		
		$UsersModel = TableRegistry::get('Users');
		
		$getUserData = $UsersModel->find('all',['conditions' => ['Users.id' => $session->read('User.id')]])->first();
		
		$UserData = $UsersModel->newEntity();
		@$UserData->id = $getUserData->id;
		$UserData->last_login = date('Y-m-d h:i:s');
		$UserData->avail_status = "Logout";
		
		$UsersModel->save($UserData);
		
		$session->delete('User');
		$session->delete('requestedLanguage');
		$session->delete('setRequestedLanguageLocale');
		$session->delete('profile');
		$session->delete('dog_in_home_status');
		$session->delete("currency");
		
		return $this->redirect(['controller' => 'guests']);
	}
		
	/**Function for Login page
	*/
	function signup()
	{

		$this->viewBuilder()->layout('landing');
		$error=array();
		$captchErr="";
		$this->request->data = @$_REQUEST;
		$UserBadgeModel=TableRegistry :: get("Users_badge");
		$UserBadgedata=$UserBadgeModel->newEntity();
		// print_r($this->request->data['Users']);die;
		if(isset($this->request->data['Users']))
		{ 
			// echo 'test by sachin ';die;
			if(isset($this->request->data['g-recaptcha-response']) && !empty($this->request->data['g-recaptcha-response'])){
					//your site secret key
					$secret = CAPTCHA_SECRET_KEY;
					//get verify response data
					$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$this->request->data['g-recaptcha-response']);
					$responseData = json_decode($verifyResponse);

                    if($responseData->success){
						$this->request->data['Users']['password'] = $this->request->data['Users']['create_password'];
						 
						unset($this->request->data['Users']['create_password']);
                    	



						$data=$this->request->data;
						$error=$this->validate_register($data);
                    	// print_r($error);die;

						if(count($error) == 0)
						{
							// echo 'here';die;
							// Loaded Users Model
							$UsersModel = TableRegistry::get('Users');
							// Code for Reference Code Activation
							$referenceCodeFlag = false;
							if(!empty($this->request->data['Users']['reference_code'])){
								$referenceCode = $this->request->data['Users']['reference_code'];
								$referenceCodeFlag = true;
								unset($this->request->data['Users']['reference_code']);
							}else{
								unset($this->request->data['Users']['reference_code']);	
							}
							$UsersData = $UsersModel->newEntity($this->request->data['Users'],['validate' => true]);
							//CODE FOR MULTILIGUAL START
							$session = $this->request->session();
							$UsersModel->_locale = $session->read('requestedLanguage');
							//CODE FOR MULTILIGUAL END
                            $passwordOrg = $this->request->data['Users']['password'];
							
							$activation_key = md5(microtime());							
							$UsersData->password = md5($passwordOrg);
							//SET CUSTOM VARIABLES FOR SAVE
							$UsersData->org_password = $passwordOrg;
							$UsersData->activation_key = $activation_key;								
							$UsersData->date_added=date('Y-m-d H:i:s');	
							$UsersData->date_modified = date('Y-m-d h:i:s');	
										// print_r($UsersData);die;
			
							$latitude = $this->request->data['Users']['country'];				
							$longitude = $this->request->data['Users']['zip'];	
							//echo $latitude.$longitude;die;
							// get latitude and longitude from country and zip start	
							$sourceSelectedLocation = $latitude." ".$longitude;
							$url = "http://maps.google.com/maps/api/geocode/json?address=".urlencode($sourceSelectedLocation)."&sensor=false";
							$ch = curl_init();
							curl_setopt($ch, CURLOPT_URL, $url);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
							curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
							curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
							$response = curl_exec($ch);
							curl_close($ch);
							$response_a = json_decode($response);
							$sourceLocationLatitude = $response_a->results[0]->geometry->location->lat;
							$sourceLocationLongitude = $response_a->results[0]->geometry->location->lng;
							$UsersData->latitude=$sourceLocationLatitude;					
							$UsersData->longitude=$sourceLocationLongitude;					
							// end get latitude and longitude from country and zip start			
							$UsersData->status = 0;
							// 
							$SaveNewUser=$UsersModel->save($UsersData);
							$newUserId=$SaveNewUser['id'];
							if($SaveNewUser)
							{
								$getUsersTempId1 = $UsersData->id;
								$UserBadgedata->user_id= $UsersData->id;
								$UserBadgeModel->save($UserBadgedata);
								
								//pr($UsersData->id);die;
								$uid = base64_encode($this->request->data['Users']['email']);
								$link = HTTP_ROOT.'guests/activation/'.$uid.'/'.$activation_key.'/success:registerSuccess';
								$linkOnMail = '<a href="'.$link.'" target="_blank">'.$this->stringTranslate(base64_encode('Click Here For Activate Your Account')).'</a>';
								
								$replace = array('{full_name}','{email}','{link}');
								$with = array($this->request->data['Users']['first_name'],$this->request->data['Users']['email'],$linkOnMail);
								
								// Code for Reference Code Activation
								/*if($referenceCodeFlag){
									$referencesModel = TableRegistry::get('UserReferences');
									$checkReference = $referencesModel->find('all',[
										'conditions'=>[
											'UserReferences.reference_code' => $referenceCode, 
											'UserReferences.status' => 0, 
											'UserReferences.email' => $this->request->data['Users']['email']
										]])->toArray();
										
									if (count($checkReference)) { // if reference code present change status to 1
										$referenceData = $referencesModel->newEntity();
										$referenceData -> id = $checkReference[0]->id; 
										$referenceData -> status = 1;		
										$referencesModel->save($referenceData);
										
										// updating the reference money
										$referenceMoneyData = $UsersModel->newEntity();
										$referUserData = $UsersModel->get($checkReference[0]->user_id);
										$referConfigAmount = 20;
										$newReferAmount = $referUserData->refer_amount + $referConfigAmount;
										
										$referenceMoneyData->id = $checkReference[0]->user_id;
										$referenceMoneyData->refer_amount = $newReferAmount;
										$UsersModel->save($referenceMoneyData);
										
									}
								 }*/
								
								$this->send_email('',$replace,$with,'new_registration',$this->request->data['Users']['email'],'');
								
								$userInfo = $UsersModel->get($getUsersTempId1);
								//$this->UsersessionSet($userInfo);
								
								
								if ($this->request->is('ajax')) {
										//echo "Success:".$this->stringTranslate(base64_encode(SIGN_UP)).":guests/login";
										$this->setSuccessMessage($this->stringTranslate(base64_encode(SIGN_UP)));
										die;
									}else{
										$this->setSuccessMessage($this->stringTranslate(base64_encode(SIGN_UP)));
										return $this->redirect(['controller' => 'guests', 'action' => 'sign-thankyou', '?' => array(
        'newuserid' => $newUserId
    )]);			
								//die;
									}
							 
								
							} else{
								
								$this->set('loginerror',$this->Member->validationErrors);
								$this->set('totalError',count($this->Member->validationErrors));
								$this->set('signupdata',$data);
							} 
						}
					}else{
						$captchErr = $this->stringTranslate(base64_encode('Robot verification failed, please try again'));
					}
				}else{
					$captchErr = $this->stringTranslate(base64_encode('Please click on the reCAPTCHA box'));
				}
			}else{
					
				$this->set('loginerror',$error);
				$this->set('totalError',count($error));
				$this->set('signupdata',@$data);
			}
			$this->set('captchErr',@$captchErr);
			
			$fb = new \Facebook\Facebook([
			'app_id' => FACEBOOK_APP_ID, // Replace {app-id} with your app id
			'app_secret' => FACEBOOK_SECRET,
			'default_graph_version' => 'v2.2',
			]);

			$helper = $fb->getRedirectLoginHelper();

			$permissions = ['email']; // Optional permissions
			$loginUrl = $helper->getLoginUrl(HTTP_ROOT.'guests/signup-with-facebook', $permissions);


			$this->set('signupWithFacebook', '<a href="' . htmlspecialchars($loginUrl) . '"><i class="fa fa-facebook-square"></i> Signup with Facebook!</a>');
	        $this->set('facebookUrl',$loginUrl);
	}
	/**Function for Sign Up With Refer
	*/
	function share($shortname = null,$token=null,$referId = null)
	{
		$this->viewBuilder()->layout('landing');
		
		//$referId = convert_uudecode(base64_decode($referId));
	    $session = $this->request->session();
	    $userId = $session->read("User.id");
	    $UsersModel = TableRegistry::get('Users');
	    $UserBadgeModel=TableRegistry :: get("Users_badge");
		$UserBadgedata=$UserBadgeModel->newEntity();
	 
		if(isset($this->request->data['Users']['reference_promocode']) && $this->request->data['Users']['reference_promocode'])
		{ 
			    $UsersData = $UsersModel->newEntity();
			    $UsersData = $UsersModel->patchEntity($UsersData, $this->request->data['Users'],['validate'=>'update']);
			    
			         if(!$UsersData->errors()){
						
							//CODE FOR MULTILIGUAL START
							$session = $this->request->session();
							//CODE FOR MULTILIGUAL END
                            $passwordOrg = $this->request->data['Users']['password'];
							if($this->request->data['Users']['reference_type']=='token'){
								$promocode_requested =  convert_uudecode(base64_decode($this->request->data['Users']['reference_promocode']));
							}else{
								$promocode_requested = $this->request->data['Users']['reference_promocode'];
							}	
							
							
							
							$ReferedUserData = $UsersModel->find('all',['conditions'=>["Users.id ='$promocode_requested' OR Users.reference_code='$promocode_requested'"]])
							->select('Users.id')
							->first();
							
							
							if(!empty($ReferedUserData)){
								$referID = $ReferedUserData->id;
							}else{
								$referID = 0;
							}
							
							$activation_key = md5(microtime());							
							$UsersData->password = md5($this->request->data['Users']['password']);
							$UsersData->reference_id = $referID; 
							//SET CUSTOM VARIABLES FOR SAVE
							$UsersData->org_password = $this->request->data['Users']['password'];
							$UsersData->activation_key = $activation_key;								
							$UsersData->date_added=date('Y-m-d H:i:s');	
							$UsersData->date_modified = date('Y-m-d h:i:s');				
							
							//GET LATITUDE LONGITUDE FROM SELECTED ZIP CODE
							$url = "http://maps.google.com/maps/api/geocode/json?address=".urlencode($this->request->data['Users']['zip'])."&sensor=false"; 
								$ch = curl_init();
								curl_setopt($ch, CURLOPT_URL, $url);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
								curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
								curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
								curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
								$response = curl_exec($ch);
								curl_close($ch);
								$response_a = json_decode($response);
								@$sourceLocationLatitude = $response_a->results[0]->geometry->location->lat;
								@$sourceLocationLongitude = $response_a->results[0]->geometry->location->lng;
							
							$UsersData->latitude=$sourceLocationLatitude;					
							$UsersData->longitude=$sourceLocationLongitude;	
							$UsersData->status = 0;
							
							$UsersModel->save($UsersData);
							  $UserBadgedata->user_id= $UsersData->id;
								$UserBadgeModel->save($UserBadgedata);
								
								$uid = base64_encode($this->request->data['Users']['email']);
								$link = HTTP_ROOT.'guests/activation/'.$uid.'/'.$activation_key.'/success:registerSuccess';
								$linkOnMail = '<a href="'.$link.'" target="_blank">'.$this->stringTranslate(base64_encode('Click Here For Activate Your Account')).'</a>';
								
								$replace = array('{full_name}','{email}','{link}');
								$with = array($this->request->data['Users']['first_name'],$this->request->data['Users']['email'],$linkOnMail);
								
								$this->send_email('',$replace,$with,'new_registration',$this->request->data['Users']['email'],'');
							return $this->redirect(['controller' => 'guests', 'action' => 'reference-thankyou']);
					}else{
					    $this->set("userData",$UsersData);
					}

		}else{
			   if(isset($token) && !empty($token) && isset($referId) && !empty($referId) && isset($shortname) && !empty($shortname)){
						  $this->set("rf_token",$referId);
						 if($token == "promocode"){
							$this->set("token","promocode");
						 }else if($token == "token"){
							$this->set("token","token"); //MEANS ID	
						 }
				  }else{
						return $this->redirect(['controller' => 'guests']);
					}
		 }	

			
		$UserBlogsModel = TableRegistry::get('UserBlogs');
		$servicesModel = TableRegistry::get('Services');
		
		$blogsInfo = $UserBlogsModel->find('all', ['order' => ['UserBlogs.modified' => 'desc']]) ->limit(3)->where(['UserBlogs.featured' =>1])->where(['UserBlogs.status' =>1])->toArray();
		$this->set('blogsInfo',$blogsInfo);
		
		$servicesInfo = $servicesModel->find('all', ['order' => ['Services.created' => 'desc']]) ->limit(5)->where(['Services.status' =>1])->toArray();
		$this->set('servicesInfo',$servicesInfo);
					
		//Fetch data how works
		$worksModel = TableRegistry::get('HowWorks');
		$workdata = $worksModel->find('all', ['conditions' =>['HowWorks.category' => 'How_it_works']])->order(['modified'=>'desc']) ->limit(3)->where(['status' => 1])->toArray();
		$this->set('works_data',$workdata);

		//Fetch data why choose
		$chooseData = $worksModel->find('all',['conditions'=>['HowWorks.category'=>'why_choose_us']])->order(['modified'=>'desc']) ->limit(4)->where(['status' => 1])->toArray();
		$this->set('choose_data',$chooseData);

		//Fetch data news updates
		$news_data = $worksModel->find('all',['conditions'=>['HowWorks.category'=>'news_updates']])->order(['modified'=>'desc']) ->limit(3)->where(['status' => 1])->toArray();
		$this->set('news_data',$news_data);
	}
	/**Function Reference thankyou
	 * */
	function referenceThankyou(){
		 $this->viewBuilder()->layout('landing');
		 $SiteModel = TableRegistry::get('SiteConfigurations');
		 $siteConfigurationData=$SiteModel->find('all')->toArray();
		 $this->set('siteConfigurationData',$siteConfigurationData);
	}
	/**Function for Validate SIGN UP
	*/
	function validate_register($data)
	{
	    $errors=array();
		//Validation for first name
		if(trim($data['Users']['first_name'])=='')
		{
			$errors['first_name'][]= $this->stringTranslate(base64_encode("This is required field"))."\n";
		}else{
			if(is_numeric($data['Users']['first_name'])){
				$errors['first_name'][]= $this->stringTranslate(base64_encode("First name should be alphabatic"))."\n";
			}
		}
		//Validation for last name
		/*if(trim($data['Users']['last_name'])=='')
		{
			$errors['last_name'][]=$this->stringTranslate(base64_encode("This is required field"))."\n";
		}else{
			if(is_numeric($data['Users']['last_name'])){
				$errors['last_name'][]=$this->stringTranslate(base64_encode("Last name should be alphabatic"))."\n";
			}
		}*/
         //Validation for email
		if(trim($data['Users']['email'])=='')
		{
			$errors['email'][]=$this->stringTranslate(base64_encode("This is required field"))."\n";
		}
		else
		{
			$checkEmail=explode('@',$data['Users']['email']);
			if($this->isValidEmail($data['Users']['email'])==0){
				$errors ['email'] [] =$this->stringTranslate(base64_encode("Please enter valid email"))."\n";
			}else{
				if($this->isUniqueEmail($data['Users']['email'])=='false'){
					$errors ['email'] [] = $this->stringTranslate(base64_encode("Email already exists"))."\n";
				}
			}
		}
		//Validation for password
		if(trim($data['Users']['password'])=='')
		{
			$errors['password'][]=$this->stringTranslate(base64_encode("This is required field"))."\n";
		}
		
		if(trim($data['Users']['re_password'])=='')
		{
			$errors['re_password'][]=$this->stringTranslate(base64_encode("This is required field"))."\n";
		}
		if(trim($data['Users']['password'])!='' && trim($data['Users']['re_password'])!=''){
			if(trim($data['Users']['password']) != trim($data['Users']['re_password'])){
				$errors['re_password'][]=$this->stringTranslate(base64_encode("Password does not matched"))."\n";
			}
		}
		return $errors;
	}
	/**
	 Function for email verify
	*/	
	function verifyEmail(){
		       $UsersModel = TableRegistry::get('Users');
			 
			    $activation_key = md5(microtime());	
			    $UsersData= $UsersModel->newEntity();
			    
			    $UsersData->id = $userId;
				$UsersData->activation_key = $activation_key;	
				$UsersModel->save($UsersData);
				
			  if($UsersModel->save($UsersData)){
				    $UsersData = $UsersModel->get($userId);
				    $uid = base64_encode($UsersData->email);
					$link = HTTP_ROOT.'guests/activation/'.$uid.'/'.$activation_key.'/success:registerSuccess';
					$linkOnMail = '<a href="'.$link.'" target="_blank">'.$this->stringTranslate(base64_encode('Click Here For Activate Your Account')).'</a>';
					
					$replace = array('{full_name}','{email}','{link}');
					$with = array($UsersData->first_name,$UsersData->email,$linkOnMail);
					
				$this->send_email('',$replace,$with,'new_registration',$UsersData->email,'');
				
				 echo "Success:Verification link has been sent on your registered  email Id.";die;
	          
	          }else{
			     echo "Error:Network not working, please try again.";die;
			  }
	}
	/**Function for member activation
	*/ 
	function activation($uid=null,$key = null)
	{
		// echo 'here';die;
		$session = $this->request->session();
		$this->viewBuilder()->layout('landing');
		
		$uid = base64_decode($uid);
		$UsersModel = TableRegistry::get('Users');
		$userData= $UsersModel->newEntity();
		$countRec = $UsersModel->find('all',['conditions' => ['Users.email' => $uid,'Users.activation_key' => $key]])->count();
		$count = $UsersModel->find('all',['conditions' => ['Users.email' => $uid ,'Users.activation_key' => $key]])->first();
			//echo "<pre>"; print_r($count);die;
		if($countRec >= 0){
			if($count->email !="" &&  $count->activation_key==$key)
			{   
				
				
				$userData->logged_intime = date('Y-m-d H:i:s');
				$userData->id = $count->id;
				$userData->status=1;
				$userData->activation_key="";
				
				$UsersModel->save($userData);
			   
			   
				//$getUserData =  $getValidUserData->first();	
				//echo "<pre>"; print_r($getUserData);die;
				/*$userActivateData = $UsersModel->newEntity();
				$userActivateData->last_login = date('Y-m-d h:i:s');
				$userActivateData->avail_status = "Login";
			 
				$UsersModel->save($userActivateData);*/
			 	$getUserData = 	$UsersModel->find('all',
											['conditions' => ['Users.email' => $uid]]
										)->toArray();
				$session->write('User.id', $getUserData[0]->id);
				$session->write('User.email', $getUserData[0]->email);
				$session->write('User.user_type', $getUserData[0]->user_type);
				$session->write('User.name', ucwords($getUserData[0]->first_name." ".substr($getUserData[0]->last_name,0,1)));
                $session->write('User.facebook_id', $getUserData[0]->facebook_id);
				$session->write('User.is_image_uploaded', $getUserData[0]->is_image_uploaded);
				$session->write('User.image', $getUserData[0]->image);
				$session->write('User.last_login', $getUserData[0]->last_login);
				$session->write('User.user_type', $getUserData[0]->user_type);
				$session->write('User.address1', $getUserData[0]->address);
				$session->write('User.address2', $getUserData[0]->address2);
				$session->write('User.zip', $getUserData[0]->zip);
				$session->write('User.city', $getUserData[0]->city);
				$session->write('User.state', $getUserData[0]->state);
				$session->write('User.country', $getUserData[0]->country);
				$replace = array('{full_name}');
				$with = array($count->first_name." ".$count->last_name);
				$this->send_email('',$replace,$with,'account_activated',$count->email);
				$this->setSuccessMessage($this->stringTranslate(base64_encode(ACTIVATE_ACCT)));
				
			}
		}else{
			//$this->setErrorMessage($this->stringTranslate(base64_encode("Activation link has been expired")));
			$this->setErrorMessage($this->stringTranslate(base64_encode("Account already Registered")));
		}
		return $this->redirect(['controller' => 'guests', 'action' => 'home']);			
	}
	/**
      function for subscribe 
	*/	
     function subscribe(){
     	$SubscribesModel = TableRegistry::get('Subscribes');

		$this->request->data = @$_REQUEST;
		
		if(isset($this->request->data['Subscribes']['email']) && !empty($this->request->data['Subscribes']['email'])){
			$getSubscribeData = $SubscribesModel->find('all',['conditions' => ['Subscribes.email' => $this->request->data['Subscribes']['email']]])->first();
				
			if(!empty($getSubscribeData)){

			   echo "Error:".$this->stringTranslate(base64_encode("Email already exists"));
               $this->setErrorMessage($this->stringTranslate(base64_encode("Email already exists")));
			   die;
			}else{
				$SubscribeData = $SubscribesModel->newEntity();
                $SubscribeData->email = $this->request->data['Subscribes']['email']; 
                if($SubscribesModel->save($SubscribeData))
				{
					$replace = array('{message}');
				    $with = array($this->request->data['Subscribes']['email']);
						
					echo 'Success:'.$this->stringTranslate(base64_encode("You have been subscribe successfully"));
					$this->setSuccessMessage($this->stringTranslate(base64_encode("You have been subscribe successfully")));
					$this->send_email('',$replace,$with,'subscribe_confirmation',$this->request->data['Subscribes']['email'],'');
				}
				die;
            }
	 } 
  }/**
                 
  */
  function subscriberEmailExists(){

		$SubscribesModel = TableRegistry::get('Subscribes');
		if(@$_REQUEST['Subscribes']['email']!='')
		{
			$email = $_REQUEST['Subscribes']['email'];
		}
		$getData = $SubscribesModel->find('all',['conditions' => ['Subscribes.email' => $email]])->count();
		
		if ($getData>0) {
			 $ret = 'false';
		} else { 
			  $ret = 'true';//Email not exiting in out database error display 
		} 
		if($this->request->is('ajax')){
			echo $ret;die;
		
		}else{
			return $ret;
		
		}
  }
  function verifySite($recaptcha)
  {
	 $recaptchaAuthUrl="https://www.google.com/recaptcha/api/siteverify";
	 $secret='6Led9RkTAAAAAJ_YhXH6_jy-9bkTFZFph5nRB9l3';
	 $remoteip=$_SERVER['REMOTE_ADDR'];
	 $url=$recaptchaAuthUrl."?secret=".$secret."&response=".$recaptcha."&remoteip=".$remoteip;
	 $curl = curl_init();
	 curl_setopt($curl, CURLOPT_URL, $url);
	 curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	 curl_setopt($curl, CURLOPT_TIMEOUT, 10);
	 curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
	 $res = curl_exec($curl);
	 curl_close($curl);
	 return $res;
	}
	
	/**Function for Login page
	*/
	function signupWithFacebook()
	{
		if(isset($this->request->query['error'])){
			$this->setErrorMessage($this->request->query['error_description'].", Kindly try later.");
			return $this->redirect(['controller' => 'guests', 'action' => 'home']);			
		}
		
		$fb = new \Facebook\Facebook([
		  'app_id' => FACEBOOK_APP_ID, // Replace {app-id} with your app id
		  'app_secret' => FACEBOOK_SECRET,
		  'default_graph_version' => 'v2.5',
		  ]);
		
		$helper = $fb->getRedirectLoginHelper();
		$accessToken = $helper->getAccessToken();
		$fb->setDefaultAccessToken($accessToken);
		
		$response = $fb->get('/me?fields=first_name, last_name, picture, email');
		$userNode = $response->getGraphUser();
		
		
		$UsersModel = TableRegistry::get('Users');
		$UsersData = $UsersModel->newEntity();
		
		$passwordOrg = $this->RandomStringGenerator(15);
		$UsersData->password = md5($passwordOrg);
		
		//SET CUSTOM VARIABLES FOR SAVE
		$UsersData->org_password = $passwordOrg;
		$UsersData->date_added=date('Y-m-d H:i:s');					
		$UsersData->status = 0;
		
		$fname = $userNode->getProperty('first_name');
		$lname = $userNode->getProperty('last_name');
		$email = $userNode->getProperty('email');
		$fbId  = $userNode->getProperty('id');
		
		$UsersData->first_name = $fname;
		$UsersData->last_name = $lname;
		$UsersData->is_image_updated = 0;
		$UsersData->email = $email;
		$UsersData->is_image_uploaded = 0;
		$UsersData->facebook_id = $fbId;
		$UsersData->image = "https://graph.facebook.com/".$fbId."/picture";
		
		if($this->isUniqueEmail($email)==1){
			if($UsersModel->save($UsersData))
			{
				$getUsersTempId1 = $UsersData->id;
									
				$replace = array('{full_name}','{email}','{password}');
				$with = array($fname." ".$lname,$email,$passwordOrg);
				
				
				$this->send_email('',$replace,$with,'signup_with_facebook',$email,'');
				
				$userInfo = $UsersModel->get($getUsersTempId1);
				$this->UsersessionSet($userInfo);
				$this->setSuccessMessage(SIGN_UP);
				return $this->redirect(['controller' => 'guests', 'action' => 'sign-thankyou']);		
				
			}
		}else{
			
				$session = $this->request->session();
				$email = trim($email);
				$getValidUserData = $UsersModel->find('all',
											['conditions' => ['Users.email' => $email]]
									);

				if($getValidUserData->count()>0)
				{
					$getUserData =  $getValidUserData->first();
					$myLoginInfo = $UsersModel->newEntity();
					
					$myLoginInfo->id = $getUserData->id;
					$myLoginInfo->last_login = date('Y-m-d h:i:s');
				 	$UsersModel->save($myLoginInfo);
				 
					$session->write('User.id', $getUserData->id);
					$session->write('User.email', $getUserData->email);
					$session->write('User.name', $getUserData->first_name." ".$getUserData->last_name);
					$session->write('User.image', $getUserData->image);
					$session->write('User.last_login', $getUserData->last_login);
					$this->setSuccessMessage($this->stringTranslate(base64_encode('You have successfully logged in')));
					return $this->redirect(['controller' => 'Guests', 'action' => 'home']);	
					
				}else{
					$this->setErrorMessage($this->stringTranslate(base64_encode('Authentication Failed! Please try again')));
				}
			
		}
		$this->render("signup");
		
	}
	
	public function checkDevice() {
		/*
		$this->loadComponent('MobileDetect');
		
		// Any mobile device (phones or tablets).
		if( $this->MobileDetect->isMobile() ){
			$detect= "mobile";	
		} else {
			$detect= "desktop";
		}*/
		$useragent=$_SERVER['HTTP_USER_AGENT'];

		if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
			
			$detect= "mobile";
		}else{
			$detect= "desktop";
		}

		$this->set('detect',$detect);
	}
	
	
	public function signThankyou(){
		$this->viewBuilder()->layout('landing');
		if(!empty($_GET['newuserid'])){
				 $newUserID=$_GET['newuserid'];
		}
		$this->set('newUserID',$newUserID);
		$SiteModel = TableRegistry::get('SiteConfigurations');
		$siteConfigurationData=$SiteModel->find('all')->toArray();
		$this->set('siteConfigurationData',$siteConfigurationData);
		// for find near by users
		$UsersModel= TableRegistry::get('Users');
		$userData=$UsersModel->find('all')->where(['id'=>$newUserID])->toArray();
				    //$Userratingdata=$userData->user_ratings;
					//$userFromArr=array();
					//foreach($Userratingdata as $Userrating){
					//	$userFromArr[]=$Userrating->user_from;
					//}
					$gettingUserData=$UsersModel->find('all')->where(['user_type'=>'Sitter'])->contain(['Users_badge','UserRatings','UserSitterServices'])->toArray();
					// echo "<pre>"; print_R($gettingUserData);die;
					 $commentUserData=array();
					//foreach($gettingUserData as $gettingUser){
						//	if(in_array($gettingUser->id,$userFromArr)){
							//	$commentUserData[]=$gettingUser;
						//	} 
					//}
				
					$sourceLocationLatitude =$userData[0]->latitude;
					$sourceLocationLongitude =$userData[0]->longitude;
					if((!empty($sourceLocationLatitude)) && (!empty($sourceLocationLongitude))){
					$query='SELECT
									  id, (
										3959 * acos (
										  cos ( radians('.$sourceLocationLatitude.') )
										  * cos( radians( latitude ) )
										  * cos( radians( longitude ) - radians('.$sourceLocationLongitude.') )
										  + sin ( radians('.$sourceLocationLatitude.') )
										  * sin( radians( latitude ) )
										)
									  ) AS distance
									FROM users
									HAVING distance < '.DEFAULT_RADIUS.'
									ORDER BY distance';
				$connection = ConnectionManager::get('default');
				$results = $connection->execute($query)->fetchAll('assoc');	//RETURNS ALL USER ID WITH DISTANSE 			
				$finalDistanceArr=array();
				foreach($results as $result){
					foreach($gettingUserData as $favData){
							$selUserData=$favData->id;
							if(in_array($selUserData,$result)){
								
								$finalDistanceArr[]=$result;
							} 
				} 
				}
				
				if(!empty($finalDistanceArr)){
					$idArr = array();
					$distanceAssociation = array();
					foreach($finalDistanceArr as $resultsValue){
							$idArr[] = $resultsValue['id']; //STORE ALL ID INTO AN ARRAY
							//STORE ALL DISTANCE ALONG WITH USER ID AS KEY INTO AN ARRAY
							$distanceAssociation[$resultsValue['id']] = $resultsValue['distance'];
				}}
				//echo "<pre>"; print_R($distanceAssociation);die;
				$nearUseridArr=array();	
				foreach($distanceAssociation as $key=>$diatance){
						if($diatance != 0){
								$nearUseridArr[]=$key;
						}
				}	
		
				$this->set('distanceAssociation',$distanceAssociation);	
				$bookingRequestModel = TableRegistry :: get("BookingRequests");
				
					
				foreach($gettingUserData as $key=> $gettingUser){
						if(in_array($gettingUser->id,$nearUseridArr)){
							@$flag++;
							if($flag < 5){
								$getUsersArr[]=$gettingUser;
								$userIDs=$gettingUser['id'];
						
							
				
				$getUsersArr[$key]['repeatClient'] = $bookingRequestModel->find('all')
							->where(['BookingRequests.sitter_id' => $userIDs/*,'BookingRequests.folder_status_guest' => "pending"*//*,'BookingRequests.read_status' => "unread"*/])
							->group('BookingRequests.user_id HAVING COUNT(BookingRequests.user_id) != 1' )
							->hydrate(false)->count();
							
				
			//end repeat client
							}
							
						}
				}
			
			$this->set('getUsersArr',$getUsersArr);
			
		}
				//echo "<pre>"; print_R($getUsersArr);die;
		
		
		//end of near by user function
		
		if(isset($this->request->data) && !empty($this->request->data))
		{
			//pr($this->request->data);
				//echo "<pre>"; print_r($this->request->data); die;
				$userID=$this->request->data['checkboxG3'];
				$message=$this->request->data['message'];
				$newUserData=$UsersModel->find('all')->where(['id'=>$newUserID])->toArray();
				//echo "<pre>"; print_r($newUserData); die;
				$name=$newUserData[0]['first_name']." ".$newUserData[0]['last_name'];
				$email=$newUserData[0]['email'];
				
				$Userdata=array();
				foreach($userID as $user){
					$Userdata=$UsersModel->find('all')->where(['id'=>$user])->toArray();
					$full_name=$Userdata[0]['first_name']." ".$Userdata[0]['last_name'];
					$emailReceive=$Userdata[0]['email'];
					
					$replace = array('{full_name}','{name}','{email}','{message}');
					$with = array($full_name,$name,$email,$message);
					$this->send_email('',$replace,$with,'contact_request_on_registration',$emailReceive,'');
				}
				$this->setSuccessMessage($this->stringTranslate(base64_encode("Your message send to selected Sitters.")));
			 	//$this->Flash->error(__("You Can't book itself."));

			 	//$user_id=$_GET['uid'];
			 	$UserModel=TableRegistry::get('Users');
	        	$getUserData=$UserModel->find('all')->where(['id'=>$newUserID])->toArray();
	        	//echo "<pre>"; print_r($getUserData[0]);die;
	        	$session = $this->request->session();
	        	$session->write('User.id', $getUserData[0]->id);
				$session->write('User.email', $getUserData[0]->email);

				$session->write('User.user_type', $getUserData[0]->user_type);

				$session->write('User.name', ucwords($getUserData[0]->first_name." ".substr($getUserData[0]->last_name,0,1)));
	            $session->write('User.facebook_id', $getUserData[0]->facebook_id);
				$session->write('User.is_image_uploaded', $getUserData[0]->is_image_uploaded);
				$session->write('User.image', $getUserData[0]->image);
				$session->write('User.last_login', $getUserData[0]->last_login);
				$session->write('User.user_type', $getUserData[0]->user_type);
				
				$session->write('User.address1', $getUserData[0]->address);
				$session->write('User.address2', $getUserData[0]->address2);
				$session->write('User.zip', $getUserData[0]->zip);
				$session->write('User.city', $getUserData[0]->city);
				$session->write('User.state', $getUserData[0]->state);
				$session->write('User.country', $getUserData[0]->country);
				return $this->redirect(['controller' => 'Guests', 'action' => 'home']);
				//echo "<pre>"; print_r($Userdata); die;
		} 
		
		
	}
	//For cookie
	function userCookie(){
	    $cookie_name = "userCookie";
		$cookie_value = "setUserCookie";
		
		setcookie($cookie_name, $cookie_value,time() + (86400 * 30), "/"); // 86400 = 1 day
		//echo $_COOKIE["userCookie"];
         die;
     }

}
?>
