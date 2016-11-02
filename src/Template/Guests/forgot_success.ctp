<!--[.innerpage-conent Area start]-->
<main>
  <section>
    <div class="innerpage-conent">
      <div class="thankyou-wrapper">
        <div class="container">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
              <h1 class="thankyou-heading">
                <span >
                  <i>
                  </i>
                </span> <?php echo $this->requestAction('app/get-translate/'.base64_encode('Congrats! Password reset request has been recieved.')); ?> 
              </h1>
              <p class="thankyou-title">
              </p>
              <p class="thankyou-text">
                <span><?php echo $this->requestAction('app/get-translate/'.base64_encode('What happens now')); ?>
                </span>
               </p>
            </div>
          </div>
          <div class="wrapper-thankyou ">
            <div class="thankyou1">
              <div class="thankyou-icon">
                <span class="icon-2">
                </span>
              </div>
              <div class="thankyou-icon-righttext">
                <h3><?php echo $this->requestAction('app/get-translate/'.base64_encode('You will recieve an email along with password reset link as soon as possible.')); ?> 
                </h3>
                <p><?php echo $this->requestAction('app/get-translate/'.base64_encode('Kindly Review this email.')); ?> 
                </p>
                
              </div>
            </div>
            
            <div class="thankyou1 margt20">
              <div class="thankyou-icon">
                <span class="icon-1">
                </span>
              </div>
              <div class="thankyou-icon-righttext">
                <h3><?php echo $this->requestAction('app/get-translate/'.base64_encode('You have to click on reset password link which is sent in your email')); ?> 
                </h3>
                <p><?php echo $this->requestAction('app/get-translate/'.base64_encode('Once you clicked on that link then you will be redirect on reset password form.')); ?> 
                </p>
              </div>
            </div>
            
            
            <div class="thankyou1 margt20">
              <div class="thankyou-icon">
                <span class="icon-3">
                </span>
              </div>
              <div class="thankyou-icon-righttext">
                <h3><?php echo $this->requestAction('app/get-translate/'.base64_encode('Set New Password')); ?>
                </h3>
                <p><?php echo $this->requestAction('app/get-translate/'.base64_encode('You have to enter new password and confirm password for reset the old password.')); ?>
                </p>
              </div>
            </div>
            
            
          </div>
        </div>
        <hr />
        <div class="container">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <h5 class="contact-text"><?php echo $this->requestAction('app/get-translate/'.base64_encode('Connect with us for the  Latest News & Updates')); ?>
              </h5>
              <ul class="list-inline text-center thanks-social-icon">
                <li>
                  <a href="<?php echo isset($siteConfiguration->facebook_link)? $siteConfiguration->facebook_link:""; ?>">
                    <div class="thanks-facebook-icon">
                      <i class="fa fa-facebook" >
                      </i>
                    </div>
                  </a>
                </li>
                <li>
                  <a href="<?php echo isset($siteConfiguration->twitter_link)? $siteConfiguration->twitter_link:""; ?>">
                    <div class="thanks-twiter-icon">
                      <i class="fa fa-twitter" >
                      </i>
                    </div>
                  </a>
                </li>
                <li>
                  <a href="<?php echo isset($siteConfiguration->google_link)? $siteConfiguration->google_link:""; ?>">
                    <div class="thanks-gplus-icon">
                      <i class="fa fa-google-plus" >
                      </i>
                    </div>
                  </a>
                </li>
                <li>
                 <a href="<?php echo isset($siteConfiguration->instagram_link)? $siteConfiguration->instagram_link:""; ?>">
                    <div class="thanks-linked-icon">
                      <i class="fa fa-instagram" >
                      </i>
                    </div>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
