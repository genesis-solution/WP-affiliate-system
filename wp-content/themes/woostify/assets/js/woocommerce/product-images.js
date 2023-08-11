/**
 * Product images
 *
 * @package woostify
 */

/* global woostify_product_images_slider_options, woostify_variation_gallery, woostify_default_gallery */

'use strict';
if ( typeof woostifyEvent == 'undefined' ){
	var woostifyEvent = {};
	woostifyEvent.carouselActionReady = [];
} 
var galleries = document.querySelectorAll( '.product-gallery' );

// Sticky summary for list layout.
function woostifyStickySummary(gallery) {
	if ( ! woostify_woocommerce_general.enabled_sticky_product_summary ) {
		return;
	}
	var summary = document.body.classList.contains('has-gallery-list-layout ') ? gallery.querySelector( '.product-summary' ) : false;
	if ( ! summary || window.innerWidth < 992 ) {
		return;
	}

	if ( gallery.offsetHeight <= summary.offsetHeight ) {
		return;
	}

	var sidebarStickCmnKy = new WSYSticky(
		'.summary.entry-summary',
		{
			stickyContainer: '.product-page-container',
			marginTop: parseInt( woostify_woocommerce_general.sticky_top_space ),
			marginBottom: parseInt( woostify_woocommerce_general.sticky_bottom_space )
		}
	);

	// Update sticky when found variation.
	jQuery( 'form.variations_form' ).on(
		'found_variation',
		function() {
			sidebarStickCmnKy.update();
		}
	);
	return sidebarStickCmnKy;
}
// Load event.
window.addEventListener(
	'load',
	function() {
		if( galleries) {
			galleries.forEach( function( gallery, index ){
				woostifyStickySummary(gallery);
			});
			setTimeout(
				function() {
					window.dispatchEvent( new Event( 'resize' ) );
				},
				200
			);
		}
	}
);

function renderSlider( element, _options ) {
	if( !element ) return false;
	if( element.classList.contains('flickity-enabled') ) {
		return false
	}
	var items = element.querySelectorAll( _options.cellSelector);
	if( items.length < 2 ) {
		return false;
	}
	return new Flickity( element, _options );
}

/**
 * Class WoostifyGallery
 */
class WoostifyGallery {
	constructor(selector, options) {
	  	// Các thuộc tính được khởi tạo khi tạo đối tượng WoostifyGallery
		var gallery = this;
		if (typeof selector === 'string') {
			selector = document.querySelector( selector );
	  	}
		gallery.el = selector;
		gallery.mobileSlider = {};
		gallery.imageCarousel = {};
		gallery.thumbCarousel = {};
		gallery.options = options; // Reference object.
		gallery.sliderOptions = { ...options.main}; // Shallow clone object.
		gallery.thumbOptions = { ...options.thumb}; // Shallow clone object.
		
		gallery.init();
		return gallery;

	}
	
	// Phương thức để khởi tạo và hiển thị gallery
	init() {
		var gallery = this;
		var galleryElement = gallery.el;
		// gallery.thumbOptions.container = galleryElement.querySelector(gallery.thumbOptions.container);
		// gallery.thumbOptions.asNavFor = galleryElement.querySelector(gallery.thumbOptions.asNavFor);
		// gallery.sliderOptions.container = galleryElement.querySelector( gallery.sliderOptions.container );

		gallery.productThumbnails = gallery.getProductThumbnails();
		gallery.checkDragable();
		gallery.noSliderLayout    = ( galleryElement.classList.contains( 'column-style' ) || galleryElement.classList.contains( 'grid-style' ) );
		gallery.prevBtn = document.createElement( "button" );
		gallery.nextBtn = document.createElement( "button" );
		
		gallery.initSlider();
		gallery.events();
	}

