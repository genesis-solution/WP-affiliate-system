
(function($) {
	'use strict';
	// Add Section Area Button Elementor Editer
	if ( elementorCommon ) {
		var addSectionTmpl = $( "#tmpl-elementor-add-section" );
		var listButton = $('.elementor-add-section-area-button');
		var index = 0;
		if ( addSectionTmpl.length > 0 ) {
			let actionForAddSection = addSectionTmpl.text();
			let stylesheet = '';
			actionForAddSection = actionForAddSection.replace( '<div class="elementor-add-section-drag-title', stylesheet + '<div class="elementor-add-section-area-button elementor-add-woostify-site-button" style="background:#4744b7; margin-left: 5px; position: relative; top: 3px;"><img height="18" width="18" src="http://demo.woostify.com/wp-content/uploads/2021/07/icon-logo.svg"/><i class="eicon-folder" style="display: none"></i> </div><div class="elementor-add-section-drag-title' );
			addSectionTmpl.text( actionForAddSection );
		}
		elementor.on( "preview:loaded", function() {
			var editer = elementor.$previewContents[0].body;
			$(editer).on( 'click', '.elementor-add-woostify-site-button', function(e) {
				showTemplate('pages');
				let add_section = $( this ).closest( '.elementor-add-section' );
				if ( add_section.hasClass( 'elementor-add-section-inline' ) ) {

					index = add_section.prevAll().length;
				} else {
					index = add_section.prev().children().length;
				}
			} );


			//Import template
			$('body').on( 'click', '#woostify-template-library-header-import', function (e) {
				var id = $( '#woostify-demo-data' ).val();
				var type = $('#woostify-demo-type').val();
				var page = $( '#woostify-demo-page' ).val();
				var btn = $(this);
				var data     = {
					action: 'woostify_import_template',//woostify_modal_template
					id: id,
					type: type,
					post_id: admin.post_id,
					page: page,
					_ajax_nonce: admin.nonce,
				};

				let templateModel = new Backbone.Model({
					getTitle() {
						return data['title']
					},
				});
				let page_settings = '';
				let api_url = '';

				$.ajax(
					{
						type: 'POST',
						url: admin.url,
						data: data,
						beforeSend: function (response) {
							btn.addClass('loading');
						},
						success: function (response) {
							console.log( response );
							console.log(index);
							btn.removeClass('loading');
							var page_content = response.data;
							if ( undefined !== page_content && '' !== page_content ) {
								if ( undefined != $e && 'undefined' != typeof $e.internal ) {
									elementor.channels.data.trigger('template:before:insert', templateModel);
									elementor.getPreviewView().addChildModel( page_content, { at : index } || {} );
									elementor.channels.data.trigger('template:after:insert', {});
									$e.internal( 'document/save/set-is-modified', { status: true } )
								} else {
									elementor.channels.data.trigger('template:before:insert', templateModel);
									elementor.getPreviewView().addChildModel( page_content, { at : index } || {} );
									elementor.channels.data.trigger('template:after:insert', {});
									elementor.saver.setFlagEditorChange(true);
								}
							};
							$( '#woostify-sites-modal' ).css('display', 'none');
						},
						error: function(e){
							console.log(e);
							alert( 'Something went wrong, try logging in!' );
						}
					}
				);
			} );

			$('body').on( 'click', '.woostify-template-library-menu-item', function (e) {
				e.preventDefault();
				var tab = $(this);
				var type = tab.data('tab');
				showTemplate(type, tab);
			} );

			// Select demo type
			$('body').on('change', '.woostify-select-demo-type', function () {
				var select = $(this);
				var demoType = select.val();
				var templateType = select.data('type');

				var data = {
					action: 'woostify_select_demo_type',
					template_type: templateType,
					demo_type: demoType,
					_ajax_nonce: admin.nonce,
				};

			$.ajax(
				{
					type: 'POST',
					url: admin.url,
					data: data,
					beforeSend: function (response) {
					},
					success: function (response) {
						console.log( response );
						$('body').find('.woostify-template-wrapper').html( response );
					},
				}
			);

			});

		});


		// Show Preview template
		$('body').on('click', '.woostify-template-library-template-preview', function (e) {
			var theme = $(this);
			var btnBack = $('body').find('#woostify-template-library-header-preview-back');
			var action = $('body').find('#woostify-template-library-header-tools');

			var id = theme.parents('.woostify-tempalte-item').attr('data-id');
			var type = theme.parents('.woostify-tempalte-item').attr('data-type');
			var page = theme.parents('.woostify-tempalte-item').data('page');
			console.log(type );
			var data     = {
				action: 'woostify_get_template',//woostify_modal_template
				id: id,
				type: type,
				page: page,
				_ajax_nonce: admin.nonce,
			};

			$.ajax(
				{
					type: 'GET',
					url: admin.url,
					data: data,
					beforeSend: function (response) {
						$( action ).find('.elementor-templates-modal__header__item').prop("disabled",true);

					},
					success: function (response) {
						btnBack.css( 'display', 'block' );
						btnBack.siblings().css( 'display', 'none' );
						action.css( 'display', 'block' );
						$('.woostify-sites-modal').find('.elementor-templates-modal__header__menu-area').css('display', 'none');
						// $('body').find('#wooostify-template-library-templates-container').html(response);woostify-widget-content
						$('body').find('.woostify-widget-content').html(response);
						$( action ).find('.elementor-templates-modal__header__item').prop("disabled",false);
					},
				}
			);
		});

		// Show list page
		$( 'body' ).on( 'click', '.elementor-type-pages', function (e) {
			var theme = $(this);
			var id = theme.parents('.woostify-tempalte-item').attr('data-id');
			var type = theme.parents('.woostify-tempalte-item').attr('data-type');
			showListPage(id, type);
		} );

		$( 'body' ).on( 'click', '#woostify-template-library-header-preview-back', function (e) {
			var btn = $(this);
			var step = btn.attr('step');
			var type;
			if ( step == 2 ) {
				type = btn.parents('.elementor-templates-modal__header').find('.elementor-active').data('tab');
				showTemplate(type);
			}
			if ( step == 3 ) {
				var type = $('body').find('#woostify-demo-type').val();
				if ( type != 'pages' ) {
					showTemplate(type);
				} else {
					var id = $('body').find('#woostify-demo-data').val();
					showListPage(id, type);
				}
			}
		} );

		// Close modal template
		$('body').on( 'click', '.woostify-close-button', function (e) {
			$( '#woostify-sites-modal' ).css('display', 'none');
		} );

		$( 'body' ).on( 'change', '.woostify-favorite-template-input', function (e) {
			console.log( $(this) );
			var btn = $(this);
			var value = $(this).val();
			var data     = {
				action: 'woostify_wishlist_template',//woostify_wishlist_template
				value: value,
				_ajax_nonce: admin.nonce,
			};

			$.ajax(
				{
					type: 'GET',
					url: admin.url,
					data: data,
					success: function (response) {
						if ( response.success == true ) {
							var icon = btn.siblings('.favorite-label').find('span');
							if ( icon.hasClass('eicon-heart') ) {
								icon.removeClass('eicon-heart');
								icon.addClass('eicon-heart-o');
							} else {
								icon.removeClass('eicon-heart-o');
								icon.addClass('eicon-heart');
							}
						}
					},
				}
			);
		} );

		$( 'body' ).on( 'click', '.woostify-link-favorite', function (e) {
			e.preventDefault();
			var data     = {
				action: 'woostify_list_favorite',//woostify_favotite
				_ajax_nonce: admin.nonce,
			};

			$.ajax(
				{
					type: 'GET',
					url: admin.url,
					data: data,
					success: function (response) {
						console.log(response);
						$( '#woostify-sites-modal' ).html( response );
					},
				}
			);
		});

		function showTemplate(type, tab = null) {
			var data     = {
				action: 'woostify_modal_template',//woostify_modal_template
				type: type,
				_ajax_nonce: admin.nonce,
			};

			$.ajax(
				{
					type: 'GET',
					url: admin.url,
					data: data,
					beforeSend: function (response) {
					},
					success: function (response) {
						$( '#woostify-sites-modal' ).css('display', 'block');
						$( '#woostify-sites-modal' ).html( response );
						if ( tab ) {
							tab.parent().find('.elementor-active').removeClass('active');
							tab.addClass('active');
						}
					},
				}
			);
		};

		function showListPage(id, type) {
			var data     = {
				action: 'woostify_list_child_page',//woostify_modal_template
				id: id,
				type: type,
				_ajax_nonce: admin.nonce,
			};
			$.ajax(
				{
					type: 'POST',
					url: admin.url,
					data: data,
					success: function (response) {
						$('body').find('.woostify-widget-content').html(response);
					},
				}
			);
		}
	}

})(jQuery);