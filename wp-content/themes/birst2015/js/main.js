/* global jQuery, window */
(function($) {
	
	var countDown = {
		labels: ['weeks', 'days', 'hours', 'minutes', 'seconds'],
		parser: /([0-9]{2})/gi,
		currDate: '00:00:00:00:00',
		nextDate: '00:00:00:00:00',
		init: function () {
			
			if (typeof $.fn.countdown === 'function') {
				
				$('.countdown-timer').each( function () {
					var _this = $(this);
					
					countDown.buildLayout(_this);
					
					_this.countdown( _this.data('datetime'), function(event) {
						var newDate = event.strftime('%w:%d:%H:%M:%S'),
							data;
						if (newDate !== countDown.nextDate) {
							countDown.currDate = countDown.nextDate;
							countDown.nextDate = newDate;
							// Setup the data
							data = {
								'curr': countDown.strfobj(countDown.currDate),
								'next': countDown.strfobj(countDown.nextDate)
							};
							// Apply the new values to each node that changed
							countDown.diff(data.curr, data.next).forEach(function(label) {
								var selector = '.%s'.replace(/%s/, label),
										$node = _this.find(selector);
								// Update the node
								$node.removeClass('flip');
								$node.find('.curr').text(data.curr[label]);
								$node.find('.next').text(data.next[label]);
								// Wait for a repaint to then flip
								/* _.delay(function($node) {
									$node.addClass('flip');
								}, 50, $node); */
								setTimeout( function() {
									$node.addClass('flip');
								}, 50);
							});
						}
					});
					
				});
				
			}
			
		},
		strfobj: function(str) {
			var parsed = str.match(countDown.parser), obj = {};

			countDown.labels.forEach(function(label, i) {
        obj[label] = parsed[i];
      });
      return obj;
    },
		diff: function(obj1, obj2) {
      var diff = [];
      countDown.labels.forEach(function(key) {
        if (obj1[key] !== obj2[key]) {
          diff.push(key);
        }
      });
      return diff;
    },
		buildLayout: function(container) {
			// Build the layout
			var initData = countDown.strfobj(countDown.currDate);
			countDown.labels.forEach(function(label, i) {
				var cur = initData[label];
				var next = initData[label];
				container.append('<div class="time '+label+'"><span class="count curr top">'+cur+'</span><span class="count next top">'+next+'</span><span class="count next bottom">'+next+'</span><span class="count curr bottom">'+cur+'</span><span class="label">'+label+'</span></div>');
			});
		}
	};
	$(countDown.init());


	var secondaryImageAlignmnet = {
		init: function () {
			$('.secondary-background').each( function () {
				var position = $(this).data('bg-position');
				$(this).css({'background-position': position, 'height': $(this).parent().height()+'px'});
			});
			
			$( window ).resize( function() {
				$('.secondary-background').each( function () {
					$(this).css({'height': $(this).parent().height()+'px'});
				});
			});
			
		}
	};
	$(secondaryImageAlignmnet.init());
	
	var WebLayer = {
		init: function () {
      if($(window).width() > 768){
			$('.layer--web .item').hover(function(){
        var $item = $(this).index();
        $('.layer--web .secondary-content').hide();
        $('.layer--web .secondary-content:eq('+$item+')').show();
        $('.layer--web .center-content').hide();
      }, function(){
        $('.layer--web .center-content').show();
        $('.layer--web .secondary-content').hide();
      });
      }else{
        $('.layer--web .item').click(function(){
        var $item = $(this).index();
        $('.layer--web .secondary-content').hide();
        $('.layer--web .secondary-content:eq('+$item+')').show();
        $('.layer--web .center-content').hide();
        });
        $('.layer--web .center-item').click(function(){
        $('.layer--web .center-content').show();
        $('.layer--web .secondary-content').hide();
        });
      }
		}
	};
  $(WebLayer.init);

	
	var HoverImages = {
		init: function () {
      $('.badged-list__list-item').hover(function(){
        if($(this).find('.badged-list__list-item__badge-c img').attr("src").indexOf(".svg") != -1){
          var bgimg = $(this).find('.badged-list__list-item__badge-c img').attr("src").replace(".svg","");
          $(this).find('.badged-list__list-item__badge-c img').attr("src",bgimg+"-roll.svg");
        }else{
          var bgimg = $(this).find('.badged-list__list-item__badge-c img').attr("src").replace(".png","");
          $(this).find('.badged-list__list-item__badge-c img').attr("src",bgimg+"-roll.png");
        }
      }, function(){
        if($(this).find('.badged-list__list-item__badge-c img').attr("src").indexOf(".svg") != -1){
          var bgimg = $(this).find('.badged-list__list-item__badge-c img').attr("src").replace("-roll.svg",".svg");
          $(this).find('.badged-list__list-item__badge-c img').attr("src",bgimg);
        }else{
          var bgimg = $(this).find('.badged-list__list-item__badge-c img').attr("src").replace("-roll.png",".png");
          $(this).find('.badged-list__list-item__badge-c img').attr("src",bgimg);
        }
      });
    }
  };
  //$(HoverImages.init);
  
  var searchForm = {
		init: function () {
			
			$("#search").attr('value', '');
			$("#search-mobile").attr('value', '');
			
			$('#search-container > form').on('submit', function (e) {
				
				var _this = $(this);
				var searchField = _this.find("#search");
				
				if (searchField.val() == '') {
					
					if(searchField.hasClass('show')) {
						searchField.addClass('validation-error');
					} else {
						searchField.addClass('show');
					}
					
					return false;
					
				} else {
					
					//_this.submit();
					return true;
					
				}
				
				return false;
				
			});
			
			$('#mobile-search-container > form').on('submit', function (e) {
				
				var _this = $(this);
				var searchField = _this.find("#search-mobile");
				
				if (searchField.val() == '') {
					
					
					
					
					if(searchField.hasClass('show')) {
						searchField.addClass('validation-error');
					} else {
						
						$('.navbar-toggle').fadeOut();
						$('.site-branding').fadeOut(300, 
								function () { 
									$('#mobile-search-container').css({'width': '91%', 'margin-right': '8%'}); 
									searchField.addClass('show'); 
									$('.close-search').addClass('show');
								} );
					}
					
					return false;
					
				} else {
					
					//_this.submit();
					return true;
					
				}
				
				return false;
				
			});
			
			$('.close-search').click ( function () {
				
				$(this).removeClass('show');
				$("#search-mobile").attr('value', '');
				
				$('#mobile-search-container').css({'width': '16px', 'margin-right': '3%'}); 
				$('#search-mobile').removeClass('show'); 
				$('.close-search').removeClass('show');
				
				setTimeout( function () {
					$('.navbar-toggle').fadeIn();
					$('.site-branding').fadeIn();
				}, 400);
						
			});


			$('#search').keyup( function() {
					
					$(this).addClass('has-value');
					
					if ($(this).hasClass('validation-error')) {
						$(this).removeClass('validation-error');
					}
					
			});
			
			$('#search-mobile').keyup( function() {
					
					$(this).addClass('has-value');
					
					if ($(this).hasClass('validation-error')) {
						$(this).removeClass('validation-error');
					}
					
			});
			
		}
	};
	$(searchForm.init);
	
	var layerMobileImage = {
		init: function () {
			
			$('section').each( function () {
				
				var _this = $(this);
				var _data = _this.data('mobileimage');
				
				if (_data !== undefined) {
					_this.css({'background': 'url(' +_data+ ')'});
				}
				
			});
			
		}
	};
	if ($(window).width() < 769) {
		$(layerMobileImage.init);
	}
	
	var mastCarousel = {
		init: function () {
			
			$('.layer--mast').each( function () {
				
				var _this = $(this);
				var height;
				
				var img = _this.find('.layer--mast-container-c:first-child').data('bgimage');
				var container = _this.find('.layer--mast-carousel-carousel-nav-side-bg');
									
				container.css({'background-image': 'url('+img+')'});
				
				if ($(window).width() > 768) {
					_this.find('.layer--mast-carousel').carouFredSel({
						height : 700,
						align : 'center',
						width : '100%',
						infinite : true,
						circular : true,
						responsive : true,
						scroll : {
								items : 1,
								fx : 'fade',
								duration : 1200,
								onBefore: function () {
									var container = _this.find('.layer--mast-carousel-carousel-nav-side-bg');
									container.fadeOut();
								},
								onAfter: function () {
									
									var img = _this.find('.layer--mast-container-c:first-child').data('bgimage');
									var container = _this.find('.layer--mast-carousel-carousel-nav-side-bg');
									container.fadeIn();
									container.css({'background-image': 'url('+img+')'});
									
								}
						}
					});
				} else {
					if (_this.find('.layer--mast-carousel').length) {
						_this.removeAttr('style');
					}
					_this.find('.layer--mast-carousel').carouFredSel({
						align : 'center',
						width : '100%',
						infinite : false,
						circular : false,
						responsive : true,
						scroll : {
								items : 1,
								fx : 'crossfade',
								duration : 1200,
								onAfter: function () {
									
									var img = _this.find('.layer--mast-container-c:first-child').data('bgimage');
									var container = _this.find('.layer--mast-carousel-carousel-nav-side-bg');
									
									console.log(img);
									
									container.css({'background-image': img})
									
								}
						}
					});
				}
				
				
				
			});
			
		}
	};
	$(mastCarousel.init());
	
	var featureImageVideo = {
		init: function () {
			
			$('.layer--featured-image').each( function () {
				
				var _this = $(this);
				
				var waypoint = new Waypoint({
					element: _this,
					handler: function () {
						if (_this.find('video').length) {
							_this.find('video')[0].play();
						}
					},
					offset: '50%'
				});
				
			});
			
		}
	};
	$(featureImageVideo.init);
	
	var whyAnimationLayers = {
		init: function () {
			
			var container, layers = Array(), layersCount = 0, windowHeight = $(window).height();
			
			container = $('.layer--why-animated-layer-container');
			
			var multiplier = 0.5;
			var index = 0;
			
			var bgIndex = [2400, 4500, 4500, 5500, 7000, 7200];
			
			$('.layer--why-animated-animation').each( function () {
				
				var _this = $(this);
				var birstTile = _this.find('.layer--why-animated-animation-tile-birst');
				
				console.log(bgIndex[index]);
				
				layersCount++;
				
				whyAnimationLayers.centerObject(birstTile);
				
				if(!navigator.userAgent.match('CriOS')) {
					container.find('.layer--why-animated-animation-bg:eq('+_this.index()+')').parallax("50%", bgIndex[index], 0.2, true);
				}
				
				if(navigator.userAgent.match('CriOS')) {
					
					whyAnimationLayers.alignObjectToObject(_this.find('.layer--why-animated-animation-tile-legacy'), birstTile, 'left');
					whyAnimationLayers.alignObjectToObject(_this.find('.layer--why-animated-animation-tile-discovery'), birstTile, 'right');
					_this.find('.layer--why-animated-animation-bg').css({'opacity': 1, 'transition': 'all 0s ease-in'});
					
				} else {
					
					var waypoint = new Waypoint({
						element: _this,
						handler: function () {
							whyAnimationLayers.alignObjectToObject(_this.find('.layer--why-animated-animation-tile-legacy'), birstTile, 'left');
							whyAnimationLayers.alignObjectToObject(_this.find('.layer--why-animated-animation-tile-discovery'), birstTile, 'right');
						},
						offset: '10%'
					});
					
					var waypoint = new Waypoint({
						element: _this,
						handler: function () {
							_this.find('.layer--why-animated-animation-bg').css({'opacity': 1});
							
						},
						offset: '100%'
					});
					
				}
				
				index++;
				
			});
			
			if ($(window).width() > 768) {
				//container.css({'height': (windowHeight*layersCount)+'px'});
			}
			
		},
		centerObject: function (obj) {
			
			var objWidth = obj.width();
			var leftCentered = ($(window).width() - objWidth)/2;
			
			if ($(window).width() > 768) {
				obj.css({'left': leftCentered+'px'});
			}
			
		},
		alignObjectToObject: function (objToAlign, objToAlignTo, side) {
			
			var leftXPos = (objToAlignTo.position().left-objToAlign.width());
			var rightXPos = (objToAlignTo.position().left+objToAlignTo.width());
			
			if ($(window).width() > 768) {
				if (side === 'left') {
					objToAlign.css({'left': leftXPos+'px', 'opacity': 1});
				} else if (side === 'right') {
					objToAlign.css({'left': rightXPos+'px', 'right': 'auto', 'opacity': 1});
				}
			} else {
				objToAlign.css({'opacity': 1});
			}
			
		}
	};
	if ($(window).width() > 768) {
    $(whyAnimationLayers.init);
  }
	
	$( window ).resize(function() {
		setTimeout( function () { whyAnimationLayers.init(); }, 300);
	});
	
	
	var EqualHeightColumns = {
		init: function() {
			// Equal height columns
			setTimeout(function() {
		  	$('[data-js="eqh-w"]').each(function() {
					$(this).find('[data-js="eqh-c"]').equalHeights();
					$(this).find('[data-js="eqh-c2"]').equalHeights();

          $(this).find('.tile').equalHeights();

				});
			}, 700);
			$(window).resize(function(e) {
				$('[data-js="eqh-w"]').each(function() {
					$(this).find('[data-js="eqh-c"]').height('auto');
					$(this).find('[data-js="eqh-c"]').equalHeights();
					$(this).find('[data-js="eqh-c2"]').height('auto');
					$(this).find('[data-js="eqh-c2"]').equalHeights();

          $(this).find('.tile').height('auto');
          $(this).find('.tile').equalHeights();

				});
			});
		}
	};
	$(window).load(EqualHeightColumns.init());
	
	// Customer Spotlight Logos Carousel
	
	var customSpolightLogosCarousel = {
		init: function () {
			$('.display-logos .layer--customer-spotlight-carousel .layer--customer-spotlight-container')
				.each( function () {
					
					var _this = $(this);
					var $items = 5;
					
					if ($(window).width() < 1200 && $(window).width() > 1025) {
						//$items = 4;
					}
					
					if ($(window).width() < 1024 && $(window).width() > 769) {
						//$items = 3;
					}
					
					if ($(window).width() < 768) {
						$items = 2;
					}
					
					_this.carouFredSel({
						circular: true,
						infinite: true,
						auto    : true,
						responsive: true,
						items: $items,
						scroll  : {
								items   : $items,
								pauseOnHover    : true,
								duration    : 1000
						},
						prev: {
							button: _this.parent().find('.prev'),
							items   : 1
						},
						next: {
							button: _this.parent().find('.next'),
							items   : 1
						},
            swipe: {
              onTouch : true
            }
					});
				});
		}
	};
	$(customSpolightLogosCarousel.init);
	
	// Leadership Overview
	var leadershipOverview = {
		init: function () {
			$('.leadership__overview-leaders ul li:eq(0)').addClass('active');
			$('.leadership__overview-bio:eq(0)').addClass('active');
			
			$('.leadership__overview-leaders ul li').click ( function () {
				var index = $(this).index();
				
				$('.leadership__overview-leaders ul li').removeClass('active');
				$('.leadership__overview-bio').removeClass('active');
				
				$('.leadership__overview-leaders ul li:eq('+index+')').addClass('active');
				$('.leadership__overview-bio:eq('+index+')').addClass('active');
				
				if ($(window).width() < 1024) {
					$('html, body').animate({
						scrollTop: $('.leadership__overview-bio:eq('+index+')').offset().top - 200
					 }, 1200);
				}
			
			});
		}
	}
	$(leadershipOverview.init());
	
	// CTA Tiles
	var ctaTiles = {
		init: function () {
			$('.layer--cta-tiles--tile').click( function () {
				$('.layer--cta-tiles--tile').each( function () {
					$(this).removeClass('active');
				});
				$(this).addClass('active');
			});
		}
	}
	$(ctaTiles.init());
	
	// Customer Tiles
	// Handling of mobile devcies hover transition
	var ctaTiles = {
		init: function () {
			$('.customer-tile-container').click( function () {
				$('.customer-tile-container').each( function () {
					$(this).find('.customer-tile-buttons').removeClass('active');
				});
				$(this).find('.customer-tile-buttons').addClass('active');
			});
		}
	}
	$(ctaTiles.init());
	
	
	// Layer linking
	var layerLinking = {
		init: function () {
			var hash = window.location.hash.replace("#", "");
			//alert($.isNumeric(hash));
			if($.isNumeric(hash) == true) {
				//alert($("#content section:eq("+hash+")").offset().top)
				setTimeout(
					function () {
						$('html, body').animate({
							scrollTop: $("#content section:eq("+hash+")").offset().top - 125
						 }, 1200)
					 	//alert($("#content section:eq("+hash+")").offset().top)
					}
				 , 300);
			}
			
			$('#section-navigation .nav-content-wrapper .nav-content .menu li.menu-item a').click( function (e) {
				//e.preventDefault();
				var path = window.location.pathname;
				var linkUrlPath = $(this).attr('href').split("#");
				var hash = $(this).attr('href').replace(linkUrlPath[0]+"#", "");
				//alert(path);
				//alert(hash);
				//alert(window.location.pathname);
				if (path == linkUrlPath[0]) {
					$('html, body').animate({
						scrollTop: $("#content section:eq("+hash+")").offset().top - 110
					 }, 1200);
				}
			});
		}
	}
	$(window).load(layerLinking.init());
	
	// Partner filter drop down style
	var partnerFilter = {
		customersArray: Array(),
		init : function() {
			$('#partner-region')
				.select2({
					minimumResultsForSearch: Infinity
				})
				.on("change", function () { 
					partnerFilter.filterCustomers($('#partner-region').val());
				});
			$('.resources-tile').each( function () {
				partnerFilter.customersArray.push($(this));
			});
			
		},
		filterCustomers: function (filterOn) {
			var delayTime = 20;
			var delayTimeMax = 2000;
			var delayTimeIncrement = 80;
			var index = 1;
			$('.partners-tile').each( function () {
				$(this).hide();
			});
			$('.partners-tile').each( function () {
				if (filterOn != 'all') { 
					if ($(this).hasClass(filterOn)) {
						//$(this).doTimeout(delayTime).fadeIn();
						var el=$(this);
						if (delayTime > delayTimeMax) {
							delayTime = delayTimeMax;
						}
						
						$(this).css({'height': 0, 'width': 0, 'opacity': 0});
						setTimeout(function() { 
								partnerFilter.applyStyle(el, index);
								index++;
						}, delayTime); 
						delayTime += delayTimeIncrement;
						
					}
				} else {
					var el=$(this);
					if (delayTime > delayTimeMax) {
						delayTime = delayTimeMax;
					}
					
					$(this).css({'height': 0, 'width': 0});
					setTimeout(function() { 
							partnerFilter.applyStyle(el, index);
							index++;
					}, delayTime); 
					delayTime += delayTimeIncrement;
					
					
				}
			});
		},
		applyStyle : function (obj, index) {
			var indexDivisor = 4;
			var marginRight = '3%';
			var er = /^-?[0-9]+$/;
			var height = 258;
			var width = '22.75%';
			
			if ($(window).width() >= 768 && $(window).width() <= 1024) {
				indexDivisor = 2;
				marginRight = '3%';
				width = '48.5%';
			} else if ($(window).width() < 768) {
				indexDivisor = 1;
				marginRight = '0';
				width = '100%';
			}
			
			var indexPosition = ((index / indexDivisor) / 1);
			
			console.log(((index / indexDivisor) / 1));
			if (er.test(indexPosition)) {
				obj.css({'margin-right': '0'});
			} else {
				obj.css({'margin-right': marginRight});
			}
			obj.animate({'height': height+'px', 'width': width, 'display': 'block', 'opacity': 1});
		}
	}
	$(document).ready(partnerFilter.init());
	
	// Customer filter drop down style
	var resourcesFilter = {
		customersArray: Array(),
		init : function() {
			$('#resource-type')
				.select2({
					minimumResultsForSearch: Infinity
				})
				.on("change", function () { 
					resourcesFilter.filterCustomers($('#resource-type').val());
				});
			$('.resources-tile').each( function () {
				resourcesFilter.customersArray.push($(this));
			});
			
			$('#resource-role')
				.select2({
					minimumResultsForSearch: Infinity
				})
				.on("change", function () { 
					resourcesFilter.filterCustomers($('#resource-role').val()); 
				});
			$('.resources-tile').each( function () {
				resourcesFilter.customersArray.push($(this));
			});
			
			//var url = window.location.hash;
			var hash = window.location.hash.replace("#", "");
			if (hash != '' && ($.isNumeric(hash) == false)) {
				resourcesFilter.filterCustomers(hash); 
				$('html, body').animate({
					scrollTop: $(".resource-filter-container:eq(0)").offset().top
				 }, 1200);
			}
		},
		filterCustomers: function (filterOn) {
			var delayTime = 20;
			var delayTimeMax = 2000;
			var delayTimeIncrement = 80;
			var index = 1;
			$('.resources-tile').each( function () {
				$(this).hide();
			});
			$('.resources-tile').each( function () {
				if (filterOn != 'all') { 
					if ($(this).hasClass(filterOn)) {
						//$(this).doTimeout(delayTime).fadeIn();
						var el=$(this);
						if (delayTime > delayTimeMax) {
							delayTime = delayTimeMax;
						}
						
						$(this).css({'height': 0, 'width': 0, 'opacity': 0});
						setTimeout(function() { 
								resourcesFilter.applyStyle(el, index);
								index++;
						}, delayTime); 
						delayTime += delayTimeIncrement;
						
					}
				} else {
					var el=$(this);
					if (delayTime > delayTimeMax) {
						delayTime = delayTimeMax;
					}
					
					$(this).css({'height': 0, 'width': 0});
					setTimeout(function() { 
							resourcesFilter.applyStyle(el, index);
							index++;
					}, delayTime); 
					delayTime += delayTimeIncrement;
					
					
				}
			});
		},
		applyStyle : function (obj, index) {
			var indexDivisor = 4;
			var marginRight = '3%';
			var er = /^-?[0-9]+$/;
			var height = 390;
			var width = '22.75%';
			
			if ($(window).width() >= 768 && $(window).width() <= 1024) {
				indexDivisor = 2;
				marginRight = '3%';
				width = '48.5%';
			} else if ($(window).width() < 768) {
				indexDivisor = 1;
				marginRight = '0';
				width = '100%';
			}
			
			var indexPosition = ((index / indexDivisor) / 1);
			
			console.log(((index / indexDivisor) / 1));
			if (er.test(indexPosition)) {
				obj.css({'margin-right': '0'});
			} else {
				obj.css({'margin-right': marginRight});
			}
			obj.animate({'height': height+'px', 'width': width, 'display': 'block', 'opacity': 1});
		}
	}
	$(document).ready(resourcesFilter.init());
	
	var productDiagram = {
		init: function () {
			$('img[usemap]').rwdImageMaps();
			$('area').click ( function (e) {
				e.preventDefault();
				//alert($(this).attr('href').substring(1));
				var index = $(this).index();
				$('.tool-tip:eq('+index+')').fadeIn();
				$('.product-diagram-image').animate({'opacity': 0.3});
				$('html, body').animate({
						scrollTop: $('.tool-tip:eq('+index+')').offset().top - 200
				}, 1000);
			});
			$('.content-close').click ( function () {
				$(this).parent().parent().fadeOut();
				$('.product-diagram-image').animate({'opacity': 1});
			});
		}
	}
	$(productDiagram.init());
	
	// Pop-up videos
	$('a[href*="youtube"], a[href*="youtu.be"], a[href*="vimeo"]').magnificPopup({
		type: 'iframe',
		iframe: {
			patterns: {
				yourcustomsource: {
					index: '',
					src: '%id%'
				}
			}
		},
		mainClass: 'mfp-fade',
		callbacks: {
			open: function() {
				$('.layer--columns').each( function () {
					var video = $(this).find('video');
					
					if (video.DOMexists()) {
						video.get(0).pause();
					}
				});
			},
			close: function() {
      	$('.layer--columns').each( function () {
					var video = $(this).find('video');
					
					if (video.DOMexists()) {
						video.get(0).play();
					}
				});
    	}
		},
		removalDelay: 160,
		preloader: false,
		fixedContentPos: false
	}).click ( function () { $(this).blur(); });
	
	$('a.modal').magnificPopup({
		type: 'image',
		closeOnContentClick: true,
		mainClass: 'mfp-img-mobile',
		image: {
			verticalFit: true
		},
		zoom: {
			enabled: true,
			duration: 300 // don't foget to change the duration also in CSS
		}
		
	});
	
	// layer tabs
	var layerTabs = {
		init: function () {
			$('.tab-nav li:first-child').addClass('active');
			$('.tab-content').each ( function () {
				$(this).hide();
			});
			$('.tab-nav li').css({'cursor': 'pointer'});
			$('.tab-nav li').click ( function () {
				layerTabs.activateTab($(this));
			});
			$('.tab-nav li a').click ( function (e) {
				e.preventDefault();
			});
			$('.tab-content:eq(0)').show();
      
      if ($('.layer--tabs').hasClass('alt-tabs')) {
        $('.layer--tabs .tab-content').each(function(idx, item){
          var carouselId = "carousel" + idx;
          var $totalSlides = $('#'+carouselId+' .carousel .slide-content').length;
          if($totalSlides > 1){
          $('#'+carouselId+' .carousel').slick({
            prevArrow: $('#'+carouselId+' .carousel-arrows .prev'),
            nextArrow: $('#'+carouselId+' .carousel-arrows .next'),
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: false,
            arrows: true
          });
          }
        });
      }
			
			layerTabs.setTabsPosition();
			var iOS = ( navigator.userAgent.match(/(iPad|iPhone|iPod)/g) ? true : false );

			// Bind event listener to browser to resize mast viewing area on window resize
			if (iOS !== true) {
				$(window).bind('resize', function(e){
					window.resizeEvt;
						$(window).resize(function(){
							clearTimeout(window.resizeEvt);
							window.resizeEvt = setTimeout(function(){
							layerTabs.setTabsPosition()
						}, 250);
					});

				});
			} else {
				window.addEventListener("orientationchange", function() {
					layerTabs.setTabsPosition()
				}, false);
			}

		},
		setTabsPosition : function () {
			if ($(window).width() > 768 && ($('.tab-nav li').size() < 5) && !$('.layer--tabs').hasClass('alt-tabs')) {
				var tabNavContainerWidth = $('.tab-nav').width();
				var tabNavItemWidth = $('.tab-nav li').width();
				var tabNavItemNum = $('.tab-nav li').size();
				var firstItemLeftMargin = (tabNavContainerWidth - ((tabNavItemWidth * tabNavItemNum))) / 2;
				$('.tab-nav:eq(0)').animate({'margin-left': firstItemLeftMargin+'px'});
			}
      if ($('.layer--tabs').hasClass('alt-tabs')) {
        var $total = $('.layer--tabs .tab-nav li').length;
        if($total > 3){
          var $percent = 100 / $total;
          $('.layer--tabs .tab-nav li').css('width',$percent+'%');
        }
      }
		},
		activateTab: function (tab) {
			$('.tab-nav li').each( function () {
				$(this).removeClass('active');
			});
			$('.tab-content').each( function () {
				$(this).hide();
			});
			$('.tab-nav li:eq('+tab.index()+')').addClass('active');
			$('.tab-content:eq('+tab.index()+')').show();
			if ($(window).width() < 769) {
				$('html, body').animate({
        	scrollTop: $('.tab-content:eq('+tab.index()+')').offset().top
        }, 1000);
			}
		}
	}
	$(document).ready(layerTabs.init());
	
	// Mobile nav toggle
	var mobileNavToggle = {
		init: function () {
			$('.navbar-toggle').click( function () {
				var navTarget = $(this).data('target');
				
				if (!$(this).hasClass('menu-open')) {
					$(this).addClass('menu-open');
					$(navTarget).show();
				} else {
					$(this).removeClass('menu-open');
					$(navTarget).hide();
				}
			});
		}
	}
	$(document).ready(mobileNavToggle.init());
	
	// Awards Carousel
	var awardsCarousel = {
		init: function () {
			$('.layer--awards__carousel-carousel').carouFredSel({
				responsive: true,
				width: '100%',
				height: 160,
				auto: false,
				scroll: 2,
					items: {
					//	height: '30%',	//	optionally resize item-height
						visible: {
							min: 2,
							max: 6
						},
					},
					prev: '#prev',
					next: '#next'
			});
		}
	}
	$(awardsCarousel.init());

  // Sticky masthead
  var StickyMasthead = {
      header: [],
      contentStart: [],
      init: function() {
        var self = StickyMasthead;
        if($('#masthead-wrapper').hasClass('stuck')) { return; }
        self.header = $('#masthead-wrapper').addClass('stuck');
        self.contentStart = $('#content-wrapper');
        if(self.header.length > 0) {
          self.setup();
        }
      },
      setup: function() {
          var self = this;

          self.onResize();
          self.contentStart.waypoint(StickyMasthead.waypointCallback, self.stickyOptions);
          $(window).resize(self.onResize);
          $(window).load(self.onResize);
          // Run the onresize again later because sometimes browsers need a bit
          // more time to get the topnav sorted out and it can leave an extra space
          // on the page.
          window.setTimeout(self.onResize, 300);
      },
      onResize: function() {
          var self = StickyMasthead;
          var homePage = $('body.page-template-template-home-php');

          if($('#wpadminbar').length > 0) {
              self.header.css({top: $('#wpadminbar').height()});
          }
          if (homePage.length === 0) {
              var contentWrapper = $('#content-wrapper');
              if (contentWrapper.length && $(window).innerWidth() >= 768) {
                  contentWrapper.css('padding-top', self.header.outerHeight());
              } else {
                  contentWrapper.css('padding-top', self.header.outerHeight());
              }
          }
      },
      waypointCallback: function(direction) {
          var self = StickyMasthead;
          if ($(window).innerWidth() < 768) {
              return;
          }

          if ('up' === direction) {
              self.header.removeClass('small');
          } else {
              self.header.addClass('small');
          }
      },
      stickyOptions: {
          offset: function() {
              return -120;
          }
      }
  };
  $(StickyMasthead.init);
	
	var homeMastAnimation = {
		init: function () {
			if($('.layer--mast-animated').length > 0) {
				$(window).scroll(function() {
					var y_scroll_pos = window.pageYOffset;
					var scroll_pos_element = $('.layer--mast-animated').position();     
					var tagetPosition =  scroll_pos_element.top - 800;
					
					if(y_scroll_pos >= 1) {
						homeMastAnimation.revealSecondary();
					} else {
						homeMastAnimation.hideSecondary();
					}
				});
			}
		},
		hideSecondary: function () {
			if($('.layer--mast-animated').hasClass('transitioned')) {
				if(!$('.layer--mast-animated').hasClass('animating')) {
					$('.layer--mast-animated').addClass('animating');
					$('body').addClass('noscroll');
					setTimeout(function() {
						$('.sprite-6').hide();
					}, 100);
					setTimeout(function() {
						$('.sprite-5').show();
					}, 101);
					setTimeout(function() {
						$('.sprite-5').hide();
					}, 250);					
					setTimeout(function() {
						$('.sprite-4').show();
					}, 251);
					setTimeout(function() {
						$('.sprite-4').hide();
					}, 400);				
					setTimeout(function() {
						$('.sprite-3').show();
					}, 401);
					setTimeout(function() {
						$('.sprite-3').hide();
					}, 550);				
					setTimeout(function() {
						$('.sprite-2').show();
					}, 551);
					setTimeout(function() {
						$('.sprite-2').hide();
					}, 700);
					setTimeout(function() {
						$('.sprite-1').show();
						$('.layer--mast-animated').removeClass('transitioned');
						$('.layer--mast-animated')
						.find('.secondary')
						.fadeOut(300, 'swing', function () {
							$('.layer--mast-animated').find('.primary').fadeIn(300);
							$('.layer--mast-animated--slide').fadeIn(300);
						});
					}, 701);
					setTimeout(function() {
						$('.layer--mast-animated').removeClass('animating');
						$('body').removeClass('noscroll');
					}, 1000);
				}
			}
		},
		revealSecondary: function () {
			if(!$('.layer--mast-animated').hasClass('transitioned')) {
				if($(window).width() > 1024) {
					$('body').addClass('noscroll');
				}
				$('.layer--mast-animated')
				.find('.primary')
				.fadeOut(300, '', 
					function () { 
						if($(window).width() > 1024) {
							if(!$('.layer--mast-animated').hasClass('animating')) {
								$('html,body').animate({scrollTop: $('html,body').offset().top},'slow', function () { $('body').addClass('noscroll'); });
								//$('body').addClass('noscroll');
								$('.layer--mast-animated').addClass('animating');
								
								$('.layer--mast-animated--slide').fadeOut(300, 'swing',
									function () {
										$('.sprite-1').fadeOut();
										
										setTimeout(function() {
											$('.sprite-2').show();
										}, 100);
										setTimeout(function() {
											$('.sprite-2').hide();
										}, 250);
										
										setTimeout(function() {
											$('.sprite-3').show();
										}, 251);
										setTimeout(function() {
											$('.sprite-3').hide();
										}, 400);
										
										setTimeout(function() {
											$('.sprite-4').show();
										}, 401);
										setTimeout(function() {
											$('.sprite-4').hide();
										}, 550);
										
										setTimeout(function() {
											$('.sprite-5').show();
										}, 551);
										setTimeout(function() {
											$('.sprite-6').fadeIn(600);
										}, 551);
										
		
									});
							}
						}
						$('.layer--mast-animated').find('.secondary').fadeIn();
						$('.layer--mast-animated').addClass('transitioned');
						setTimeout(function() {
							$('.layer--mast-animated').removeClass('animating');
							$('body').removeClass('noscroll');
						}, 1000);
					});
			}
		},
		disableScroll: function () {
			if (window.addEventListener) {
				window.addEventListener('DOMMouseScroll', wheel, false);
			}
			window.onmousewheel = document.onmousewheel = wheel;
			document.onkeydown = keydown;
		},
		enableScroll: function () {
			if (window.removeEventListener) {
        window.removeEventListener('DOMMouseScroll', wheel, false);
    	}
    	window.onmousewheel = document.onmousewheel = document.onkeydown = null;
		}
	}
	$(homeMastAnimation.init());
	
	solutionFinder = {
		init: function () {
			$('.solution-nav li:eq(0)').addClass('active');
			
			$('.solution-nav li a').click ( function (e) {
				e.preventDefault();
				var index = $(this).parent().index();
				var hrefVal = $(this).attr('href');
				$('.solution-nav li.active').removeClass('active');
				$(this).parent().addClass('active');
				$('.image-container').fadeOut ( 100, 'linear', function () {  });
				$('.questions').fadeOut ( 100, 'linear', function () {  });
				$('.layer--solution-finder .row').css({'background-image': 'url('+$('.questions:eq('+index+')').data('bgimage')+')'});
				//$('.image-container:eq('+index+')').delay(310).fadeIn(300)
				$('.questions:eq('+index+')').delay(310).fadeIn(300)
				$('.cta-link').attr('href', hrefVal);
				if ($(window).width() < 768) {
					 $('html, body').animate({
           	scrollTop: $(".question-container").offset().top - 200
           }, 2000);
				}
			});
		}
	}
	$(solutionFinder.init());

  // bind to tabs change event
  var Tabs = {
      init: function() {
        var hash = window.location.hash.substr(1);
        var activeIndex = 0;
        if (hash) {
          activeIndex = Tabs.getTabIndex(hash);
        }
        $('.tabs').on('gumby.onChange', function(e, index) {
					Tabs.resetIcons();
					Tabs.setActiveIcon();
				}).trigger('gumby.set', activeIndex);
        $('.technology-button a').each( function () {
          $(this).click ( function() {
            //alert($(this).attr('href'));
            $('.tabs').on('gumby.onChange', function(e, index) {}).trigger('gumby.set', Tabs.getTabIndex($(this).attr('href')));
            $("html, body").animate({ scrollTop: 0 }, 500);
          });
        });
				Tabs.resetIcons();
				
				// Only run on non iOS devices and platfors
				var deviceAgent = navigator.userAgent.toLowerCase();
				var agentID = deviceAgent.match(/(iPad|iPhone|iPod)/i);
				if (!agentID) {
					$(".tab-nav li").hover(function() {
							$(this).addClass('over');
							$(this).find("img.default-icon").hide();
							$(this).find("img.active-icon").show();
						}, function() {
							$(this).removeClass('over');
							$(this).find("img.active-icon").hide();
							$(this).find("img.default-icon").show();
							Tabs.setActiveIcon();
						}
					);
				}
      },
      getTabIndex: function(value) {
        var currentIndex = 0;
        var activeIndex = '';
        value = value.replace("#", "");
        $('.tab-nav li').each( function() {
          if ($(this).hasClass(value)) {
            activeIndex = currentIndex;
          }
          currentIndex++
        });
        return activeIndex
      },
			resetIcons: function() {
				$(".tab-nav .icon img.active-icon").hide();
				$(".tab-nav .icon img.default-icon").show();
				Tabs.setActiveIcon();
			},
			setActiveIcon: function() {
				$(".tab-nav li.active img.default-icon").hide();
				$(".tab-nav li.active img.active-icon").show();
			}
  };
  $(Tabs.init);
	

  // TODO - extract this to a plugin
  var LinksInNewWindow = {
    init: function() {
      LinksInNewWindow.setup();
    },
    setup: function() {
      var domain = LinksInNewWindow.getDomain();

      // Find PDF and specific external links
      $('a[href$=".pdf"],a[rel="external"]').attr('target', '_blank');

      // Find fully qualified links that aren't for this domain
      $('a[href^="http://"],a[href^="https://"],a[href^="//"]')
        .not('a[href*="http://' + domain + '"],a[href^="https://' + domain + '"]')
          .attr('target', '_blank');
    },
    getDomain: function() {
      return window.location.hostname;
    },
    getProtocolAndDomain: function() {
      var protocol = window.location.protocol;

      if ( protocol.substr(-1) !== ':' ) {
        protocol += ':';
      }
      return protocol + '//' + window.location.hostname;
    }
  };
  $(window).load(LinksInNewWindow.init);

  var ColumnizeFooterNavigation = {
    init: function() {
      if ($.fn.columnize) {
        ColumnizeFooterNavigation.setup();
      } else {
        window.log("WARNING: jQuery Columnizer plugin not loaded");
      }
    },
    setup: function() {
      $('#footer-navigation > ul').columnize({
        manualBreaks: true,
        cssClassPrefix: 'columnizer'
      });
    }
  };
  $(ColumnizeFooterNavigation.init);
	
	var newsYearDropdown = {
		init: function () {
			if ($('body').hasClass('page-press') || $('body').hasClass('page-news')) {
				var newsYearDropdown = '<div class="news-index-nav-container"><div class="news-index-nav"><label for="newsYear">Year: </label><select name="newsYear" class="newsByYear" style="width: 150px">';
				$('section.news-index-list').each(function() {
					yearLink = $(this).attr('data-section-name');
					dropdownText = $(this).attr('data-dropdown-text');
					newsYearDropdown += '<option value="#'+ yearLink +'">'+ dropdownText +'</option>';
				});
				newsYearDropdown += '</select></div></div>';
				$('.news-and-events-page .entry-content').prepend(newsYearDropdown);
			}
			$('select.newsByYear').select2();
			var $eventSelect = $(".newsByYear");
			$eventSelect.on("change", function (e) { 
				$('section.news-index-list').hide();
				$($eventSelect.val()).show();
			});
			$('section.news-index-list').hide();
				$($eventSelect.val()).show();
		}
	}
	$(newsYearDropdown.init());
	
	// Quotes Carousel
	var quotesCarousel = {
		init: function () {
			setTimeout(function() {
			$('.layer--quote .layer--quote__carousel')
				.each( function () {
					
					var _this = $(this);
					
					_this.carouFredSel({
						circular: true,
						infinite: true,
						auto: {
							play: true,
							timeoutDuration: 7000
						},
						responsive: true,
						scroll  : {
								items   : 1,
								pauseOnHover    : true,
								duration    : 1000
						},
						pagination : '.layer--quote__pagination'
					});
				});
			}, 1000);
		}
	};
	$(quotesCarousel.init);
	
	var stackedFeaturesDivider = {
		init: function() {
			if ($('.stacked-features-divider').length > 0) {
				// Equal height columns
				setTimeout(function() {
					col_height = $('.stacked-features-divider').prev().outerHeight();
					stack_height = $('.stack-col-1').outerHeight() - 20; // overlaps 12 pixels above and below the stacks, but arrow heads are 14 pixes in height
					
					$('.stacked-features-divider').height(col_height);
					$('.stacked-features-divider__container .divider').height(stack_height);
				}, 800);
				$(window).resize(function(e) {
					col_height = $('.stacked-features-divider').prev().outerHeight();
					stack_height = $('.stack-col-1').outerHeight() - 20; // overlaps 12 pixels above and below the stacks, but arrow heads are 14 pixes in height
					
					$('.stacked-features-divider').height(col_height);
					$('.stacked-features-divider__container .divider').height(stack_height);
				});
			}
		}
	};
	$(window).load(stackedFeaturesDivider.init());
	
	var AnalyticsServerDiagram = {
		init: function() {
			// Equal height columns
			diagram_height = 0;
			current_height = $('.layer--asd .diagram-image').height();
			
			$('.layer--asd .blurb-content').each(function() {
				if ($(this).outerHeight() > diagram_height) {
					diagram_height = $(this).outerHeight();
				}
			});
			//alert(diagram_height + " vs " + current_height);
			
			if (diagram_height > current_height) {
				$('.layer--asd .diagram-image, .layer--asd .blurb').height(diagram_height);
			}
			$(window).resize(function(e) {
				diagram_height = 0;
				current_height = $('.layer--asd .diagram-image').height();
				
				$('.layer--asd .blurb-content').each(function() {
					if ($(this).outerHeight() > diagram_height) {
						diagram_height = $(this).outerHeight();
					}
				});
				
				if (diagram_height > current_height) {
					$('.layer--asd .diagram-image, .layer--asd .blurb').height(diagram_height);
				}
			});
		}
	};
	$(window).load(AnalyticsServerDiagram.init());

	/* Scroll To Next Element Snippet */
	$(".scroll-next a").click(function(e) {
			e.preventDefault();
			var offset = 20; //Offset of 20px
			var scrollToElement = $(this).parent().parent().parent().next();

			$('html, body').animate({
					scrollTop: scrollToElement.offset().top + offset
			}, 1000);
	});
	
	//$('.widget_categories').find('.widget__title').append('<a href="/feed/">Feed</a>');
	$('.widget_recent_entries').find('.widget__title').append('<a href="/feed/">Feed</a>');
	
	// Accordian
	$('.layer-accordian--content-container').accordion({
		heightStyle: "content"
	});
	
	// Pop-up videos
	$('.form-popup').magnificPopup({
		type: 'iframe',
		iframe: {
			patterns: {
				yourcustomsource: {
					index: '',
					src: '%id%'
				}
			}
		},
		mainClass: 'mfp-fade',
		removalDelay: 160,
		preloader: false,
		fixedContentPos: false
	});

	/* detect touch */
if("ontouchstart" in window){
    document.documentElement.className = document.documentElement.className + " touch";
}
if(!$("html").hasClass("touch")){
    /* background fix */
    $(".parallax").css("background-attachment", "fixed");
}

/* fix vertical when not overflow
call fullscreenFix() if .fullscreen content changes */
function fullscreenFix(){
    var h = $('body').height();
    // set .fullscreen height
    $(".content-b").each(function(i){
        if($(this).innerHeight() <= h){
            $(this).closest(".fullscreen").addClass("not-overflow");
        }
    });
}
$(window).resize(fullscreenFix);
fullscreenFix();

/* resize background images */
function backgroundResize(){
    var windowH = $(window).height();
    $(".background").each(function(i){
        var path = $(this);
        // variables
        var contW = path.width();
        var contH = path.height();
        var imgW = path.attr("data-img-width");
        var imgH = path.attr("data-img-height");
        var ratio = imgW / imgH;
        // overflowing difference
        var diff = parseFloat(path.attr("data-diff"));
        diff = diff ? diff : 0;
        // remaining height to have fullscreen image only on parallax
        var remainingH = 0;
        if(path.hasClass("parallax") && !$("html").hasClass("touch")){
            var maxH = contH > windowH ? contH : windowH;
            remainingH = windowH - contH;
        }
        // set img values depending on cont
        imgH = contH + remainingH + diff;
        imgW = imgH * ratio;
        // fix when too large
        if(contW > imgW){
            imgW = contW;
            imgH = imgW / ratio;
        }
        //
        path.data("resized-imgW", imgW);
        path.data("resized-imgH", imgH);
        path.css("background-size", imgW + "px " + imgH + "px");
    });
}
$(window).resize(backgroundResize);
$(window).focus(backgroundResize);
backgroundResize();

/* set parallax background-position */
function parallaxPosition(e){
    var heightWindow = $(window).height();
    var topWindow = $(window).scrollTop();
    var bottomWindow = topWindow + heightWindow;
    var currentWindow = (topWindow + bottomWindow) / 2;
    $(".parallax").each(function(i){
        var path = $(this);
        var height = path.height();
        var top = path.offset().top;
        var bottom = top + height;
        // only when in range
        if(bottomWindow > top && topWindow < bottom){
            var imgW = path.data("resized-imgW");
            var imgH = path.data("resized-imgH");
            // min when image touch top of window
            var min = 0;
            // max when image touch bottom of window
            var max = - imgH + heightWindow;
            // overflow changes parallax
            var overflowH = height < heightWindow ? imgH - height : imgH - heightWindow; // fix height on overflow
            top = top - overflowH;
            bottom = bottom + overflowH;
            // value with linear interpolation
            var value = min + (max - min) * (currentWindow - top) / (bottom - top);
            // set background-position
            var orizontalPosition = path.attr("data-oriz-pos");
            orizontalPosition = orizontalPosition ? orizontalPosition : "50%";
            $(this).css("background-position", orizontalPosition + " " + value + "px");
        }
    });
}
if(!$("html").hasClass("touch")){
    $(window).resize(parallaxPosition);
    //$(window).focus(parallaxPosition);
    $(window).scroll(parallaxPosition);
    parallaxPosition();
}


  /* Content Slide Out */
  $('.layer--content_slide_down_button').click(FadeSlideIn);
  $('.close-x').click(FadeSlideOut);
	
	$('a[href$="#slide"]').click( function() {
		$(this).closest('.layer--badged-list').next(".layer--content_slide_down").stop(true, true).slideDown('slow');
	});

  function FadeSlideIn(ID) {
      $( this ).closest('.layer--content_slide_out').next(".layer--content_slide_down").stop(true, true).slideDown('slow');
  }

  function FadeSlideOut(ID) {
      $('.layer--content_slide_down').stop(true, true).slideUp('slow');
  }

$(document).ready(function(e) {
    $('.layer--explore-features').smint({
    	'scrollSpeed' : 1000
    });
});

function scrollToAnchor(aid, offset) {
	var aTag = $("a[name='"+ aid +"']");
	$('html,body').animate({scrollTop: (aTag.offset().top + offset) },'slow');
}

$('.sticky-scroller .anchorLink').click (function (e) {
	e.preventDefault();
	var anchor_url = $(this).attr('href');
	var hash = anchor_url.substring(anchor_url.indexOf("#")+1);
	if ($(window).width() > 710) {
		scrollToAnchor(hash, -255);
	} else {
		scrollToAnchor(hash, -132);
	}
});

	// sticky scroller
	var StickyScroller = {
    sticky_nav: [],
    nav_items: [],
    sticky_container: [],
    init: function() {
      var $$ = $('.layer--resource_tabs');

      if ($$.length == 0) return;

      StickyScroller.setup($$);
    },
    setup: function($$) {
      StickyScroller.sticky_container = $$;
      StickyScroller.sticky_nav = $('.layer--resource_tabs .sticky-scroller ul');
			StickyScroller.sticky_nav_width = $('.sticky-scroller ul').width();
			StickyScroller.setupStickyNav();
      StickyScroller.highlightNav();
			StickyScroller.resizeEvent();
			$(window).on("scroll", function(e) {
				if ($(window).width() > 867) {
					StickyScroller.setupStickyNav();
				}
			});
    },
		setupStickyNav: function() {
			if ($(window).width() > 867) {
				$('.layer--resource_tabs .sticky-scroller').css('height', 143 + $('.resource-content').height()+ 'px');

				var y = $(window).scrollTop();
	   		var z = 432;
				var rc_pos = $('.resource-content').offset();
				var rc_left_pos = rc_pos.left;
				var rc_bottom_pos = rc_pos.top + $('.resource-content').height();
				var sc_pos_top = StickyScroller.sticky_nav.offset().top;
				var sc_bottom_pos = sc_pos_top + $('.sticky-scroller ul').height() - 82;

				if (y >= z) {
					scroll_bottom = rc_bottom_pos - 310;
					if (sc_bottom_pos >= rc_bottom_pos && scroll_bottom <= y) {
						StickyScroller.sticky_nav.addClass("slide-up").css('left','0').css('width',StickyScroller.sticky_nav_width);
					} else {
						StickyScroller.sticky_nav.removeClass("slide-up");
						StickyScroller.sticky_nav.addClass("stuck").css('left',rc_left_pos-StickyScroller.sticky_nav_width).css('width',StickyScroller.sticky_nav_width);
					}
				} else {
					StickyScroller.sticky_nav.removeClass("stuck slide-up").css('left','auto').css('width','auto');
				}
			} else {
				$('.layer--resource_tabs .sticky-scroller').css('height','auto');
			}
		},
		highlightNav: function() {
			var sections = {},
				i        = 0;
			//var offset = $('.anchorLink.current').offset().top;

			$(window).scroll(function(){
				var offset = $('.anchorLink.current').offset().top;
				if ($(window).width() > 867) {
					// Grab positions of our sections
					$('section.resource-group').each(function(){
						sections[this.id] = $(this).offset().top;
					});
					var pos = $(this).scrollTop();
					//console.log('pos: '+pos)
					for(i in sections){
						//console.log('section'+i+': '+sections[i])
						//console.log('offset: '+offset);
						//console.log('pos-offset: '+(pos - offset));
						//console.log($('.anchorLink.current').delay(300).parent().index());
						if(sections[i] < (offset+20)){
							$('.sticky-scroller ul a').removeClass('current');
							$('.sticky-scroller ul a[href^="#' + i + '"]').addClass('current');
						}
					}
				}
			});
		},
		resizeEvent: function() {
			var iOS = ( navigator.userAgent.match(/(iPad|iPhone|iPod)/g) ? true : false );

			// Bind event listener to browser to resize mast viewing area on window resize
			if (iOS !== true) {
				$(window).bind('resize', function(e){
					window.resizeEvt;
					$(window).resize(function(){
						if ($(window).width() > 867) {
							clearTimeout(window.resizeEvt);
							window.resizeEvt = setTimeout(function() {
								StickyScroller.sticky_nav_width = $('.sticky-scroller').width();
								StickyScroller.setupStickyNav();
								StickyScroller.highlightNav();
							}, 250);
						} else {
							$('.layer--resource_tabs .sticky-scroller').css('height','auto');
						}
					});
				});
			} else {
				window.addEventListener("orientationchange", function() {
					if ($(window).width() > 867) {
						StickyScroller.sticky_nav_width = $('.sticky-scroller').width();
						StickyScroller.setupStickyNav();
						StickyScroller.highlightNav();
					} else {
						$('.layer--resource_tabs .sticky-scroller').css('height','auto');
					}
				}, false);
			}
		}
  };
  $(StickyScroller.init);
  
  	$(document).ready(function(e) {
    	$('#menu-item-7332 a').html('Customer Login <span style="font-size:1rem"> →</span>');
	});
	
	if($('.widget .tagcloud').length){
		$('.widget .tagcloud a').wrapInner('<div></div>');
	}
	
	if($('.featured--blog__blocks').length){
		var rowDivs = new Array();
 $('.featured--blog__blocks .excerpt').each(function() {
    rowDivs.push($(this).height());
 });
 var maxValue = Math.max.apply(Math, rowDivs);
 $('.featured--blog__blocks .excerpt').css('min-height',maxValue+'px');
 var rowDivs2 = new Array();
 $('.featured--blog__blocks .entry-title').each(function() {
    rowDivs2.push($(this).height());
 });
 var maxValue2 = Math.max.apply(Math, rowDivs2);
 $('.featured--blog__blocks .entry-title').css('min-height',maxValue2+'px');
	}
	$(window).resize(function(){
		if($('.featured--blog__blocks').length){
		var rDivs = new Array();
 $('.featured--blog__blocks .excerpt').each(function() {
    rDivs.push($(this).height());
 });
 var maxValue = Math.max.apply(Math, rDivs);
 $('.featured--blog__blocks .excerpt').css('min-height',maxValue+'px');
 var rowDivs2 = new Array();
 $('.featured--blog__blocks .entry-title').each(function() {
    rowDivs2.push($(this).height());
 });
 var maxValue2 = Math.max.apply(Math, rowDivs2);
 $('.featured--blog__blocks .entry-title').css('min-height',maxValue2+'px');
	}
	});
	
	/* if($(window).width() > 767){
	if($('.blog').length&&$('.featured--blog__blocks').length){
		$(window).load(function() {
			if($('#wpadminbar').length){
				var pos = $('#secondary').offset().top - 80;
				var pos2 = $('#footer-wrapper').offset().top - $('#secondary').height() - 155;
			}else{
				var pos = $('#secondary').offset().top - 112;
				var pos2 = $('#footer-wrapper').offset().top - $('#secondary').height() - 187;
			}
			var right = $('#menu-item-231').offset().left - 205;
			var secwidth = $('#secondary').width() + 40;
			if($(window).scrollTop()>pos&&$(window).scrollTop()<pos2){
					$('#secondary').css({'position':'absolute', 'top':'13%', 'left':'inital', 'max-width':secwidth});
				}else if($(window).scrollTop()>pos2){
					$('#secondary').css({'position':'absolute','top':'initial', 'bottom':'20px', 'left':'initial', 'right':'0', 'max-width':secwidth});
				}else{
					$('#secondary').css({'position':'absolute', 'top':'0'});
				}
			$(window).scroll(function(e) {
                if($(window).scrollTop()>pos&&$(window).scrollTop()<pos2){
					$('#secondary').css({'position':'absolute', 'top':'13%', 'left':'inital', 'max-width':secwidth});
				}else if($(window).scrollTop()>pos2){
					$('#secondary').css({'position':'absolute','top':'initial', 'bottom':'20px', 'left':'inital', 'right':'0', 'max-width':secwidth});
				}else{
					$('#secondary').css({'position':'absolute', 'top':'0'});
				}
            });
			$(window).resize(function(e) {
				if($(window).width()>767){
				var right = $('#menu-item-231').offset().left - 219;
				var secwidth = $('#secondary').width();
               if($(window).scrollTop()>pos&&$(window).scrollTop()<pos2){
					$('#secondary').css({'position':'absolute', 'top':'13%', 'left':'inital', 'max-width':secwidth});
				}else if($(window).scrollTop()>pos2){
					$('#secondary').css({'position':'absolute','top':'initial', 'bottom':'20px', 'left':'inital', 'right':'0', 'max-width':secwidth});
				}else{
					$('#secondary').css({'position':'absolute', 'top':'0'});
				}
				}else{
					$('#secondary').css({'position':'absolute', 'top':'0'});
				}
            });
		});
	}
	
	if($('.single-post').length){
		$(window).load(function() {
			if($('#wpadminbar').length){
				var pos = $('#secondary').offset().top - 80;
				var pos2 = $('#footer-wrapper').offset().top - $('#secondary').height() - 155;
			}else{
				var pos = $('#secondary').offset().top - 112;
				var pos2 = $('#footer-wrapper').offset().top - $('#secondary').height() - 187;
			}
			var right = $('#menu-item-231').offset().left - 205;
			var secwidth = $('#secondary').width() + 40;
			if($(window).scrollTop()>pos&&$(window).scrollTop()<pos2){
					$('#secondary').css({'position':'absolute', 'top':'13%', 'left':right+'px', 'max-width':secwidth, 'height':'100%'});
				}else if($(window).scrollTop()>pos2){
					$('#secondary').css({'position':'absolute','top':'initial', 'bottom':'20px', 'left':'initial', 'right':'0', 'max-width':secwidth, 'height':'auto'});
				}else{
					$('#secondary').css({'position':'absolute', 'top':'0', 'height':'100%'});
				}
			$(window).scroll(function(e) {
                if($(window).scrollTop()>pos&&$(window).scrollTop()<pos2){
					$('#secondary').css({'position':'absolute', 'top':'13%', 'left':right+'px', 'max-width':secwidth, 'height':'100%'});
				}else if($(window).scrollTop()>pos2){
					$('#secondary').css({'position':'absolute','top':'initial', 'bottom':'20px', 'left':'initial', 'right':'0', 'max-width':secwidth, 'height':'auto'});
				}else{
					$('#secondary').css({'position':'absolute', 'top':'0', 'height':'100%'});
				}
            });
			$(window).resize(function(e) {
				if($(window).width()>767){
				var right = $('#menu-item-231').offset().left - 219;
				var secwidth = $('#secondary').width();
               if($(window).scrollTop()>pos&&$(window).scrollTop()<pos2){
					$('#secondary').css({'position':'absolute', 'top':'13%', 'left':right+'px', 'max-width':secwidth, 'height':'100%'});
				}else if($(window).scrollTop()>pos2){
					$('#secondary').css({'position':'absolute','top':'initial', 'bottom':'20px', 'left':'initial', 'right':'0', 'max-width':secwidth, 'height':'auto'});
				}else{
					$('#secondary').css({'position':'absolute', 'top':'0', 'height':'100%'});
				}
				}else{
					$('#secondary').css({'position':'absolute', 'top':'0'});
				}
            });
		});
	}
	
	if($('.category, .tag').length){
		$(window).load(function() {
			if($('#wpadminbar').length){
				var pos = $('#secondary').offset().top - 80;
				var pos2 = $('#footer-wrapper').offset().top - $('#secondary').height() - 160;
				var top = $('#masthead').height() + 20;
			}else{
				var pos = $('#secondary').offset().top - 112;
				var pos2 = $('#footer-wrapper').offset().top - $('#secondary').height() - 192;
				var top = $('#masthead').height() + 20 - 32;
			}
			var right = $('#menu-item-231').offset().left - 205;
			var secwidth = $('#secondary').width() + 40;
			if($(window).scrollTop()>pos2){
					$('#secondary').css({'position':'absolute','top':'initial', 'bottom':'20px', 'left':'initial', 'right':'0', 'max-width':secwidth});
				}else{
					$('#secondary').css({'position':'initial', 'top':top+'px', 'left':right+'px', 'max-width':secwidth});
				}
			$(window).scroll(function(e) {
				if($('#wpadminbar').length){
				var top = $('#masthead').height() + 20;
			}else{
				var top = $('#masthead').height() + 20 - 32;
			}
                if($(window).scrollTop()>pos2){
					$('#secondary').css({'position':'absolute','top':'initial', 'bottom':'20px', 'left':'initial', 'right':'0', 'max-width':secwidth});
				}else{
					$('#secondary').css({'position':'initial', 'top':top+'px', 'left':right+'px', 'max-width':secwidth});
				}
            });
			$(window).resize(function(e) {
				if($(window).width()>767){
				var right = $('#menu-item-231').offset().left - 219;
				var secwidth = $('#secondary').width();
               if($(window).scrollTop()>pos2){
					$('#secondary').css({'position':'absolute','top':'initial', 'bottom':'20px', 'left':'initial', 'right':'0', 'max-width':secwidth});
				}else{
					$('#secondary').css({'position':'fixed', 'top':top+'px', 'left':right+'px', 'max-width':secwidth});
				}
				}else{
					$('#secondary').css({'position':'initial', 'top':'0'});
				}
            });
		});
	}
	} */
	
	$(function() {
    $('.layer--carousel').each(function() {
      var container = $(this);
      var carousel = container.children('.carousel-slides');
      var slides = carousel.children('.carousel-slide');
      slides.show();
      carousel.carouFredSel({
        width: '100%',
		height: 'auto',
        responsive: true,
		prev: {
			button: '.carousel-arrows .prev-arrow',
			key: 'left'
		},
		next: {
			button: '.carousel-arrows .next-arrow',
			key: 'right'
		},
        scroll: {
          duration: 1500,
          fx: 'crossfade',
          pauseOnHover: false
        },
        auto: {
          play: true,
          timeoutDuration: 5000
        },
        pagination: '.carousel-pagination'
      });
    });
  });
	
	//$(function() {
    //$('.layer--quote__carousel .carousel-item .equal-height-column').matchHeight();
	//});
  
// Responsive Tables - Zurb
$(document).ready(function() {
  var switched = false;
  var updateTables = function() {
    if (($(window).width() < 769) && !switched ){
      switched = true;
      $("table.responsive").each(function(i, element) {
        splitTable($(element));
      });
      return true;
    }
    else if (switched && ($(window).width() > 769)) {
      switched = false;
      $("table.responsive").each(function(i, element) {
        unsplitTable($(element));
      });
    }
  };
   
  $(window).load(updateTables);
  $(window).on("redraw",function(){switched=false;updateTables();}); // An event to listen for
  $(window).on("resize", updateTables);
   
	
	function splitTable(original)
	{
		original.wrap("<div class='table-wrapper' />");
		
		var copy = original.clone();
		copy.find("td:not(:first-child), th:not(:first-child)").css("display", "none");
		copy.removeClass("responsive");
		
		original.closest(".table-wrapper").append(copy);
		copy.wrap("<div class='pinned' />");
		original.wrap("<div class='scrollable' />");

    setCellHeights(original, copy);
	}
	
	function unsplitTable(original) {
    original.closest(".table-wrapper").find(".pinned").remove();
    original.unwrap();
    original.unwrap();
	}

  function setCellHeights(original, copy) {
    var tr = original.find('tr'),
        tr_copy = copy.find('tr'),
        heights = [];

    tr.each(function (index) {
      var self = $(this),
          tx = self.find('th, td');

      tx.each(function () {
        var height = $(this).outerHeight(true);
        heights[index] = heights[index] || 0;
        if (height > heights[index]) heights[index] = height;
      });

    });

    tr_copy.each(function (index) {
      $(this).height(heights[index]);
    });
  }

});

$('a[href*="#industry-analysts"]').click(function(e){
  e.preventDefault();
  $('html, body').animate({
      scrollTop: $(".layer--featured-image.content-top").offset().top - 100
  }, 1000);
});

function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
}

var resourcesDeepLinking = {
  init: function () {
    var pathname = window.location.pathname;
    console.log(pathname);
    if(pathname.indexOf('resources') > -1 && window.location.search.indexOf('r=') > -1){
      var resource = getUrlParameter('r');
      setTimeout(function(){
        $('#resource-type option[value="'+resource+'"]').prop('selected', true).trigger('change');
      },200);
      console.log(resource);
      $('html, body').animate({
      scrollTop: $("#resource-type").offset().top - 160
  }, 1000);
    }
  }
};
$(resourcesDeepLinking.init);
	
})(jQuery);

