<!--[Footer Start]-->
  <footer class="foot-wrap" id="footer">
      <!--top foot-->
      <div class="top-foot">
          <div class="container">
              <div class="fb-area">
                  <div class="row">
                      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                          <div class="foot-box">
                          <p class="txt-head"><?php echo $this->requestAction('app/get-translate/'.base64_encode('About Sitter Guide')); ?></p>          
								<ul>
									<li><a href="<?php echo HTTP_ROOT.'about-us'; ?>" title="About Us"> <?php echo $this->requestAction('app/get-translate/'.base64_encode('About Us')); ?></a> </li>
									<li><a href="<?php echo HTTP_ROOT."partners"; ?>" title="Partners">  <?php echo $this->requestAction('app/get-translate/'.base64_encode('Partners')); ?></a> </li>
									<li><a href="<?php echo HTTP_ROOT.'news'; ?>" title="In the News"><?php echo $this->requestAction('app/get-translate/'.base64_encode('In the News')); ?></a>
									</li>
									<li><a href="<?php echo HTTP_ROOT.'privacy'; ?>" title="Privacy Policy"> <?php echo $this->requestAction('app/get-translate/'.base64_encode('Privacy Policy')); ?></a> </li>
									<li><a href="<?php echo HTTP_ROOT.'terms'; ?>" title="Terms & Conditions"> <?php echo $this->requestAction('app/get-translate/'.base64_encode('Terms & Conditions')); ?></a> </li>
                                </ul>
                               
                        </div>
                      </div>
                      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                          <div class="foot-box">
                          <p class="txt-head"><?php echo $this->requestAction('app/get-translate/'.base64_encode('Top Pet Sitting Cities')); ?></p>            
         
                              <ul>
                                  <li><a href="<?php echo HTTP_ROOT."search/search-by-cities/Sydney";?>" title="<?php echo $this->requestAction('app/get-translate/'.base64_encode('Pet Sitters Sydney')); ?>"><?php echo $this->requestAction('app/get-translate/'.base64_encode('Pet Sitters Sydney')); ?></a> </li>
                                    <li><a href="<?php echo HTTP_ROOT."search/search-by-cities/Melbourne";?>" title="<?php echo $this->requestAction('app/get-translate/'.base64_encode('Pet Sitters Melbourne')); ?>"><?php echo $this->requestAction('app/get-translate/'.base64_encode('Pet Sitters Melbourne')); ?></a> </li>
                                    <li><a href="<?php echo HTTP_ROOT."search/search-by-cities/Brisbane";?>" title="<?php echo $this->requestAction('app/get-translate/'.base64_encode('Pet Sitters Brisbane')); ?>"><?php echo $this->requestAction('app/get-translate/'.base64_encode('Pet Sitters Brisbane')); ?></a> </li>
                                    <li><a href="<?php echo HTTP_ROOT."search/search-by-cities/Perth";?>" title="<?php echo $this->requestAction('app/get-translate/'.base64_encode('Pet Sitters Perth')); ?>"><?php echo $this->requestAction('app/get-translate/'.base64_encode('Pet Sitters Perth')); ?></a> </li>
                                    <li><a href="<?php echo HTTP_ROOT."search/search-by-cities/Adelaide";?>" title="<?php echo $this->requestAction('app/get-translate/'.base64_encode('Pet Sitters Adelaide')); ?>"><?php echo $this->requestAction('app/get-translate/'.base64_encode('Pet Sitters Adelaide')); ?></a> </li>
                                    <li><a href="<?php echo HTTP_ROOT."search/search-by-cities/Canberra";?>" title="<?php echo $this->requestAction('app/get-translate/'.base64_encode('Pet Sitters Canberra')); ?>"><?php echo $this->requestAction('app/get-translate/'.base64_encode('Pet Sitters Canberra')); ?></a> </li>
                                </ul>
                               
                        </div>
                      </div>
                      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                          <div class="foot-box">
                          <p class="txt-head"><?php echo $this->requestAction('app/get-translate/'.base64_encode('Learn More')); ?></p>          
                              <ul>                   

                                  <!--<li><a href="#" title="How does Sitter Guide Work"> <?php echo $this->requestAction('app/get-translate/'.base64_encode('How does Sitter Guide Work')); ?></a> </li>-->
                                    <li><a href="<?php echo HTTP_ROOT.'insurance'; ?>" title=" Insurance & Refunds"> <?php echo $this->requestAction('app/get-translate/'.base64_encode('Insurance & Refunds')); ?></a> </li>
                                    
                                    
                                    <li><a href="<?php echo HTTP_ROOT.'house-rules'; ?>" title="House Rules"><?php echo $this->requestAction('app/get-translate/'.base64_encode('House Rules')); ?></a> </li>
                                    <li><a href="<?php echo HTTP_ROOT.'safety'; ?>" title="Safety"><?php echo $this->requestAction('app/get-translate/'.base64_encode('Safety')); ?></a> </li>
                                    <li><a href="<?php echo HTTP_ROOT.'benefits'; ?>" title="Benefits of sittings"> <?php echo $this->requestAction('app/get-translate/'.base64_encode('Benefits of sittings')); ?></a> </li>
                                   
									<li><a href="<?php echo HTTP_ROOT.'become-a-sitter'; ?>" title=" Become a Sitter"> <?php echo $this->requestAction('app/get-translate/'.base64_encode('Become a Sitter')); ?></a> </li>	
                                </ul>
                               
                        </div>
                      </div>
                      <?php echo $this->Form->create(null,[
                                    'url' => ['controller' => 'guests', 'action' => 'subscribe'],
                                     'id'=>'subscribeForm',
                                     'enctype'=>'multipart/form-data',
                                     'style'=>'display:block'
                                ]);?>
                      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                          <div class="foot-box fb-last">
                          <p class="txt-head"><?php echo $this->requestAction('app/get-translate/'.base64_encode('Need Help?')); ?></p>          
                            <ul>
								<li>
									<a href="<?php echo HTTP_ROOT.'help'; ?>" title="Help Center"><?php echo $this->requestAction('app/get-translate/'.base64_encode('Help Center')); ?></a>
								</li>
								<li><a href="<?php echo HTTP_ROOT.'contact-us'; ?>" title="Contact Us"><?php echo $this->requestAction('app/get-translate/'.base64_encode('Contact Us')); ?></a> </li>
							</ul>
                                
                            <div class="news-let">
                                <p class="txt-head"><?php echo $this->requestAction('app/get-translate/'.base64_encode('Subscribe Newsletter')); ?></p>
                                 <div class="input email">
                                  <p class="successMessage clr"></p>
                                  <p class="errorMessage clr"></p>
                                    <?php echo $this->Form->input('Subscribes.email',['class'=>'nwlt-input','placeholder'=>$this->requestAction('app/get-translate/'.base64_encode('Enter Your Email')),'label'=>false, 'templates' => [
                                                 'inputContainer' => '{{content}}'
                                                  ]]); 

                                    ?>                               
                                  <input id="subscribe-btn"  type="submit" class="sb-btn" value="<?php echo $this->requestAction('app/get-translate/'.base64_encode('Subscribe')); ?>" />
                                  <label class="error" for="subscribes-email" generated="true"></label>
                                 </div> 
                            </div>
                        </div>
                      </div>
                      
                     <?php echo $this->Form->end(); ?>
                </div>
                </div>
            </div>
        </div>    
        <!--/top foot-->            
        <!--bot foot-->
        <div class="bot-foot">
          <div class="container">
              <div class="bf-area">
                  <div class="row">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">                      
                          <div class="bot-social">
                              <p><?php echo $this->requestAction('app/get-translate/'.base64_encode('Join The Sitter Guide Pack')); ?></p>
                              <ul>
									<li>
										<a href="<?php echo isset($siteConfiguration->facebook_link)? $siteConfiguration->facebook_link:""; ?>" title=""><i class="fa fa-facebook"></i></a>
									</li>
                                    <li>
										<a href="<?php echo isset($siteConfiguration->google_link)? $siteConfiguration->google_link:""; ?>" title=""><i class="fa fa-google-plus"></i></a>
									</li>
                                    <li>
										<a href="<?php echo isset($siteConfiguration->twitter_link)? $siteConfiguration->twitter_link:""; ?>" title=""><i class="fa fa-twitter"></i></a>
									</li>
                                    <li>
										<a href="<?php echo isset($siteConfiguration->instagram_link)? $siteConfiguration->instagram_link:""; ?>" title=""><i class="fa fa-instagram"></i></a>
									</li>
									<li>
										<a href="<?php echo isset($siteConfiguration->youtube_link)? $siteConfiguration->youtube_link:""; ?>" title=""><i class="fa fa-youtube"></i></a>
									</li>
                                   
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <div class="drop-area">
                              <div class="row">
                                  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                      <div class="form-group">
                                        

										  <?php 
											$cont = $this->request->params['controller'];
											$act = $this->request->params['action'];
										  ?>     
                  <!-- <select class="form-control"  id="multiLingual"> 
                    <option value=""><?php echo $this->requestAction('app/get-translate/'.base64_encode('CHOOSE LANGUAGE')); ?></option>                 
                       <option value="<?php echo HTTP_ROOT.'app/setGuestStore/en/'.$cont.'/'.$act;?>"><?php echo $this->requestAction('app/get-translate/'.base64_encode('ENGLISH')); ?></option>                                          
                       <option value="<?php echo HTTP_ROOT.'app/setGuestStore/fr/'.$cont.'/'.$act;?>"><?php echo $this->requestAction('app/get-translate/'.base64_encode('FRENCH')); ?></option> 
                       <option value="<?php echo HTTP_ROOT.'app/setGuestStore/de/'.$cont.'/'.$act;?>"><?php echo $this->requestAction('app/get-translate/'.base64_encode('GERMAN')); ?></option>  
                       <option value="<?php echo HTTP_ROOT.'app/setGuestStore/hu/'.$cont.'/'.$act;?>"><?php echo $this->requestAction('app/get-translate/'.base64_encode('HUNGARIAN')); ?></option>  
                       <option value="<?php echo HTTP_ROOT.'app/setGuestStore/it/'.$cont.'/'.$act;?>"><?php echo $this->requestAction('app/get-translate/'.base64_encode('ITALIAN')); ?>x</option>  
                       <option value="<?php echo HTTP_ROOT.'app/setGuestStore/ro/'.$cont.'/'.$act;?>"><?php echo $this->requestAction('app/get-translate/'.base64_encode('ROMANIAN')); ?></option>  
                       
                       <option value="<?php echo HTTP_ROOT.'app/setGuestStore/es/'.$cont.'/'.$act;?>"><?php echo $this->requestAction('app/get-translate/'.base64_encode('SPANISH')); ?></option>   
                  </select>   -->  
                  <!--<option value="<?php echo HTTP_ROOT.'app/setGuestStore/ru/'.$cont.'/'.$act;?>">RUSSIAN</option>  -->          
             </div>                      
         </div>
         <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<div class="form-group">
                     <select class="form-control" id="">                                          
						  <option value="AED"><?php echo $this->requestAction('app/get-translate/'.base64_encode('USD')); ?></option>
						
						  <option value="ARS"><?php echo $this->requestAction('app/get-translate/'.base64_encode('ARS')); ?></option>
						
						  <option value="AUD"><?php echo $this->requestAction('app/get-translate/'.base64_encode('AUD')); ?></option>
						
						  <option value="BGN"><?php echo $this->requestAction('app/get-translate/'.base64_encode('BGN')); ?></option>
						
						  <option value="BRL"><?php echo $this->requestAction('app/get-translate/'.base64_encode('BRL')); ?></option>
						
						  <option value="CAD"><?php echo $this->requestAction('app/get-translate/'.base64_encode('CAD')); ?></option>
						
						  <option value="CHF"><?php echo $this->requestAction('app/get-translate/'.base64_encode('CHF')); ?></option>
						
						  <option value="CLP"><?php echo $this->requestAction('app/get-translate/'.base64_encode('CLP')); ?></option>
						
						  <option value="CNY"><?php echo $this->requestAction('app/get-translate/'.base64_encode('CNY')); ?></option>
						
						  <option value="COP"><?php echo $this->requestAction('app/get-translate/'.base64_encode('COP')); ?></option>
						
						  <option value="CRC"><?php echo $this->requestAction('app/get-translate/'.base64_encode('CRC')); ?></option>
						
						  <option value="CZK"><?php echo $this->requestAction('app/get-translate/'.base64_encode('CZK')); ?></option>
						
						  <option value="DKK"><?php echo $this->requestAction('app/get-translate/'.base64_encode('DKK')); ?></option>
						
						  <option value="EUR"><?php echo $this->requestAction('app/get-translate/'.base64_encode('EUR')); ?></option>
						
						  <option value="GBP"><?php echo $this->requestAction('app/get-translate/'.base64_encode('GBP')); ?></option>
						
						  <option value="HKD"><?php echo $this->requestAction('app/get-translate/'.base64_encode('HKD')); ?></option>
						
						  <option value="HRK"><?php echo $this->requestAction('app/get-translate/'.base64_encode('HRK')); ?></option>
						
						  <option value="HUF"><?php echo $this->requestAction('app/get-translate/'.base64_encode('HUF')); ?></option>
						
						  <option value="IDR"><?php echo $this->requestAction('app/get-translate/'.base64_encode('IDR')); ?></option>
						
						  <option value="ILS"><?php echo $this->requestAction('app/get-translate/'.base64_encode('ILS')); ?></option>
						
						  <option value="INR"><?php echo $this->requestAction('app/get-translate/'.base64_encode('INR')); ?></option>
						
						  <option value="JPY"><?php echo $this->requestAction('app/get-translate/'.base64_encode('JPY')); ?></option>
						
						  <option value="KRW"><?php echo $this->requestAction('app/get-translate/'.base64_encode('KRW')); ?></option>
						
						  <option value="MAD"><?php echo $this->requestAction('app/get-translate/'.base64_encode('MAD')); ?></option>
						
						  <option value="MXN"><?php echo $this->requestAction('app/get-translate/'.base64_encode('MXN')); ?></option>
						
						  <option value="MYR"><?php echo $this->requestAction('app/get-translate/'.base64_encode('MYR')); ?></option>
						
						  <option value="NOK"><?php echo $this->requestAction('app/get-translate/'.base64_encode('NOK')); ?></option>
						
						  <option value="NZD"><?php echo $this->requestAction('app/get-translate/'.base64_encode('NZD')); ?></option>
						
						  <option value="PEN"><?php echo $this->requestAction('app/get-translate/'.base64_encode('PEN')); ?></option>
						
						  <option value="PHP"><?php echo $this->requestAction('app/get-translate/'.base64_encode('PHP')); ?></option>
						
						  <option value="PLN"><?php echo $this->requestAction('app/get-translate/'.base64_encode('PLN')); ?></option>
						
						  <option value="RON"><?php echo $this->requestAction('app/get-translate/'.base64_encode('RON')); ?></option>
						
						  <option value="RUB"><?php echo $this->requestAction('app/get-translate/'.base64_encode('RUB')); ?></option>
						
						  <option value="SAR"><?php echo $this->requestAction('app/get-translate/'.base64_encode('SAR')); ?></option>
						
						  <option value="SEK"><?php echo $this->requestAction('app/get-translate/'.base64_encode('SEK')); ?></option>
						
						  <option value="SGD"><?php echo $this->requestAction('app/get-translate/'.base64_encode('SGD')); ?></option>
						
						  <option value="THB"><?php echo $this->requestAction('app/get-translate/'.base64_encode('THB')); ?></option>
						
						  <option value="TRY"><?php echo $this->requestAction('app/get-translate/'.base64_encode('TRY')); ?></option>
						
						  <option value="TWD"><?php echo $this->requestAction('app/get-translate/'.base64_encode('TWD')); ?></option>
						
						  <option value="UAH"><?php echo $this->requestAction('app/get-translate/'.base64_encode('UAH')); ?></option>
						
						  <option selected="" value="USD"><?php echo $this->requestAction('app/get-translate/'.base64_encode('USD')); ?></option>
						
						  <option value="UYU"><?php echo $this->requestAction('app/get-translate/'.base64_encode('UYU')); ?></option>
						
						  <option value="VND"><?php echo $this->requestAction('app/get-translate/'.base64_encode('VND')); ?></option>
						
						  <option value="ZAR"><?php echo $this->requestAction('app/get-translate/'.base64_encode('ZAR')); ?></option>
						
					  </select>             
                                          </div> 
                                    </div>                                    
                                </div>
                            </div>
                              <p class="crgt"><?php echo isset($siteConfiguration->site_footer)?$siteConfiguration->site_footer:""?></p>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <!--bot foot-->
    </footer>
