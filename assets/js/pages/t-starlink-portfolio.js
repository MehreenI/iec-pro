( function () {
	'use strict';

	document.querySelectorAll('.iec_starlink_portfolio_hero_button_list a[href^="#"]').forEach(function(link) {
	    link.addEventListener('click', function(e) {
	        e.preventDefault();
	        var target = document.querySelector(this.getAttribute('href'));
	        if (target) {
	            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
	        }
	    });
	});
}() );