	initSlider(){
		var gallery = this;
		var galleryElement = gallery.el;
		if ( ! gallery.noSliderLayout ) {
			gallery.productThumbnails = gallery.getProductThumbnails();
			if ( !gallery.productThumbnails ) {
				return false;
			}
			gallery.sliderOptions.on = {
				ready: function() {
					gallery.changeImageCarouselButtonIcon( );
					gallery.calculateVerticalSliderHeight( );
				}
			}

			gallery.imageCarousel = gallery.renderSlider( gallery.sliderOptions.container, gallery.sliderOptions );
			gallery.galleryThumbnailCarousel();


		}else{
			gallery.woostifyGalleryCarouselMobile();
		}

		// Re-init easyzoom.
		if ( 'function' === typeof( easyZoomHandle ) ) {
			easyZoomHandle();
		}

		// Re-init Photo Swipe.
		if ( 'function' === typeof( initPhotoSwipe ) ) {
			initPhotoSwipe( '.product-images-container' );
		}

		setTimeout(
			function() {
				window.dispatchEvent( new Event( 'resize' ) );
			},
			200
		);

	}
	
	// RENDER
	// Carousel widget.
	renderSlider( element, _options ) {
		if( !element ) return false;
		return new Flickity( element, _options );
	}


	// Create product images item.
	createImages( fullSrc, src, size ) {
		var item  = '<figure class="image-item ez-zoom" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">';
			item += '<a href=' + fullSrc + ' data-size=' + size + ' itemprop="contentUrl" data-elementor-open-lightbox="no">';
			item += '<img src=' + src + ' itemprop="thumbnail">';
			item += '</a>';
			item += '</figure>';

		return item;
	}
	// Create product thumbnails item.
	createThumbnails( src ) {
		var item  = '<div class="thumbnail-item">';
			item += '<img src="' + src + '">';
			item += '</div>';

		return item;
	}

	changeImageCarouselButtonIcon(  ) {
		var galleryElement = this.el;
		var imageNextBtn = galleryElement.querySelector( '.flickity-button.next' );
		var imagePrevBtn = galleryElement.querySelector( '.flickity-button.previous' );

		if ( imageNextBtn ) {
			imageNextBtn.innerHTML = this.options.next_icon;
		}

		if ( imagePrevBtn ) {
			imagePrevBtn.innerHTML = this.options.prev_icon;
		}
	}
	
	woostifyGalleryCarouselMobile(){
		var gallery = this;
		var galleryElement = gallery.el;
		var mobileGallery = galleryElement.querySelector( '.has-gallery-list-layout .product-gallery.has-product-thumbnails' );
		if ( ! mobileGallery || window.innerWidth > 991 ) {
			return;
		}
		gallery.sliderOptions.on   = {
			ready: function() {
				gallery.changeImageCarouselButtonIcon( );
			}
		}
		gallery.mobileSlider = new Flickity( galleryElement.querySelector('.product-images-container'), gallery.sliderOptions );

	}

	/**
	 * VerticalSliderMaxHeight = height of product image
	 * @returns void
	 */
	calculateVerticalSliderHeight(){
		var gallery = this;
		var galleryElement = gallery.el;
		if ( !( window.matchMedia( '( min-width: 768px )' ).matches && galleryElement.classList.contains( 'vertical-style' ) ) ) {
			return;
		}
		var currFirstImage = galleryElement.querySelector( '.image-item img' );
		gallery._setVerticalSliderHeight(currFirstImage); // Set cho lần đầu

		gallery.waitImageLoad(currFirstImage, (loadedImg) => { // setheight mỗi lần re_init slider
			gallery._setVerticalSliderHeight(loadedImg);
		}).then((loadedImg) => {
			// 'Image loaded successfully' + loadedImg.src);
		}).catch((err) => {
			console.error('Error loading image', err);
		});
		

	}
	
	// Function nay duoc goi tu calculateVerticalSliderHeight. khong nen goi truc tiep ma khong kiem tra dieu kien
	_setVerticalSliderHeight( img ){
		var imgHeight = img ? img.offsetHeight : 0;
		var productThumbnails = this.getProductThumbnails();
		if ( imgHeight ) {
			productThumbnails.style.maxHeight = imgHeight + 'px';
		}
	}

	// Function check image is loaded.
	isImageOk( img ){
		if (!img.complete) {
			return false;
		}
		if (typeof img.naturalWidth != "undefined" && img.naturalWidth == 0) {
			return false;
		}
		return true;
	}

	async waitImageLoad_v2(img, callback) {
		var check = 0;
		var intv = 0;
		intv = setInterval( function () {
			if ( IsImageOk( img ) && check < 20 ) {
				var imgHeight = img ? img.offsetHeight : 0;
				if ( imgHeight ) {
					_setVerticalSliderHeight(img);
				}
				clearInterval( intv );
			}
			check++;
		}, 200);
	}

