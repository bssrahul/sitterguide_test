<!--[Inner Content]-->
<section class="inner-cont"> 
	
  <!--[Search result page]-->
    <?php echo $this->element('frontElements/Search/search_filters'); ?>

  <!--[Search result page]--> 
  <!--[Search result Listing]-->
  <div class='searchRes'>		
  <?php echo $this->element('frontElements/Search/search_results'); ?>  
  </div>
<!--[/Search result Listing]--> 
  
</section>
<style>

.search-overlay .search-img { position: relative; top: 100px;}
.search-overlay { background: #fff none repeat scroll 0 0;display: block; left: 0; min-height: 100%; position: relative; text-align: center; top: 0; transition: all 0.3s ease 0s; width: 100%; z-index: 1002;}
.sl-map{height:768px;}
</style>

<!--[Inner Content]-->  
<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();
    
    	$('#pet_in_home').prop('checked', false);
		$('#housing_condition').prop('checked', false);
		$('#medical_experience').prop('checked', false);
		$('.homePet').prop('checked', false);
		$('.house-condition').prop('checked', false);
		$('.medical-experience').prop('checked', false);
});

    /*function init() {
        window.addEventListener('scroll', function(e){
            var distanceY = window.pageYOffset || document.documentElement.scrollTop,
                shrinkOn = 300,
                header = document.querySelector("header");
            if (distanceY > shrinkOn) {
                classie.add(header,"smaller");
            } else {
                if (classie.has(header,"smaller")) {
                    classie.remove(header,"smaller");
                }
            }
        });
    }*/
    window.onload = init();
    

</script>
<script>
    
    
    $(function(){
        
        $(document).on('click',".qvBtn",function(){
        
            if($('#myCarousel2').find("div.popUpSlider").removeClass("active")){
                $('#myCarousel2').find("div.popUpSlider").removeClass("active");
            }
            var qv = $(this).attr('data-rel');
            $(".qvModal"+qv).addClass('active');
        
        });
        
        $('#myCarousel2').bind('slide.bs.carousel', function (e) {
        
            
            
        }); 
    });

     $(document).ready(function(){
     
        $("#sidebar").stick_in_parent();
        
    
     });
     //For slider
    // alert(4);
      $(document).on('click',".pageLink",function(){
        //alert(5);
            $(".pageLink").removeClass("Pageactive");
            $(this).addClass("Pageactive");
            var page = $(this).data('rel');
            var location_val = $("#location_autocomplete").val();
            
            $.ajax({
                url: "<?php echo HTTP_ROOT."search/ajax-pagination"; ?>",
                data:{pageno:page,location_autocomplete:location_val},
                type:"POST",
                beforeSend: function(){
                  $('#getImg'+sitter).html('<div class="ajax_overlay"><img class="search-img" src="'+ajax_url+'img/walking.gif"/></div>');
                  $(".ajax_overlay").show();
                },
                
                complete: function(){
                  $('#getImg'+sitter).html('');
                  $(".ajax_overlay").hide();
                },
                success:function(res)
                {
                    //console.log("success");
                    $(".searchRes").html(res);
                    
                }
            });
            
        });


      $(document).on('click',".SearchpageLink",function(){
        //alert(5);
            var page = $(this).data('rel');
            $(".SearchpageLink").removeClass("Pageactive");
            var posted_data = $('#searchParam').serialize() + '&location=' + $("#location_autocomplete").val() + '&pageno='+page;//ALL SUBMITTED DATA FROM THE FORM
            
            $(this).addClass("Pageactive");
            
            $.ajax({
                url: "<?php echo HTTP_ROOT."search/search-ajax-pagination"; ?>",
                data:posted_data,
                type:"POST",
                beforeSend: function(){
                  $('#getImg'+sitter).html('<div class="ajax_overlay"><img class="search-img" src="'+ajax_url+'img/walking.gif"/></div>');
                  $(".ajax_overlay").show();
                },
                
                complete: function(){
                  $('#getImg'+sitter).html('');
                  $(".ajax_overlay").hide();
                },
                success:function(res)
                {
                    //console.log("success");
                    $(".searchRes").html(res);
                    
                }
            });
            
        });
     $(document).on('click',".quick-view",function(){
         //alert($(this).find('a.select-sitter-images').attr("data-rel2"));
         //$('#myCarousel2').find("active").;
         //$( "#myCarousel2" ).hasClass("active")
         
         sitter_images($(this).find('a.select-sitter-images').attr("data-rel2"));
         
         
     });
   
     $(document).on('click',".rightPopup",function(){
         if($("#myCarousel2").find("div.active").next().find('div.sitter-quike-view').attr('data-id')){
            sitter_images($("#myCarousel2").find("div.active").next().find('div.sitter-quike-view').attr('data-id'));
              
         }else{
            sitter_images($('.qvModal'+$('#myCarousel2 .popUpSlider').length).find('div.sitter-quike-view').attr('data-id'));
         } 
     });
    
     $(document).on('click',".leftPopup",function(){
         if($("#myCarousel2").find("div.active").prev().find('div.sitter-quike-view').attr('data-id')){
             sitter_images($("#myCarousel2").find("div.active").prev().find('div.sitter-quike-view').attr('data-id'));
          }else{
              sitter_images($('.qvModal'+$('#myCarousel2 .popUpSlider').length).find('div.sitter-quike-view').attr('data-id'));
          }
    });
    
    var sitter;
    
    function sitter_images(sitter){
           $.ajax({
                url: "<?php echo HTTP_ROOT."search/sitter-gallery"; ?>",
                data:{sitter:sitter},
                type:"POST",
                
                beforeSend: function(){
                  $('#getImg'+sitter).html('<div class="ajax_overlay"><img class="search-img" src="'+ajax_url+'img/walking.gif"/></div>');
                  $(".ajax_overlay").show();
                },
                
                complete: function(){
                  $('#getImg'+sitter).html('');
                  $(".ajax_overlay").hide();
                },
                success:function(res)
                {
                    $('#getImg'+sitter).html("");
                    setTimeout(function(){
                        $('#getImg'+sitter).html(res);
                        $('.ajaxSliderNext').attr('href','#customCrousalNext'+sitter); 
                        $('.ajaxSliderPrev').attr('href','#customCrousalNext'+sitter); 
                    },1000);

                    setTimeout(function(){
                        $('.customCrousalNext'+sitter).carousel();  
                    },1500);
                    
                }
            });
    }
</script>
<style>
.searchImg{width:163px; height:165px;}
.favouriteSection { background: rgba(0, 0, 0, 0) none repeat scroll 0 0 !important; color: #da6a14; font-size: 25px;text-decoration:none !important; outline:none;}
.mapIconLabel { font-size: 15px; font-weight: bold; color: #FFFFFF; font-family: 'DINNextRoundedLTProMediumRegular';}
.pagination{float:left; margin-left:50px;}
.Pageactive{background-color:#cceeff; color:#fff;}
.pagination > li > a.Pageactive,.pagination >  li:first-child { background-color:#80bfff; color:#fff;}
</style>
