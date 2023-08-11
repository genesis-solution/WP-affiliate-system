/**
 * General JS
 *
 * @package Woostify
 */

// Get all Prev element siblings.
var prevSiblings = function( target ) {
	var siblings = [],
		n        = target;

	while ( n = n.previousElementSibling ) {
		siblings.push( n );
	}

	return siblings;
}

// Get all Next element siblings.
var nextSiblings = function( target ) {
	var siblings = [],
		n        = target;

	while ( n = n.nextElementSibling ) {
		siblings.push( n );
	}

	return siblings;
}

// Get all element siblings.
var siblings = function( target ) {
	var prev = prevSiblings( target ) || [],
		next = nextSiblings( target ) || [];

	return prev.concat( next );
}

// SECTION TAB SETTINGS.
var woostifyWelcomeTabSettings = function() {
	var section = document.querySelector( '.woostify-welcome-settings-section-tab' );
	if ( ! section ) {
		return;
	}

	var button = section.querySelectorAll( '.tab-head-button' );
	if ( ! button.length ) {
		return;
	}

	button.forEach(
		function( element ) {
			element.onclick = function() {
				var id          = element.hash ? element.hash.substr( 1 ) : '',
					idSiblings  = siblings( element ),
					tab         = section.querySelector( '.woostify-setting-tab-content[data-tab="' + id + '"]' ),
					tabSiblings = siblings( tab );

				// Active current tab heading.
				element.classList.add( 'active' );
				if ( idSiblings.length ) {
					idSiblings.forEach(
						function( el ) {
							el.classList.remove( 'active' );
						}
					);
				}

				// Active current tab content.
				tab.classList.add( 'active' );
				if ( tabSiblings.length ) {
					tabSiblings.forEach(
						function( el ) {
							el.classList.remove( 'active' );
						}
					);
				}
			}
		}
	);

	// Trigger first click. Active tab.
	window.addEventListener(
		'load',
		function() {
			var currentTab = section.querySelector( 'a[href="' + window.location.hash + '"]' ),
				generalTab = section.querySelector( 'a[href="#dashboard"]' );

			if ( currentTab ) {
				currentTab.click();
			} else if ( generalTab ) {
				generalTab.click();
			}
		}
	);
}

var woostifyMoveWordpressUpdateVersionNotice = function() {
	var notice = document.querySelector( '.update-nag' );
	if ( ! notice ) {
		return;
	}

	var notice_clone = notice.cloneNode( true );
	var notices_wrap = document.querySelector( '.woostify-notices-wrap' );

	if ( ! notices_wrap ) {
		return;
	}

	notice.remove();
	notices_wrap.prepend( notice_clone );
}

// Show all module info
var showAllModuleInfo = function () {
	var showallbutton  		   = document.querySelector('.module-info-view-all-addon-btn');
	var moduleinfoviewalladdon = document.querySelector('.module-info-view-all-addon');  
	var moduleinfolist         = document.querySelector('.woostify-module-info-list');

	if ( !showallbutton && moduleinfoviewalladdon != 'null' && moduleinfolist != 'null' ) {
		return;
	}

	moduleinfoviewalladdon.classList.remove('hiden');
	moduleinfolist.classList.remove('active');

	showallbutton.addEventListener(
		'click',
		function (event) {
			event.preventDefault();
			moduleinfoviewalladdon.classList.add('hiden');
			moduleinfolist.classList.add('active');			
		}
	);

}