	async waitImageLoad(img, callback) {
		return new Promise((resolve, reject) => {
			img.addEventListener('load', () => {
			callback(img);
			resolve(img);
			});
			img.addEventListener('error', reject);
		});
	}

	galleryThumbnailCarousel(){
		if( ! this.horizontalThumbnailCarousel() ) { // Nếu đã có cái này thì khỏi chạy cái kia
			this.verticalThumbnailCarousel();
		}
	}

	verticalThumbnailCarousel(){
		var gallery = this;
		var galleryElement = gallery.el;
		var productThumbnails = gallery.getProductThumbnails();
		if ( ! productThumbnails ) {
			return;
		}
		var thumbOptions = gallery.thumbOptions;

		if ( window.matchMedia( '( max-width: 767px )' ).matches ) {
			gallery.thumbCarousel = new Flickity( productThumbnails, thumbOptions );
		} else {
			if ( galleryElement.classList.contains( 'vertical-style' ) ) {
				gallery.calculateVerticalSliderHeight(); // Huynh them vao
				gallery.verticalThumbnailSliderAction(gallery);
				gallery.addThumbButtons( );
			} else {
				gallery.thumbCarousel = new Flickity(productThumbnails, thumbOptions );
			}
		}

	}

	verticalThumbnailSliderAction(){
		var gallery = this;
		var productThumbnails = gallery.getProductThumbnails();
		var thumbNavImages = productThumbnails.querySelectorAll( '.thumbnail-item' );
		var imageCarousel = gallery.imageCarousel;

		thumbNavImages[0].classList.add( 'is-nav-selected' );
		thumbNavImages[0].classList.add( 'is-selected' );

		thumbNavImages.forEach(
			function( thumbNavImg, thumbIndex ) {
				thumbNavImg.addEventListener(
					'click',
					function() {
						imageCarousel.select( thumbIndex );
					}
				);
			}
		);

		var thumbImgHeight = 0 < imageCarousel.selectedIndex ? thumbNavImages[imageCarousel.selectedIndex].offsetHeight : thumbNavImages[0].offsetHeight;
		var thumbHeight    = productThumbnails.offsetHeight;

		imageCarousel.on(
			'change',
			function() {
				productThumbnails.querySelectorAll( '.thumbnail-item' ).forEach(
					function( thumb ) {
						thumb.classList.remove( 'is-nav-selected', 'is-selected' );
					}
				)

				var selected = 0 <= imageCarousel.selectedIndex ? thumbNavImages[ imageCarousel.selectedIndex ] : thumbNavImages[ 0 ];
				selected.classList.add( 'is-nav-selected', 'is-selected' );

				var scrollY = selected.offsetTop + productThumbnails.scrollTop - ( thumbHeight + thumbImgHeight ) / 2;
				productThumbnails.scrollTo(
					{
						top: scrollY,
						behavior: 'smooth',
					}
				);
			}
		);
	}
	addThumbButtons(){
		var gallery = this;
		var galleryElement = gallery.el;

		var productThumbnails = gallery.getProductThumbnails();
		var productThumbnailsWrapper = productThumbnails.parentElement;
		gallery.prevBtn.classList.add( 'thumb-btn', 'thumb-prev-btn', 'prev' );
		gallery.prevBtn.innerHTML = gallery.options.vertical_prev_icon;

		gallery.nextBtn.classList.add( 'thumb-btn', 'thumb-next-btn', 'next' );
		gallery.nextBtn.innerHTML = gallery.options.vertical_next_icon;

		productThumbnailsWrapper.appendChild( gallery.prevBtn );
		productThumbnailsWrapper.appendChild( gallery.nextBtn )
		
		gallery.displayThumbButtons();
		gallery.changeImageCarouselButtonEvents();

	}

