<section class="tab-section1" >
		<div class="container">
			<div class="help-listing1">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
						<h2 class="pt22"><?php if(!empty($title)){echo $title;}?></h2>
						<?php  if(empty($faqsData)){?><div class="col-md-3 col-md-offset-5"><h4><?php echo $this->requestAction('app/get-translate/'.base64_encode("Record Not Found"));?><h4></div> <?php	 }
							else{
									$count=1;
									foreach($faqsData as $faqs) { ?>
										
																									
															<div>
																	<h3><?php echo $count++.".      ".$faqs->question;?></h3>
																	<p class="text-justify" >	<?php echo $faqs->answer;?>	</p>
																										 
															</div>
													<?php	
													
												}
								}?>
					</div>
    			</div>
			</div>
       </div>
</section>
<style>
.tab-section .customHeight ul li a {
  color: #71a140 !important; 
  font-size: 13px;
}
.pad-bottom10 b {
  font-weight: 800 !important;
}
</style>
