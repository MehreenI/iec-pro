( function ( $ ) {
	'use strict';

	window.IEC = window.IEC || {};

	var registry = {};

	function resolveModal( modal ) {
		return modal instanceof $ ? modal : $( modal );
	}

	function lockBody( lock, bodyClass ) {
		var cls = bodyClass || 'iec-popup-open';
		$( 'body' ).toggleClass( cls, lock ).css( 'overflow', lock ? 'hidden' : '' );
	}

	function getConfig( $modal, options ) {
		var id = $modal.attr( 'id' ) || $modal[0];
		return $.extend( {}, registry[ id ], options );
	}

	function invoke( fn, $modal ) {
		if ( typeof fn === 'function' ) {
			fn( $modal );
		}
	}

	IEC.openPopup = function ( modal, options ) {
		var $modal = resolveModal( modal );
		if ( ! $modal.length ) {
			return;
		}

		var config    = getConfig( $modal, options || {} );
		var openClass = config.openClass || 'is-open';

		$modal.addClass( openClass );
		lockBody( true, config.bodyClass );
		invoke( config.onOpen, $modal );
		$modal.trigger( 'iec:popup:open' );
	};

	IEC.closePopup = function ( modal, options ) {
		var $modal = resolveModal( modal );
		if ( ! $modal.length ) {
			return;
		}

		var config    = getConfig( $modal, options || {} );
		var openClass = config.openClass || 'is-open';

		$modal.removeClass( openClass );
		lockBody( false, config.bodyClass );
		invoke( config.onClose, $modal );
		$modal.trigger( 'iec:popup:close' );
	};

	IEC.bindPopup = function ( options ) {
		var $modal = resolveModal( options.modal );

		if ( ! $modal.length || $modal.data( 'iecPopupBound' ) ) {
			return;
		}

		$modal.data( 'iecPopupBound', true );
		registry[ $modal.attr( 'id' ) || String( Object.keys( registry ).length ) ] = options;

		if ( options.triggers ) {
			$( document ).on( 'click.iecPopup', options.triggers, function ( e ) {
				e.preventDefault();
				IEC.openPopup( $modal, options );
			} );
		}

		if ( options.close ) {
			$( document ).on( 'click.iecPopup', options.close, function ( e ) {
				e.preventDefault();
				IEC.closePopup( $modal, options );
			} );
		}

		$modal.on( 'click.iecPopup', function ( e ) {
			if ( e.target === $modal[0] ) {
				IEC.closePopup( $modal, options );
			}
		} );
	};

	IEC.initPopups = function () {
		IEC.bindPopup( {
			modal: '#iecEnquiryModal',
			triggers: '#iecEnquiryModalTrigger, .recommended_solutions_section a.learn_more_btn[data-id="iecModelEnquiry"]',
			close: '#iecEnquiryModalClose',
			openClass: 'is-open',
			bodyClass: 'iec-modal-locked',
			onClose: function () {
				$( '#enquiry-form-new' ).show();
				$( '#success-popup' ).hide();
			},
		} );

		IEC.bindPopup( {
			modal: '#contactModal',
			triggers: '#openContactModal',
			close: '#closeContactModal, #contactModal .custom_modal_overlay',
			openClass: 'active',
			onOpen: function () {
				if ( typeof IEC.initEnquiryForms === 'function' ) {
					IEC.initEnquiryForms();
				}
			},
		} );

		$( document ).on( 'click.iecPopup', '[data-iec-popup-open]', function ( e ) {
			e.preventDefault();
			var target = $( this ).attr( 'data-iec-popup-open' );
			if ( target ) {
				IEC.openPopup( target );
			}
		} );

		$( document ).on( 'keydown.iecPopup', function ( e ) {
			if ( e.key !== 'Escape' ) {
				return;
			}
			$( '#iecEnquiryModal.is-open, #contactModal.active' ).each( function () {
				IEC.closePopup( this );
			} );
		} );
	};

	IEC.initModals = IEC.initPopups;

} )( jQuery );
