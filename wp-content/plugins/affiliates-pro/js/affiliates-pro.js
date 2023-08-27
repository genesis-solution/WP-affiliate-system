/**
 * affiliates-pro.js
 *
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
 * @package affiliates-pro
 * @since affiliates-pro 1.0.0
 */
jQuery(document).ready(function(){
	/* columns toggle */
	jQuery('#columns-toggle').click(function(){
		var ajaxing = jQuery('#columns-toggle').data('ajaxing');
		if (!(typeof ajaxing === 'undefined' || !ajaxing)) {
			return;
		}
		jQuery('#columns-toggle').data('ajaxing',true);
		jQuery('#columns-container').toggle();
		var visible = jQuery('#columns-container').is(':visible');
		if (visible) {
			jQuery(this).addClass('on');
			jQuery(this).removeClass('off');
		} else {
			jQuery(this).addClass('off');
			jQuery(this).removeClass('on');
		}
		if (
			( typeof ajaxurl !== 'undefined' ) &&
			( typeof affiliates_ajax_nonce !== 'undefined' )
		) {
			var data = {
				action: 'affiliates_set_option',
				affiliates_ajax_nonce: affiliates_ajax_nonce,
				key: 'show_columns',
				value: JSON.stringify(visible)
			};
			jQuery.ajax({
				type   : 'POST',
				async  : false,
				url    : ajaxurl,
				data   : data
			});
		}
		jQuery('#columns-toggle').data('ajaxing',false);
	});

	jQuery('.column-toggle').click(function(event){

		var ajaxing = jQuery(this).data('ajaxing');
		if (!(typeof ajaxing === 'undefined' || !ajaxing)) {
			return;
		}
		jQuery(this).data('ajaxing',true);

		// hide/show column
		event.stopPropagation();
		var value = jQuery(this).val();
		jQuery('th.'+value).toggle();
		var visible = jQuery('th.'+value).is(':visible');
		if ( visible ) {
			jQuery('td.'+value).show();
		} else {
			jQuery('td.'+value).hide();
		}
		// adjust column span
		var columns = jQuery('#affiliates-overview-table > thead > tr > th:visible');
		jQuery('td.dynamic-colspan').attr('colspan',columns.length);

		// save visibility for column
		if (
			( typeof ajaxurl !== 'undefined' ) &&
			( typeof affiliates_ajax_nonce !== 'undefined' ) &&
			( typeof affiliates_overview_columns !== 'undefined' )
		) {
			affiliates_overview_columns[jQuery(this).val()] = visible;
			var data = {
				action: 'affiliates_set_option',
				affiliates_ajax_nonce: affiliates_ajax_nonce,
				key   : 'affiliates_overview_columns',
				value : JSON.stringify(affiliates_overview_columns)
			};
			jQuery.ajax({
				type     : 'POST',
				dataType : 'json',
				async    : false,
				url      : ajaxurl,
				data     : data
			});
		}

		jQuery(this).data('ajaxing',false);
	});

	// Rates
	if ( jQuery('#integration').length ) {
		jQuery('#integration').change(function(event){
			var data = {
				action: 'affiliates_rates_set_fields',
				integration: event.target.value,
				post_id: jQuery('#ajax_object_id').val(),
				term_id: jQuery('#ajax_term_id').val()
			};
			jQuery.ajax({
				type   : 'POST',
				async  : false,
				url    : ajaxurl,
				data   : data,
				success: function(response) {
					// Reset the selects
					jQuery('#post_type_select').empty();
					jQuery('#post_type_select').append(jQuery('<option>', {
						value: '',
						text : '--',
						selected : true
					}));
					jQuery('#term_select').empty();
					jQuery('#term_select').append(jQuery('<option>', {
						value: '',
						text : '--',
						selected : true
					}));

					if ( response !== '' ) {
						items = JSON.parse( response );
						if( 'posts' in items ) {
							jQuery.each(items['posts'], function (i, item) {
								jQuery('#post_type_select').append(jQuery('<option>', {
									value: item.ID,
									text : item.title,
									selected : item.selected
								}));
							});
						}
						if( 'terms' in items ) {
							jQuery.each(items['terms'], function (i, item) {
								jQuery('#term_select').append(jQuery('<option>', {
									value: item.ID,
									text : item.title,
									selected : item.selected
								}));
							});
						}
					}
				}
			});
		});
	}

	jQuery('.update-skip-action').on('change', function(){
		var $form = jQuery(this).closest('form');
		$form.append('<input type="hidden" name="skip-action" value="1"/>');
		$form.find('input[type=submit]').click();
	});

	// Referral Items
	// Remove item
	jQuery('body').on('click', '.img_remove_action', function() {
		var tr = jQuery('#row_' + jQuery(this).attr('row_id') );
		tr.fadeOut(200, function(){
			tr.remove();
		});
		return false;
	});
	// Add items
	jQuery(".new-referral-item").click(function(){
		var i = jQuery( '#num_items' ).val();
		i = parseInt( i );
		jQuery('#referral_items tr:last').after(
			'<tr id="row_' + i + '">' +
			'<td>-<input type="hidden" name="item_id[]" value=""></input></td>' +
			'<td><input type="text" name="item_reference[]" value=""></input></td>' +
			'<td><input type="text" name="item_type[]" value=""></input></td>' +
			'<td><input type="text" name="item_rate_id[]" value=""></input></td>' +
			'<td><input type="text" name="item_line_amount[]" value=""></input></td>' +
			'<td><input type="text" name="item_amount[]" value=""></input></td>' +
			'<td><input type="text" name="item_currency_id[]" value="" readonly="readonly"></input></td>' +
			'<td class="actions"><img src="' + affiliates_plugin_url + 'images/remove.png" alt="' + affiliates_referral_item_remove_alt + '" title="' + affiliates_referral_item_remove_title + '" class="img_remove_action" row_id="' + i + '" /></td>' +
			'</tr>'
		);

		i = i + 1;
		jQuery( '#num_items' ).val( i );

	});

});
