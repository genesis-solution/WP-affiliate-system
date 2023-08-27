/*!
 * dashboard-overview-control.js
 *
 * Copyright (c) 2010 - 2019 "kento" Karim Rahimpur www.itthinx.com
 *
 * This code is provided subject to the license granted.
 * Unauthorized use and distribution is prohibited.
 * See COPYRIGHT.txt and LICENSE.txt
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * This header and all notices must be kept intact.
 *
 * @author Karim Rahimpur
 * @package affiliates
 * @since affiliates 4.0.0
 */

( function( $ ) {

	if ( typeof affiliates_overview === 'undefined' ) {
		affiliates_overview = {};
	}

	affiliates_overview.get_affiliate_url = function( aff_parameter, aff_id, string_URL, bloginfo_url ) {
		var hash_parameters = string_URL.split('#');
		var hash_parameter = '';
		var url_variables = '';

		if ( typeof hash_parameters[1] !== 'undefined' ) {
			hash_parameter = '#' + hash_parameters[1];
		}
		url_variables = hash_parameters[0];
		url_parameters = url_variables.replace( /\?/g, '&' );
		params = url_parameters.split( '&' );
		for ( var i = 1; i < params.length; i++ ) {
			if ( params[i].toLowerCase().indexOf( aff_parameter ) >= 0 ) {
				params[i] = '';
			}
			if ( params[i].toLowerCase().indexOf( affiliates_overview_controls.cname ) >= 0 ) {
				params[i] = '';
			}
		}

		var url_params = '';
		for ( var j = 1; j < params.length; j++ ) {
			url_params = params[j] != '' ? url_params + '&' + params[j] : url_params + '';
		}

		var main_url = params[0] != '' ? params[0] : bloginfo_url;
		var aff_url = main_url + url_params + '&' + aff_parameter + '=' + aff_id + hash_parameter;
		aff_url = aff_url.replace( '&', '?' );

		return aff_url;
	}

	affiliates_overview.update = function( event ) {
		var container = $( this ).closest( '.affiliates-dashboard-overview-link' );
		if ( container.length > 0 ) {
			var generate_url = container.find( '.affiliates-generate-url' ).first().val();
			if ( typeof generate_url === 'undefined' || generate_url === '' ) {
				generate_url = affiliates_overview_controls.site_url;
			}
			var affiliate_url = affiliates_overview.get_affiliate_url(
				affiliates_overview_controls.pname,
				affiliates_overview_controls.affiliate_id,
				generate_url,
				affiliates_overview_controls.site_url
			);
			container.find( '.affiliate-url' ).val( affiliate_url );
		}
	};

	$( document ).ready( function() {
		$( '.affiliates-dashboard-overview-link .affiliates-generate-url' ).on( 'touchend keyup', affiliates_overview.update );
		$( '.affiliates-dashboard-overview-filters .datefield' ).on( 'change', function( event ) {
			$( this ).closest( '.affiliates-dashboard-overview-filters' ).find( 'select[name="range"]' ).val( 'custom' );
		} );
	} );

} )( jQuery );
