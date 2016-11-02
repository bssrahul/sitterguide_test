	var host = window.location.host;
	var proto = window.location.protocol;
	var ajax_url = proto+"//"+host+"/sitterguide_test/"; 
	
	/*FUNCTION FOR VALIDATION*/
	  $(document).ready(function(){
		  $("#flip").click(function(){
			  $("#panel").slideDown("slow");
		  });
		   $("#flipclose").click(function(){
			  $("#panel").slideUp("slow");
		  });
		  $(window).scroll(function() {

		 if ($(this).scrollTop()>775)
		 {		
			$('.panel-pop').hide("slow");
		 }
		});	  	  
	  });
	$(document).ready(function(){
		
		//SLIDEUP MESSAGES FUNCTIONALITY START
		
		$('.success_msg, .error_msg').on('click',function(){
				$(this).slideUp(1000);
		});
		setInterval(function() {
		   $('.success_msg, .error_msg').slideUp();
		}, 10000);
		//DROP DOWN TOGGEL
		$('#droplogForgot').click(function () {
			$('#dropcont').hide();
            $('#dropcontForgot').fadeToggle();
            setTimeout(function(){$("#droplog").trigger("click");},500);

        });

        $('#loginBack').click(function () {
			$('#dropcontForgot').hide();
            $('#dropcont').fadeToggle();
            setTimeout(function(){$("#droplog").trigger("click");},500);

        });
		//SLIDEUP MESSAGES FUNCTIONALITY START
		
		//CODE SNIPPET FOR SIGN UP
	
		$('#addUsers').validate({
			rules: {
				"Users[title]":
				{
					required:true,
					
				},
				"Users[first_name]":
				{
					required:true,
					lettersonly: true ,
				},
				"Users[last_name]":
				{
					lettersonly: true
				},
				"Users[email]":
				{
					required: true,
					email: true,
					remote: ajax_url+"App/isUniqueEmailAjax"
				},
				"Users[create_password]":
				{
					required: true,
					minlength: '6'
				},
				"Users[re_password]":
				{
					required: true,
					equalTo: '#users-create-password'
				},
				"Users[zip]":
				{
					required:true
				},
				"Users[birth_date]":
				{
					required:true
				},
				"Users[country]":
				{
					required:true
				},
				"Users[term_condition]":
				{
					required:true
				}
			},
			messages: {
				"Users[title]":
				{
					required : "This field is required"
					
				},
				"Users[first_name]":
				{
					required : "This field is required"
					
				},
				"Users[email]":
				{
					required : "This field is required",
					email: 'Kindly use valid email address',
					remote: "Email address already exists"
					
				},
				"Users[create_password]":
				{
					required : "This field is required",
					minlength: 'Please enter minimum 6 characters.'
				},
				"Users[re_password]":
				{
					required : "This field is required",
					equalTo: 'Password does not match'
				},
				"Users[zip]":
				{
					required : "This field is required",
				},
				"Users[birth_date]":
				{
					required : "This field is required"
					
				},
				"Users[country]":
				{
					required : "This field is required"
					
				},
				"Users[term_condition]":
				{
					required : "This field is required"
					
				}
			}
			
		});
		// code for review add page
		$('#addrating').validate({
			rules: {
				"comment":
				{
					required:true,
					minlength:10
				},
				"rating":
				{
					required:true
				}
				
			},
			messages: {
				"comment":
				{
					required : "This field is required",
					minlength: 'Please enter minimum 6 characters.'
					
				},
				"rating":
				{
					required : "This field is required"
					
				}
				
			}
		});
		
		// code for review edit page
		
		$('#editrating').validate({
			rules: {
				"Comment":
				{
					required:true,
					minlength:10
				},
				"rating":
				{
					required:true
				}
				
			},
			messages: {
				"comment":
				{
					required : "This field is required",
					minlength: 'Please enter minimum 6 characters.'
					
				},
				"rating":
				{
					required : "This field is required"
					
				}
				
			}
		});
		//CODE SNIPPET FOR EDIT PROFILE
		$('#profileedit').validate({
			rules: {
				"Users[first_name]":
				{
					required:true,
				},
				"Users[last_name]":
				{
					required:true,
				},
				/*"Users[email]":
				{
					required: true,
					email: true,
					remote: ajax_url+"App/isUniqueEmailAjax"
				},*/
				"Users[phone]":
				{
					required: true,
					minlength: '10'
				}/*,
				"Users[re_password]":
				{
					required: true,
					minlength: '6',
					equalTo: '#users-password'
				}*/
			},
			messages: {
				"Users[first_name]":
				{
					required : "This field is required"
					
				},
				"Users[last_name]":
				{
					required : "This field is required"
					
				},
				/*"Users[email]":
				{
					required : "This field is required",
					email: 'Kindly use valid email address',
					remote: "Email address already exists"
					
				},*/
				"Users[phone]":
				{
					required : "This field is required",
					minlength: 'Please enter minimum 10 characters.'
				}/*,
				"Users[re_password]":
				{
					required : "This field is required",
					minlength: 'Please enter minimum 6 characters.',
					equalTo: 'Password does not match'
				}*/
			}/*,
			submitHandler: function(form) {
				var actionURL = $('#addUsers').attr('action');
				signup("addUsers","sign-up",actionURL);
				return false;
			}*/
			
		});
		// code for calender pop-up
		
		$('#SetAvailablity').validate({
			rules: {
				"start_date":
				{
					required:true,
					
				},
				"end_date":
				{
					required:true
				},
				"day_care":
				{
					required:true,
					number:true
					
				},
				"night_care":
				{
					required:true,
					number:true
				},
				"visit":
				{
					required:true,
					number:true
				},
				"market_place":
				{
					required:true,
					number:true
				}
				
			},
			messages: {
				"start_date":
				{
					required : "This field is required",
										
				},
				"end_date":
				{
					required : "This field is required"
					
				},
				"day_care":
				{
					required : "This field is required",
					number:"This field should be numeric"
					
				},
				"night_care":
				{
					required : "This field is required",
					number:"This field should be numeric"
					
				},
				"visit":
				{
					required : "This field is required",
					number:"This field should be numeric"
					
				},
				"market_place":
				{
					required : "This field is required",
					number:"This field should be numeric"
				}
				
			}
		});
		//CODE SNIPPET FOR FORGOT PASSWORD
		$('#forgotPasswordForm').validate({
			rules: {
				"Users[email]":
				{
					required: true,
					email: true,
					remote: ajax_url+"App/isEmailExists"
				}
			},
			messages: {				
				"Users[email]":
				{
					required : "This field is required",
					email: 'Kindly use valid email address',
					remote: "Email address not exists in our database"
					
				}
			}
			
		});
		
		//CODE SNIPPET FOR RESET PASSWORD
		$('#resetPasswordForm').validate({
			rules: {
				"Users[password]":
				{
					required: true,
					minlength: '6'
				},
				"Users[re_password]":
				{
					required: true,
					minlength: '6',
					equalTo: '#reset_pwd_field'
				}
			},
			messages: {				
				"Users[password]":
				{
					required : "This field is required",
					minlength: 'Please enter minimum 6 characters.'
				},
				"Users[re_password]":
				{
					required : "This field is required",
					minlength: 'Please enter minimum 6 characters.',
					equalTo: 'Password does not match'
				}
			}
			
		});
		//END RESET PASSWORD
		//CODE SNIPPET FOR LOGIN
		$('#loginUser').validate({
			rules: {
				"Users[email]":
				{
					required: true,
					email: true
				},
				"Users[password]":
				{
					required: true,
					minlength: '6'
				}
			},
			messages: {				
				"Users[email]":
				{
					required : "This field is required",
					email: 'Kindly use valid email address'
				},
				"Users[password]":
				{
					required : "This field is required",
					minlength: 'Please enter minimum 6 characters.'
				}
			},
			submitHandler: function(form) {
				var actionURL = $('#loginUser').attr('action');
				process_form("loginUser","log_in_btn",actionURL);
				return false;
			}
			
		});
			//CODE SNIPPET FOR LOGIN
		$('#login_user').validate( {
			//alert("okokoko");
			rules: {
				"Users[email]":
				{
					required: true,
					email: true
				},
				"Users[password]":
				{
					required: true,
					minlength: '6'
				}
			},
			messages: {				
				"Users[email]":
				{
					required : "This field is required",
					email: 'Kindly use valid email address'
				},
				"Users[password]":
				{
					required : "This field is required",
					minlength: 'Please enter minimum 6 characters.'
				}
			}/*,
			submitHandler: function(form) {
				var actionURL = $('#loginUser').attr('action');
				process_form("loginUser","logInBtn",actionURL);
				return false;
			}*/
			
		});
		//CODE SNIPPET FOR REFERE FRIEND
		$('#referForm').validate({
			rules:{
				"UserReferences[email]":
				{
					required: true,
					email: true,
					remote: ajax_url+"App/isUniqueEmailAjax"
				}
			},
			messages: {				
				"UserReferences[email]":
				{
					required : "This field is required",
					email: 'Kindly use valid email address',
				    remote: 'Email id already registered.'
				}
			},
			submitHandler: function(form) {
				var actionURL = $('#referForm').attr('action');
				process_refer_form("referForm","refer-btn",actionURL);
				return false;
			}
		});
		//END REFER FRIEND
		//CODE SNIPPET FOR Generate refer code
		$('#referFormPromocode').validate({
			rules:{
				"[UserPromocode[promocode]":
				{
					alphanumeric:true,
					required: true
				}
			},
			messages:{				
				"[UserPromocode[promocode]":
				{
					required : "This field is required"
				}
			},
			submitHandler: function(form) {
				var actionURL = $('#referFormPromocode').attr('action');
				process_refer_form("referFormPromocode","refer-promocode-btn",actionURL);
				return false;
			}
		});
		//CODE SNIPPET FOR SUBSCRIBE
		$('#subscribeForm').validate({
			rules: {
				"Subscribes[email]":
				{
					required: true,
					email: true,
					//remote: ajax_url+"guests/subscriberEmailExists"
				}
			},
			messages: {				
				"Subscribes[email]":
				{
					required : "This field is required",
					email: 'Kindly use valid email address'
					//remote: "Email id already subscribed."
					
				}
			},
			submitHandler: function(form) {
				var actionURL = $('#subscribeForm').attr('action');
				//alert('okokokoko');
				//process_form("","subscribe-btn",actionURL);
				//return false;
				var btnID = 'subscribe-btn';
				var formID = 'subscribeForm';
				//alert(formID+btnID+'url='+actionURL);
					var orgBtnVal=$("#"+btnID).val();//GET BUTTON VALUE
					$("#"+btnID).attr('disabled',true);//MAKE THE BUTTON FADE AFTER CLICKED ON IT
					$("#"+btnID).val('Wait...');//CHANGE THE BUTTON TEXT AFTER CLICKED ON IT
					var formData = $('#'+formID).serialize();//BIND THE FORM VALUE INTO A VARIABLE
					//console.log(formData);
					$.ajax({
						url: actionURL,//AJAX URL WHERE THE LOGIC HAS BUILD
						data:formData,//ALL SUBMITTED DATA FROM THE FORM
						 
						success:function(res)
						{
							//console.log(res);
							//alert(res);
							var response = res.split(':');
							if($.trim(response[0]) == 'Success'){
								$('.clr').html('');	//Emtpy Error MESSAGE
								//alert(response[1]);
								
								$('.successMessage').html(response[1]);	//DISPLAY SUCCESS MESSAGE
								$('#'+formID)[0].reset();
								setTimeout(function(){window.location.href = ajax_url;},1000);
							}if($.trim(response[0]) == 'Error'){
								$('.clr').html('');	//Emtpy Error MESSAGE
								$('.errorMessage').html(response[1]);	//DISPLAY SUCCESS MESSAGE
							}
							
							//CODE FOR CHANGE THE BUTTON STYLE AND TEXT
							$("#"+btnID).attr('disabled',false);
							$("#"+btnID).val(orgBtnVal);	
						}
					});
				
			}
			
		});
		//CODE SNIPPET FOR SUBSCRIBE
		$('#addpartners').validate({
			rules: {
				"Partners[title]":
				{
					required: true
				},
				"Partners[short_description]":
				{
					required: true
				},
				"Partners[description]":
				{
					required: true
				},
				"Partners[image]":
				{
					required: true
				}
			},
			messages: {				
				"Partners[title]":
				{
					required : "This field is required"
				},
				"Partners[short_description]":
				{
					required : "This field is required"
				},
				"Partners[description]":
				{
					required : "This field is required"
				},
				"Partners[image]":
				{
					required : "This field is required"
				}
			}/*,
			submitHandler: function(form) {
				var actionURL = $('#subscribeForm').attr('action');
				//alert('okokokoko');
				process_form("subscribeForm","subscribe-btn",actionURL);
				return false;
			}*/
			
		});
		
		
         //CODE SNIPPET FOR General sitter profile
		$('#generelInfo').validate({
			rules: {
				"Users[title]":
				{
					required:true
				},
				"Users[birth_date]":
				{
					required:true
				},
				"Users[first_name]":
				{
					required:true,
					lettersonly: true ,
				},
				"Users[first_name]":
				{
				    lettersonly: true
				},
				"Users[address]":
				{
					required:true
				},
				"Users[address2]":
				{
					required:true
				},
                "Users[city]":
				{
					required:true,
					lettersonly: true
				},
				"Users[zip]":
				{
					required:true
				},
				"Users[state]":
				{
					required:true,
					lettersonly: true
				},
				"Users[country]":
				{
					required:true,
					lettersonly: true
				},
                "Users[country_code]":
				{
					required:true
				},
				"Users[phone]":
				{
					required:true,
					number:true
				},
				"Users[zone_id]":
				{
					required:true 
				},
				"Users[emergency_email]":
				{
					required : true,
					email: true
				},
				"Users[emergency_contacts]":
				{
					required : true,
					number:true
				},
				"Users[password]":
				{
					minlength: '6'
				},
				"Users[re_password]":
				{
					 required:true,
					minlength: '6',
					equalTo: '#usersp-password'
				}
			},
			messages: {
				"Users[title]":
				{
					required : "This field is required"
					
				},
				"Users[birth_date]":
				{
					required : "This field is required"
					
				},
				"Users[first_name]":
				{
					required : "This field is required"
					
				},
				"Users[address]":
				{
					required : "This field is required"
					
				},
				"Users[address2]":
				{
					required : "This field is required"
					
				},
				"Users[city]":
				{
					required : "This field is required"
					
				},
				"Users[zip]":
				{
					required : "This field is required"
					
				},
				"Users[state]":
				{
					required : "This field is required"
					
				},
				"Users[country_code]":
				{
					required : "This field is required"
				},
				"Users[phone]":
				{
					required : "This field is required",
					number:"Mobile number should be numerical"
				},
				"Users[zone_id]":
				{
					required : "This field is required"
				},
				"Users[term_condition]":
				{
					required : "This field is required"

				},
				"Users[emergency_email]":
				{
					required : "This field is required",
					email: 'Kindly use valid email address'
				},
				"Users[emergency_contacts]":
				{
					required : "This field is required",
					number:"Contact number should be numerical"
					
				},
                "Users[password]":
				{
					minlength: 'Please enter minimum 6 characters.'
				},
				"Users[re_password]":
				{
					required : "This field is required",
					minlength: 'Please enter minimum 6 characters.',
					equalTo: 'Password does not match'
				}

			}

         });
        //CODE SNIPPET FOR share sign up
		$('#shareSignUpInfo').validate({
			rules: {
				"Users[first_name]":
				{
					required:true,
					lettersonly: true 
				},
				"Users[zip]":
				{
					required:true
				},
				"Users[phone]":
				{
					required:true,
					number:true
				},
				"Users[password]":
				{
					required:true,
					minlength: '6'
				},
				"Users[email]":
				{
					required: true,
					email: true,
					remote: ajax_url+"App/isUniqueEmailAjax"
				}
			},
			messages: {
				"Users[first_name]":
				{
					required : "First name field is required"
					
				},
				"Users[zip]":
				{
					required : "Zip field is required"
					
				},
				"Users[phone]":
				{
					required : "Phone field is required",
					number:"Mobile number should be numerical"
				},
                "Users[password]":
				{
					required : "Password field is required",
					minlength: 'Please enter minimum 6 characters.'
				},
				"Users[email]":
				{
					required : "Email field is required",
					email: 'Kindly use valid email address',
					remote: "Email address already exists"
					
				}
           }

         });
	    //CODE SNIPPET FOR Sitter House
		$('#sitterHouse').validate({
			rules: {
				"UserSitterHouses[property_type]":
				{
					required:true
				},
				"UserSitterHouses[outdoor_area]":
				{
					required:true
				},
				"UserSitterHouses[outdoor_area_size]":
				{
					required:true
				},
				"UserSitterHouses[outing_allow_multiple]":
				{
					required:true
				},
				"UserSitterHouses[breaks_provided_every]":
				{
					required:true
				},
				"UserSitterHouses[fully_fenced]":
				{
					required:true
				},
				"UserSitterHouses[smokers]":
				{
					required:true
				},
				"UserSitterHouses[birds_in_cages]":
				{
					required:true
				},
				"UserSitterHouses[dogs_in_home]":
				{
					required:true
				},
				"UserSitterHouses[cats_in_home]":
				{
					required:true
				},
				"UserSitterHouses[about_home_desc]":
				{
					required:true
				},
				"UserSitterHouses[spaces_access_desc]":
				{
					required:true
				},
				"UserSitterHouses[home_pets_desc]":
				{
					required:true
				}
             },
			messages: {
				
				"UserSitterHouses[property_type]":
				{
					required : "This field is required"
				},
				"UserSitterHouses[outdoor_area]":
				{
					required : "This field is required"
				},
				"UserSitterHouses[outdoor_area_size]":
				{
					required : "This field is required"
				},
				"UserSitterHouses[outing_allow_multiple]":
				{
					required : "This field is required"
				},
				"UserSitterHouses[breaks_provided_every]":
				{
					required : "This field is required"
				},
				"UserSitterHouses[fully_fenced]":
				{
					required : "This field is required"
				},
				"UserSitterHouses[smokers]":
				{
					required : "This field is required"
				},
				"UserSitterHouses[birds_in_cages]":
				{
					required : "This field is required"
				},
				"UserSitterHouses[dogs_in_home]":
				{
					required : "This field is required"
				},
				"UserSitterHouses[cats_in_home]":
				{
					required : "This field is required"
				},
				"UserSitterHouses[about_home_desc]":
				{
					required : "This field is required"
				},
				"UserSitterHouses[spaces_access_desc]":
				{
					required : "This field is required"
				},
				"UserSitterHouses[home_pets_desc]":
				{
					required : "This field is required"
				}
				

			}

         });
	    /*For About Sitter form*/
		$('#aboutSitter').validate({
			rules: {
				"UserAboutSitters[your_self]":
				{
					required:true 
				},
				"UserAboutSitters[client_choose_desc]":
				{
					required:true 
				},
				"UserAboutSitters[sh_pet]":
				{
					required:true 
				},
				"UserAboutSitters[gh_pet]":
				{
					required:true 
				},
				"UserAboutSitters[sh_pet_sizes][]":
				{
					required:true 
				},
				"UserAboutSitters[gh_pet_sizes][]":
				{
					required:true 
				},
				"UserAboutSitters[sh_guest_age]":
				{
					required:true 
				},
				"UserAboutSitters[gh_guest_age]":
				{
					required:true 
				},
				"UserAboutSitters[mixed_familes]":
				{
					required:true 
				}
			},
		    messages: {
				"UserAboutSitters[your_self]":
				{
					required : "This field is required"
				}
			}

         });
		/*For Services and Rates form*/
		$('#servicesAndRates').validate({
			rules: {
				"UserSitterServices[sh_holiday_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[sh_small_guest_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[sh_large_guest_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[sh_day_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[sh_night_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[sh_cat_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[sh_puppy_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[gh_holiday_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[gh_small_guest_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[gh_large_guest_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[gh_day_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[gh_night_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[gh_cat_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[gh_puppy_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[gh_drop_in_visit_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[mp_holiday_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[mp_small_guest_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[mp_large_guest_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[mp_grooming_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[mp_recreation_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[mp_training_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[mp_driving_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[mp_cat_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[mp_puppy_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[sh_dc_additional_guest_limit]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[sh_dc_extended_stay_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[sh_dc_additional_guest_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[sh_dc_holiday_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[sh_nc_additional_guest_limit]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[sh_nc_extended_stay_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[sh_nc_additional_guest_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[sh_nc_holiday_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[gh_dc_additional_guest_limit]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[gh_dc_extended_stay_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[gh_dc_additional_guest_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[gh_dc_holiday_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[gh_nc_additional_guest_limit]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[gh_nc_extended_stay_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[gh_nc_additional_guest_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[gh_nc_holiday_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[gh_dv_additional_guest_limit]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[gh_dv_extended_stay_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[gh_dv_additional_guest_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[gh_dv_holiday_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[mp_gr_additional_guest_limit]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[mp_gr_premium_grooming_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[mp_gr_additional_guest_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[mp_gr_holiday_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[mp_tr_additional_guest_limit]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[mp_tr_premium_training_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[mp_tr_additional_guest_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[mp_tr_holiday_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[mp_rc_additional_guest_limit]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[mp_rc_premium_recreation_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[mp_rc_additional_guest_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[mp_rc_holiday_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[mp_ds_additional_guest_limit]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[mp_ds_premium_driver_service_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[mp_ds_additional_guest_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[mp_ds_holiday_rate]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[day_care_limit]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[night_care_limit]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[visits_limit]":
				{
					required:true, 
					number:true,
					min: 0
				},
				"UserSitterServices[hourly_services_limit]":
				{
					required:true, 
					number:true,
					min: 0
				}
             },
			messages: {
				"UserServiceDetail[sh_holiday_rate]":
				{
					required : "This field is required"
				}
			}

         });
         $('#about_guest').validate();
         
		/*For Skills & Accreditations form*/
		$('#skillsAccreditations').validate({
			rules: {
				"UserProfessionals[govt][licence][scanned_certification]":
				{
					required:true 
				}
			},
		    messages: {
				"UserProfessionals[govt][licence][scanned_certification]":
				{
					required : "This field is required"
				}
			}

         });		
	
		/*//CODE SNIPPET FOR REFERE FRIEND
		$('#referForm').validate({
			rules: {
			
				"UserSitterServices[gh_holiday_rate]":

				{
					 number: true  
				},
				"UserSitterServices[gh_puppy_rate]":
				{
					 number: true 
				},
				"UserSitterServices[gh_cat_rate]":
				{
					 number: true 
				},
				"UserSitterServices[gh_horse_rate]":
				{
					 number: true 
				},
				"UserSitterServices[gh_reptiles_rate]":
				{
					 number: true 
				},
				"UserSitterServices[gh_small_pets_rate]":
				{
					 number: true 
				},
				"UserSitterServices[gh_dc_guest_rate]":
				{
					 number: true 
				},
				"UserSitterServices[gh_nc_guest_rate]":
				{
					 number: true 
				},
				"UserSitterServices[gh_hc_guest_rate]":
				{
					 number: true 
				},
				"UserSitterServices[gh_ltc_guest_rate]":
				{
					 number: true 
				},
				"UserSitterServices[gh_vpd_1_visit_pr_day]":
				{
					 number: true 
				},
				"UserSitterServices[gh_vpd_2_visit_pr_day]":
				{
					 number: true 
				},
				"UserSitterServices[hp_gm_guest_rate]":
				{
					 number: true 
				},
				"UserSitterServices[hp_tr_guest_rate]":
				{
					 number: true 
				},
				"UserSitterServices[hp_or_1_day_1_guest]":
				{
					 number: true 
				},
				"UserSitterServices[hp_or_2_day_1_guest]":
				{
					 number: true 
				},
				"UserSitterServices[hp_ds_pick_up]":
				{
					 number: true 
				},
				"UserSitterServices[hp_ds_drop_off]":
				{
					 number: true 
				},
				"UserSitterServices[hp_ds_return]":
				{
					 number: true 
				},
				"UserSitterServices[day_care_limit]":
				{
					 number: true 
				},
				"UserSitterServices[visits_limit]":
				{
					 number: true 
				},
				"UserSitterServices[night_care_limit]":
				{
					 number: true 
				},
				"UserSitterServices[hourly_services_limit]":
				{
					 number: true 
				}
			},
			messages: {				
				"UserSitterServices[sh_holiday_rate]":
				{
					required : "This field is required"
				}
			}/*,
			submitHandler: function(form) {
				var actionURL = $('#subscribeForm').attr('action');
				//alert('okokokoko');
				process_form("subscribeForm","subscribe-btn",actionURL);
				return false;
			}*/
			
		/*});*/
		/*End service and rates*/
		/*Start Contact form*/
		$('#contactform').validate({
			rules: {
				"name":
				{
					required: true
				},
				"email":
				{
					required: true,
					email: true
				},
				"phone_no":
				{	
				    required: true,
					number:true,
					minlength: '10',
					maxlength:'10'
															
				},
				"message":
				{
					required: true
					
				},
				"location":
				{
					required: true
				}
				
			},
			messages:{				
				"name":
				{
					 required: "This field is required.",
				},
				"email":
				{
					required : "This field is required",
					email: 'Kindly use valid email address '
					
				},
				"phone_no":
				{
					required : "This field is required",
					number: "Please enter a valid 10-digit mobile number (04XX XXX XXX).",
					minlength:"Please enter a valid 10-digit mobile number (04XX XXX XXX).",
					maxlength:"Please enter a valid 10-digit mobile number (04XX XXX XXX)."
				},
				"message":
				{
					 required: "This field is required."	
				},
				"location":
				{
					required:"This field is required."
				}
				
			}
			
		});
	/*End contact form*/
		/*For booking contact form*/
		$('#bookingContact').validate({
			rules: {
				"BookingRequests[booking_start_date]":
				{
					required:true 
				},
				"BookingRequests[booking_end_date]":
				{
					required:true 
				},
				"BookingRequests[message]":
				{
					required:true 
				},
				"guest_id_for_booking[]":
				{
					required:true 
				}
			},
		    messages: {
				"BookingRequests[booking_start_date]":
				{
					required : "This field is required"
				},
				"guest_id_for_booking[]":
				{
					required:"Please select your pet" 
				}
			}

         });
         /*For fake profile report*/
		$('#profile-report').validate({
			rules: {
				"ProfileReport[report_reason]":
				{
					required:true 
				}
			},
		    messages: {
				"ProfileReport[report_reason]":
				{
					required : "This field is required"
				}
			}

         });
	});
		//End base profile
	function gettingstarted(formID,btnID,actionURL){
		var orgBtnVal=$("#"+btnID).val();//GET BUTTON VALUE
		$("#"+btnID).attr('disabled',true);//MAKE THE BUTTON FADE AFTER CLICKED ON IT
		$("#"+btnID).val('Processing...');//CHANGE THE BUTTON TEXT AFTER CLICKED ON IT
		var formData = $('#'+formID).serialize();//BIND THE FORM VALUE INTO A VARIABLE
		
		$.ajax({
			url: actionURL,//AJAX URL WHERE THE LOGIC HAS BUILD
			data:formData,//ALL SUBMITTED DATA FROM THE FORM
			 
			success:function(res)
			{
				//CODE FOR CHANGE THE BUTTON STYLE AND TEXT
				$("#"+btnID).attr('disabled',false);
				$("#"+btnID).val(orgBtnVal);	
				//alert('okokk');
			}
		});
	}
	
	/*FUNCTION FOR SUBMIT THE SIGNUP FORM AND DISPLAYING THERE REPOSNSE*/
	function signup(formID,btnID,actionURL){
				
		var orgBtnVal=$("#"+btnID).val();//GET BUTTON VALUE
		var formData = $('#'+formID).serialize();//BIND THE FORM VALUE INTO A VARIABLE
		
		
		$.ajax({
			url: actionURL,//AJAX URL WHERE THE LOGIC HAS BUILD
			data:formData,//ALL SUBMITTED DATA FROM THE FORM
			
			beforeSend: function(){
				$("#"+btnID).attr('disabled',true);//MAKE THE BUTTON FADE AFTER CLICKED ON IT
				$("#"+btnID).val('Processing...');//CHANGE THE BUTTON TEXT AFTER CLICKED ON IT
			},
			
			complete: function(){
			   //CODE FOR CHANGE THE BUTTON STYLE AND TEXT
				$("#"+btnID).attr('disabled',false);
				$("#"+btnID).val(orgBtnVal);	
			},	
			 
			success:function(res)
			{
				//alert(res);
				//console.log(res);
				var response = res.split(':');
				if($.trim(response[0]) == 'Success'){
					$('.successMessage').html(response[1]);	//DISPLAY SUCCESS MESSAGE
					$('#'+formID)[0].reset();
					setTimeout(function(){window.location.href = ajax_url+response[2];},1000);
				}else{
					$('#myModal_sign').html(res);	//DISPLAY RESPONSE ERRORS
				}
				
				
			}
		});
	}
	/*FUNCTION FOR SUBMIT THE REFER FRIEND*/
	function process_refer_form(formID,btnID,actionURL){
        var orgBtnVal=$("#"+btnID).val();//GET BUTTON VALUE
		$("#"+btnID).attr('disabled',true);//MAKE THE BUTTON FADE AFTER CLICKED ON IT
		$("#"+btnID).val('Processing...');//CHANGE THE BUTTON TEXT AFTER CLICKED ON IT
		var formData = $('#'+formID).serialize();//BIND THE FORM VALUE INTO A VARIABLE
		$.ajax({
			url: actionURL,//AJAX URL WHERE THE LOGIC HAS BUILD
			data:formData,//ALL SUBMITTED DATA FROM THE FORM
			success:function(res)
			{
				var response = res.split(':');
				if($.trim(response[0]) == 'Success'){
					$('.clr').html('');	//Emtpy Error MESSAGE
					$('.successMessage').html(response[1]);	//DISPLAY SUCCESS MESSAGE
					$('#'+formID)[0].reset();
					
					$('#squarespaceModal').modal('hide');
					setTimeout(function(){window.location.href = ajax_url+"dashboard/promote";},1000);
				}if($.trim(response[0]) == 'Error'){
					$('.clr').html('');	//Emtpy Error MESSAGE
					$('.errorMessage').html(response[1]);	//DISPLAY SUCCESS MESSAGE
				}
				//CODE FOR CHANGE THE BUTTON STYLE AND TEXT
				$("#"+btnID).attr('disabled',false);
				$("#"+btnID).val(orgBtnVal);	
			}
		});
	}
	
	/*FUNCTION FOR SUBMIT THE FORGOT FORM AND DISPLAYING THERE REPOSNSE*/
	function process_form(formID,btnID,actionURL){

		//alert(formID+btnID+'url='+actionURL);
		var orgBtnVal=$("#"+btnID).val();//GET BUTTON VALUE
		$("#"+btnID).attr('disabled',true);//MAKE THE BUTTON FADE AFTER CLICKED ON IT
		$("#"+btnID).val('Processing...');//CHANGE THE BUTTON TEXT AFTER CLICKED ON IT
		var formData = $('#'+formID).serialize();//BIND THE FORM VALUE INTO A VARIABLE
		//console.log(formData);
		$.ajax({
			url: actionURL,//AJAX URL WHERE THE LOGIC HAS BUILD
			data:formData,//ALL SUBMITTED DATA FROM THE FORM
			 
			success:function(res)
			{
				console.log(res);
				//alert(res);
				var response = res.split(':');
				if($.trim(response[0]) == 'Success'){
					$('.clr').html('');	//Emtpy Error MESSAGE
					//alert(response[1]);
					
					$('.successMessage').html(response[1]);	//DISPLAY SUCCESS MESSAGE
					$('#'+formID)[0].reset();
					setTimeout(function(){window.location.href = ajax_url;},1000);
				}if($.trim(response[0]) == 'Error'){
					$('.clr').html('');	//Emtpy Error MESSAGE
					$('.errorMessage').html(response[1]);	//DISPLAY SUCCESS MESSAGE
				}
				
				//CODE FOR CHANGE THE BUTTON STYLE AND TEXT
				$("#"+btnID).attr('disabled',false);
				$("#"+btnID).val(orgBtnVal);	
			}
		});
		
	}
	
	
	/*$(document).ready(function(e){
		
		// submiting email for reference for invitaion using ajax 
		$('#referForm').submit(function( event ) {
			event.preventDefault();
			var inputEmail = $('#referEmail').val();
           //alert(inputEmail);
			$.ajax({
				method: "POST",
				url: "dashboard/reference",
				data: { email: inputEmail },
				success : function (result) {
				
					var jsonResult = JSON.parse(result);
					if (jsonResult.type=='success') {
						msgAlert = '<div class="alert alert-success" role="alert">'+jsonResult.message+'</div>';
					} else {
						msgAlert = '<div class="alert alert-danger" role="alert">'+jsonResult.message+'</div>';
					}
					$('.successMessage').html(msgAlert);
					setInterval(function(){ $('.successMessage').html(''); }, 3000);

				},
				error : function () {

				}
			});
		});
		
	});*/
