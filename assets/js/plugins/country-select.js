( function ( $ ) {
	'use strict';

	$.fn.countrySelect = function () {
		return this.each( function () {
			var $select = $( this );
			var $form   = $select.closest( 'form' );

			if ( $select.hasClass( 'select2-hidden-accessible' ) ) {
				return;
			}

			var placeholder = $select.data( 'placeholder' )
				|| $form.find( '[id*="country-label"]' ).first().text().trim()
				|| $select.find( 'option[value=""]' ).first().text().trim()
				|| 'Country...';

			var $modal = $select.closest( '.custom_contact_modal' );
			var dropdownParent = $modal.length ? $modal.find( '.modal_body' ) : $select.closest( '.country, .bf_form_group' );

			function withFlag( country, wrapClass ) {
				if ( ! country.id ) {
					return country.text;
				}
				return $( '<span class="' + wrapClass + '">' +
					'<i class="flag-icon flag-icon-' + country.id.toLowerCase() + '"></i>' +
					'<span class="country-name">' + country.text + '</span></span>' );
			}

			$select.select2( {
				placeholder: placeholder,
				allowClear: true,
				width: '100%',
				dropdownParent: dropdownParent,
				templateResult: function ( c ) { return withFlag( c, 'select2-option-with-flag' ); },
				templateSelection: function ( c ) { return withFlag( c, 'select2-selection-with-flag' ); },
			} );

			$select.on( 'change', function () {
				var code = $( this ).val();
				var phonePlugin = $form.find( 'input[name="phone"]' ).data( 'phone-plugin' );
				if ( code && phonePlugin ) {
					phonePlugin.setCountry( code.toLowerCase() );
				}
			} );
		} );
	};

} )( jQuery );
