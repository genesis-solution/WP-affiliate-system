(function($) {
	'use strict';
	// Add Section Area Button Elementor Editer


	$( document ).on( 'click', '.template-item', function ( e ) {
		alert('22');
		var demo = $(this);
		var id = demo.attr('demo-id');
		var data = {
			action: 'woostify_admin_list_page_demo',
			id: id,
			security: admin.nonce,
		};
		$.ajax(
			{
				type: 'GET',
				url: admin.url,
				data: data,
				// beforeSend: function (response) {
				// 	btn.addClass('loading');
				// },
				success: function (response) {
					console.log( response );
					$('#woostify-demo-theme').html(response);
				},
				error: function(e){
					console.log(e);
				}
			}
		);
	} );


})(jQuery);