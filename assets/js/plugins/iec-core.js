( function ( $ ) {
	'use strict';

	window.IEC = window.IEC || {};

	// Cloudflare onload can fire before enquiry-form-submit.js assigns the real handler.
	window.iecTurnstileOnload = window.iecTurnstileOnload || function () {
		if ( typeof IEC.initEnquiryForms === 'function' ) {
			IEC.initEnquiryForms();
		}
	};

	IEC.scrollTo = function ( $target, offset, duration ) {
		if ( ! $target || ! $target.length ) {
			return;
		}
		$( 'html, body' ).animate( { scrollTop: $target.offset().top - ( offset || 100 ) }, duration || 400 );
	};

	IEC.fieldContainer = function ( $field ) {
		return $field.closest( '.bf_form_group, .form-field, .form-control' ).first();
	};

	IEC.initAOS = function ( options ) {
		if ( typeof AOS === 'undefined' ) {
			return;
		}
		AOS.init( $.extend( { duration: 800, once: true }, options || {} ) );
	};

	IEC.kickAOS = function () {
		if ( typeof AOS === 'undefined' ) {
			return;
		}
		if ( typeof AOS.refreshHard === 'function' ) {
			AOS.refreshHard();
		} else if ( typeof AOS.refresh === 'function' ) {
			AOS.refresh();
		}
	};

	IEC.scheduleAOSKick = function () {
		if ( typeof AOS === 'undefined' ) {
			return;
		}

		window.requestAnimationFrame( function () {
			IEC.kickAOS();
		} );
		window.setTimeout( IEC.kickAOS, 150 );
		window.setTimeout( IEC.kickAOS, 600 );
		window.addEventListener( 'load', IEC.kickAOS );
		window.addEventListener( 'pageshow', IEC.kickAOS );
	};

	IEC.setErrorMessages = function () {
		if ( window.error_messages ) {
			return;
		}

		var sources = [ 'iecEnquiry', 'iecProduct', 'iecMarketDetail', 'iecBecomePartner', 'iecJobs' ];
		var match = sources.map( function ( key ) {
			return window[ key ];
		} ).find( function ( cfg ) {
			return cfg && cfg.errorMessages;
		} );

		if ( match ) {
			window.error_messages = match.errorMessages;
		}
	};

	function initVoucherVideo() {
		var $play  = $( '#iecPlayBtn' );
		var $thumb = $( '.iec-video-thumbnail' );
		var $wrap  = $( '.iec-video-iframe' );

		if ( ! $play.length || ! $wrap.length || $play.data( 'iecVideoBound' ) ) {
			return;
		}

		$play.data( 'iecVideoBound', true ).on( 'click', function () {
			var src = $wrap.data( 'src' ) || $wrap.find( 'iframe' ).attr( 'src' );
			if ( src && $wrap.find( 'iframe' ).length ) {
				$wrap.find( 'iframe' ).attr( 'src', src );
			}
			$thumb.addClass( 'hide' );
			$wrap.show();
		} );
	}

	IEC.initLazyVideos = function () {
		initVoucherVideo();
	};

	IEC.bindDialog = function ( options ) {
		var $dialog = $( options.dialog );

		if ( ! $dialog.length || ! $dialog[0].showModal || $dialog.data( 'iecDialogBound' ) ) {
			return;
		}

		$dialog.data( 'iecDialogBound', true );

		function close() {
			if ( $dialog[0].open ) {
				$dialog[0].close();
			}
		}

		$( document ).on( 'click', options.trigger, function () {
			if ( typeof options.onOpen === 'function' ) {
				options.onOpen( $( this ) );
			}
			$dialog[0].showModal();
		} );

		$dialog.find( options.close || '.close' ).on( 'click', close );
		$dialog.on( 'click', function ( e ) {
			if ( e.target === $dialog[0] ) {
				close();
			}
		} );
		$dialog[0].addEventListener( 'cancel', function ( e ) {
			e.preventDefault();
			close();
		} );
	};

	function initGlobalUI() {
		$( document ).on( 'click', 'a.iec-scroll-link[href^="#"]', function ( e ) {
			var $target = $( $( this ).attr( 'href' ) );
			if ( ! $target.length ) {
				return;
			}
			e.preventDefault();
			IEC.scrollTo( $target, 80 );
		} );
	}

	IEC.boot = function () {
		IEC.setErrorMessages();
		initGlobalUI();
		IEC.initAOS();
		IEC.scheduleAOSKick();

		if ( typeof IEC.initPopups === 'function' ) {
			IEC.initPopups();
		}

		IEC.initLazyVideos();

		[ 'initAccordions', 'initSwipers', 'initEnquiryForms' ].forEach( function ( method ) {
			if ( typeof IEC[ method ] === 'function' ) {
				IEC[ method ]();
			}
		} );
	};

	$( IEC.boot );

} )( jQuery );