	displayThumbButtons() {
		var gallery = this;
		var productThumbnails = gallery.getProductThumbnails();
		var thumbs            = productThumbnails.querySelectorAll( '.thumbnail-item' );
		var totalThumbHeight = 0;
		if ( thumbs.length ) {
			thumbs.forEach(
				function( thumb ) {
					var thumbHeight   = thumb.offsetHeight;
					thumbHeight      += parseInt( window.getComputedStyle( thumb ).getPropertyValue( 'margin-top' ) );
					thumbHeight      += parseInt( window.getComputedStyle( thumb ).getPropertyValue( 'margin-bottom' ) );
					totalThumbHeight += thumbHeight;
				}
			)
		}

		if ( totalThumbHeight > productThumbnails.offsetHeight ) {
			productThumbnails.classList.add( 'has-buttons' );
			gallery.nextBtn.style.display = 'block';
			gallery.prevBtn.style.display = 'block';
		} else {
			productThumbnails.classList.remove( 'has-buttons' );
			gallery.nextBtn.style.display = 'none';
			gallery.prevBtn.style.display = 'none';
		}
	}

	horizontalThumbnailCarousel(){
		var gallery = this;
		var galleryElement = gallery.el;
		var result = false;
		gallery.productThumbnails = gallery.getProductThumbnails();
		if ( ! gallery.productThumbnails ) {
			return;
		}
		var productThumbnails = gallery.productThumbnails;
		var thumbCarousel = gallery.thumbCarousel;
		var thumbOptions = gallery.thumbOptions;		

		if ( ( galleryElement.classList.contains( 'horizontal-style' ) || window.matchMedia( '( max-width: 767px )' ).matches ) ) {
			var thumbEls   = productThumbnails.querySelectorAll( '.thumbnail-item' );
			var totalWidth = 0;
			if ( thumbEls.length ) {
				thumbEls.forEach(
					function( thumbEl ) {
						var thumbWidth = thumbEl.offsetWidth;
						thumbWidth    += parseInt( window.getComputedStyle( thumbEl ).getPropertyValue( 'margin-left' ) );
						thumbWidth    += parseInt( window.getComputedStyle( thumbEl ).getPropertyValue( 'margin-right' ) );
						totalWidth    += thumbWidth;
					}
				);
			}

			if ( totalWidth >= productThumbnails.offsetWidth ) {
				thumbOptions.groupCells = '60%';
				thumbOptions.wrapAround = true;
			} else {
				thumbOptions.groupCells = '3';
				thumbOptions.wrapAround = false;
			}
			if ( thumbCarousel && thumbCarousel.slider ) {
				thumbCarousel.destroy();
			}
			gallery.thumbCarousel = new Flickity( gallery.productThumbnails, thumbOptions );
			result = true;
		}
		return result;
	}

	// Reset carousel.
	resetCarousel() {
		var gallery = this;
		if( (!(gallery.imageCarousel)) && (!(gallery.imageCarousel.slider||0))){
			imageCarousel.select( 0 )
		}
		if( (!(gallery.mobileSlider)) && (!(gallery.mobileSlider.slider||0))){
			mobileSlider.select( 0 )
		}
	}