/*For sign up*/
$( document ).ready(function() {
    $('#signUpEmail').click(function(){
      $('#addUsers').slideToggle();
      $('#loginFacebook').toggle();
    });

   $('#googleChapcha').click(function(){
    
    	
	});

   $('#multiLingual').change(function(){
   var languagePath = $(this).val();
	  window.location.href = languagePath;
    });

   $(document)
	.on( 'click', '.dropdown-menu', function (e){
	    e.stopPropagation();
	});
	jQuery.validator.addMethod("lettersonly", function(value, element) {
  return this.optional(element) || /^[a-z][A-Z ]+$/i.test(value);
}, "Letters only please"); 
jQuery.validator.addMethod("alphanumeric", function(value, element) {
  return this.optional(element) || /^[a-z][0-9]+$/i.test(value);
}, "Please enter alphanumeric value only");
/*End sign up*/


/*====For password fair line====*/
$("#usersp-password").keyup(function(){
    	var value = $(this).val();
      	if((value.length) === 0){
      		$('#passwordStatus').html("");
        }else if((value.length) > 0 && (value.length) < 6){
              $('#passwordStatus').html("<img id='password_line' src='"+ ajax_url+'img/'+'weak.jpg'+"'><small class='pull-right'>Weak</small>");
        }else if((value.length) >= 6 && (value.length) < 9){
              $('#passwordStatus').html("<img id='password_line' src='"+ ajax_url+'img/'+'fair.jpg'+"'><small class='pull-right'>Fair</small>");
        }else if((value.length) > 9){
              $('#passwordStatus').html("<img id='password_line' src='"+ ajax_url+'img/'+'good.jpg'+"'><small class='pull-right'>Good</small>");
        }
});
 /*====End fair line====*/
 
 
/*For Remove profile image */
 $(document).on('click', '.removeProfileImg',function(){
 	var imageId = $(this).attr('data-rel');
 	   $.ajax({
		 beforeSubmit:function(e){
				$('#wait-loader').html('<img  src="'+ajax_url+'/img/ajax_wait.gif">');
		 },
         url: ajax_url+'dashboard/remove-gallery-image', 
         data:'imageId='+imageId,
         success: function(result){
			$('#wait-loader').html(''); 
            $("#images_preview").html(result);
          }
        });
   }); 
 });
 /*End profile image*/
