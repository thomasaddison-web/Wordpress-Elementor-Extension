jQuery('.complex-popup-link').magnificPopup({
    type: 'inline',
    midClick: true,
    mainClass: 'mfp-with-zoom', // this class is for CSS animation below
    zoom: {
      enabled: true, // By default it's false, so don't forget to enable it
      duration: 500, // duration of the effect, in milliseconds
      easing: 'ease-in-out', // CSS transition easing function
      opener: function(openerElement) {
        return openerElement.is('img') ? openerElement : openerElement.find('img');
      }
    },
    showCloseBtn:false,
    callbacks: {
        open: function() {
        // Update initial custom text on page load
           // Custom text update function

           jQuery('.complex-tabs-content .tab-pane').eq(0).addClass('active');            
            
			var owl = jQuery('.owl-carousel');
			owl.each(function() {
				var $this = jQuery(this);
				$this.owlCarousel({
					loop:true,
					margin: 0,
					items:1,
					nav:false,
					mouseDrag: false,
					touchDrag: false,
					pullDrag: false
				});

				$this.on('changed.owl.carousel', function(event) {
					updateCustomText($this, event);
				});

				jQuery( '.navigation-bullet > div' ).on( 'click', function() {
					$this.trigger('to.owl.carousel', [jQuery(this).index(), 300]);
					jQuery( '.navigation-bullet > div' ).removeClass( 'active' );
					jQuery(this).addClass( 'active' );
				})
			})
			
			setTimeout(function(){
				jQuery('.owl-carousel').trigger('refresh.owl.carousel');
			}, 200)

            setTimeout(function(){
                console.log('ttttt');
                jQuery('.large-thumb').each(function() {
                    jQuery(this).flexslider({
                        animation: "slide",
                        controlNav: "thumbnails",
                        start: function(){
                            jQuery(window).resize();
                        },
                    });
                })
            }, 500) 
        },
        afterOpen: function() {
             
        },
        close: function() {
            var owl = jQuery('.owl-carousel');
            owl.each(function() {
                // Reset the Owl Carousel to the first slide
                jQuery(this).trigger('to.owl.carousel', 0);

                // Refresh the Owl Carousel to apply changes
                jQuery(this).trigger('refresh.owl.carousel');
            });

            jQuery('.navigation-bullet').each(function() {
                jQuery(this).find('div').removeClass('active');
                jQuery(this).find('div').eq(0).addClass('active');
            });

            jQuery('.complex-tabs-content').each(function(index) {
                jQuery(this).find('.tab-pane').removeClass('active');
                jQuery(this).find('.tab-pane').eq(0).addClass('active');
            });
            jQuery('.tab-menu').each(function(index) {
                var $this = jQuery(this);
                $this.find('button').removeClass('active');
                $this.find('button').eq(0).addClass('active');
            });

            setTimeout(function() {
                jQuery(window).trigger('resize');
            }, 20);
        }
    }
});
function updateCustomText(slide, event) {
	var itemCount = slide.find('.owl-item:not(.cloned)').length;
	var currentIndex = event.page.index + 1;
	var currentSlideNumber = (currentIndex % itemCount) + 1;
	var totalSlides = event.page.count;

	// Update custom text for pagination
	slide.closest('.complex-tabs-content').find('.navigation-text > span').text(currentIndex + '/' + totalSlides);
}

jQuery('.tab-menu button').on('click', function () {
    var $tabGroup = jQuery(this).parent().siblings('.complex-tabs-content');
    // Remove 'active' class from all tabs and panes
    jQuery('.tab-menu button').removeClass('active');
    $tabGroup.find('.tab-pane').removeClass('active');

    // Add 'active' class to the clicked tab
    var tabId = jQuery(this).data('tab');
    jQuery(this).addClass('active');

    // Show the corresponding pane
    jQuery('#' + tabId).addClass('active');

    jQuery('.navigation-bullet').each(function() {
        jQuery(this).find('div').eq(0).addClass('active');
    })
    
    // Reset the Owl Carousel to the first slide
    $tabGroup.find(".owl-carousel").trigger('to.owl.carousel', 0);

    // Refresh the Owl Carousel to apply changes
    $tabGroup.find(".owl-carousel").trigger('refresh.owl.carousel');

    //jQuery(window).trigger('resize');

    setTimeout(function() {
        jQuery(window).trigger('resize');
    }, 20);
});

jQuery('.close-modal').on( "click", function() {
    jQuery.magnificPopup.close();
});