	var host = window.location.host;
	var proto = window.location.protocol;
	var ajax_url = proto+"//"+host+"/sitterguide_test/"; 
	
	$(function(){
			
		/*DATE PICKER SCRIPT FOR HOME PAGE CALENDER START*/
		$( "#boardingFrom" ).datepicker({
		  defaultDate: "+1",
		  changeMonth: true,
		  dateFormat: 'yy-mm-dd', 
		  numberOfMonths: 1,
		  yearRange: "-50:+0",
		  minDate: new Date(),
		  onSelect: function(date){

				var selectedDate = new Date(date);
				var msecsInADay = 86400000;
				var endDate = new Date(selectedDate.getTime() + msecsInADay);

				//$("boardingTo").datepicker( "option", "minDate", endDate );
				$( "#boardingTo" ).datepicker( "option", "minDate", date );
		  }
		  /*onClose: function( selectedDate ) {
			$( "#boardingTo" ).datepicker( "option", "minDate", selectedDate );
		  }*/
		});
		
		//DATE PICKER SCRIPT FOR TO DATE
		$( "#boardingTo" ).datepicker({
		  defaultDate: "+1",
		  changeMonth: true,
		  dateFormat: 'yy-mm-dd',
		  numberOfMonths: 1,
		  yearRange: "-50:+0",
		  minDate: new Date(),
		  /*onClose: function( selectedDate ) {
			$( "#boardingFrom" ).datepicker( "option", "maxDate", selectedDate );
		  }*/
		});
		
		//OPEN DATE PICKER ONCLICK ON CALENDER ICON FOR TO AND FROM DATE
		$('#cIconFrom').click(function(){
			$( "#boardingFrom" ).focus();

		});
		
		$('#cIconTo').click(function(){
			$( "#boardingTo" ).focus();

		});
		
		/*HOME PAGE CALENDER SCRIPT END*/
		
		
		
		/*DATE PICKER SCRIPT FOR SEARCH FILTER ON SEARCH PAGE CALENDER START*/
		$( "#boardingFromFilter" ).datepicker({
		  defaultDate: "+1",
		  changeMonth: true,
		  dateFormat: 'yy-mm-dd', 
		  numberOfMonths: 1,
		  yearRange: "-50:+0",
		  minDate: new Date(),
		  onSelect: function(date){

				var selectedDate = new Date(date);
				var msecsInADay = 86400000;
				var endDate = new Date(selectedDate.getTime() + msecsInADay);

				//$("boardingTo").datepicker( "option", "minDate", endDate );
				$( "#boardingToFilter" ).datepicker( "option", "minDate", date );
				gerSearchResult();
		  }
		  /*onClose: function( selectedDate ) {
			$( "#boardingTo" ).datepicker( "option", "minDate", selectedDate );
		  }*/
		});
		
		//DATE PICKER SCRIPT FOR TO DATE
		$( "#boardingToFilter" ).datepicker({
		  defaultDate: "+1",
		  changeMonth: true,
		  dateFormat: 'yy-mm-dd',
		  numberOfMonths: 1,
		  yearRange: "-50:+0",
		  minDate: new Date(),
		  onClose: function( selectedDate ) {
			//$( "#boardingFrom" ).datepicker( "option", "maxDate", selectedDate );
			gerSearchResult();
		  }
		});
		
		
		/*- OLD CODE
		$( "#boardingFromFilter" ).datepicker({
		  defaultDate: "+1",
		  changeMonth: true,
		  dateFormat: 'yy-mm-dd', 
		  numberOfMonths: 1,
		  yearRange: "-50:+0",
		  onClose: function( selectedDate ) {
			$( "#boardingToFilter" ).datepicker( "option", "minDate", selectedDate );
		  },
		  onSelect: function(dateText, inst) {
			setTimeout(function(){ $( "#boardingToFilter" ).focus(); }, 000);
			
				
		  }
		});
		
		//DATE PICKER SCRIPT FOR TO DATE
		$( "#boardingToFilter" ).datepicker({
		  defaultDate: "+1",
		  changeMonth: true,
		  dateFormat: 'yy-mm-dd',
		  numberOfMonths: 1,
		  yearRange: "-50:+0",
		  onClose: function( selectedDate ) {
			$( "#boardingFromFilter" ).datepicker( "option", "maxDate", selectedDate );
		  },
		  onSelect: function(dateText, inst) {
				 gerSearchResult();
				
		  }
		});*/
		
		//OPEN DATE PICKER ONCLICK ON CALENDER ICON FOR TO AND FROM DATE
		$('#cIconFromFilter').click(function(){
			$( "#boardingFromFilter" ).focus();

		});
		
		$('#cIconToFilter').click(function(){
			$( "#boardingToFilter" ).focus();

		});
		
		/*DATE PICKER SCRIPT FOR SEARCH FILTER ON SEARCH PAGE CALENDER END*/
		
		
		//CHANGE HOME PAGE SEARCH BUTTON VALUE ON CLICK
		$('.searchBtn').click(function(){
			var orgBtn = $(this).val();
			$(this).val('Searching...');

		});
		
		//SCRIPT FOR CHOOSE SERVICES SYNCRONIZATION WITH FOR CODE ON HOME PAGE
		$('.chooseService').click(function(){
			
			$('.chooseService').removeClass('active');
			
			$(this).addClass('active');
			
			$('#selected_service').val($("ul.service_selected a.active").attr('data-rel'));
			
			$('.zipOption').removeClass('onLoadHide');
			$('.dogOption').addClass('onLoadHide');
			
			$('.FirstThreeServices').removeClass('onLoadHide');
			$('.LastTwoServices').addClass('onLoadHide');
			
			if($(this).hasClass('d-visit')){
				$('.zipOption').addClass('onLoadHide');
				$('.dogOption').removeClass('onLoadHide');
			}

			if($(this).hasClass('dn-care')){
				
				$('.FirstThreeServices').addClass('onLoadHide');
				$('.mpOption').addClass('onLoadHide');
				$('.dnOption').removeClass('onLoadHide');
				
			}		

			if($(this).hasClass('m-place')){
				$('.FirstThreeServices').addClass('onLoadHide');
				$('.dnOption').addClass('onLoadHide');
				$('.mpOption').removeClass('onLoadHide');
				
			}


		});
		
		
		//SCRIPT FOR CHOOSE SERVICES SYNCRONIZATION WITH FOR CODE ON SEARCH PAGE	
		$('.chooseService').click(function(){
			$('.chooseService').removeClass('active');
			$(this).addClass('active');
			
			$('#selected_service').val($("ul.service_selected a.active").attr('data-rel'));
			
			$('.dropInOption').addClass('onLoadHide');
			$('.FirstThreeServices').removeClass('onLoadHide');
			$('.LastTwoServices').addClass('onLoadHide');
			$('.mPlacesOption').children().removeClass('onLoadHide');

			if($(this).hasClass('d-visit')){
				$('.dropInOption').removeClass('onLoadHide');
			}

			if($(this).hasClass('dn-care')){
				$('.FirstThreeServices').addClass('onLoadHide');
				$('.LastTwoServices').removeClass('onLoadHide');
			}

			if($(this).hasClass('m-place')){
				$('.FirstThreeServices').addClass('onLoadHide');
				$('.LastTwoServices').removeClass('onLoadHide');
				$('.mPlacesOption').children().addClass('onLoadHide');
			}


		});
		
		//SCRIPT FOR PRICE SLIDER CODE 
		$( "#slider-range" ).slider({
		  range: true,
		  min: 0,
		  max: 500,
		  values: [ 1, 200 ],
		  slide: function( event, ui ) {
			$( "#startRange" ).val( "$" + ui.values[ 0 ]);
			$( "#endRange" ).val( "$" + ui.values[ 1 ]);
			
		  },
		  change: function( event, ui ) {
			 gerSearchResult();
			
		  }

		});
    
		$( "#startRange" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ));
   
		$( "#endRange" ).val( "$" + $( "#slider-range" ).slider( "values", 1 ));
    
		
		/*Search JS ADD ON FORM START By Rahul jain dated on 5th May*/
		$("ul.pet_count li.dog-in-li").click(function() {
			$("ul.pet_count li").removeClass('active');
			$(this).addClass("active");
			$('#pet_count').val($("ul.pet_count li.active span").attr('data-rel'));
			
		});
	
		$("ul.booking_days li.dog-in-li").click(function() {
			
			if($(this).hasClass("active")==true){
				$(this).removeClass("active");
			}else{
				$(this).addClass("active");
			}
			
			var textArray = $('ul.booking_days li.active').find('span:first').map(function(){
				return $(this).attr('data-rel');
			}).get(); // ["sunday", "monday"]

			var textString = textArray.join(); // "sanday, monday"
			$('#booking_days').val(textString);
			
		});
	   ////////////////
	   /*$("ul.booking_days li.dog-in-li").click(function() {
			
			if($(this).hasClass("active")==true){
				$(this).removeClass("active");
			}else{
				$(this).addClass("active");
			}
			
			var textArray = $('ul.booking_days li.active').find('span:first').map(function(){
				return $(this).attr('data-rel');
			}).get(); // ["sunday", "monday"]

			var textString = textArray.join(); // "sanday, monday"
			$('#booking_days').val(textString);
			
		});*/
	   ///////////
		$("ul.marketplace li.marketplace_li").click(function() {
			
			if($(this).hasClass("active")==true){
				$(this).removeClass("active");
			}else{
				$(this).addClass("active");
			}
			
			var textArray = $('ul.marketplace li.active').find('a:first').map(function(){
				return $(this).attr('data-rel');
			}).get(); // ["sunday", "monday"]

			var textString = textArray.join(); // "sanday, monday"
			$('#marketplace').val(textString);
			
		});
		
		//GET VALUE OF DOG SIZES
		$("ul.dog_size li.dog_size_li").click(function() {
			
			if($(this).find('a:first').hasClass("active")==true){
				$(this).find('a:first').removeClass("active");
			}else{
				$(this).find('a:first').addClass("active");
			}
			
			$('#dog_size').val($(this).find('a:first').attr('data-rel'));
			
		});
		
		//PERFORM SEARCH FUNCTIONALITY USING AJAX
		$(".ajaxSearch").click(function(){

			  gerSearchResult();
	
		});

		$(".ajaxSearchDropDown").change(function(){

			gerSearchResult();

		});

		$(".ajaxPopUpSearch").click(function(){

			gerSearchResult();
			/*
			$('#pet_in_home').prop('checked', false);
			$('#housing_condition').prop('checked', false);
			$('#medical_experience').prop('checked', false);
			$('.homePet').prop('checked', false);
			$('.house-condition').prop('checked', false);
			$('.medical-experience').prop('checked', false);
			*/

		});		
		
		//FUNCTIONALITY FOR SITTER MORE INFO
		$('#pet_in_home').click(function(){
			  if($(this).is(":checked")){
				  $('.homePet').prop('checked', true);
			  }
			  else if($(this).is(":not(:checked)")){
				  $('.homePet').prop('checked', false);
			  }
		});
		$('#housing_condition').click(function(){
			  if($(this).is(":checked")){
				  $('.house-condition').prop('checked', true);
			  }
			  else if($(this).is(":not(:checked)")){
				  $('.house-condition').prop('checked', false);
			  }
		});
		$('#medical_experience').click(function(){
			  if($(this).is(":checked")){
				  $('.medical-experience').prop('checked', true);
			  }
			  else if($(this).is(":not(:checked)")){
				  $('.medical-experience').prop('checked', false);
			  }
		});
		
		
	});

	function gerSearchResult(){
		
	  var posted_data = $('#searchParam').serialize() + '&location=' + $("#location_autocomplete").val();//ALL SUBMITTED DATA FROM THE FORM
	  
	  $.ajax({
			url: $('#searchParam').attr('action'),//AJAX URL WHERE THE LOGIC HAS BUILD
			data:posted_data,
			
			beforeSend: function(){
			  $(".search-overlay").show();
			  $(".sl-area").html('<span class="search-overlay"><img class="search-img" src="'+ajax_url+'img/walking.gif"/></span>');
			},
			
			complete: function(){
			  $(".search-overlay").hide();
			  $(".search-overlay").html('');
			},
			success:function(res)
			{
			  $(".searchRes").html(res);
			  $('[data-toggle="popover"]').popover();
			}
		  });

	}
	
	$(document).on( 'change', '.searchByDistance', function (e){
		$('#hidden_distance').val($(this).val());
		gerSearchResult();
	});
	
	/*FAVOURITE SECTION START*/
	$(document).on('click','.favouriteSection',function(){

		var objLike = $(this);
		var actionURL = objLike.data("href");
		objLike.parent('.favourite_sitter1').children('.likeLoader').show();
		$.ajax({
			url: actionURL,//AJAX URL WHERE THE LOGIC HAS BUILD
			success:function(res)
			{
				var response = res.split(':');
				
				if($.trim(response[0]) == 'Success'){
				
					if($.trim(response[1])=='unlike')
					{
						objLike.removeClass('unlike');
						objLike.addClass('like');					
						objLike.html('&nbsp;<i class="fa fa-heart-o"></i>');
					}
					else
					{
						objLike.removeClass('like');
						objLike.addClass('unlike');		
						objLike.html('&nbsp;<i class="fa fa-heart"></i>');
					}
				}else if($.trim(response[0]) == 'Error'){
					window.location.href=ajax_url+"guests/login";
				}
				objLike.parent('.favourite_sitter1').children('.likeLoader').hide();
			}
		});
	});	/*FAVOURITE SECTION END*/
	
