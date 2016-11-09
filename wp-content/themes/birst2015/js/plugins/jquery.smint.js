/*

SMINT V1.0 by Robert McCracken
SMINT V2.0 by robert McCracken with some awesome help from Ryan Clarke (@clarkieryan) and mcpacosy ‏(@mcpacosy)
SMINT V3.0 by robert McCracken with some awesome help from Ryan Clarke (@clarkieryan) and mcpacosy ‏(@mcpacosy)

SMINT is my first dabble into jQuery plugins!

http://www.outyear.co.uk/smint/

If you like Smint, or have suggestions on how it could be improved, send me a tweet @rabmyself

*/


(function(){


	$.fn.smint = function( options ) {

		var settings = $.extend({
			'scrollSpeed'  : 500,
			'mySelector'     : 'div'
		}, options);

		// adding a class to users div
		$(this).addClass('smint');

		if($('#wpadminbar').length){
			var admin=162;
		}else{
			var admin=130;
		}
		
		//Set the variables needed
		var optionLocs = new Array(),
			lastScrollTop = 0,
			menuHeight = $(".smint").height(),
			smint = $('.smint'),
        	smintA = $('.smint a'),
        	myOffset = smint.height();

      



		if ( settings.scrollSpeed ) {
				var scrollSpeed = settings.scrollSpeed
			}

		if ( settings.mySelector ) {
				var mySelector = settings.mySelector
		};



		return smintA.each( function(index) {
            
			var id = $(this).attr('href').split('#')[1];

			if (!$(this).hasClass("extLink")) {
				$(this).attr('id', id);
			}

			
			//Fill the menu
			optionLocs.push(Array(
				$(mySelector+"."+id).position().top-menuHeight, 
				$(mySelector+"."+id).height()+$(mySelector+"."+id).position().top, id)
			);

			///////////////////////////////////

			// get initial top offset for the menu 
			if($('#wpadminbar').length){
				var stickyTop = smint.offset().top-162;	
			}else{
				var stickyTop = smint.offset().top-130;	
			}

			// check position and make sticky if needed
			var stickyMenu = function(direction){

				// current distance top
				var scrollTop = $(window).scrollTop()+myOffset; 

				// if we scroll more than the navigation, change its position to fixed and add class 'fxd', otherwise change it back to absolute and remove the class
				if (scrollTop > stickyTop+myOffset) { 
					if($('#wpadminbar').length){
						smint.css({ 'position': 'fixed', 'top':162,'left':0, 'width':'100%' }).addClass('fxd');
					}else{
						smint.css({ 'position': 'fixed', 'top':130,'left':0, 'width':'100%' }).addClass('fxd');
					}
					
					if($(window).width()<769){
						if($('#wpadminbar').length){
							smint.css({ 'position': 'fixed', 'top':96,'left':0, 'width':'100%' }).addClass('fxd');
						}else{
							smint.css({ 'position': 'fixed', 'top':50,'left':0, 'width':'100%' }).addClass('fxd');
						}
					}

					// add padding to the body to make up for the loss in heigt when the menu goes to a fixed position.
					// When an item is fixed, its removed from the flow so its height doesnt impact the other items on the page
					$('body').css('padding-top', menuHeight );	
				} else {
					smint.css({'position':'relative', 'top':0}).removeClass('fxd'); 
					//remove the padding we added.
					$('body').css('padding-top', '0' );	
				}   

				// Check if the position is inside then change the menu
				// Courtesy of Ryan Clarke (@clarkieryan)
				/*if($('#wpadminbar').length){
					var scrollTop2 = $(window).scrollTop()+myOffset+162; 
				}else{
					var scrollTop2 = $(window).scrollTop()+myOffset+130; 
				}
				if(optionLocs[index][0] <= scrollTop2 && scrollTop2 <= optionLocs[index][1]){	
					if(direction == "up"){
						$("#"+id).addClass("active");
						$("#"+optionLocs[index+1][2]).removeClass("active");
					} else if(index > 0) {
						$("#"+id).addClass("active");
						$("#"+optionLocs[index-1][2]).removeClass("active");
					} else if(direction == undefined){
						$("#"+id).removeClass("active");
					} 
					$.each(optionLocs, function(i){
						if(id != optionLocs[i][2]){
							
							$("#"+optionLocs[i][2]).removeClass("active");
						}
					});
				}*/
			};

			// run functions
			stickyMenu();

			// run function every time you scroll
			$(window).scroll(function() {
				//Get the direction of scroll
				if($('#wpadminbar').length){
					var st = $(this).scrollTop()+myOffset+162;
				}else{
					var st = $(this).scrollTop()+myOffset+130;
				}
				if (st > lastScrollTop) {
				    direction = "down";
				} else if (st < lastScrollTop ){
				    direction = "up";
				}
				//console.log(direction+'-'+st+'-'+lastScrollTop);
				lastScrollTop = st;
				stickyMenu(direction);
				
				var mc = $('.mobile-collection').offset().top-278;
				var aa = $('.app-analysis').offset().top-278;
				var rc = $('.rcmgt').offset().top-278;
				var mdm = $('.mdm').offset().top-278;
				var fa = $('.full-api').offset().top-278;
				//console.log(mc+'--'+aa+'--'+rc+'--'+mdm+'--'+fa);
				
				if($(window).scrollTop()<278){
						$('#mobile-collection, #mobile-collection .explore-featured--button').removeClass('active');
					}
					if($(window).scrollTop()>=mc&&$(window).scrollTop()<aa){
						$('#mobile-collection, #mobile-collection .explore-featured--button').addClass('active');
						$('#app-analysis, #app-analysis .explore-featured--button').removeClass('active');
					}
					if($(window).scrollTop()>=aa&&$(window).scrollTop()<rc){
						$('#app-analysis, #app-analysis .explore-featured--button').addClass('active');
						$('#mobile-collection, #mobile-collection .explore-featured--button').removeClass('active');
						$('#rcmgt, #rcmgt .explore-featured--button').removeClass('active');
					}
					if($(window).scrollTop()>=rc&&$(window).scrollTop()<mdm){
						$('#rcmgt, #rcmgt .explore-featured--button').addClass('active');
						$('#mdm, #mdm .explore-featured--button').removeClass('active');
						$('#app-analysis, #app-analysis .explore-featured--button').removeClass('active');
					}
					if($(window).scrollTop()>=mdm&&$(window).scrollTop()<fa){
						$('#mdm, #mdm .explore-featured--button').addClass('active');
						$('#rcmgt, #rcmgt .explore-featured--button').removeClass('active');
						$('#full-api, #full-api .explore-featured--button').removeClass('active');
					}
					if($(window).scrollTop()>=fa){
						$('#full-api, #full-api .explore-featured--button').addClass('active');
						$('#mdm, #mdm .explore-featured--button').removeClass('active');
					}

				// Check if at bottom of page, if so, add class to last <a> as sometimes the last div
				// isnt long enough to scroll to the top of the page and trigger the active state.

				/*if($(window).scrollTop() + $(window).height() == $(document).height()) {
	       			smintA.removeClass('active')
	       			$(".smint a:not('.extLink'):last").addClass('active')
	       			
   				} else {
   					smintA.last().removeClass('active')
   				}*/
			});

			///////////////////////////////////////
        
        	$(this).on('click', function(e){
				// gets the height of the users div. This is used for off-setting the scroll so the menu doesnt overlap any content in the div they jst scrolled to
				if($('#wpadminbar').length){
					var myOffset = smint.height()+172; 
				}else{
					var myOffset = smint.height()+140; 
				}  
				
				if($(window).width()<769){
					if($('#wpadminbar').length){
						var myOffset = smint.height()+132; 
					}else{
						var myOffset = smint.height()+100; 
					} 
				}

        		// stops hrefs making the page jump when clicked
				e.preventDefault();
				
				// get the hash of the button you just clicked
				var hash = $(this).attr('href').split('#')[1];

				

				var goTo =  $(mySelector+'.'+ hash).offset().top-myOffset;
				
				// Scroll the page to the desired position!
				$("html, body").stop().animate({ scrollTop: goTo }, scrollSpeed);
				
				// if the link has the '.extLink' class it will be ignored 
		 		// Courtesy of mcpacosy ‏(@mcpacosy)
				if ($(this).hasClass("extLink"))
                {
                    return false;
                }

			});	


			//This lets yo use links in body text to scroll. Just add the class 'intLink' to your button and it will scroll

			$('.intLink').on('click', function(e){
				var myOffset = smint.height();   

				e.preventDefault();
				
				var hash = $(this).attr('href').split('#')[1];

				if (smint.hasClass('fxd')) {
					var goTo =  $(mySelector+'.'+ hash).position().top-myOffset;
				} else {
					var goTo =  $(mySelector+'.'+ hash).position().top-myOffset*2;
				}
				
				$("html, body").stop().animate({ scrollTop: goTo }, scrollSpeed);

				if ($(this).hasClass("extLink"))
                {
                    return false;
                }

			});	
		});

	};

	$.fn.smint.defaults = { 'scrollSpeed': 500, 'mySelector': 'div'};
})(jQuery);