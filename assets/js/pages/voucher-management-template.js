( function ( $ ) {
	'use strict';

	window.initVoucherManagementPage = function () {
		IEC.initAOS();
	};

	$( function () {
		if ( $( '[data-voucher-management-page]' ).length ) {
			initVoucherManagementPage();
		}
	} );

} )( jQuery );