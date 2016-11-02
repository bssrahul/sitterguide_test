<div class="col-md-9 col-lg-10 col-sm-8 lg-width80" >
  <div class="row db-top-bar-header no-padding-left no-padding-right bg-title">
    <div class="col-xs-12 col-sm-5 col-md-6 col-lg-6">
      <h3>
        <span class="fa fa-smile-o">  </span><span style="margin-left:15px"><?php echo $this->requestAction('app/get-translate/'.base64_encode('Promote')); ?></span>
        
      </h3>
    </div>
    <div class="col-xs-12 col-sm-7 col-md-6 col-lg-6">
      <ol class="breadcrumb text-right">
        <li> <?php echo $this->requestAction('app/get-translate/'.base64_encode('You are here')); ?> : 
        </li>
        <li>
          <a href="#"><?php echo $this->requestAction('app/get-translate/'.base64_encode('Home')); ?>
          </a>
        </li>
        <li class="active"><?php echo $this->requestAction('app/get-translate/'.base64_encode('Promote')); ?>
        </li>
      </ol>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
      <div class="earn-more"> <?php echo $this->requestAction('app/get-translate/'.base64_encode('Earn More, Play More')); ?>
      </div>
      <div class="earnmor2wrapper">
        <p class="text-earn "><?php echo $this->requestAction('app/get-translate/'.base64_encode('Attract new clients and their dogs by  Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since thesharing your Siter Guide profile link and promo code. Your promo code gives pet owners new to Siterguide $20 off their first booking—while you’ll still earn your full rate.  Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the pet owners new to Siterguide $20 off their first booking—while you’ll still earn your full rate.  Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the Lorem Ipsum is simply dummy text of Lorem Ipsum has been')); ?> .
        </p>
        <p class="generate-promo">
			 <?php if(empty(@$reference_code)){ echo $this->requestAction('app/get-translate/'.base64_encode("Generate your promocode")); }else{ echo $this->requestAction('app/get-translate/'.base64_encode("Your Promotion Link")); }?>
        </p>
        <div class="generate-wrap">
           <?php echo $this->Form->create(null,[
						  'url' => ['controller' => 'dashboard', 'action' => 'generate-promocode'],
						  'class'=>'form-inline',
						  'id'=>'referFormPromocode',
					 ]);?>
			 <div class="row">
				
				<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
					 <?php if(empty(@$reference_code)){ ?>
					  <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
					  <?php echo $refer_url; ?>
					  </div>
					<?php }else{ ?>  
					    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
					  <?php echo $refer_url.@$reference_code; ?>
					   </div>
					<?php } ?>
			 <?php if(empty(@$reference_code)){ ?>
					  <div class="col-lg-6 col-sm-12 col-md-6 col-xs-12">
						<!--<input type="text" class="form-control generat-field" style="width:100%;">-->
						 <?php 
							  echo $this->Form->input('UserPromocode.promocode',[
									'templates' => ['inputContainer' => '{{content}}'],
									'label'=>false,
									'class' =>'form-control generat-field',
									'style'=>'width:100%',
									'value'=>@$reference_code
							 ]);
                       ?>
                       <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
						 <p class="successMessage clr otp_success_msg"></p>
						 <p class="errorMessage clr otp_error_msg"></p>
						</div>  
					  </div>
					  <div class="col-lg-6 col-sm-12 col-md-6 col-xs-12">
						<button type="submit" class="btn btn-primary btn-block generat-btn" id="refer-promocode-btn" ><?php echo $this->requestAction('app/get-translate/'.base64_encode('Generate')); ?>
						</button>
					  </div>
					  <?php } ?>
				</div>
            </div>
          <?php echo $this->Form->end(); ?>
        </div>
        <p class="text-earn1 "><?php echo $this->requestAction('app/get-translate/'.base64_encode("Attract new clients and their dogs by  Lorem Ipsum is simply dummy text of the printing and typesetting their dogs by  Lorem Ipsum is simply dummy text of the printing and typesetting  industry. Attract new clients and their dogs by  Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since thesharing your Siter Guide profile link and promo code. Your promo code gives pet owners new to Siterguide $20 off their first booking—while you’ll still earn your full rate.  Lorem Ipsum is simply dummy text of the printing and typesetting industry. ")); ?> . 
        </p>
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
      <div class="sitter-balance-wrapper">
        <div class="balace-head">
          <h5><?php echo $this->requestAction('app/get-translate/'.base64_encode('Promote Your Business')); ?>
          </h5>
        </div>
        <div class="promote-wrap1">  
          <p class="para"><?php echo $this->requestAction('app/get-translate/'.base64_encode('Share In Person: Order custom items, like business cards, that include your link and code. Then, share them with friends, neighbors, and family to spread the word')); ?>. 
          </p>
          <h5><?php echo $this->requestAction('app/get-translate/'.base64_encode('Share online')); ?>
          </h5>
          <p class="top10p">
            <?php echo $this->requestAction('app/get-translate/'.base64_encode('Share your profile online to attract new clients')); ?>. 
          </p>
          <ul class=" list-unstyled prom-social">
            <li>
            
				<a href="javascript:void(0)"
				    onclick="javascript:genericSocialShare('http://www.facebook.com/sharer.php?u=<?php echo @$promotion_url; ?>')">
				  <i class="fa fa-facebook-square">
                  </i> <?php echo $this->requestAction('app/get-translate/'.base64_encode('Post On Facebook')); ?>
               </a>   
			   
			</li>
            <li>
			<a href="javascript:void(0)"
              onclick="javascript:genericSocialShare('http://twitter.com/share?text=<?php echo @$promotion_url; ?>')">
                <i class="fa fa-twitter">
                </i> <?php echo $this->requestAction('app/get-translate/'.base64_encode('Post On Twitter')); ?> 
              </a>
            </li>
            <li>
			<a href="javascript:void(0)"
              onclick="javascript:genericSocialShare('http://pinterest.com/pin/create/button/?url=<?php echo @$promotion_url; ?>')">
                <i class="fa fa-pinterest">
                </i> <?php echo $this->requestAction('app/get-translate/'.base64_encode('Post On Craigslist')); ?> 
              </a>
            </li>
           <!-- <li>
              <a href="javascript:void(0)"
                onclick="javascript:genericSocialShare('http://www.facebook.com/sharer.php?u=<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>')">
                <i class="fa fa-linkedin-square">
                </i> Post On Linkedin 
              </a>
            </li>
            <li>
              <a href="#">
                <i class="fa fa-map-marker">
                </i>&nbsp; Post On Google Places 
              </a>
            </li>
            <li>
              <a href="#">
                <i class="fa fa-arrow-up">
                </i> Post On NextDoor 
              </a>
            </li>
            <li>
              <a href="#">
                <i class="fa fa-envelope">
                </i> Email your Profile 
              </a>
            </li>-->
          </ul>
          <p class="prom-visit"> 
            <a href="#"><?php echo $this->requestAction('app/get-translate/'.base64_encode('Visit our Sitter Resources Center for more advice on growing your business')); ?>.
            </a> 
          </p>
        </div>
      </div>

      <!-- Refer frined start -->
         <div class="easy-step-wrapper">
        <div class="easy-head">
          <h5><?php echo $this->requestAction('app/get-translate/'.base64_encode('Refer a Friend')); ?> 
          </h5>
        </div>
        <div class="easy-body">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
              <h2 class="referafriend"><?php echo $this->requestAction('app/get-translate/'.base64_encode('Refer a Friend, get $20')); ?>
              </h2>
              <p class="refer-text"><?php echo $this->requestAction('app/get-translate/'.base64_encode("For every friend that books a stay, we'll give you a $20 credit towards your next booking")); ?>
                . 
              </p>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
              <div class=" text-center">
        <button class="btn btn-invite12"  data-toggle="modal" data-target="#squarespaceModal"> <?php echo $this->requestAction('app/get-translate/'.base64_encode("Invite Friend")); ?>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- end of refer friends -->
          <!--Model pop up -->
        <!-- Modal -->
    <div id="dogInHomeStatusAlert" class="modal fade" role="dialog">
      <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $this->requestAction('app/get-translate/'.base64_encode('Notification')); ?></h4>
        </div>
        <div class="modal-body">
        <p><?php echo $this->requestAction('app/get-translate/'.base64_encode('Dear Sitter, your "dogs in home" status currently disabled,if you still want to add pet then you need to enable the pet status')); ?>.</p><br>
        <p><?php echo $this->requestAction('app/get-translate/'.base64_encode('Are you enable pet status then click on continue?')); ?></p>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="location.href = '<?php echo HTTP_ROOT."dashboard/house#usersitterhouses-outdoor-area-size"; ?>'" ><?php echo $this->requestAction('app/get-translate/'.base64_encode('Continue')); ?></button><button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->requestAction('app/get-translate/'.base64_encode('Cancel')); ?></button>
        </div>
      </div>

      </div>
    </div>
        <!--end pop up-->

    </div>
  </div>