	updateGallery( data, reset, variationId  ){
		var gallery = this;
		var galleryElement = gallery.el;

		if ( ! data.length || document.documentElement.classList.contains( 'quick-view-open' ) ) {
			return;
		}
		var images     = '',
			thumbnails = '',
			imageCarousel = gallery.imageCarousel||{},
			thumbCarousel = gallery.thumbCarousel||{},
			mobileSlider = gallery.mobileSlider||{};

		for ( var i = 0, j = data.length; i < j; i++ ) {
			if ( reset ) {
				// For reset variation.
				var size = data[i].full_src_w + 'x' + data[i].full_src_h;

				images     += gallery.createImages( data[i].full_src, data[i].src, size );
				thumbnails += ( data.length > 1) ? gallery.createThumbnails( data[i].gallery_thumbnail_src ) : '';
			} else if ( variationId && variationId == data[i][0].variation_id ) {
				// Render new item for new Slider.
				if ( 1 >= ( data[i].length - 1 ) ) {
					thumbnails = '';
					for ( var x = 1, y = data[i].length; x < y; x++ ) {
						var size = data[i][x].full_src_w + 'x' + data[i][x].full_src_h;
						images  += gallery.createImages( data[i][x].full_src, data[i][x].src, size );
					}
				} else {
					for ( var x = 1, y = data[i].length; x < y; x++ ) {
						var size    = data[i][x].full_src_w + 'x' + data[i][x].full_src_h;
						images     += gallery.createImages( data[i][x].full_src, data[i][x].src, size );
						thumbnails += (data[i].length > 1) ? gallery.createThumbnails( data[i][x].gallery_thumbnail_src ) : '';
					}
				}
			}
		}
		console.log( imageCarousel );
		if ( imageCarousel && imageCarousel.slider ) {
			imageCarousel.destroy();
		}

		if ( thumbCarousel && thumbCarousel.slider ) {
			thumbCarousel.destroy();
		}

		if ( mobileSlider && mobileSlider.slider ) {
			mobileSlider.destroy();
		}

		// Append new markup html.
		if ( images && galleryElement.querySelector( '.product-images' ) ) {
			galleryElement.querySelector( '.product-images' ).querySelector( '.product-images-container' ).innerHTML = images;
		}

		if ( galleryElement.querySelector( '.product-thumbnail-images' ) ) {
			if ( '' !== thumbnails ) {
				var productThumbnailsWrapper = galleryElement.querySelector( '.product-thumbnail-images' ).querySelector( '.product-thumbnail-images-container' );

				if ( ! productThumbnailsWrapper ) {
					productThumbnailsWrapper = document.createElement( 'div' );
					productThumbnailsWrapper.classList.add('product-thumbnail-images-container' );
				}
				productThumbnailsWrapper.classList.remove('flickity-enabled');
				galleryElement.querySelector( '.product-thumbnail-images' ).innerHTML = '';
				galleryElement.querySelector( '.product-thumbnail-images' ).appendChild( productThumbnailsWrapper ).innerHTML = thumbnails;

				if ( galleryElement.querySelector( '.product-gallery' )) {
					galleryElement.querySelector( '.product-gallery' ).classList.add( 'has-product-thumbnails' );
				}

				if ( galleryElement.classList.contains( 'product-gallery' )) {
					galleryElement.classList.add( 'has-product-thumbnails' );
				}
			} else {
				galleryElement.querySelector( '.product-thumbnail-images' ).innerHTML = '';
			}
		}

		gallery.initSlider();

	}
	//END RENDER FUNCTIONS



	// UPDATE OPTIONS
	checkDragable(){
		if ( window.matchMedia( '( min-width: 768px )' ).matches &&
			this.el.classList.contains( 'vertical-style' )
		) {
			this.thumbOptions.draggable = false;
		}
	}

	getProductThumbnails(){
		var gallery = this;
		var galleryElement = gallery.el;
		if( (typeof this.thumbOptions.asNavFor == 'string') && (galleryElement.querySelector(gallery.thumbOptions.asNavFor)) ){
			gallery.thumbOptions.asNavFor = galleryElement.querySelector(gallery.thumbOptions.asNavFor);
		}
		
		if( (typeof this.sliderOptions.container == 'string') && (galleryElement.querySelector(gallery.sliderOptions.container)) ){
			gallery.sliderOptions.container = galleryElement.querySelector(gallery.sliderOptions.container);
		}

		if( (typeof this.thumbOptions.container == 'string') && (galleryElement.querySelector(gallery.thumbOptions.container)) ){
			gallery.thumbOptions.container = galleryElement.querySelector(gallery.thumbOptions.container);
		}
		if( typeof this.thumbOptions.container == 'string' ) return false;
		return this.thumbOptions.container;
	}
	events(){
		var gallery = this;
		var galleryElement = gallery.el;

		// Resize
		window.addEventListener(
			'resize',
			function(){
				gallery.checkDragable();
			}
		);

		// imageCarousel next previous
		gallery.changeImageCarouselButtonEvents();

		// Listen reset_variations event. 
		gallery.listenResetVariations();

		// Listen found_variation event. 
		gallery.listenFoundVariations();
	}

	changeImageCarouselButtonEvents(){
		var gallery = this;
		var galleryElement = gallery.el;
		var thumbButtons = galleryElement.querySelectorAll( '.thumb-btn' );
		if ( thumbButtons.length ) {
			thumbButtons.forEach(
				function( thumbBtn ) {
					thumbBtn.addEventListener(
						'click',
						function() {
							var currBtn = this;
							if ( currBtn.classList.contains( 'prev' ) ) {
								gallery.imageCarousel.previous();
							} else {
								gallery.imageCarousel.next();
							}
						}
					)
				}
			)
		}
	}