// Changelog
var showChangelogTheme = function () {
	var woostify_changelog = document.querySelector('.changelog-woostify-wrapper'); 

	if ( ! woostify_changelog ) {
		return;
	}

	var changelog_version = woostify_changelog.querySelectorAll( '.changelog-woostify-version' );
	var page_numbers = woostify_changelog.querySelectorAll('.page-numbers'); 

	page_numbers.forEach(
		function (item, index) {
			var page_number  = item.querySelectorAll( '.page-number' );
			var product_id   = item.getAttribute('data-changelog-product');
			var per_page     = item.getAttribute('data-per-page');
			var total_pages  = item.getAttribute( 'data-total-pages' );
			var page_pre     = item.querySelector('.page-pre');
			var page_next    = item.querySelector('.page-next');
			var dots         = item.querySelector('.dots');
			var page_current = item.querySelector('.page-number.active');

			page_number.forEach(
				function (element) {
					element.onclick = function() {
						var page_siblings = siblings( element );
						var page = this.getAttribute( 'data-page-number' );
						page = parseFloat(page);
		
						page_current = this;
						element.classList.add( 'active' );
						var n = 1;
						if ( page_siblings.length ) {
							page_siblings.forEach(
								function( el ) {
									el.classList.remove( 'active' );
									el.classList.remove( 'actived' );
								}
							);
							for (var i = 1; i <= 5 ; i++) {
								if (n <= 5) {
		
									if (page - i > 0 && item.children[page - i]) {
										item.children[page - i].classList.add( 'actived' );
										n++;
									}
		
									if (item.children[page + i - 1]) {
										item.children[page + i - 1].classList.add( 'actived' );
										n++;
									}

								}
							}
							
							if ( page - 1 != 0) {
								page_pre.classList.remove( 'disable' );
							}else{
								page_pre.classList.add( 'disable' );
							}

							if ( parseFloat( total_pages ) - page >= 2) {
								page_next.classList.remove( 'disable' );
							}else{
								page_next.classList.add( 'disable' );
							}

							if ( parseFloat( total_pages ) - page <= 2 ) {
								dots.classList.add( 'hide' );
							}else{
								dots.classList.remove( 'hide' );
							}
						}
		
						// Request.
						var request = new Request(
							ajaxurl,
							{
								method: 'POST',
								body: 'action=changelog_pagination&page=' + parseInt(page) + '&per_page=' + per_page + '&product_id=' + product_id + '&ajax_nonce=' + woostify_install_demo.ajax_nonce,
								credentials: 'same-origin',
								headers: new Headers(
									{
										'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8'
									}
								)
							}
						);
						
						// Add .loading class
						changelog_version[index].classList.add('loading');
		
						// Fetch API.
						fetch( request )
						.then(
							function( res ) {
								if ( 200 !== res.status ) {
									console.log( 'Status Code: ' + res.status );
									return;
								}
							
								res.json().then(
									function( r ) {
										if ( ! r.success ) {
											return;
										}
										
										if ( r.data.length == 0 ) {
											return;
										}
		
										console.log(r.data);
										var content = '';
										var monthNames = ["January", "February", "March", "April", "May", "June",
										"July", "August", "September", "October", "November", "December"
										];
										r.data.forEach(
											function (value, index) {
												var date = new Date(value.date);
												var day = date.getDay();
												var month = monthNames[date.getMonth()];
												var year = date.getFullYear();
		
												content += '<li class="changelog-item">';
												content += '<div class="changelog-version-heading">';
												content += 	'<span>'+value.title.rendered+'</span>';
												content += 	'<span class="changelog-version-date">'+month+ ' '+ day +', ' + year+'</span>';
												content += '</div>';
												content += '<div class="changelog-version-content">';
												content += 		value.content.rendered;
												content += '</div>';
												content += '</li>';
											}
										);
		
										changelog_version[index].innerHTML = content;
			
									}
								);
							}
						).finally(
							function() {
								// Remove .loading class
								changelog_version[index].classList.remove('loading');
							}
						);
					}
				}
			);
			
			// Pre page
			page_pre.addEventListener(
				'click',
				function () {					
					var page = parseFloat( page_current.getAttribute( 'data-page-number' ) );
				
					page -= 1;

					if ( page == 0 ) {
						return;
					}

					page_current = item.children[page];

					var page_siblings = siblings( page_current );
					var n = 1;

					page_current.classList.add( 'active' );
					if ( page_siblings.length ) {
						page_siblings.forEach(
							function( el ) {
								el.classList.remove( 'active' );
								el.classList.remove( 'actived' );
							}
						);
						for (var i = 1; i <= 5 ; i++) {
							if (n <= 5) {
	
								if (page - i > 0 && item.children[page - i]) {
									item.children[page - i].classList.add( 'actived' );
									n++;
								}
	
								if (item.children[page + i - 1]) {
									item.children[page + i - 1].classList.add( 'actived' );
									n++;
								}

							}
						}
						
						if ( page - 1 != 0) {
							page_pre.classList.remove( 'disable' );
						}else{
							page_pre.classList.add( 'disable' );
						}

						if ( parseFloat( total_pages ) - page >= 2) {
							page_next.classList.remove( 'disable' );
						}else{
							page_next.classList.add( 'disable' );
						}

						if ( parseFloat(dots.getAttribute('data-last-pages')) - page >= 2 ) {
							dots.classList.add( 'hide' );
						}else{
							dots.classList.remove( 'hide' );
						}
					}

					// Request.
					var request = new Request(
						ajaxurl,
						{
							method: 'POST',
							body: 'action=changelog_pagination&page=' + parseInt(page) + '&per_page=' + per_page + '&product_id=' + product_id + '&ajax_nonce=' + woostify_pro_dashboard.ajax_nonce,
							credentials: 'same-origin',
							headers: new Headers(
								{
									'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8'
								}
							)
						}
					);
					
					// Add .loading class
					changelog_version[index].classList.add('loading');

					// Fetch API.
					fetch( request )
					.then(
						function( res ) {
							if ( 200 !== res.status ) {
								console.log( 'Status Code: ' + res.status );
								return;
							}
						
							res.json().then(
								function( r ) {
									if ( ! r.success ) {
										return;
									}
									
									if ( r.data.length == 0 ) {
										return;
									}
	
									console.log(r.data);
									var content = '';
									var monthNames = ["January", "February", "March", "April", "May", "June",
									"July", "August", "September", "October", "November", "December"
									];
									r.data.forEach(
										function (value, index) {
											var date = new Date(value.date);
											var day = date.getDay();
											var month = monthNames[date.getMonth()];
											var year = date.getFullYear();
	
											content += '<li class="changelog-item">';
											content += '<div class="changelog-version-heading">';
											content += 	'<span>'+value.title.rendered+'</span>';
											content += 	'<span class="changelog-version-date">'+month+ ' '+ day +', ' + year+'</span>';
											content += '</div>';
											content += '<div class="changelog-version-content">';
											content += 		value.content.rendered;
											content += '</div>';
											content += '</li>';
										}
									);
	
									changelog_version[index].innerHTML = content;
		
								}
							);
						}
					).finally(
						function() {
							// Remove .loading class
							changelog_version[index].classList.remove('loading');
						}
					);

				}
			);
			
			// Next page
			page_next.addEventListener(
				'click',
				function () {
					var page = parseFloat( page_current.getAttribute( 'data-page-number' ) );

					page += 1;

					if ( parseFloat( total_pages ) - page == 0 ) {
						return;
					}

					page_current = item.children[page];

					var page_siblings = siblings( page_current );
					var n = 1;

					page_current.classList.add( 'active' );
					if ( page_siblings.length ) {
						page_siblings.forEach(
							function( el ) {
								el.classList.remove( 'active' );
								el.classList.remove( 'actived' );
							}
						);
						for (var i = 1; i <= 5 ; i++) {
							if (n <= 5) {
	
								if (page - i > 0 && item.children[page - i]) {
									item.children[page - i].classList.add( 'actived' );
									n++;
								}
	
								if (item.children[page + i - 1]) {
									item.children[page + i - 1].classList.add( 'actived' );
									n++;
								}

							}
						}
						
						if ( page - 1 != 0) {
							page_pre.classList.remove( 'disable' );
						}else{
							page_pre.classList.add( 'disable' );
						}

						if ( parseFloat( total_pages ) - page >= 2) {
							page_next.classList.remove( 'disable' );
						}else{
							page_next.classList.add( 'disable' );
						}

						if ( parseFloat(dots.getAttribute('data-last-pages')) - page >= 2 ) {
							dots.classList.add( 'hide' );
						}else{
							dots.classList.remove( 'hide' );
						}
					}

					// Request.
					var request = new Request(
						ajaxurl,
						{
							method: 'POST',
							body: 'action=changelog_pagination&page=' + parseInt(page) + '&per_page=' + per_page + '&product_id=' + product_id + '&ajax_nonce=' + woostify_pro_dashboard.ajax_nonce,
							credentials: 'same-origin',
							headers: new Headers(
								{
									'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8'
								}
							)
						}
					);

					// Add .loading class
					changelog_version[index].classList.add('loading');

					// Fetch API.
					fetch( request )
					.then(
						function( res ) {
							if ( 200 !== res.status ) {
								console.log( 'Status Code: ' + res.status );
								return;
							}
						
							res.json().then(
								function( r ) {
									if ( ! r.success ) {
										return;
									}
									
									if ( r.data.length == 0 ) {
										return;
									}
	
									console.log(r.data);
									var content = '';
									var monthNames = ["January", "February", "March", "April", "May", "June",
									"July", "August", "September", "October", "November", "December"
									];
									r.data.forEach(
										function (value, index) {
											var date = new Date(value.date);
											var day = date.getDay();
											var month = monthNames[date.getMonth()];
											var year = date.getFullYear();
	
											content += '<li class="changelog-item">';
											content += '<div class="changelog-version-heading">';
											content += 	'<span>'+value.title.rendered+'</span>';
											content += 	'<span class="changelog-version-date">'+month+ ' '+ day +', ' + year+'</span>';
											content += '</div>';
											content += '<div class="changelog-version-content">';
											content += 		value.content.rendered;
											content += '</div>';
											content += '</li>';
										}
									);
	
									changelog_version[index].innerHTML = content;
		
								}
							);
						}
					).finally(
						function() {
							// Remove .loading class
							changelog_version[index].classList.remove('loading');
						}
					);

				}
			);

		}
	);


}

document.addEventListener(
	'DOMContentLoaded',
	function() {
		woostifyWelcomeTabSettings();
		woostifyMoveWordpressUpdateVersionNotice();
		showAllModuleInfo();
		showChangelogTheme();
	}
);