<!--[Footer End]-->
<?php 
if(!isset($_COOKIE["userCookie"])){ 
	
	?>
	  <div id="cookies-bot-wrap">
      <div class="close-btn"> <b id="hide">X</b> </div>
			<div class="row">
				<div class="container">
					<div class="cbw-area">
						<p><?php echo $this->requestAction('app/get-translate/'.base64_encode('By using our website, you agree to the use of cookies as described in our')); ?>  <a href="<?php echo HTTP_ROOT."privacy"; ?>"><ins><?php echo $this->requestAction('app/get-translate/'.base64_encode('Privacy Policy')); ?></ins></a>  </p>
					</div>
				</div>
			</div>
		</div>
<?php } ?> 
<!----------------------------------header resize------------------------------------------>
 <?php
     echo $this->Html->script(['Front/classie.js','Admin/bootstrap.min.js','Front/custom.js']);
 ?>
<script>
   
    /*window.onload = init();*/
/*header resize*/
$(document).ready(function(){
    $("#flip").click(function(){
        $("#panel").slideDown("slow");
    });
  $("#close").click(function(){
        $("#panel").slideUp("slow");
    });
    $("#dro plog").click(function(){
        $("#dr opcont").toggle("slow");
    });
  $("#drop log2").click(function(){
        $("#dropcont2").toggle("slow");
    });
    $("#dro plog3").click(function(){
        $("#dropcont3").toggle("slow");
    }); 
    //$(".cake-error").css('display','none')
  
  
  

});
  //For cookie
  $(document).on('click','#hide', function(){
		       $.ajax({
					url: ajax_url+"guests/user-cookie",//AJAX URL WHERE THE LOGIC HAS BUILD
					success:function(res)
					{
					    $("#cookies-bot-wrap").hide();
					}
				});
	});
    
	/*Last Drop down country- currency listing */

$(document).ready(function(){
    $("#hide").click(function(){
        $("#cookies-bot-wrap").hide();
    });
   
});

$(document)
.on( 'click', '.dropdown-menu', function (e){
    e.stopPropagation();
});

$(document)
.on( 'click', '#cookie-close', function (e){
    
});
/* Last Drop down country- currency listing */
</script>
<style>
#loginUser label.error { color: #ff5a5f !important;
    float: right;
    font-size: 12px !important;
    font-weight: normal !important;
   
    position: relative;
    right: 4px;
    text-align: right !important;
    top: -7px;}

.pac-item-selected{
 background:#f3f3f3 !important;
}
.close-btn{
   position: absolute;
    right: 5px;
    top: 5px;
    color:#fff;
}
}
</style>
<?php			
	echo $this->Html->script(['Front/vendorscript.js','Front/video.js']);
?>
<script>
$(document).ready(function(){
    $("#myBtnv").click(function(){
        $("#myModalv").modal();
    });
});
</script>
