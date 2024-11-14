;(function($) {

    "use strict";

    var tfcounter = function() {    	
        $(window).scroll(function() {
        	var oTop = $('.counter').offset().top - window.innerHeight;
            if ($(window).scrollTop() > oTop) {
                var odo = $(".odometer");
	            odo.each(function() {
	                var countNumber = $(this).data("count");
	                $(this).html(countNumber);                                    
	            });
        	}            
    	});
    }

    var logo = function() {
        // Elements to inject
        var mySVGsToInject = document.querySelectorAll('img.logo_svg');

        // Trigger the injection
        SVGInjector(mySVGsToInject, {
            pngFallback: 'assets/png'
        });
    }

    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/tfcounter.default', tfcounter );
        elementorFrontend.hooks.addAction( 'frontend/element_ready/tfcounter.default', logo );
    });

})(jQuery);