$(document).ready(function(){
/*For profile video*/
    $("#browseVideo").on('click',function(){
        $("#images").trigger("click");    
        });
/*End profile video*/
 
 
 
/*Last Drop down country- currency listing*/
$(function () {
  	$('.navbar-toggle-sidebar').click(function () {
  		
  		$('.navbar-nav').toggleClass('slide-in');
  		$('.side-body').toggleClass('body-slide-in');
  		$('#search').removeClass('in').addClass('collapse').slideUp(200);
  	});

  	$('#search-trigger').click(function () {
  		$('.navbar-nav').removeClass('slide-in');
  		$('.side-body').removeClass('body-slide-in');
  		$('.search-input').focus();
  	});
  });
   /*Last Drop down country- currency listing*/
   $(document)
	.on( 'click', '.dropdown-menu', function (e){
	    e.stopPropagation();
	});
 /*Last Drop down country- currency listing*/
});
/*Last Drop down country- currency listing*/
 $(document).on('click', '.getCalender', function(){
	   var actionURl = $(this).attr('data-rel');
		$.ajax({
			url:  actionURl,//AJAX URL WHERE THE LOGIC HAS BUILD
			beforeSend: function(){
			  $(".ajax_overlay").show();
			  $(".ajax_overlay").html('<img class="search-img" src="'+ajax_url+'img/walking.gif"/>');
			},
			complete: function(){
			  $(".ajax_overlay").hide();
			  $(".ajax_overlay").html('');
			},
			success:function(res)
			{
				$('#myCalender').html(res);	//DISPLAY RESPONSE ERRORS
				$('input[type=checkbox]').onoff();
			}
		});
	});
   $(document).on('click', '.getCalenderReceived', function(){
	   var actionURl = $(this).attr('data-rel');
		$.ajax({
			url:  actionURl,//AJAX URL WHERE THE LOGIC HAS BUILD
			beforeSend: function(){
			  $(".ajax_overlay").show();
			  $(".ajax_overlay").html('<img class="search-img" src="'+ajax_url+'img/walking.gif"/>');
			},
			complete: function(){
			  $(".ajax_overlay").hide();
			  $(".ajax_overlay").html('');
			},
			success:function(res)
			{
				$('#myCalender_recieved').html(res);	//DISPLAY RESPONSE ERRORS
				$('input[type=checkbox]').onoff();
			}
		});
	});
	  $(document).on('click', '.getCalenderSend', function(){
	   var actionURl = $(this).attr('data-rel');
		$.ajax({
			url:  actionURl,//AJAX URL WHERE THE LOGIC HAS BUILD
			beforeSend: function(){
			  $(".ajax_overlay").show();
			  $(".ajax_overlay").html('<img class="search-img" src="'+ajax_url+'img/walking.gif"/>');
			},
			complete: function(){
			  $(".ajax_overlay").hide();
			  $(".ajax_overlay").html('');
			},
			success:function(res)
			{
				
				$('#myCalender_send').html(res);	//DISPLAY RESPONSE ERRORS
				$('input[type=checkbox]').onoff();
			}
		});
	});
 /*Last Drop down country- currency listing*/
 
	$(document).on('click','#saveLimitSeat', function(){ 
	
		var actionURl = ajax_url+"dashboard/ajax-set-limit";
		var formData = $("#SetAvailablity").serialize();
		
		$.ajax({
			url:  actionURl,//AJAX URL WHERE THE LOGIC HAS BUILD
			data:formData,
				
			success:function(res)
			{
				location.reload();
				$('#myModal21').modal('hide');
					
			}
		});
	
	});
