( function ( $ ) {
	'use strict';

	function fieldContainer( $field ) {
		if ( window.IEC && typeof IEC.fieldContainer === 'function' ) {
			return IEC.fieldContainer( $field );
		}
		return $field.closest( '.bf_form_group, .form-field, .form-control' ).first();
	}

	$.fn.phonePlugin = function ( options ) {
		options = options || {};

		return this.each( function () {
			var $input = $( this );
			if ( $input.data( 'phone-plugin' ) || ! window.intlTelInput ) {
				return;
			}

			var iti = window.intlTelInput( this, {
				initialCountry: 'us',
				preferredCountries: [ 'us', 'gb', 'de', 'fr', 'ru' ],
				nationalMode: false,
				autoPlaceholder: 'aggressive',
				placeholderNumberType: 'MOBILE',
				formatOnDisplay: true,
				separateDialCode: true,
				utilsScript: ( window.iecConfig && window.iecConfig.intlTelUtils ) || '',
				...options,
			} );

			var validatePhone = function () {
				var $container = fieldContainer( $input );
				var $error     = $container.find( 'p.error' ).first();
				var value      = $input.val().trim();
				var required   = $input.prop( 'required' );

				if ( ! value ) {
					if ( required ) {
						$container.addClass( 'error-active is-invalid' );
						$input.addClass( 'error-field' );
						return false;
					}
					$container.removeClass( 'error-active is-invalid' );
					$input.removeClass( 'error-field' );
					return true;
				}

				if ( iti.isValidNumber() ) {
					$container.removeClass( 'error-active is-invalid' );
					$input.removeClass( 'error-field' );
					return true;
				}

				$container.addClass( 'error-active is-invalid' );
				$input.addClass( 'error-field' );
				if ( $error.length ) {
					$error.text( 'Please enter a valid phone number' );
				}
				return false;
			};

			$input.on( 'focus', function () {
				$input.data( 'iec-touched', 1 );
			} );

			$input.on( 'keyup blur', function () {
				if ( ! $input.data( 'iec-touched' ) ) {
					return;
				}
				validatePhone();
			} );

			$input.on( 'countrychange', function () {
				var countryData = iti.getSelectedCountryData();
				var $form       = $input.closest( 'form' );
				var $country    = $form.find( 'select[name="country"]' ).first();
				if ( countryData && countryData.iso2 && $country.length ) {
					$country.val( countryData.iso2.toUpperCase() ).trigger( 'change.select2' );
				}
			} );

			$input.data( 'phone-plugin', {
				validate: validatePhone,
				getNumber: function () {
					return iti.getNumber();
				},
				isValid: function () {
					return iti.isValidNumber();
				},
				setCountry: function ( code ) {
					iti.setCountry( code );
				},
				instance: iti,
			} );
		} );
	};

}( jQuery ) );
