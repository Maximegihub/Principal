(function( $ ) {

	'use strict';

	var errorClass = 'wdes-template-types-popup-error';

	//openPopup
	$(document).on( 'click', '.page-title-action', function(e){

		e.preventDefault();

		$( '.wdes-template-types-popup' ).addClass( 'wdes-template-types-popup-active' );

	} );

	//closePopup
	$(document).on( 'click', '.wdes-template-types-popup-overlay', function (e){

		$( '.wdes-template-types-popup' ).removeClass( 'wdes-template-types-popup-active' );

	} );

	//validateForm
	$(document).on( 'click', '#templates_type_submit', function(){

		var $this = $( this ),
			form = $this.closest( '#templates_type_form' ),
			templateType = form.find( '#template_type' ),
			optionType  = templateType.find( 'option:selected' ).val();

		templateType.removeClass( errorClass );

		if ( '' !== optionType ) {
			form.submit();
		} else {
			templateType.addClass( errorClass );
		}

	} );

	//changeType
	$(document).on( 'click', '#template_type',function (e){
		var $this = $( this ),
			value = $this.find( 'option:selected' ).val();

		if ( '' !== value ) {
			$this.removeClass( errorClass );
		}
	} );


})( jQuery );