</div>


<!--
refer afriend modal popup stars-->
<!-- line modal -->
<div class="modal fade" id="squarespaceModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">
            <img src="<?php echo HTTP_ROOT; ?>img/pop-cross.png" alt="cross">
          </span>
          <span class="sr-only"><?php echo $this->requestAction('app/get-translate/'.base64_encode('Close')); ?>
          </span>
        </button>
        <h2>
          <span><?php echo $this->requestAction('app/get-translate/'.base64_encode('Refer Friends & Get $20')); ?>
          </span>
        </h2>
      </div>
      <div class="modal-body">
        <!-- content goes here -->
        <div class="row">
       <div class="col-sm-6" style="margin-left:40px">
       <p class="successMessage clr otp_success_msg"></p>
             <p class="errorMessage clr otp_error_msg"></p>
           </div> 
          <div class="col-sm-12">
        
            <div class="to-from">
              <div class="popup-form">
                    <?php echo $this->Form->create(@$userInfo,[
              'url' => ['controller' => 'dashboard', 'action' => 'reference'],
              'class'=>'form-horizontal',
              'id'=>'referForm',
           ]);?>
        <div class="form-group">
          <label for="inputEmail3" class="col-sm-2 col-lg-1 text-left no-padding-right control-label"><?php echo $this->requestAction('app/get-translate/'.base64_encode('To')); ?>:
                    </label>
                    <div class="col-sm-6  ">
                       <?php 
                echo $this->Form->input('UserReferences.email',[
                'templates' => ['inputContainer' => '{{content}}'],
                'label'=>false,
                'class' =>'form-control'
                ]);
                       ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="input" class="col-sm-2 col-lg-1 no-padding-right control-label"><?php echo $this->requestAction('app/get-translate/'.base64_encode('From')); ?>:
                    </label>
                    <div class="col-sm-6  ">
                        <?php 
                echo $this->Form->input('UserReferences.from_email',[
                'templates' => ['inputContainer' => '{{content}}'],
                'label'=>false,
                'class' =>'form-control',
                'value'=>@$user_email,
                'disabled'=>'disabled'
                ]);
                       ?>
                    </div>
                  </div>
              </div>
            </div>
          </div>
          <div class="col-sm-12 col-md-12">
            <div class="pop-content">
              <div class="col-sm-7">
                <p><?php echo $this->requestAction('app/get-translate/'.base64_encode('"I thought you would like $20 to use on
                  Sitter Guide')); ?>.
                </p>
                <br>
                <p><?php echo $this->requestAction('app/get-translate/'.base64_encode('Sitter Guide is the all-in-one home for
                  thousands of people')); ?> 
                  <b><?php echo $this->requestAction('app/get-translate/'.base64_encode('sitting for pets, people, plants & properties')); ?> .
                  </b>
                </p>
                <br>
                <p><?php echo $this->requestAction('app/get-translate/'.base64_encode("It’s really easy to search and find a sitter, conect in-person, book and stay through Sitter Guide")); ?>.
                </p>
                <br>
                <p><?php echo $this->requestAction('app/get-translate/'.base64_encode('Also, check out the market place for')); ?> 
                  <b><?php echo $this->requestAction('app/get-translate/'.base64_encode('traniers, groomers, drivers')); ?> 
                  </b><?php echo $this->requestAction('app/get-translate/'.base64_encode('& people who want to share')); ?> 
                  <b><?php echo $this->requestAction('app/get-translate/'.base64_encode('recreation time')); ?>
                  </b><?php echo $this->requestAction('app/get-translate/'.base64_encode('with you too')); ?> ..."
                </p>         
              </div>
              <div class="col-sm-5 no-padding-left no-padding-right">
                <div class="box">
                  <img src="<?php echo HTTP_ROOT; ?>img/pop-logo.png"  class="img-responsive text-center center-block">
                  <p class="box-text"><?php echo $this->requestAction('app/get-translate/'.base64_encode('Give $20 to your firends to use on their first stay')); ?>
                  </p>
                  <p class="box-text"><?php echo $this->requestAction('app/get-translate/'.base64_encode("You'll also get $20 when they complete their first booking")); ?>.
                  </p>
                  <br>
                  <br>
                  <div class="pop-dog">
                    <img src="<?php echo HTTP_ROOT; ?>img/pop-dog.png" class="img-responsive" alt="dog">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-12 icon-stripe no-padding-left no-padding-right">
            <div class="col-sm-6 col-xs-7">
              <ul class="list-inline icons-social">
                <li>
                   <a href="javascript:void(0)" 
                onclick="javascript:genericSocialShare('http://www.facebook.com/sharer.php?u=<?php echo $refer_url; ?>">
                <img src="<?php echo HTTP_ROOT; ?>img/popi1.png" width="31" height="31" alt="facebook">
          </a>
                </li>
                <li>
                  <img src="<?php echo HTTP_ROOT; ?>img/popi2.png" width="31" height="31" alt="twitter">
                </li>
              </ul>
            </div>
            <div class="col-sm-6 col-xs-5 pull-right text-right">
              <button class="btn btn-send " id="refer-btn" ><?php echo $this->requestAction('app/get-translate/'.base64_encode('Send Mail')); ?>
              </button>
            </div>
          </div>
          <div class="col-sm-12">
            <div class="link">
              <div class="input-group">
                <span class="input-group-addon green" id="basic-addon2" style="cursor:pointer !important;" onclick="copyToClipboard('#userreferences-refer-url')" >
                  <img src="<?php echo HTTP_ROOT; ?>img/pop-chain.png"  alt="chain"> <?php echo $this->requestAction('app/get-translate/'.base64_encode('Copy your link')); ?> 
                </span>
                     <?php 
                echo $this->Form->input('UserReferences.refer_url',[
                'templates' => ['inputContainer' => '{{content}}'],
                'label'=>false,
                'class' =>'form-control',
                'value'=>@$refer_url,
                'readonly'=>'readonly'
                ]);
                       ?>
              </div>
            </div>
          </div>
          <?php echo $this->Form->end(); ?>
          <div class="col-sm-12">
            <p class="email"><?php echo $this->requestAction('app/get-translate/'.base64_encode("In order for your referral to receive a $20 credit, they'll need to use your unique referral link to create a new Sitter Guide account. If a member of their household already has a Sitter Guide account, they'll be ineligible for this credit.")); ?>
            </p>
          </div>
          <div class="col-sm-12">
            <div class="pop-footer">
              <ul class="list-inline">
                <li> &copy; <?php echo $this->requestAction('app/get-translate/'.base64_encode('2016,All Right Reserved')); ?>
                </li>
                <li>|
                </li>
                <li> <a href="http://betasoftdev.com/sitterguide_test/terms" title="Terms and Conditions"><?php echo $this->requestAction('app/get-translate/'.base64_encode('Terms and Conditions')); ?> </a></li>
                </li>
                <li>|
                </li>
                <li><a href="http://betasoftdev.com/sitterguide_test/privacy" title="Privacy Policy"><?php echo $this->requestAction('app/get-translate/'.base64_encode('Privacy Policy')); ?>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--
refer afriend modal popup ends-->
<script type="text/javascript">
function genericSocialShare(url){
  $(".squarespaceModal").modal('hide');
    window.open(url,'sharer','toolbar=0,status=0,width=648,height=395');
    return true;
}
function copyToClipboardFF(text) {
            window.prompt("Copy to clipboard: Ctrl C, Enter", text);
        }

        function copyToClipboard(inputId) {
        var input = $(inputId);
            var success = true,
                    range = document.createRange(),
                    selection;
            // For IE.
            if (window.clipboardData) {
                window.clipboardData.setData("Text", input.val());
            } else {
                // Create a temporary element off screen.
                var tmpElem = $('<div>');
                tmpElem.css({
                    position: "absolute",
                    left: "-1000px",
                    top: "-1000px",
                });
                // Add the input value to the temp element.
                tmpElem.text(input.val());
                $("body").append(tmpElem);
                // Select temp element.
                range.selectNodeContents(tmpElem.get(0));
                selection = window.getSelection();
                selection.removeAllRanges();
                selection.addRange(range);
                // Lets copy.
                try {
                    success = document.execCommand("copy", false, null);
                }
                catch (e) {
                    copyToClipboardFF(input.val());
                }
                if (success) {
                    //alert("The text is on the clipboard, try to paste it!");
                    // remove temp element.
                    tmpElem.remove();
                }
            }
        }
</script>
<script type="text/javascript">
function genericSocialShare(url){
    window.open(url,'sharer','toolbar=0,status=0,width=648,height=395');
    return true;
}
</script>
