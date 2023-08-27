/*!
 * dashboard-banners-controls.js
 *
 * Copyright (c) 2010 - 2019 "kento" Karim Rahimpur www.itthinx.com
 *
 * This code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt.
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This header and all notices must be kept intact.
 *
 * @author Karim Rahimpur
 * @package affiliates
 * @since affiliates 4.0.0
 */

( function( $ ) {

	$( document ).ready( function() {
		$( '.copy-to-clipboard-trigger' ).on( 'click', function( event ) {
			var source = $( '#' + $( this ).data( 'source' ) );
			if ( source.length ) {
				source.select();
				var text = source.text();
				if ( document.execCommand( 'copy' ) ) {
					$( source ).fadeOut( 100 ).fadeIn( 100 );
				}
			}
		} );
	} );
} )( jQuery );