/*End profile video*/

/*Jquery for get idle state of user start*/
var idleTimer = null;
var idleState = false;
var idleWait = 10000;

(function ($) {

	$(document).ready(function () {
	
		$('*').bind('mousemove keydown scroll', function () {
		
			clearTimeout(idleTimer);
					
			if (idleState == true) { 
				
				
				//STATUS CHANGE INTO USER TABLE START
				
				$.ajax({
					url:  ajax_url+'/dashboard/change-idle-status',//AJAX URL WHERE THE LOGIC HAS BUILD
					
					data:{avail_status:'Available'},
						
					success:function(res)
					{
						if($.trim(res)=='success'){
							
							setTimeout(function () {
								// Reactivated event
								$("body").find("#display_status").val("Online");	
								$("body").find("#display_status").css('background-image', 'url(' + ajax_url+'img/online.png' + ')');	
							},1000);	
							
						}
							
					}
				});
				//STATUS CHANGE INTO USER TABLE START
			}
			
			idleState = false;
			
			idleTimer = setTimeout(function () { 
				
				//STATUS CHANGE INTO USER TABLE START
				/*
				$.ajax({
					url:  ajax_url+'/dashboard/change-idle-status',//AJAX URL WHERE THE LOGIC HAS BUILD
					data:{avail_status:'Idle'},
						
					success:function(res)
					{
						
						if($.trim(res)=='success'){
							

								// Reactivated event
								$("body").find("#display_status").val("Away");	
								$("body").find("#display_status").css('background-image', 'url(' + ajax_url+'img/away.png' + ')');	

							
						}
												
					}
				});*/
				//STATUS CHANGE INTO USER TABLE START
				
				idleState = true; }, idleWait);
		});
		
		$("body").trigger("mousemove");
	
	});
}) (jQuery)

	