	listenFoundVariations(){
		var gallery = this;
		var galleryElement = gallery.el;
		gallery.listEvents = gallery.listEvents || {};
		if( gallery.listEvents.found_variation||0 ) {
			return;
		}
		jQuery( 'form.variations_form' ).on(
			'found_variation',
			function( e, variation ) {
				if ( 'undefined' !== typeof( woostify_variation_gallery ) && woostify_variation_gallery.length ) {
					gallery.updateGallery( woostify_variation_gallery, false, variation.variation_id );
				}else{
					// check if Woostify_Variation_Swatches_Frontend is exists
					if( variation.variation_gallery_images || 0 ){
						var thumbs = galleryElement.querySelector( '.product-thumbnail-images' );

						// Neu chi co 1 image trong gallery và image nay trung voi product variation image thi coi nhu k co.
						var has_gallery = ( ( variation.variation_gallery_images.length > 1 ) || (variation.variation_gallery_images.length && variation.image && variation.variation_gallery_images[0]['full_src'] != variation.image['full_src'] ) );
						if( has_gallery ) {
							gallery.updateGallery(variation.variation_gallery_images, true, variation.variation_id );
							if( thumbs ) {
								thumbs.classList.add( 'variation-gallery' );
							}
						} else {
							// Draw gallery default.
							if ( 'undefined' !== typeof( woostify_default_gallery ) && woostify_default_gallery.length ) {
								var images = [];
								if( variation.image||0 ) {
									images.push( variation.image );
									// Function forEach: array.forEach(function(currentValue, index, arr), thisValue).
									woostify_default_gallery.forEach( function( item, index, default_gallery ) {
										// this = images
										if( index ) images.push( item );
									}, images );
								}
								else{
									images = woostify_default_gallery;
								}
								gallery.updateGallery( gallery, images, true );
								if( thumbs ) {
									thumbs.classList.remove( 'variation-gallery' );
								}
							}
						}
					}
				}
			}
		);
		gallery.listEvents.found_variation = 1;
	}

	listenResetVariations(){
		var gallery = this;
		var galleryElement = gallery.el;
		gallery.listEvents = gallery.listEvents||{};
		if( gallery.listEvents.reset_variations||0 ) {
			return;
		}
		jQuery( '.reset_variations' ).on(
			'click',
			function(){
				if ( 'undefined' !== typeof( woostify_default_gallery ) && woostify_default_gallery.length ) {
					gallery.updateGallery( woostify_default_gallery, true );
					if( galleryElement.querySelector( '.product-thumbnail-images' ) ) {
						galleryElement.querySelector( '.product-thumbnail-images').classList.remove( 'variation-gallery' );
					}
				}

				gallery.resetCarousel();

				// Update slider height.
				setTimeout(
					function() {
						window.dispatchEvent( new Event( 'resize' ) );
					},
					200
				);

				if ( document.body.classList.contains( 'elementor-editor-active' ) || document.body.classList.contains( 'elementor-editor-preview' ) ) {
					if ( ! galleryElement.querySelector( '.product-thumbnail-images-container' ) ) {
						galleryElement.querySelector( '.product-gallery' ).classList.remove( 'has-product-thumbnails' );
					}
				}

			}
		);
		gallery.listEvents.reset_variations = true;
	}


} // End Class

var woostifyGalleries = [];
document.addEventListener(
	'DOMContentLoaded',
	function(){
		if( (woostifyEvent.productImagesReady||0 ) ){
			return;
		}
		galleries.forEach( function( galleryElement, index ){
			var gallery = new WoostifyGallery( galleryElement, woostify_product_images_slider_options);
			woostifyGalleries.push( gallery );
		});

		// For Elementor Preview Mode.
		if ( 'function' === typeof( onElementorLoaded ) ) {
			onElementorLoaded(
				function() {
					window.elementorFrontend.hooks.addAction(
						'frontend/element_ready/global',
						function() {
							setTimeout( function(){
								var galleries = document.querySelectorAll( '.product-gallery' );
								galleries.forEach( function( galleryElement, index ){
									renderSlider( galleryElement.querySelector( woostify_product_images_slider_options.main.container ), woostify_product_images_slider_options);
								});
							}, 200);
						}
					);
				}
			);
		}

		woostifyEvent.productImagesReady = 1;
	}
);