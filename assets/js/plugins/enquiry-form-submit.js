/**
 * Enquiry form — field validation, Select2 / phone plugins,
 * Cloudflare Turnstile, and AJAX submit.
 *
 * @package iec
 */
( function ( $ ) {
	'use strict';

	window.IEC = window.IEC || {};

	var cfg      = window.iecEnquiry || {};
	var FORM_SEL = 'form.iec-enquiry-form, form[data-iec-enquiry="1"], form#enquiry-form-new, form#enquiry-form';
	var PLUGIN_TRIES = 30;
	var PLUGIN_WAIT  = 120;

	function strings() {
		return cfg.strings || {};
	}

	function fieldContainer( $field ) {
		if ( typeof IEC.fieldContainer === 'function' ) {
			return IEC.fieldContainer( $field );
		}
		return $field.closest( '.bf_form_group, .form-field, .form-control' ).first();
	}

	function isValidEmail( email ) {
		return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test( email );
	}

	function setFieldInvalid( $field, message ) {
		var $container = fieldContainer( $field );
		var $error     = $container.find( 'p.error' ).first();

		$field.addClass( 'error-field' );
		$container.addClass( 'is-invalid error-active' );
		if ( message && $error.length ) {
			$error.text( message );
		}
	}

	function clearFieldInvalid( $field ) {
		var $container = fieldContainer( $field );
		$field.removeClass( 'error-field' );
		$container.removeClass( 'is-invalid error-active' );
	}

	function resetFormErrors( $form ) {
		$form.find( '.bf_form_group' ).removeClass( 'is-invalid error-active' );
		$form.find( '.error-field' ).removeClass( 'error-field' );
	}

	function validateField( $field ) {
		var value   = $field.val();
		var copy    = strings();
		var isEmpty = ! value || value === '' || ( Array.isArray( value ) && value.length === 0 );

		if ( $field.prop( 'required' ) && isEmpty ) {
			setFieldInvalid( $field, copy.fieldRequired || 'This field is required' );
			return false;
		}

		if ( $field.attr( 'type' ) === 'email' && value && ! isValidEmail( value ) ) {
			setFieldInvalid( $field, copy.emailInvalid || 'Please enter a valid email address' );
			return false;
		}

		clearFieldInvalid( $field );
		return true;
	}

	function apiMessage( result ) {
		var messages = cfg.errorMessages || window.error_messages || {};

		if ( result && result.message ) {
			return result.message;
		}
		if ( result && result.code && messages[ result.code ] ) {
			return messages[ result.code ];
		}
		return strings().genericError || 'Something went wrong. Please try again.';
	}

	function showOverlay( overlay, show ) {
		if ( ! overlay ) {
			return;
		}
		if ( show ) {
			overlay.removeAttribute( 'hidden' );
			overlay.style.display = 'flex';
			return;
		}
		overlay.setAttribute( 'hidden', '' );
		overlay.style.display = 'none';
	}

	function setBusy( $submitBtn, overlay, busy ) {
		showOverlay( overlay, busy );
		$submitBtn.prop( 'disabled', busy );
	}

	function showResponse( $response, message, isError ) {
		if ( ! $response.length ) {
			return;
		}
		$response.text( message ).removeAttr( 'hidden' ).show();
		$response.toggleClass( 'error-message', !! isError );
	}

	function scrollToFirstError( $form ) {
		var $target = $form.find( '.bf_form_group.is-invalid, .bf_form_group.error-active' ).first();
		if ( ! $target.length ) {
			$target = $form.find( '.error-field' ).first().closest( '.bf_form_group, .form-field' );
		}
		if ( typeof IEC.scrollTo === 'function' ) {
			IEC.scrollTo( $target );
			return;
		}
		if ( $target.length && $target.offset() ) {
			$( 'html, body' ).animate( { scrollTop: $target.offset().top - 100 }, 300 );
		}
	}

	function thankYouRedirect() {
		var lang = cfg.lang || window.location.pathname.split( '/' )[ 1 ] || 'en';
		window.location.href = '/' + lang + '/thank-you/';
	}

	function initSelect( $form, selector, plugin, options ) {
		$form.find( selector ).each( function () {
			var $el = $( this );
			if ( $el.hasClass( 'select2-hidden-accessible' ) ) {
				return;
			}
			if ( plugin && $.fn[ plugin ] ) {
				$el[ plugin ]();
				return;
			}
			if ( $.fn.select2 ) {
				$el.select2( options( $el ) );
			}
		} );
	}

	function initSelect2Fields( $form ) {
		if ( ! $.fn.select2 ) {
			return false;
		}

		initSelect( $form, 'select[name="country"]', 'countrySelect', function ( $el ) {
			return {
				placeholder: $el.data( 'placeholder' ) || 'Country...',
				allowClear: true,
				width: '100%',
				dropdownParent: $el.closest( '.country, .bf_form_group' ),
			};
		} );

		initSelect( $form, 'select[name="interests[]"]', '', function ( $el ) {
			$el.find( 'option[value=""]' ).remove();
			return {
				placeholder: $el.data( 'placeholder' ) || $form.find( '#interest-label' ).first().text().trim() || 'Interest...',
				multiple: true,
				maximumSelectionLength: 5,
				allowClear: true,
				width: '100%',
				dropdownParent: $el.closest( '.interest, .bf_form_group' ),
			};
		} );

		initSelect( $form, 'select[name="hear_source"]', '', function ( $el ) {
			return {
				placeholder: $el.data( 'placeholder' ) || $form.find( '#hear-source-label' ).first().text().trim() || '',
				allowClear: true,
				width: '100%',
				dropdownParent: $el.closest( '.hear, .how, .bf_form_group' ),
			};
		} );

		return true;
	}

	function initPhoneFields( $form ) {
		if ( ! window.intlTelInput || ! $.fn.phonePlugin ) {
			return false;
		}

		$form.find( 'input[name="phone"]' ).each( function () {
			var $input = $( this );
			if ( ! $input.data( 'phone-plugin' ) ) {
				$input.phonePlugin();
			}
		} );

		return true;
	}

	function initPlugins( $form, attempt ) {
		attempt = attempt || 0;
		var selectsReady = initSelect2Fields( $form );
		var phoneReady   = initPhoneFields( $form );

		if ( ( ! selectsReady || ! phoneReady ) && attempt < PLUGIN_TRIES ) {
			window.setTimeout( function () {
				initPlugins( $form, attempt + 1 );
			}, PLUGIN_WAIT );
		}
	}

	function getTurnstile( $form ) {
		var $widget  = $form.find( '.cf-turnstile[data-turnstile-rendered], .g-recaptcha[data-turnstile-rendered]' ).first();
		var widgetId = $widget.length ? $widget.data( 'turnstile-widget-id' ) : undefined;
		var token    = '';

		if ( typeof turnstile === 'undefined' ) {
			return { token: '', widgetId: widgetId, enabled: false };
		}

		token = ( typeof widgetId !== 'undefined' )
			? turnstile.getResponse( widgetId )
			: ( turnstile.getResponse ? turnstile.getResponse() : '' );

		if ( ! token ) {
			token = $form.find( 'input[name="cf-turnstile-response"]' ).first().val() || '';
		}

		return { token: token, widgetId: widgetId, enabled: true };
	}

	function resetTurnstile( widgetId ) {
		if ( typeof turnstile === 'undefined' ) {
			return;
		}
		if ( typeof widgetId !== 'undefined' ) {
			turnstile.reset( widgetId );
			return;
		}
		turnstile.reset();
	}

	function isTurnstileHostReady( el ) {
		if ( ! el || ! el.isConnected ) {
			return false;
		}

		if ( el.closest( '.banner-form.hide-popup' ) ) {
			return false;
		}

		var host = el.closest( '.iec-popup, .iec-modal-overlay, dialog, [hidden], .banner-form' );
		if ( host ) {
			if ( host.hasAttribute( 'hidden' ) ) {
				return false;
			}
			if ( ( host.classList.contains( 'iec-popup' ) || host.classList.contains( 'iec-modal-overlay' ) )
				&& ! host.classList.contains( 'is-open' )
				&& ! host.classList.contains( 'active' ) ) {
				return false;
			}
			if ( host.tagName === 'DIALOG' && ! host.open ) {
				return false;
			}
		}

		var style = window.getComputedStyle( el );
		return style.display !== 'none' && style.visibility !== 'hidden';
	}

	function renderTurnstileWidgets( root ) {
		if ( typeof turnstile === 'undefined' || ! turnstile.render ) {
			return;
		}

		var scope = root && root.querySelectorAll ? root : document;
		scope.querySelectorAll( '.cf-turnstile:not([data-turnstile-rendered]), .g-recaptcha:not([data-turnstile-rendered])' ).forEach( function ( el ) {
			var sitekey = el.getAttribute( 'data-sitekey' );
			if ( ! sitekey || ! isTurnstileHostReady( el ) ) {
				return;
			}

			try {
				var widgetId = turnstile.render( el, {
					sitekey: sitekey,
					retry: 'auto',
					'refresh-expired': 'auto',
				} );
				el.setAttribute( 'data-turnstile-rendered', '1' );
				el.setAttribute( 'data-turnstile-widget-id', String( widgetId ) );
				$( el ).data( 'turnstile-widget-id', widgetId );
			} catch ( err ) {
				return;
			}
		} );
	}

	function buildFormData( form, captcha, phonePlugin ) {
		var formData = new FormData( form );

		if ( captcha.token ) {
			formData.set( 'cf-turnstile-response', captcha.token );
			formData.set( 'g-recaptcha-response', captcha.token );
		}

		if ( phonePlugin && phonePlugin.getNumber ) {
			var fullPhone = phonePlugin.getNumber();
			if ( fullPhone ) {
				formData.set( 'phone', fullPhone );
			}
		}

		return formData;
	}

	function onSuccess( form ) {
		var typeField = form.elements.type;
		if ( typeField && typeField.value === 'popup' ) {
			$( '#enquiry-form-new' ).hide();
			$( '#success-popup' ).show();
			return;
		}
		thankYouRedirect();
	}

	function onFail( $submitBtn, overlay, $response, message, captcha ) {
		setBusy( $submitBtn, overlay, false );
		showResponse( $response, message );
		resetTurnstile( captcha.widgetId );
	}

	function validateForm( $form ) {
		var copy    = strings();
		var isValid = true;
		var captcha = getTurnstile( $form );
		var $phone  = $form.find( 'input[name="phone"]' ).first();
		var phonePlugin = $phone.data( 'phone-plugin' );

		$form.find( 'input[required], select[required], textarea[required], input[type="email"]' ).each( function () {
			if ( ! validateField( $( this ) ) ) {
				isValid = false;
			}
		} );

		if ( phonePlugin && ! phonePlugin.validate() ) {
			isValid = false;
		}

		if ( captcha.enabled && ! captcha.token ) {
			showResponse( $form.find( '.iec-enquiry-response, #form-response' ).first(), copy.captchaRequired || '', true );
			isValid = false;
		}

		return {
			ok: isValid,
			captcha: captcha,
			phonePlugin: phonePlugin,
		};
	}

	async function submitForm( form, $form, $submitBtn, overlay, $response, check ) {
		setBusy( $submitBtn, overlay, true );

		try {
			var response = await fetch( form.action, {
				method: 'POST',
				body: buildFormData( form, check.captcha, check.phonePlugin ),
				credentials: 'same-origin',
			} );

			var result = {};
			try {
				result = await response.json();
			} catch ( parseErr ) {
				result = {};
			}

			if ( response.ok && result.status === 'ok' ) {
				onSuccess( form );
				return;
			}

			onFail( $submitBtn, overlay, $response, apiMessage( result ), check.captcha );
		} catch ( networkErr ) {
			onFail( $submitBtn, overlay, $response, strings().networkError || '', check.captcha );
		}
	}

	function bindForm( form ) {
		var $form = $( form );
		var $root = $form.closest( '.iec-enquiry-root, .iec_single_office_contact_us, .iec_form_warpper, section' );
		var overlay    = $root.find( '.iec-enquiry-loading, .loading-overlay, #loading-overlay' )[ 0 ];
		var $response  = $form.find( '.iec-enquiry-response, #form-response' ).first();
		var $submitBtn = $form.find( '.iec-enquiry-submit, #form_submit_btn' ).first();

		if ( ! $submitBtn.length ) {
			return;
		}

		initPlugins( $form );
		resetFormErrors( $form );

		$form.find( 'input[required], select[required], textarea[required]' ).on( 'blur', function () {
			var $field = $( this );
			if ( $field.data( 'iec-touched' ) ) {
				validateField( $field );
			}
		} );

		$form.on( 'focusin', 'input, select, textarea', function () {
			$( this ).data( 'iec-touched', 1 );
		} );

		$form.on( 'input change', 'input, select, textarea', function () {
			clearFieldInvalid( $( this ) );
		} );

		$submitBtn.off( 'click.iecEnquiry' ).on( 'click.iecEnquiry', function ( e ) {
			e.preventDefault();
			resetFormErrors( $form );

			var check = validateForm( $form );
			if ( ! check.ok ) {
				scrollToFirstError( $form );
				return;
			}

			submitForm( form, $form, $submitBtn, overlay, $response, check );
		} );
	}

	IEC.initEnquiryForms = function () {
		document.querySelectorAll( FORM_SEL ).forEach( function ( form ) {
			if ( form.getAttribute( 'data-iec-bound' ) ) {
				return;
			}
			form.setAttribute( 'data-iec-bound', '1' );
			bindForm( form );
		} );

		renderTurnstileWidgets();
	};

	$( document ).on( 'iec:popup:open', function ( e ) {
		renderTurnstileWidgets( e.target );
	} );

	window.iecTurnstileOnload = function () {
		renderTurnstileWidgets();
		IEC.initEnquiryForms();
	};

	window.iecRecaptchaOnload = window.iecTurnstileOnload;

}( jQuery ) );
