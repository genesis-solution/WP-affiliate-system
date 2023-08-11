<?php
/**
 * Define the demo import files (local files).
 *
 * You have to use the same filter as in above example,
 * but with a slightly different array keys: local_*.
 * The values have to be absolute paths (not URLs) to your import files.
 * To use local import files, that reside in your theme folder,
 * please use the below code.
 * Note: make sure your import files are readable!
 */
function woostify_sites_local_import_files() {
	return array(
		array(
			'id'                           => 0,
			'import_file_name'             => 'Fashion',
			'local_import_file'            => WOOSTIFY_SITES_DIR . 'demos/demo-1/demo-content.xml',
			'local_import_widget_file'     => WOOSTIFY_SITES_DIR . 'demos/demo-1/widgets.wie',
			'local_import_customizer_file' => WOOSTIFY_SITES_DIR . 'demos/demo-1/customizer.dat',
			'import_preview_image_url'     => WOOSTIFY_SITES_URI . 'demos/demo-1/demo-11.jpg',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately.', 'woostify' ),
			'preview_url'                  => 'https://demo.woostify.com/fashion1/',
			'homepage'                     => 'Fashion',
			'blog_page'                    => 'Blog',
			'primary_menu'                 => 'Header Primary',
			'footer_menu'                  => 'Footer',
			'type'                         => 'free',
			'page_builder'                 => 'elementor',
			'font_page'                    => 13,
			'page'                         => array(
				'13' => array(
					'title'   => 'Home',
					'id'      => 13,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-1/demo-11.jpg',

				),
				'201' => array(
					'title'   => 'Contact',
					'id'      => 201,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-1/contact.png',
				),
			),
		),
		array(
			'id'                           => 1,
			'import_file_name'             => 'Yoga',
			'local_import_file'            => WOOSTIFY_SITES_DIR . 'demos/demo-2/demo-content.xml',
			'local_import_widget_file'     => WOOSTIFY_SITES_DIR . 'demos/demo-2/widgets.wie',
			'local_import_customizer_file' => WOOSTIFY_SITES_DIR . 'demos/demo-2/customizer.dat',
			'import_preview_image_url'     => WOOSTIFY_SITES_URI . 'demos/demo-2/demo-2.jpg',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately.', 'woostify' ),
			'preview_url'                  => 'https://demo.woostify.com/fashion2/',
			'homepage'                     => 'Woostify',
			'blog_page'                    => 'Blog',
			'primary_menu'                 => 'Primary Menu',
			'footer_menu'                  => 'Footer Menu',
			'type'                         => 'pro',
			'page_builder'                 => 'elementor',
			'font_page'                    => 11,
			'page'                         => array(
				'11' => array(
					'title'   => 'Home',
					'id'      => 11,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-2/demo-2.jpg',

				),
				'201' => array(
					'title'   => 'Contact',
					'id'      => 201,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-2/contact.jpg',
				),
				'199' => array(
					'title'   => 'About Us',
					'id'      => 199,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-2/about.jpg',
				),
			),
		),
		array(
			'id'                           => 2,
			'import_file_name'             => 'Vogue - Fashion',
			'local_import_file'            => WOOSTIFY_SITES_DIR . 'demos/demo-3/demo-content.xml',
			'local_import_widget_file'     => WOOSTIFY_SITES_DIR . 'demos/demo-3/widgets.wie',
			'local_import_customizer_file' => WOOSTIFY_SITES_DIR . 'demos/demo-3/customizer.dat',
			'import_preview_image_url'     => WOOSTIFY_SITES_URI . 'demos/demo-3/demo-3.jpg',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately.', 'woostify' ),
			'preview_url'                  => 'https://demo.woostify.com/fashion3/',
			'homepage'                     => 'Woostify',
			'blog_page'                    => 'Blog',
			'primary_menu'                 => 'Primary Menu',
			'footer_menu'                  => 'Footer Menu',
			'type'                         => 'pro',
			'page_builder'                 => 'elementor',
			'font_page'                    => 11,
			'page'                         => array(
				'11' => array(
					'title'   => 'Home',
					'id'      => 11,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-3/demo-3.jpg',

				),
				'201' => array(
					'title'   => 'Contact',
					'id'      => 201,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-3/contact.jpg',
				),
				'199' => array(
					'title'   => 'About Us',
					'id'      => 199,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-3/about.jpg',
				),
			),
		),
		array(
			'id'                           => 3,
			'import_file_name'             => 'Lensvision - sunglasses',
			'local_import_file'            => WOOSTIFY_SITES_DIR . 'demos/demo-4/demo-content.xml',
			'local_import_widget_file'     => WOOSTIFY_SITES_DIR . 'demos/demo-4/widgets.wie',
			'local_import_customizer_file' => WOOSTIFY_SITES_DIR . 'demos/demo-4/customizer.dat',
			'import_preview_image_url'     => WOOSTIFY_SITES_URI . 'demos/demo-4/demo-4.jpg',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately.', 'woostify' ),
			'preview_url'                  => 'https://demo.woostify.com/fashion4/',
			'homepage'                     => 'Woostify',
			'blog_page'                    => 'Blog',
			'primary_menu'                 => 'Primary Menu',
			'footer_menu'                  => 'Footer Menu',
			'type'                         => 'pro',
			'page_builder'                 => 'elementor',
			'font_page'                    => 11,
			'page'                         => array(
				'11' => array(
					'title'   => 'Home',
					'id'      => 11,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-4/demo-4.jpg',

				),
				'201' => array(
					'title'   => 'Contact',
					'id'      => 201,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-4/contact.jpg',
				),
				'199' => array(
					'title'   => 'About Us',
					'id'      => 199,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-4/about.jpg',
				),
			),
		),
		array(
			'id'                           => 4,
			'import_file_name'             => 'Shoebox',
			'local_import_file'            => WOOSTIFY_SITES_DIR . 'demos/demo-5/demo-content.xml',
			'local_import_widget_file'     => WOOSTIFY_SITES_DIR . 'demos/demo-5/widgets.wie',
			'local_import_customizer_file' => WOOSTIFY_SITES_DIR . 'demos/demo-5/customizer.dat',
			'import_preview_image_url'     => WOOSTIFY_SITES_URI . 'demos/demo-5/demo-5.jpg',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately.', 'woostify' ),
			'preview_url'                  => 'https://demo.woostify.com/',
			'homepage'                     => 'Woostify',
			'blog_page'                    => 'Blog',
			'primary_menu'                 => 'Primary Menu',
			'footer_menu'                  => 'Footer Menu',
			'type'                         => 'pro',
			'page_builder'                 => 'elementor',
			'font_page'                    => 886,
			'page'                         => array(
				'886' => array(
					'title'   => 'Home',
					'id'      => 886,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-5/demo-5.jpg',

				),
				'201' => array(
					'title'   => 'Contact',
					'id'      => 201,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-5/contact.jpg',
				),
				'199' => array(
					'title'   => 'About Us',
					'id'      => 199,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-5/about.jpg',
				),
			),
		),
		array(
			'id'                           => 5,
			'import_file_name'             => 'Cosmetica - Cosmetic',
			'local_import_file'            => WOOSTIFY_SITES_DIR . 'demos/demo-6/demo-content.xml',
			'local_import_widget_file'     => WOOSTIFY_SITES_DIR . 'demos/demo-6/widgets.wie',
			'local_import_customizer_file' => WOOSTIFY_SITES_DIR . 'demos/demo-6/customizer.dat',
			'import_preview_image_url'     => WOOSTIFY_SITES_URI . 'demos/demo-6/demo-6.png',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately.', 'woostify' ),
			'preview_url'                  => 'https://demo.woostify.com/cosmetica/',
			'homepage'                     => 'Woostify',
			'blog_page'                    => 'Blog',
			'primary_menu'                 => 'Primary Menu',
			'footer_menu'                  => 'Footer Menu',
			'type'                         => 'pro',
			'page_builder'                 => 'elementor',
			'font_page'                    => 11,
			'page'                         => array(
				'11' => array(
					'title'   => 'Home',
					'id'      => 11,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-6/demo-6.png',

				),
				'201' => array(
					'title'   => 'Contact',
					'id'      => 201,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-6/contact.jpg',
				),
				'199' => array(
					'title'   => 'About Us',
					'id'      => 199,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-6/about.jpg',
				),
			),
		),
		array(
			'id'                           => 6,
			'import_file_name'             => 'Ankle - Fashion',
			'local_import_file'            => WOOSTIFY_SITES_DIR . 'demos/demo-7/demo-content.xml',
			'local_import_widget_file'     => WOOSTIFY_SITES_DIR . 'demos/demo-7/widgets.wie',
			'local_import_customizer_file' => WOOSTIFY_SITES_DIR . 'demos/demo-7/customizer.dat',
			'import_preview_image_url'     => WOOSTIFY_SITES_URI . 'demos/demo-7/demo-7.png',
			'import_notice'                => __( 'After you import this demo, you should update permalink.', 'woostify' ),
			'preview_url'                  => 'https://demo.woostify.com/ankle/',
			'homepage'                     => 'Homepage',
			'blog_page'                    => 'Blog',
			'primary_menu'                 => 'main menu',
			'footer_menu'                  => '',
			'type'                         => 'pro',
			'page_builder'                 => 'elementor',
			'font_page'                    => 896,
			'page'                         => array(
				'896' => array(
					'title'   => 'Home',
					'id'      => 896,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-7/demo-7.png',

				),
				'790' => array(
					'title'   => 'Contact',
					'id'      => 790,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-7/contact.jpg',
				),
				'740' => array(
					'title'   => 'About Us',
					'id'      => 740,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-7/about.jpg',
				),
			),
		),
		array(
			'id'                           => 7,
			'import_file_name'             => 'Pezshop - Pet Care',
			'local_import_file'            => WOOSTIFY_SITES_DIR . 'demos/demo-8/demo-content.xml',
			'local_import_widget_file'     => WOOSTIFY_SITES_DIR . 'demos/demo-8/widgets.wie',
			'local_import_customizer_file' => WOOSTIFY_SITES_DIR . 'demos/demo-8/customizer.dat',
			'import_preview_image_url'     => WOOSTIFY_SITES_URI . 'demos/demo-8/demo-7.png',
			'import_notice'                => __( 'After you import this demo, you should update permalink.', 'woostify' ),
			'preview_url'                  => 'https://demo.woostify.com/pezshop/',
			'homepage'                     => 'Woostify',
			'blog_page'                    => 'Blog',
			'primary_menu'                 => 'Primary Menu',
			'footer_menu'                  => 'Footer Menu',
			'type'                         => 'pro',
			'page_builder'                 => 'elementor',
			'font_page'                    => 11,
			'page'                         => array(
				'11' => array(
					'title'   => 'Home',
					'id'      => 11,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-8/demo-7.png',

				),
				'201' => array(
					'title'   => 'Contact',
					'id'      => 201,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-8/contact.jpg',
				),
				'199' => array(
					'title'   => 'About Us',
					'id'      => 199,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-8/about.jpg',
				),
			),
		),
		array(
			'id'                           => 8,
			'import_file_name'             => 'Watch - Watch Shop',
			'local_import_file'            => WOOSTIFY_SITES_DIR . 'demos/demo-9/demo-content.xml',
			'local_import_widget_file'     => WOOSTIFY_SITES_DIR . 'demos/demo-9/widgets.wie',
			'local_import_customizer_file' => WOOSTIFY_SITES_DIR . 'demos/demo-9/customizer.dat',
			'import_preview_image_url'     => WOOSTIFY_SITES_URI . 'demos/demo-9/demo-9.png',
			'import_notice'                => __( 'After you import this demo, you should update permalink.', 'woostify' ),
			'preview_url'                  => 'https://demo.woostify.com/watch/',
			'homepage'                     => 'Homepage',
			'blog_page'                    => 'Blog',
			'primary_menu'                 => 'Main Menu',
			'footer_menu'                  => '',
			'type'                         => 'pro',
			'page_builder'                 => 'elementor',
			'font_page'                    => 1403,
			'page'                         => array(
				'1403' => array(
					'title'   => 'Home',
					'id'      => 1403,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-9/demo-9.png',

				),
				'790' => array(
					'title'   => 'Contact',
					'id'      => 790,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-9/contact.jpg',
				),
				'740' => array(
					'title'   => 'About Us',
					'id'      => 740,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-9/about.jpg',
				),
			),
		),
		array(
			'id'                           => 9,
			'import_file_name'             => 'Hippine - Jewelry',
			'local_import_file'            => WOOSTIFY_SITES_DIR . 'demos/demo-10/demo-content.xml',
			'local_import_widget_file'     => WOOSTIFY_SITES_DIR . 'demos/demo-10/widgets.wie',
			'local_import_customizer_file' => WOOSTIFY_SITES_DIR . 'demos/demo-10/customizer.dat',
			'import_preview_image_url'     => WOOSTIFY_SITES_URI . 'demos/demo-10/demo-10.png',
			'import_notice'                => __( 'After you import this demo, you should update permalink.', 'woostify' ),
			'preview_url'                  => 'https://demo.woostify.com/hippine/',
			'homepage'                     => 'Homepage',
			'blog_page'                    => 'Blog',
			'primary_menu'                 => 'main menu',
			'footer_menu'                  => '',
			'type'                         => 'pro',
			'page_builder'                 => 'elementor',
			'font_page'                    => 1600,
			'page'                         => array(
				'1600' => array(
					'title'   => 'Home',
					'id'      => 1600,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-10/demo-10.png',

				),
				'790' => array(
					'title'   => 'Contact',
					'id'      => 790,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-10/contact.jpg',
				),
				'740' => array(
					'title'   => 'About Us',
					'id'      => 740,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-10/about.jpg',
				),
			),
		),
		array(
			'id'                           => 10,
			'import_file_name'             => 'Furnito - Furniture',
			'local_import_file'            => WOOSTIFY_SITES_DIR . 'demos/demo-11/demo-content.xml',
			'local_import_widget_file'     => WOOSTIFY_SITES_DIR . 'demos/demo-11/widgets.wie',
			'local_import_customizer_file' => WOOSTIFY_SITES_DIR . 'demos/demo-11/customizer.dat',
			'import_preview_image_url'     => WOOSTIFY_SITES_URI . 'demos/demo-11/demo-11.png',
			'import_notice'                => __( 'After you import this demo, you should update permalink.', 'woostify' ),
			'preview_url'                  => 'https://demo.woostify.com/furnito/',
			'homepage'                     => 'Woostify',
			'blog_page'                    => 'Blog',
			'primary_menu'                 => 'Primary Menu',
			'footer_menu'                  => 'Footer Menu',
			'type'                         => 'pro',
			'page_builder'                 => 'elementor',
			'font_page'                    => 11,
			'page'                         => array(
				'11' => array(
					'title'   => 'Home',
					'id'      => 11,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-11/demo-11.png',

				),
				'201' => array(
					'title'   => 'Contact',
					'id'      => 201,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-11/contact.jpg',
				),
				'199' => array(
					'title'   => 'About Us',
					'id'      => 199,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-11/about.jpg',
				),
			),
		),
		array(
			'id'                           => 11,
			'import_file_name'             => 'Pizza',
			'local_import_file'            => WOOSTIFY_SITES_DIR . 'demos/demo-12/demo-content.xml',
			'local_import_widget_file'     => WOOSTIFY_SITES_DIR . 'demos/demo-12/widgets.wie',
			'local_import_customizer_file' => WOOSTIFY_SITES_DIR . 'demos/demo-12/customizer.dat',
			'import_preview_image_url'     => WOOSTIFY_SITES_URI . 'demos/demo-12/demo-12.png',
			'import_notice'                => __( 'After you import this demo, you should update permalink.', 'woostify' ),
			'preview_url'                  => 'https://demo.woostify.com/pizza/',
			'homepage'                     => 'Woostify',
			'blog_page'                    => 'Blog',
			'primary_menu'                 => 'Primary Menu',
			'footer_menu'                  => 'Footer Menu',
			'type'                         => 'pro',
			'page_builder'                 => 'elementor',
			'font_page'                    => 11,
			'page'                         => array(
				'11' => array(
					'title'   => 'Home',
					'id'      => 11,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-12/demo-12.png',

				),
				'201' => array(
					'title'   => 'Contact',
					'id'      => 201,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-12/contact.jpg',
				),
				'199' => array(
					'title'   => 'About Us',
					'id'      => 199,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-12/about.jpg',
				),
			),
		),
		array(
			'id'                           => 12,
			'import_file_name'             => 'Urbanstyle',
			'local_import_file'            => WOOSTIFY_SITES_DIR . 'demos/demo-13/demo-content.xml',
			'local_import_widget_file'     => WOOSTIFY_SITES_DIR . 'demos/demo-13/widgets.wie',
			'local_import_customizer_file' => WOOSTIFY_SITES_DIR . 'demos/demo-13/customizer.dat',
			'import_preview_image_url'     => WOOSTIFY_SITES_URI . 'demos/demo-13/demo-13.png',
			'import_notice'                => __( 'After you import this demo, you should update permalink.', 'woostify' ),
			'preview_url'                  => 'https://demo.woostify.com/urbanstyle/',
			'homepage'                     => 'Fashion',
			'blog_page'                    => 'Blog',
			'primary_menu'                 => 'Header Primary',
			'footer_menu'                  => 'Footer',
			'type'                         => 'free',
			'page_builder'                 => 'elementor',
			'font_page'                    => 13,
			'page'                         => array(
				'13' => array(
					'title'   => 'Home',
					'id'      => 13,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-13/demo-13.png',

				),
				'201' => array(
					'title'   => 'Contact',
					'id'      => 201,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-13/contact.jpg',
				),
			),
		),
		array(
			'id'                           => 13,
			'import_file_name'             => 'Randy',
			'local_import_file'            => WOOSTIFY_SITES_DIR . 'demos/demo-14/demo-content.xml',
			'local_import_widget_file'     => WOOSTIFY_SITES_DIR . 'demos/demo-14/widgets.wie',
			'local_import_customizer_file' => WOOSTIFY_SITES_DIR . 'demos/demo-14/customizer.dat',
			'import_preview_image_url'     => WOOSTIFY_SITES_URI . 'demos/demo-14/demo-14.png',
			'import_notice'                => __( 'After you import this demo, you should update permalink.', 'woostify' ),
			'preview_url'                  => 'https://demo.woostify.com/randy/',
			'homepage'                     => 'Woostify',
			'blog_page'                    => 'Blog',
			'primary_menu'                 => 'Primary Menu',
			'footer_menu'                  => 'Footer Menu',
			'type'                         => 'pro',
			'page_builder'                 => 'elementor',
			'font_page'                    => 11,
			'page'                         => array(
				'11' => array(
					'title'   => 'Home',
					'id'      => 11,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-14/demo-14.png',

				),
				'201' => array(
					'title'   => 'Contact',
					'id'      => 201,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-14/contact.jpg',
				),
				'1347' => array(
					'title'   => 'About Us',
					'id'      => 1347,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-14/about.jpg',
				),
			),

		),
		array(
			'id'                           => 14,
			'import_file_name'             => 'Mega Shop',
			'local_import_file'            => WOOSTIFY_SITES_DIR . 'demos/demo-15/demo-content.xml',
			'local_import_widget_file'     => WOOSTIFY_SITES_DIR . 'demos/demo-15/widgets.wie',
			'local_import_customizer_file' => WOOSTIFY_SITES_DIR . 'demos/demo-15/customizer.dat',
			'import_preview_image_url'     => WOOSTIFY_SITES_URI . 'demos/demo-15/demo-15.png',
			'import_notice'                => __( 'After you import this demo, you should update permalink.', 'woostify' ),
			'preview_url'                  => 'https://demo.woostify.com/megashop/',
			'homepage'                     => 'Woostify',
			'blog_page'                    => 'Blog',
			'primary_menu'                 => 'Primary Menu',
			'vertical_menu'                => 'Menu Vertical',
			'footer_menu'                  => 'Footer Menu',
			'type'                         => 'pro',
			'page_builder'                 => 'elementor',
			'font_page'                    => 11,
			'page'                         => array(
				'11' => array(
					'title'   => 'Home',
					'id'      => 11,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-15/demo-15.png',

				),
				'201' => array(
					'title'   => 'Contact',
					'id'      => 201,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-15/contact.jpg',
				),
				'1347' => array(
					'title'   => 'About Us',
					'id'      => 1347,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-15/about.jpg',
				),
			),
		),
		array(
			'id'                           => 15,
			'import_file_name'             => 'Auto Car',
			'local_import_file'            => WOOSTIFY_SITES_DIR . 'demos/demo-16/demo-content.xml',
			'local_import_widget_file'     => WOOSTIFY_SITES_DIR . 'demos/demo-16/widgets.wie',
			'local_import_customizer_file' => WOOSTIFY_SITES_DIR . 'demos/demo-16/customizer.dat',
			'import_preview_image_url'     => WOOSTIFY_SITES_URI . 'demos/demo-16/demo-16.png',
			'import_notice'                => __( 'After you import this demo, you should update permalink.', 'woostify' ),
			'preview_url'                  => 'https://demo.woostify.com/autocar/',
			'homepage'                     => 'Home',
			'blog_page'                    => 'Blog',
			'primary_menu'                 => 'Primary Menu',
			'vertical_menu'                => 'Menu Vertical',
			'type'                         => 'pro',
			'page_builder'                 => 'elementor',
			'font_page'                    => 556,
			'page'                         => array(
				'556' => array(
					'title'   => 'Home',
					'id'      => 556,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-16/demo-16.png',

				),
				'473' => array(
					'title'   => 'Contact',
					'id'      => 473,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-16/contact.jpg',
				),
				'398' => array(
					'title'   => 'About Us',
					'id'      => 398,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-16/about.jpg',
				),
			),
		),
		array(
			'id'                           => 16,
			'import_file_name'             => 'Meins',
			'local_import_file'            => WOOSTIFY_SITES_DIR . 'demos/demo-17/demo-content.xml',
			'local_import_widget_file'     => WOOSTIFY_SITES_DIR . 'demos/demo-17/widgets.wie',
			'local_import_customizer_file' => WOOSTIFY_SITES_DIR . 'demos/demo-17/customizer.dat',
			'import_preview_image_url'     => WOOSTIFY_SITES_URI . 'demos/demo-17/demo-17.png',
			'import_notice'                => __( 'After you import this demo, you should update permalink.', 'woostify' ),
			'preview_url'                  => 'https://demo.woostify.com/meins/',
			'homepage'                     => 'Home',
			'blog_page'                    => 'Blog',
			'primary_menu'                 => 'Primary Menu',
			'type'                         => 'pro',
			'page_builder'                 => 'elementor',
			'font_page'                    => 182,
			'page'                         => array(
				'182' => array(
					'title'   => 'Home',
					'id'      => 182,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-17/demo-17.png',

				),
				'305' => array(
					'title'   => 'Contact',
					'id'      => 305,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-17/contact.jpg',
				),
				'232' => array(
					'title'   => 'About Us',
					'id'      => 232,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-17/about.jpg',
				),
			),
		),

		array(
			'id'                           => 17,
			'import_file_name'             => 'Haute',
			'local_import_file'            => WOOSTIFY_SITES_DIR . 'demos/demo-18/demo-content.xml',
			'local_import_widget_file'     => WOOSTIFY_SITES_DIR . 'demos/demo-18/widgets.wie',
			'local_import_customizer_file' => WOOSTIFY_SITES_DIR . 'demos/demo-18/customizer.dat',
			'import_preview_image_url'     => WOOSTIFY_SITES_URI . 'demos/demo-18/demo-18.png',
			'import_notice'                => __( 'After you import this demo, you should update permalink.', 'woostify' ),
			'preview_url'                  => 'https://demo.woostify.com/haute/',
			'homepage'                     => 'Fashion',
			'blog_page'                    => 'Blog',
			'primary_menu'                 => 'Header Primary',
			'type'                         => 'free',
			'page_builder'                 => 'elementor',
			'font_page'                    => 13,
			'page'                         => array(
				'13' => array(
					'title'   => 'Home',
					'id'      => 13,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-18/demo-18.png',

				),
				'201' => array(
					'title'   => 'Contact',
					'id'      => 201,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-18/contact.jpg',
				),
			),
		),

		array(
			'id'                           => 18,
			'import_file_name'             => 'Orgifarm',
			'local_import_file'            => WOOSTIFY_SITES_DIR . 'demos/demo-19/demo-content.xml',
			'local_import_widget_file'     => WOOSTIFY_SITES_DIR . 'demos/demo-19/widgets.wie',
			'local_import_customizer_file' => WOOSTIFY_SITES_DIR . 'demos/demo-19/customizer.dat',
			'import_preview_image_url'     => WOOSTIFY_SITES_URI . 'demos/demo-19/demo-19.png',
			'import_notice'                => __( 'After you import this demo, you should update permalink.', 'woostify' ),
			'preview_url'                  => 'https://demo.woostify.com/freshio/',
			'homepage'                     => 'Homepage',
			'blog_page'                    => 'Blog',
			'primary_menu'                 => 'Primary Menu',
			'footer_menu'                  => 'Footer',
			'vertical_menu'                => 'Menu Vertical',
			'type'                         => 'pro',
			'page_builder'                 => 'elementor',
			'font_page'                    => 222,
			'page'                         => array(
				'222' => array(
					'title'   => 'Home',
					'id'      => 222,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-19/demo-19.png',

				),
				'1055' => array(
					'title'   => 'About',
					'id'      => 1055,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-19/about.jpg',
				),
				'1420' => array(
					'title'   => 'Contact',
					'id'      => 1420,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-19/contact.jpg',
				),
			),
		),

		array(
			'id'                           => 19,
			'import_file_name'             => 'Ditimal',
			'local_import_file'            => WOOSTIFY_SITES_DIR . 'demos/demo-20/demo-content.xml',
			'local_import_widget_file'     => WOOSTIFY_SITES_DIR . 'demos/demo-20/widgets.wie',
			'local_import_customizer_file' => WOOSTIFY_SITES_DIR . 'demos/demo-20/customizer.dat',
			'import_preview_image_url'     => WOOSTIFY_SITES_URI . 'demos/demo-20/demo-20.png',
			'import_notice'                => __( 'After you import this demo, you should update permalink.', 'woostify' ),
			'preview_url'                  => 'https://demo.woostify.com/ditimal/',
			'homepage'                     => 'Homepage',
			'blog_page'                    => 'Blog',
			'primary_menu'                 => 'main menu',
			'footer_menu'                  => '',
			'type'                         => 'pro',
			'page_builder'                 => 'elementor',
			'font_page'                    => 1600,
			'page'                         => array(
				'1600' => array(
					'title'   => 'Home',
					'id'      => 1600,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-20/demo-20.png',

				),
				'790' => array(
					'title'   => 'Contact',
					'id'      => 790,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-20/contact.jpg',
				),
				'740' => array(
					'title'   => 'About Us',
					'id'      => 740,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-20/about.jpg',
				),
			),
		),

		array(
			'id'                           => 20,
			'import_file_name'             => 'Fitdo',
			'local_import_file'            => WOOSTIFY_SITES_DIR . 'demos/demo-21/demo-content.xml',
			'local_import_widget_file'     => WOOSTIFY_SITES_DIR . 'demos/demo-21/widgets.wie',
			'local_import_customizer_file' => WOOSTIFY_SITES_DIR . 'demos/demo-21/customizer.dat',
			'import_preview_image_url'     => WOOSTIFY_SITES_URI . 'demos/demo-21/demo-21.png',
			'import_notice'                => __( 'After you import this demo, you should update permalink.', 'woostify' ),
			'preview_url'                  => 'https://demo.woostify.com/fitdo/',
			'homepage'                     => 'Homepage',
			'blog_page'                    => 'Blog',
			'primary_menu'                 => 'Main menu',
			'footer_menu'                  => '',
			'type'                         => 'pro',
			'page_builder'                 => 'elementor',
			'font_page'                    => 13,
			'page'                         => array(
				'13' => array(
					'title'   => 'Home',
					'id'      => 13,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-21/demo-21.png',

				),
				'443' => array(
					'title'   => 'Contact',
					'id'      => 443,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-21/contact.jpg',
				),
				'287' => array(
					'title'   => 'About Us',
					'id'      => 287,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-21/about.jpg',
				),
			),
		),

		array(
			'id'                           => 21,
			'import_file_name'             => 'Jery',
			'local_import_file'            => WOOSTIFY_SITES_DIR . 'demos/demo-22/demo-content.xml',
			'local_import_widget_file'     => WOOSTIFY_SITES_DIR . 'demos/demo-22/widgets.wie',
			'local_import_customizer_file' => WOOSTIFY_SITES_DIR . 'demos/demo-22/customizer.dat',
			'import_preview_image_url'     => WOOSTIFY_SITES_URI . 'demos/demo-22/demo-22.png',
			'import_notice'                => __( 'After you import this demo, you should update permalink.', 'woostify' ),
			'preview_url'                  => 'https://demo.woostify.com/jery/',
			'homepage'                     => 'Home',
			'blog_page'                    => 'Blog',
			'primary_menu'                 => 'Main menu',
			'footer_menu'                  => '',
			'type'                         => 'pro',
			'page_builder'                 => 'elementor',
			'font_page'                    => 62,
			'page'                         => array(
				'62' => array(
					'title'   => 'Home',
					'id'      => 62,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-22/demo-22.png',

				),
				'616' => array(
					'title'   => 'Contact',
					'id'      => 616,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-22/contact.jpg',
				),
				'614' => array(
					'title'   => 'About Us',
					'id'      => 614,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-22/about.jpg',
				),
			),
		),

		array(
			'id'                           => 22,
			'import_file_name'             => 'Kids',
			'local_import_file'            => WOOSTIFY_SITES_DIR . 'demos/demo-23/demo-content.xml',
			'local_import_widget_file'     => WOOSTIFY_SITES_DIR . 'demos/demo-23/widgets.wie',
			'local_import_customizer_file' => WOOSTIFY_SITES_DIR . 'demos/demo-23/customizer.dat',
			'import_preview_image_url'     => WOOSTIFY_SITES_URI . 'demos/demo-23/demo-23.png',
			'import_notice'                => __( 'After you import this demo, you should update permalink.', 'woostify' ),
			'preview_url'                  => 'https://demo.woostify.com/kids/',
			'homepage'                     => 'Home',
			'blog_page'                    => 'Blog',
			'primary_menu'                 => 'Primary Menu',
			'footer_menu'                  => '',
			'type'                         => 'pro',
			'page_builder'                 => 'elementor',
			'font_page'                    => 15,
			'page'                         => array(
				'15' => array(
					'title'   => 'Home',
					'id'      => 15,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-23/demo-23.png',

				),
				'733' => array(
					'title'   => 'Contact Us',
					'id'      => 733,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-23/contact.jpg',
				),
				'731' => array(
					'title'   => 'About Us',
					'id'      => 731,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-23/about.jpg',
				),
			),
		),

		array(
			'id'                           => 23,
			'import_file_name'             => 'Bakery',
			'local_import_file'            => WOOSTIFY_SITES_DIR . 'demos/demo-24/demo-content.xml',
			'local_import_widget_file'     => WOOSTIFY_SITES_DIR . 'demos/demo-24/widgets.wie',
			'local_import_customizer_file' => WOOSTIFY_SITES_DIR . 'demos/demo-24/customizer.dat',
			'import_preview_image_url'     => WOOSTIFY_SITES_URI . 'demos/demo-24/demo-24.png',
			'import_notice'                => __( 'After you import this demo, you should update permalink.', 'woostify' ),
			'preview_url'                  => 'https://demo.woostify.com/bakery/',
			'homepage'                     => 'Home',
			'blog_page'                    => 'Blog',
			'primary_menu'                 => 'Primary Menu',
			'footer_menu'                  => '',
			'type'                         => 'pro',
			'page_builder'                 => 'elementor',
			'font_page'                    => 13,
			'page'                         => array(
				'13' => array(
					'title'   => 'Home',
					'id'      => 13,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-24/demo-24.png',

				),
				'19' => array(
					'title'   => 'Contact Us',
					'id'      => 19,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-24/contact.jpg',
				),
				'17' => array(
					'title'   => 'About Us',
					'id'      => 17,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-24/about.jpg',
				),
			),
		),

		array(
			'id'                           => 24,
			'import_file_name'             => 'Bag',
			'local_import_file'            => WOOSTIFY_SITES_DIR . 'demos/demo-25/demo-content.xml',
			'local_import_widget_file'     => WOOSTIFY_SITES_DIR . 'demos/demo-25/widgets.wie',
			'local_import_customizer_file' => WOOSTIFY_SITES_DIR . 'demos/demo-25/customizer.dat',
			'import_preview_image_url'     => WOOSTIFY_SITES_URI . 'demos/demo-25/demo-25.png',
			'import_notice'                => __( 'After you import this demo, you should update permalink.', 'woostify' ),
			'preview_url'                  => 'https://demo.woostify.com/bag/',
			'homepage'                     => 'Home',
			'blog_page'                    => 'Blog',
			'primary_menu'                 => 'Primary Menu',
			'footer_menu'                  => '',
			'type'                         => 'pro',
			'page_builder'                 => 'elementor',
			'font_page'                    => 14,
			'page'                         => array(
				'14' => array(
					'title'   => 'Home',
					'id'      => 14,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-25/demo-25.png',

				),
				'18' => array(
					'title'   => 'Contact Us',
					'id'      => 18,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-25/contact.jpg',
				),
				'16' => array(
					'title'   => 'About Us',
					'id'      => 16,
					'preview' => WOOSTIFY_SITES_URI . 'demos/demo-25/about.jpg',
				),
			),
		),

	);
}
add_filter( 'woostify_sites_import_files', 'woostify_sites_local_import_files' );



function woostify_register_query_vars( $vars ) {
	$vars[] = 'p';
	return $vars;
}
add_filter( 'query_vars', 'woostify_register_query_vars' );


function woostify_sites_section() {
	return array(
		array(
			'id'                       => 0,
			'import_file_name'         => 'Banner v1',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v1.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner__free',
			'page_builder'             => 'elementor',
			'font_page'                => 4315,
		),

		array(
			'id'                       => 1,
			'import_file_name'         => 'Banner v2',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v4.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner__pro',
			'page_builder'             => 'elementor',
			'font_page'                => 4330,
		),

		array(
			'id'                       => 2,
			'import_file_name'         => 'Banner v3',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v7.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 4345,
		),

		array(
			'id'                       => 3,
			'import_file_name'         => 'Banner v4',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v13.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 4376,
		),

		array(
			'id'                       => 4,
			'import_file_name'         => 'Banner v5',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v15.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 4386,
		),

		array(
			'id'                       => 5,
			'import_file_name'         => 'Banner v6',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v19.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 4407,
		),

		array(
			'id'                       => 6,
			'import_file_name'         => 'Banner v7',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v21.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 4417,
		),

		array(
			'id'                       => 7,
			'import_file_name'         => 'Banner v8',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v31.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 4470,
		),

		array(
			'id'                       => 8,
			'import_file_name'         => 'Banner v9',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v43.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 4530,
		),

		array(
			'id'                       => 9,
			'import_file_name'         => 'Banner v10',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v44.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 4536,
		),

		array(
			'id'                       => 10,
			'import_file_name'         => 'Banner v11',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v47.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 4551,
		),

		array(
			'id'                       => 11,
			'import_file_name'         => 'Banner v12',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v52.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 4584,
		),

		array(
			'id'                       => 12,
			'import_file_name'         => 'Banner v13',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v58.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 4615,
		),
		array(
			'id'                       => 13,
			'import_file_name'         => 'Banner v14',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v61.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 4630,
		),

		array(
			'id'                       => 14,
			'import_file_name'         => 'Banner v15',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v62.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 4599,
		),

		array(
			'id'                       => 15,
			'import_file_name'         => 'Banner v16',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v63.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 4639,
		),

		array(
			'id'                       => 16,
			'import_file_name'         => 'Banner v17',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v71.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 4679,
		),

		array(
			'id'                       => 17,
			'import_file_name'         => 'Banner v18',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v78.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 4727,
		),

		array(
			'id'                       => 18,
			'import_file_name'         => 'Banner v19',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v89.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 4782,
		),

		array(
			'id'                       => 19,
			'import_file_name'         => 'Banner v20',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v90.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 4787,
		),

		array(
			'id'                       => 20,
			'import_file_name'         => 'Banner v21',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v92.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 4797,
		),

		array(
			'id'                       => 21,
			'import_file_name'         => 'Banner v22',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v104.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 4857,
		),

		array(
			'id'                       => 22,
			'import_file_name'         => 'Banner v23',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v106.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 4867,
		),

		array(
			'id'                       => 23,
			'import_file_name'         => 'Banner v24',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v114.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 5044,
		),

		array(
			'id'                       => 24,
			'import_file_name'         => 'Banner v25',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v120.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 5075,
		),

		array(
			'id'                       => 25,
			'import_file_name'         => 'Banner v26',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v121.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 5080,
		),

		array(
			'id'                       => 26,
			'import_file_name'         => 'Banner v27',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v122.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 5085,
		),

		array(
			'id'                       => 27,
			'import_file_name'         => 'Banner v28',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v126.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 5106,
		),

		array(
			'id'                       => 28,
			'import_file_name'         => 'Banner v29',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v129.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 5122,
		),

		array(
			'id'                       => 29,
			'import_file_name'         => 'Banner v30',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v130.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 5127,
		),

		array(
			'id'                       => 30,
			'import_file_name'         => 'Banner v31',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v131.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 5132,
		),

		array(
			'id'                       => 31,
			'import_file_name'         => 'Banner v32',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v134.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 5148,
		),

		array(
			'id'                       => 32,
			'import_file_name'         => 'Banner v33',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v135.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 5153,
		),

		array(
			'id'                       => 33,
			'import_file_name'         => 'Banner v34',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v136.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 5158,
		),

		array(
			'id'                       => 34,
			'import_file_name'         => 'Banner v35',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v137.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 5163,
		),

		array(
			'id'                       => 35,
			'import_file_name'         => 'Banner v36',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v139.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 5174,
		),

		array(
			'id'                       => 36,
			'import_file_name'         => 'Banner v37',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v140.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 5179,
		),

		array(
			'id'                       => 37,
			'import_file_name'         => 'Banner v38',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v144.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 5203,
		),

		array(
			'id'                       => 38,
			'import_file_name'         => 'Banner v39',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v145.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 5208,
		),

		array(
			'id'                       => 39,
			'import_file_name'         => 'Banner v40',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v146.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 5216,
		),

		array(
			'id'                       => 40,
			'import_file_name'         => 'Banner v41',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v147.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 5221,
		),

		array(
			'id'                       => 41,
			'import_file_name'         => 'Banner v42',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v156.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 5292,
		),

		array(
			'id'                       => 42,
			'import_file_name'         => 'Banner v43',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v159.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 5307,
		),

		array(
			'id'                       => 43,
			'import_file_name'         => 'Banner v44',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v161.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 5317,
		),

		array(
			'id'                       => 44,
			'import_file_name'         => 'Banner v45',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v165.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 5341,
		),

		array(
			'id'                       => 45,
			'import_file_name'         => 'Banner v46',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v166.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 5346,
		),

		array(
			'id'                       => 46,
			'import_file_name'         => 'Banner v47',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v170.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 5373,
		),

		array(
			'id'                       => 47,
			'import_file_name'         => 'Banner v48',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v174.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 5394,
		),

		array(
			'id'                       => 48,
			'import_file_name'         => 'Banner v49',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v176.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 5404,
		),

		array(
			'id'                       => 49,
			'import_file_name'         => 'Banner v50',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v177.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 5409,
		),

		array(
			'id'                       => 50,
			'import_file_name'         => 'Categories v1',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v2.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'categories',
			'page_builder'             => 'elementor',
			'font_page'                => 4320,
		),

		array(
			'id'                       => 51,
			'import_file_name'         => 'Categories v2',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v8.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'free',
			'page_builder'             => 'categories',
			'font_page'                => 4347,
		),

		array(
			'id'                       => 52,
			'import_file_name'         => 'Categories v3',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v12.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'categories',
			'page_builder'             => 'elementor',
			'font_page'                => 4371,
		),

		array(
			'id'                       => 53,
			'import_file_name'         => 'Categories v4',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v37.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'categories',
			'page_builder'             => 'elementor',
			'font_page'                => 4500,
		),

		array(
			'id'                       => 54,
			'import_file_name'         => 'Categories v5',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v42.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'categories',
			'page_builder'             => 'elementor',
			'font_page'                => 4525,
		),

		array(
			'id'                       => 55,
			'import_file_name'         => 'Categories v6',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v50.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'categories',
			'page_builder'             => 'elementor',
			'font_page'                => 4574,
		),

		array(
			'id'                       => 56,
			'import_file_name'         => 'Categories v7',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v54.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'categories',
			'page_builder'             => 'elementor',
			'font_page'                => 4594,
		),

		array(
			'id'                       => 57,
			'import_file_name'         => 'Categories v8',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v56.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'categories',
			'page_builder'             => 'elementor',
			'font_page'                => 4605,
		),

		array(
			'id'                       => 58,
			'import_file_name'         => 'Categories v9',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v69.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'categories',
			'page_builder'             => 'elementor',
			'font_page'                => 4669,
		),

		array(
			'id'                       => 59,
			'import_file_name'         => 'Categories v10',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v76.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'categories',
			'page_builder'             => 'elementor',
			'font_page'                => 4717,
		),

		array(
			'id'                       => 60,
			'import_file_name'         => 'Categories v11',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v82.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'categories',
			'page_builder'             => 'elementor',
			'font_page'                => 4742,
		),

		array(
			'id'                       => 61,
			'import_file_name'         => 'Categories v12',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v95.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'categories',
			'page_builder'             => 'elementor',
			'font_page'                => 4812,
		),

		array(
			'id'                       => 62,
			'import_file_name'         => 'Categories v13',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v103.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'categories',
			'page_builder'             => 'elementor',
			'font_page'                => 4852,
		),

		array(
			'id'                       => 63,
			'import_file_name'         => 'Categories v14',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v108.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'categories',
			'page_builder'             => 'elementor',
			'font_page'                => 4877,
		),

		array(
			'id'                       => 64,
			'import_file_name'         => 'Product v1',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v3.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'product',
			'page_builder'             => 'elementor',
			'font_page'                => 4325,
		),

		array(
			'id'                       => 65,
			'import_file_name'         => 'Product v2',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v9.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'product',
			'page_builder'             => 'elementor',
			'font_page'                => 4355,
		),

		array(
			'id'                       => 66,
			'import_file_name'         => 'Product v3',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v14.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'product',
			'page_builder'             => 'elementor',
			'font_page'                => 4381,
		),

		array(
			'id'                       => 67,
			'import_file_name'         => 'Product v4 ',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v16.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'product',
			'page_builder'             => 'elementor',
			'font_page'                => 4392,
		),

		array(
			'id'                       => 68,
			'import_file_name'         => 'Product v5',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v20.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'product',
			'page_builder'             => 'elementor',
			'font_page'                => 4412,
		),

		array(
			'id'                       => 69,
			'import_file_name'         => 'Product v6',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v30.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'product',
			'page_builder'             => 'elementor',
			'font_page'                => 4465,
		),

		array(
			'id'                       => 70,
			'import_file_name'         => 'Product v7',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v32.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'product',
			'page_builder'             => 'elementor',
			'font_page'                => 4475,
		),

		array(
			'id'                       => 71,
			'import_file_name'         => 'Product v8',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v36.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'product',
			'page_builder'             => 'elementor',
			'font_page'                => 4495,
		),

		array(
			'id'                       => 72,
			'import_file_name'         => 'Product v9',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v38.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'product',
			'page_builder'             => 'elementor',
			'font_page'                => 4505,
		),

		array(
			'id'                       => 73,
			'import_file_name'         => 'Product v10',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v45.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'product',
			'page_builder'             => 'elementor',
			'font_page'                => 4541,
		),

		array(
			'id'                       => 74,
			'import_file_name'         => 'Product v11',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v51.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'product',
			'page_builder'             => 'elementor',
			'font_page'                => 4576,
		),

		array(
			'id'                       => 75,
			'import_file_name'         => 'Product v12',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v53.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'product',
			'page_builder'             => 'elementor',
			'font_page'                => 4589,
		),

		array(
			'id'                       => 76,
			'import_file_name'         => 'Product v13',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v57.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'product',
			'page_builder'             => 'elementor',
			'font_page'                => 4610,
		),

		array(
			'id'                       => 77,
			'import_file_name'         => 'Product v14',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v64.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'product',
			'page_builder'             => 'elementor',
			'font_page'                => 4644,
		),

		array(
			'id'                       => 78,
			'import_file_name'         => 'Product v15',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v68.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'product',
			'page_builder'             => 'elementor',
			'font_page'                => 4664,
		),

		array(
			'id'                       => 79,
			'import_file_name'         => 'Product v16',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v70.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'product',
			'page_builder'             => 'elementor',
			'font_page'                => 4674,
		),

		array(
			'id'                       => 80,
			'import_file_name'         => 'Product v17',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v72.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'product',
			'page_builder'             => 'elementor',
			'font_page'                => 4684,
		),

		array(
			'id'                       => 81,
			'import_file_name'         => 'Product v18',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v77.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'product',
			'page_builder'             => 'elementor',
			'font_page'                => 4722,
		),

		array(
			'id'                       => 82,
			'import_file_name'         => 'Product v19',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v83.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'product',
			'page_builder'             => 'elementor',
			'font_page'                => 4752,
		),

		array(
			'id'                       => 83,
			'import_file_name'         => 'Product v20',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v88.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'product',
			'page_builder'             => 'elementor',
			'font_page'                => 4777,
		),

		array(
			'id'                       => 84,
			'import_file_name'         => 'Product v21',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v96.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'product',
			'page_builder'             => 'elementor',
			'font_page'                => 4817,
		),

		array(
			'id'                       => 85,
			'import_file_name'         => 'Product v22',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v98.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'product',
			'page_builder'             => 'elementor',
			'font_page'                => 4827,
		),

		array(
			'id'                       => 86,
			'import_file_name'         => 'Service v1',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v5.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'service',
			'page_builder'             => 'elementor',
			'font_page'                => 4335,
		),

		array(
			'id'                       => 87,
			'import_file_name'         => 'Service v2',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v24.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'service',
			'page_builder'             => 'elementor',
			'font_page'                => 4432,
		),

		array(
			'id'                       => 88,
			'import_file_name'         => 'Service v3',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v28.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'service',
			'page_builder'             => 'elementor',
			'font_page'                => 4455,
		),

		array(
			'id'                       => 89,
			'import_file_name'         => 'Service v4',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v41.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'service',
			'page_builder'             => 'elementor',
			'font_page'                => 4520,
		),

		array(
			'id'                       => 90,
			'import_file_name'         => 'Service v5',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v85.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'service',
			'page_builder'             => 'elementor',
			'font_page'                => 4762,
		),

		array(
			'id'                       => 91,
			'import_file_name'         => 'Service v6',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v107.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'service',
			'page_builder'             => 'elementor',
			'font_page'                => 4872,
		),

		array(
			'id'                       => 92,
			'import_file_name'         => 'Service v7',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v115.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'service',
			'page_builder'             => 'elementor',
			'font_page'                => 5049,
		),

		array(
			'id'                       => 93,
			'import_file_name'         => 'Service v8',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v151.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'service',
			'page_builder'             => 'elementor',
			'font_page'                => 5260,
		),

		array(
			'id'                       => 94,
			'import_file_name'         => 'Service v9',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v162.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'service',
			'page_builder'             => 'elementor',
			'font_page'                => 5322,
		),

		array(
			'id'                       => 95,
			'import_file_name'         => 'Instagram v1',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v6.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'instagram',
			'page_builder'             => 'elementor',
			'font_page'                => 4340,
		),

		array(
			'id'                       => 96,
			'import_file_name'         => 'Instagram v2',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v25.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'free',
			'page_builder'             => 'instagram',
			'font_page'                => 4437,
		),

		array(
			'id'                       => 97,
			'import_file_name'         => 'Instagram v3',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v60.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'instagram',
			'page_builder'             => 'elementor',
			'font_page'                => 4625,
		),

		array(
			'id'                       => 98,
			'import_file_name'         => 'Instagram v4',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v65.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'instagram',
			'page_builder'             => 'elementor',
			'font_page'                => 4649,
		),

		array(
			'id'                       => 99,
			'import_file_name'         => 'Instagram v5',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v80.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'instagram',
			'page_builder'             => 'elementor',
			'font_page'                => 4737,
		),

		array(
			'id'                       => 100,
			'import_file_name'         => 'Instagram v6',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v101.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'instagram',
			'page_builder'             => 'elementor',
			'font_page'                => 4842,
		),

		array(
			'id'                       => 101,
			'import_file_name'         => 'Subscribe v1',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v10.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'subscribe',
			'page_builder'             => 'elementor',
			'font_page'                => 4360,
		),

		array(
			'id'                       => 102,
			'import_file_name'         => 'Subscribe v2',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v26.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'subscribe',
			'page_builder'             => 'elementor',
			'font_page'                => 4445,
		),

		array(
			'id'                       => 103,
			'import_file_name'         => 'Subscribe v3',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v48.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'subscribe',
			'page_builder'             => 'elementor',
			'font_page'                => 4556,
		),

		array(
			'id'                       => 104,
			'import_file_name'         => 'Slideshow v1',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v11.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'slideshow',
			'page_builder'             => 'elementor',
			'font_page'                => 4365,
		),

		array(
			'id'                       => 105,
			'import_file_name'         => 'Slideshow v2',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v18.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'free',
			'page_builder'             => 'slideshow',
			'font_page'                => 4402,
		),

		array(
			'id'                       => 106,
			'import_file_name'         => 'Slideshow v3',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v27.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'slideshow',
			'page_builder'             => 'elementor',
			'font_page'                => 4450,
		),

		array(
			'id'                       => 107,
			'import_file_name'         => 'Slideshow v4',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v33.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'slideshow',
			'page_builder'             => 'elementor',
			'font_page'                => 4477,
		),

		array(
			'id'                       => 108,
			'import_file_name'         => 'Slideshow v5',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v35.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'slideshow',
			'page_builder'             => 'elementor',
			'font_page'                => 4490,
		),

		array(
			'id'                       => 109,
			'import_file_name'         => 'Slideshow v6',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v40.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'slideshow',
			'page_builder'             => 'elementor',
			'font_page'                => 4515,
		),

		array(
			'id'                       => 110,
			'import_file_name'         => 'Slideshow v7',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v49.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'slideshow',
			'page_builder'             => 'elementor',
			'font_page'                => 4561,
		),

		array(
			'id'                       => 111,
			'import_file_name'         => 'Slideshow v8',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v55.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'slideshow',
			'page_builder'             => 'elementor',
			'font_page'                => 4600,
		),

		array(
			'id'                       => 112,
			'import_file_name'         => 'Slideshow v9',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v67.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'slideshow',
			'page_builder'             => 'elementor',
			'font_page'                => 4659,
		),

		array(
			'id'                       => 113,
			'import_file_name'         => 'Slideshow v10',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v75.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'slideshow',
			'page_builder'             => 'elementor',
			'font_page'                => 4712,
		),

		array(
			'id'                       => 114,
			'import_file_name'         => 'Slideshow v11',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v81.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'slideshow',
			'page_builder'             => 'elementor',
			'font_page'                => 4743,
		),

		array(
			'id'                       => 115,
			'import_file_name'         => 'Slideshow v12',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v87.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'slideshow',
			'page_builder'             => 'elementor',
			'font_page'                => 4772,
		),

		array(
			'id'                       => 116,
			'import_file_name'         => 'Slideshow v13',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v94.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'slideshow',
			'page_builder'             => 'elementor',
			'font_page'                => 4807,
		),

		array(
			'id'                       => 117,
			'import_file_name'         => 'Slideshow v14',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v102.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'slideshow',
			'page_builder'             => 'elementor',
			'font_page'                => 4847,
		),

		array(
			'id'                       => 118,
			'import_file_name'         => 'Contact v25',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/contactv25.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'contact',
			'page_builder'             => 'elementor',
			'font_page'                => 7219,
		),

		array(
			'id'                       => 119,
			'import_file_name'         => 'Testimonial v1',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v22.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'testimonial',
			'page_builder'             => 'elementor',
			'font_page'                => 4422,
		),

		array(
			'id'                       => 120,
			'import_file_name'         => 'Testimonial v2',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v109.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'testimonial',
			'page_builder'             => 'elementor',
			'font_page'                => 4882,
		),

		array(
			'id'                       => 121,
			'import_file_name'         => 'Testimonial v3',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v116.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'testimonial',
			'page_builder'             => 'elementor',
			'font_page'                => 5054,
		),

		array(
			'id'                       => 122,
			'import_file_name'         => 'Testimonial v4',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v123.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'testimonial',
			'page_builder'             => 'elementor',
			'font_page'                => 5090,
		),

		array(
			'id'                       => 123,
			'import_file_name'         => 'Testimonial v5',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v132.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'testimonial',
			'page_builder'             => 'elementor',
			'font_page'                => 5137,
		),

		array(
			'id'                       => 124,
			'import_file_name'         => 'Testimonial v6',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v141.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'testimonial',
			'page_builder'             => 'elementor',
			'font_page'                => 5187,
		),

		array(
			'id'                       => 125,
			'import_file_name'         => 'Testimonial v7',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v152.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'testimonial',
			'page_builder'             => 'elementor',
			'font_page'                => 5265,
		),

		array(
			'id'                       => 126,
			'import_file_name'         => 'Testimonial v8',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v163.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'testimonial',
			'page_builder'             => 'elementor',
			'font_page'                => 5327,
		),

		array(
			'id'                       => 127,
			'import_file_name'         => 'Testimonial v9',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v167.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'testimonial',
			'page_builder'             => 'elementor',
			'font_page'                => 5351,
		),

		array(
			'id'                       => 128,
			'import_file_name'         => 'Testimonial v10',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v178.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'testimonial',
			'page_builder'             => 'elementor',
			'font_page'                => 5411,
		),

		array(
			'id'                       => 129,
			'import_file_name'         => 'Blog v1',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v23.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'blog',
			'page_builder'             => 'elementor',
			'font_page'                => 4427,
		),

		array(
			'id'                       => 130,
			'import_file_name'         => 'Blog v2',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v39.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'blog',
			'page_builder'             => 'elementor',
			'font_page'                => 4510,
		),

		array(
			'id'                       => 131,
			'import_file_name'         => 'Blog v3',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v59.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'blog',
			'page_builder'             => 'elementor',
			'font_page'                => 4620,
		),

		array(
			'id'                       => 132,
			'import_file_name'         => 'Blog v4',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v66.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'blog',
			'page_builder'             => 'elementor',
			'font_page'                => 4654,
		),

		array(
			'id'                       => 133,
			'import_file_name'         => 'Blog v5',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v79.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'blog',
			'page_builder'             => 'elementor',
			'font_page'                => 4732,
		),

		array(
			'id'                       => 134,
			'import_file_name'         => 'Blog v6',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v86.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'blog',
			'page_builder'             => 'elementor',
			'font_page'                => 4767,
		),

		array(
			'id'                       => 135,
			'import_file_name'         => 'Blog v7',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v93.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'blog',
			'page_builder'             => 'elementor',
			'font_page'                => 4802,
		),

		array(
			'id'                       => 136,
			'import_file_name'         => 'Blog v8',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v100.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'blog',
			'page_builder'             => 'elementor',
			'font_page'                => 4837,
		),

		array(
			'id'                       => 137,
			'import_file_name'         => 'Blog v9',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v105.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'blog',
			'page_builder'             => 'elementor',
			'font_page'                => 4862,
		),

		array(
			'id'                       => 138,
			'import_file_name'         => 'Blog v10',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v110.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'blog',
			'page_builder'             => 'elementor',
			'font_page'                => 5009,
		),

		array(
			'id'                       => 139,
			'import_file_name'         => 'Brand v1',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v29.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'brand',
			'page_builder'             => 'elementor',
			'font_page'                => 4460,
		),

		array(
			'id'                       => 140,
			'import_file_name'         => 'Brand v2',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v34.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'brand',
			'page_builder'             => 'elementor',
			'font_page'                => 4485,
		),

		array(
			'id'                       => 141,
			'import_file_name'         => 'Brand v3',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v46.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'brand',
			'page_builder'             => 'elementor',
			'font_page'                => 4546,
		),

		array(
			'id'                       => 142,
			'import_file_name'         => 'Brand v4',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v148.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'brand',
			'page_builder'             => 'elementor',
			'font_page'                => 5226,
		),

		array(
			'id'                       => 143,
			'import_file_name'         => 'Brand v5',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v171.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'brand',
			'page_builder'             => 'elementor',
			'font_page'                => 5375,
		),

		array(
			'id'                       => 144,
			'import_file_name'         => 'Contact v24',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/contactv24.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'contact',
			'page_builder'             => 'elementor',
			'font_page'                => 7182,
		),

		array(
			'id'                       => 145,
			'import_file_name'         => 'Top Bar v1',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v74.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'topbar',
			'page_builder'             => 'elementor',
			'font_page'                => 4707,
		),

		array(
			'id'                       => 146,
			'import_file_name'         => 'Countdown v1',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v84.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'countdown',
			'page_builder'             => 'elementor',
			'font_page'                => 4757,
		),

		array(
			'id'                       => 147,
			'import_file_name'         => 'Countdown v2',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v99.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'countdown',
			'page_builder'             => 'elementor',
			'font_page'                => 4832,
		),

		array(
			'id'                       => 148,
			'import_file_name'         => 'Video v1',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v97.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'video',
			'page_builder'             => 'elementor',
			'font_page'                => 4822,
		),

		array(
			'id'                       => 149,
			'import_file_name'         => 'Video v2',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v150.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'video',
			'page_builder'             => 'elementor',
			'font_page'                => 5255,
		),

		array(
			'id'                       => 150,
			'import_file_name'         => 'Video v3',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v160.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'video',
			'page_builder'             => 'elementor',
			'font_page'                => 5312,
		),

		array(
			'id'                       => 151,
			'import_file_name'         => 'Contact v1',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v111.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'contact',
			'page_builder'             => 'elementor',
			'font_page'                => 5024,
		),

		array(
			'id'                       => 152,
			'import_file_name'         => 'Contact v2',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v112.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'contact',
			'page_builder'             => 'elementor',
			'font_page'                => 5033,
		),

		array(
			'id'                       => 153,
			'import_file_name'         => 'Contact v3',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v113.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'contact',
			'page_builder'             => 'elementor',
			'font_page'                => 5038,
		),

		array(
			'id'                       => 154,
			'import_file_name'         => 'Contact v4',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v117.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'contact',
			'page_builder'             => 'elementor',
			'font_page'                => 5059,
		),

		array(
			'id'                       => 155,
			'import_file_name'         => 'Contact v5',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v118.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'contact',
			'page_builder'             => 'elementor',
			'font_page'                => 5064,
		),

		array(
			'id'                       => 156,
			'import_file_name'         => 'Contact v6',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v119.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'contact',
			'page_builder'             => 'elementor',
			'font_page'                => 5070,
		),

		array(
			'id'                       => 157,
			'import_file_name'         => 'Contact v7',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v124.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'contact',
			'page_builder'             => 'elementor',
			'font_page'                => 5095,
		),

		array(
			'id'                       => 158,
			'import_file_name'         => 'Contact v8',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v125.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'contact',
			'page_builder'             => 'elementor',
			'font_page'                => 5100,
		),

		array(
			'id'                       => 159,
			'import_file_name'         => 'Contact v9',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v128.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'contact',
			'page_builder'             => 'elementor',
			'font_page'                => 5116,
		),

		array(
			'id'                       => 160,
			'import_file_name'         => 'Contact v10',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v133.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'contact',
			'page_builder'             => 'elementor',
			'font_page'                => 5142,
		),

		array(
			'id'                       => 161,
			'import_file_name'         => 'Contact v11',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v138.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'contact',
			'page_builder'             => 'elementor',
			'font_page'                => 5168,
		),

		array(
			'id'                       => 162,
			'import_file_name'         => 'Contact v12',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v143.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'contact',
			'page_builder'             => 'elementor',
			'font_page'                => 5197,
		),

		array(
			'id'                       => 163,
			'import_file_name'         => 'Contact v13',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v149.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'contact',
			'page_builder'             => 'elementor',
			'font_page'                => 5246,
		),

		array(
			'id'                       => 164,
			'import_file_name'         => 'Contact v14',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v154.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'contact',
			'page_builder'             => 'elementor',
			'font_page'                => 5275,
		),

		array(
			'id'                       => 165,
			'import_file_name'         => 'Contact v15',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v155.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'contact',
			'page_builder'             => 'elementor',
			'font_page'                => 5283,
		),

		array(
			'id'                       => 166,
			'import_file_name'         => 'Contact v16',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v164.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'contact',
			'page_builder'             => 'elementor',
			'font_page'                => 5332,
		),

		array(
			'id'                       => 167,
			'import_file_name'         => 'Contact v17',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v169.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'contact',
			'page_builder'             => 'elementor',
			'font_page'                => 5364,
		),

		array(
			'id'                       => 168,
			'import_file_name'         => 'Contact v18',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v173.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'contact',
			'page_builder'             => 'elementor',
			'font_page'                => 5388,
		),

		array(
			'id'                       => 169,
			'import_file_name'         => 'Contact v19',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v175.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'contact',
			'page_builder'             => 'elementor',
			'font_page'                => 5399,
		),

		array(
			'id'                       => 170,
			'import_file_name'         => 'Contact v20',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v180.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'contact',
			'page_builder'             => 'elementor',
			'font_page'                => 5424,
		),

		array(
			'id'                       => 171,
			'import_file_name'         => 'Team v1',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v127.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'team',
			'page_builder'             => 'elementor',
			'font_page'                => 5111,
		),

		array(
			'id'                       => 172,
			'import_file_name'         => 'Team v2',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v142.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'team',
			'page_builder'             => 'elementor',
			'font_page'                => 5192,
		),

		array(
			'id'                       => 173,
			'import_file_name'         => 'Team v3',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v153.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'team',
			'page_builder'             => 'elementor',
			'font_page'                => 5270,
		),

		array(
			'id'                       => 174,
			'import_file_name'         => 'Team v4',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v158.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'team',
			'page_builder'             => 'elementor',
			'font_page'                => 5302,
		),

		array(
			'id'                       => 175,
			'import_file_name'         => 'Team v5',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v172.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'team',
			'page_builder'             => 'elementor',
			'font_page'                => 5377,
		),

		array(
			'id'                       => 176,
			'import_file_name'         => 'Team v6',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v179.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'team',
			'page_builder'             => 'elementor',
			'font_page'                => 5413,
		),

		array(
			'id'                       => 177,
			'import_file_name'         => 'Counter v1',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v157.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'counter',
			'page_builder'             => 'elementor',
			'font_page'                => 5297,
		),

		array(
			'id'                       => 178,
			'import_file_name'         => 'Counter v2',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Block-v168.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'counter',
			'page_builder'             => 'elementor',
			'font_page'                => 5356,
		),

		array(
			'id'                       => 179,
			'import_file_name'         => 'Blog Archive v1',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blog/blog_v1.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'archive',
			'page_builder'             => 'elementor',
			'font_page'                => 5851,
		),
		array(
			'id'                       => 180,
			'import_file_name'         => 'Blog Archive v2',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blog/blog_v2.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'archive',
			'page_builder'             => 'elementor',
			'font_page'                => 5859,
		),
		array(
			'id'                       => 181,
			'import_file_name'         => 'Blog Archive v3',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blog/blog_v3.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'archive',
			'page_builder'             => 'elementor',
			'font_page'                => 5871,
		),
		array(
			'id'                       => 182,
			'import_file_name'         => 'Blog Archive v4',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blog/blog_v4.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'archive',
			'page_builder'             => 'elementor',
			'font_page'                => 5876,
		),

		array(
			'id'                       => 183,
			'import_file_name'         => 'Banner v51',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/banner_v51.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 5888,
		),

		array(
			'id'                       => 184,
			'import_file_name'         => 'Banner v52',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/banner_v52.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 5920,
		),

		array(
			'id'                       => 185,
			'import_file_name'         => 'Banner v53',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/banner_v53.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 5933,
		),

		array(
			'id'                       => 186,
			'import_file_name'         => 'Banner v54',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/banner_v54.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 5976,
		),

		array(
			'id'                       => 187,
			'import_file_name'         => 'Call To Action v5',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/banner_v55.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'call-to-action',
			'page_builder'             => 'elementor',
			'font_page'                => 6122,
		),

		array(
			'id'                       => 188,
			'import_file_name'         => 'Video v4',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Video_v4.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'video',
			'page_builder'             => 'elementor',
			'font_page'                => 6008,
		),

		array(
			'id'                       => 189,
			'import_file_name'         => 'Call To Action v1',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/banner_v56.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'call-to-action',
			'page_builder'             => 'elementor',
			'font_page'                => 6129,
		),

		array(
			'id'                       => 190,
			'import_file_name'         => 'Call To Action v2',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/banner_v57.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'call-to-action',
			'page_builder'             => 'elementor',
			'font_page'                => 6180,
		),

		array(
			'id'                       => 191,
			'import_file_name'         => 'Call To Action v3',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/banner_v58.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'call-to-action',
			'page_builder'             => 'elementor',
			'font_page'                => 6189,
		),

		array(
			'id'                       => 192,
			'import_file_name'         => 'Call To Action v4',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/banner_v59.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'call-to-action',
			'page_builder'             => 'elementor',
			'font_page'                => 6234,
		),

		array(
			'id'                       => 193,
			'import_file_name'         => 'Banner v60',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/banner_v60.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 6270,
		),

		array(
			'id'                       => 194,
			'import_file_name'         => 'Banner v61',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/banner_v61.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 6283,
		),

		array(
			'id'                       => 195,
			'import_file_name'         => 'Countdown v3',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Countdown_v3.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'countdown',
			'page_builder'             => 'elementor',
			'font_page'                => 6299,
		),

		array(
			'id'                       => 196,
			'import_file_name'         => 'Banner v62',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/banner_v62.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 6340,
		),

		array(
			'id'                       => 197,
			'import_file_name'         => 'Banner v63',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/banner_v63.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner',
			'page_builder'             => 'elementor',
			'font_page'                => 6400,
		),

		array(
			'id'                       => 198,
			'import_file_name'         => 'Banner v64',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/banner_v64.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner__free',
			'page_builder'             => 'elementor',
			'font_page'                => 7349,
		),

		array(
			'id'                       => 199,
			'import_file_name'         => 'Categories v15',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/category_v15.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'categories',
			'page_builder'             => 'elementor',
			'font_page'                => 6469,
		),

		array(
			'id'                       => 200,
			'import_file_name'         => 'Categories v16',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/category_v16.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'categories',
			'page_builder'             => 'elementor',
			'font_page'                => 6521,
		),

		array(
			'id'                       => 201,
			'import_file_name'         => 'Categories v17',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/category_v17.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'categories',
			'page_builder'             => 'elementor',
			'font_page'                => 6555,
		),

		array(
			'id'                       => 202,
			'import_file_name'         => 'Categories v18',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/category_v18.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'categories',
			'page_builder'             => 'elementor',
			'font_page'                => 6575,
		),

		array(
			'id'                       => 203,
			'import_file_name'         => 'Categories v19',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/category_v19.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'categories',
			'page_builder'             => 'elementor',
			'font_page'                => 6608,
		),

		array(
			'id'                       => 204,
			'import_file_name'         => 'Categories v20',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/category_v20.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'categories',
			'page_builder'             => 'elementor',
			'font_page'                => 7318,
		),

		array(
			'id'                       => 205,
			'import_file_name'         => 'Categories v21',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/category_v21.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'categories',
			'page_builder'             => 'elementor',
			'font_page'                => 7314,
		),

		array(
			'id'                       => 206,
			'import_file_name'         => 'Contact v21',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/contactv21.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'contact',
			'page_builder'             => 'elementor',
			'font_page'                => 7065,
		),

		array(
			'id'                       => 207,
			'import_file_name'         => 'Contact v22',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/contactv22.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'contact',
			'page_builder'             => 'elementor',
			'font_page'                => 7106,
		),

		array(
			'id'                       => 208,
			'import_file_name'         => 'Contact v23',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/contactv23.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'contact',
			'page_builder'             => 'elementor',
			'font_page'                => 7138,
		),

		array(
			'id'                       => 209,
			'import_file_name'         => 'Service v10',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/service_v10.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'service',
			'page_builder'             => 'elementor',
			'font_page'                => 7354,
		),

		array(
			'id'                       => 210,
			'import_file_name'         => 'Slideshow v15',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Slideshow_v15.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'slideshow',
			'page_builder'             => 'elementor',
			'font_page'                => 7436,
		),

		array(
			'id'                       => 211,
			'import_file_name'         => 'Slideshow v16',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Slideshow_v16.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'slideshow',
			'page_builder'             => 'elementor',
			'font_page'                => 7441,
		),

		array(
			'id'                       => 212,
			'import_file_name'         => 'Team v7',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Team_v7.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'team',
			'page_builder'             => 'elementor',
			'font_page'                => 7431,
		),

		array(
			'id'                       => 213,
			'import_file_name'         => 'Testimonial v11',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Testimonial_v11.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'testimonial',
			'page_builder'             => 'elementor',
			'font_page'                => 7426,
		),

		array(
			'id'                       => 214,
			'import_file_name'         => 'Banner v65',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/banner_v65.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'banner__pro',
			'page_builder'             => 'elementor',
			'font_page'                => 7421,
		),

		array(
			'id'                       => 215,
			'import_file_name'         => 'Contact v26',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/contactv26.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'contact',
			'page_builder'             => 'elementor',
			'font_page'                => 7416,
		),

		array(
			'id'                       => 216,
			'import_file_name'         => 'Product v23',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Product_v23.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'product',
			'page_builder'             => 'elementor',
			'font_page'                => 7411,
		),

		array(
			'id'                       => 217,
			'import_file_name'         => 'Subscribe v4',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/Subscribe_v4.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'subscribe',
			'page_builder'             => 'elementor',
			'font_page'                => 7406,
		),

		array(
			'id'                       => 218,
			'import_file_name'         => 'Service v11',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/service_v10.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'service',
			'page_builder'             => 'elementor',
			'font_page'                => 7401,
		),

		array(
			'id'                       => 219,
			'import_file_name'         => 'Categories v22',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/category_v22.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'categories',
			'page_builder'             => 'elementor',
			'font_page'                => 7378,
		),

		array(
			'id'                       => 220,
			'import_file_name'         => 'Categories v23',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-blocks/category_v23.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'categories',
			'page_builder'             => 'elementor',
			'font_page'                => 7386,
		),

	);

}

function woostify_sites_footer() {
	return array(
		array(
			'id'                       => 0,
			'import_file_name'         => 'Footer v1',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-footer/Footer_v1.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'pro',
			'page_builder'             => 'elementor',
			'font_page'                => 1595,
		),
		array(
			'id'                       => 1,
			'import_file_name'         => 'Footer v2',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-footer/Footer_v2.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'pro',
			'page_builder'             => 'elementor',
			'font_page'                => 1724,
		),
		array(
			'id'                       => 2,
			'import_file_name'         => 'Footer v3',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-footer/Footer_v3.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'pro',
			'page_builder'             => 'elementor',
			'font_page'                => 1765,
		),
		array(
			'id'                       => 3,
			'import_file_name'         => 'Footer v4',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-footer/Footer_v4.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'pro',
			'page_builder'             => 'elementor',
			'font_page'                => 1854,
		),
		array(
			'id'                       => 4,
			'import_file_name'         => 'Footer v5',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-footer/Footer_v5.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'pro',
			'page_builder'             => 'elementor',
			'font_page'                => 1869,
		),
		array(
			'id'                       => 5,
			'import_file_name'         => 'Footer v6',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-footer/Footer_v6.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'pro',
			'page_builder'             => 'elementor',
			'font_page'                => 2012,
		),
		array(
			'id'                       => 6,
			'import_file_name'         => 'Footer v7',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-footer/Footer_v7.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'pro',
			'page_builder'             => 'elementor',
			'font_page'                => 2077,
		),
		array(
			'id'                       => 7,
			'import_file_name'         => 'Footer v8',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-footer/Footer_v8.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'pro',
			'page_builder'             => 'elementor',
			'font_page'                => 2148,
		),
		array(
			'id'                       => 8,
			'import_file_name'         => 'Footer v9',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-footer/Footer_v9.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'pro',
			'page_builder'             => 'elementor',
			'font_page'                => 2257,
		),
		array(
			'id'                       => 9,
			'import_file_name'         => 'Footer v10',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-footer/Footer_v10.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'pro',
			'page_builder'             => 'elementor',
			'font_page'                => 2262,
		),
		array(
			'id'                       => 10,
			'import_file_name'         => 'Footer v11',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-footer/Footer_v11.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'pro',
			'page_builder'             => 'elementor',
			'font_page'                => 2282,
		),
		array(
			'id'                       => 11,
			'import_file_name'         => 'Footer v12',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-footer/Footer_v12.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'pro',
			'page_builder'             => 'elementor',
			'font_page'                => 2293,
		),
		array(
			'id'                       => 12,
			'import_file_name'         => 'Footer v13',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-footer/Footer_v13.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'pro',
			'page_builder'             => 'elementor',
			'font_page'                => 2310,
		),
		array(
			'id'                       => 13,
			'import_file_name'         => 'Footer v14',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-footer/Footer_v14.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'pro',
			'page_builder'             => 'elementor',
			'font_page'                => 2321,
		),
		array(
			'id'                       => 14,
			'import_file_name'         => 'Footer v15',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-footer/Footer_v15.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'pro',
			'page_builder'             => 'elementor',
			'font_page'                => 2327,
		),
		array(
			'id'                       => 15,
			'import_file_name'         => 'Footer v16',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-footer/Footer_v16.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'pro',
			'page_builder'             => 'elementor',
			'font_page'                => 2332,
		),
		array(
			'id'                       => 16,
			'import_file_name'         => 'Footer v16',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-footer/Footer_v17.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'pro',
			'page_builder'             => 'elementor',
			'font_page'                => 7391,
		),
		array(
			'id'                       => 17,
			'import_file_name'         => 'Footer v16',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-footer/Footer_v18.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'pro',
			'page_builder'             => 'elementor',
			'font_page'                => 7396,
		),
	);
}

function woostify_sites_header() {
	return array(
		array(
			'id'                       => 0,
			'import_file_name'         => 'Header v1',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-header/Header_v19.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'pro',
			'page_builder'             => 'elementor',
			'font_page'                => 499,
		),
		array(
			'id'                       => 1,
			'import_file_name'         => 'Header v2',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-header/Header_v20.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'pro',
			'page_builder'             => 'elementor',
			'font_page'                => 519,
		),
		array(
			'id'                       => 2,
			'import_file_name'         => 'Header v3',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-header/Header_v25.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'pro',
			'page_builder'             => 'elementor',
			'font_page'                => 705,
		),
		array(
			'id'                       => 3,
			'import_file_name'         => 'Header v4',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-header/Header_v27.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'pro',
			'page_builder'             => 'elementor',
			'font_page'                => 890,
		),
		array(
			'id'                       => 4,
			'import_file_name'         => 'Header v5',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-header/Header_v28.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'pro',
			'page_builder'             => 'elementor',
			'font_page'                => 947,
		),
		array(
			'id'                       => 5,
			'import_file_name'         => 'Header v6',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-header/Header_v29.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'pro',
			'page_builder'             => 'elementor',
			'font_page'                => 1047,
		),
		array(
			'id'                       => 6,
			'import_file_name'         => 'Header v7',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-header/Header_v30.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'pro',
			'page_builder'             => 'elementor',
			'font_page'                => 1084,
		),
		array(
			'id'                       => 7,
			'import_file_name'         => 'Header v8',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-header/Header_v31.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'pro',
			'page_builder'             => 'elementor',
			'font_page'                => 1503,
		),
		array(
			'id'                       => 8,
			'import_file_name'         => 'Header v9',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-header/Header_v32.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'pro',
			'page_builder'             => 'elementor',
			'font_page'                => 1151,
		),
		array(
			'id'                       => 9,
			'import_file_name'         => 'Header v10',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-header/Header_v33.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'pro',
			'page_builder'             => 'elementor',
			'font_page'                => 1184,
		),
		array(
			'id'                       => 10,
			'import_file_name'         => 'Header v11',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-header/Header_v34.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'pro',
			'page_builder'             => 'elementor',
			'font_page'                => 1208,
		),
		array(
			'id'                       => 11,
			'import_file_name'         => 'Header v12',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-header/Header_v35.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'pro',
			'page_builder'             => 'elementor',
			'font_page'                => 1252,
		),
		array(
			'id'                       => 12,
			'import_file_name'         => 'Header v13',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-header/Header_v36.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'pro',
			'page_builder'             => 'elementor',
			'font_page'                => 1288,
		),
		array(
			'id'                       => 13,
			'import_file_name'         => 'Header v14',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-header/Header_v37.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'pro',
			'page_builder'             => 'elementor',
			'font_page'                => 1330,
		),
		array(
			'id'                       => 14,
			'import_file_name'         => 'Header v15',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-header/Header_v38.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'pro',
			'page_builder'             => 'elementor',
			'font_page'                => 1372,
		),
		array(
			'id'                       => 15,
			'import_file_name'         => 'Header v16',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-header/Header_v39.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'pro',
			'page_builder'             => 'elementor',
			'font_page'                => 1432,
		),
		array(
			'id'                       => 16,
			'import_file_name'         => 'Header v17',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-header/Header_v40.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'pro',
			'page_builder'             => 'elementor',
			'font_page'                => 7446,
		),
	);
}

function woostify_sites_shop() {
	return array(
		array(
			'id'                       => 0,
			'import_file_name'         => 'Shop V1',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-shop/shop_v1.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'shop',
			'page_builder'             => 'elementor',
			'font_page'                => 4252,
		),
		array(
			'id'                       => 1,
			'import_file_name'         => 'Shop V2',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-shop/shop_v2.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'shop',
			'page_builder'             => 'elementor',
			'font_page'                => 4273,
		),
		array(
			'id'                       => 2,
			'import_file_name'         => 'Shop V3',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-shop/shop_v3.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'shop',
			'page_builder'             => 'elementor',
			'font_page'                => 4298,
		),
		array(
			'id'                       => 3,
			'import_file_name'         => 'Single Product V1',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-shop/single_product_v1.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'shopsingle',
			'page_builder'             => 'elementor',
			'font_page'                => 4097,
		),
		array(
			'id'                       => 4,
			'import_file_name'         => 'Single Product V2',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-shop/single_product_v2.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'shopsingle',
			'page_builder'             => 'elementor',
			'font_page'                => 4196,
		),
		array(
			'id'                       => 5,
			'import_file_name'         => 'Single Product V3',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-shop/single_product_v3.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'shopsingle',
			'page_builder'             => 'elementor',
			'font_page'                => 5784,
		),
		array(
			'id'                       => 6,
			'import_file_name'         => 'Single Product V4',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-shop/single_product_v4.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'shopsingle',
			'page_builder'             => 'elementor',
			'font_page'                => 5802,
		),
		array(
			'id'                       => 7,
			'import_file_name'         => 'Single Product V5',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-shop/single_product_v5.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'shopsingle',
			'page_builder'             => 'elementor',
			'font_page'                => 5813,
		),
		array(
			'id'                       => 8,
			'import_file_name'         => 'Single Product V6',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-shop/single_product_v6.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'shopsingle',
			'page_builder'             => 'elementor',
			'font_page'                => 5824,
		),
		array(
			'id'                       => 9,
			'import_file_name'         => 'Cart V1',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-shop/cart_v1.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'cart',
			'page_builder'             => 'elementor',
			'font_page'                => 3862,
		),
		array(
			'id'                       => 10,
			'import_file_name'         => 'Cart V2',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-shop/cart_v2.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'cart',
			'page_builder'             => 'elementor',
			'font_page'                => 3948,
		),
		array(
			'id'                       => 11,
			'import_file_name'         => 'Cart V3',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-shop/cart_v3.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'cart',
			'page_builder'             => 'elementor',
			'font_page'                => 6036,
		),
		array(
			'id'                       => 12,
			'import_file_name'         => 'Cart V4',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-shop/cart_v4.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'cart',
			'page_builder'             => 'elementor',
			'font_page'                => 6047,
		),
		array(
			'id'                       => 13,
			'import_file_name'         => 'Cart V5',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-shop/cart_v5.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'cart',
			'page_builder'             => 'elementor',
			'font_page'                => 6056,
		),
		array(
			'id'                       => 14,
			'import_file_name'         => 'Checkout V1',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-shop/Checkout_v1.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'checkout',
			'page_builder'             => 'elementor',
			'font_page'                => 3994,
		),
		array(
			'id'                       => 15,
			'import_file_name'         => 'Checkout V2',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-shop/Checkout_v2.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'checkout',
			'page_builder'             => 'elementor',
			'font_page'                => 6090,
		),
		array(
			'id'                       => 16,
			'import_file_name'         => 'My Account',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-shop/My_account.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'myaccount',
			'page_builder'             => 'elementor',
			'font_page'                => 5709,
		),
		array(
			'id'                       => 17,
			'import_file_name'         => 'Thank You',
			'import_preview_image_url' => WOOSTIFY_SITES_URI . 'demos/images-shop/thank_you.jpg',
			'preview_url'              => 'https://demo.woostify.com/section-demo/',
			'type'                     => 'thankyou',
			'page_builder'             => 'elementor',
			'font_page'                => 5748,
		),
	);
}

add_action( 'rest_api_init', 'woostify_create_api_posts_meta_field' );

function woostify_create_api_posts_meta_field() {

	// register_rest_field ( 'name-of-post-type', 'name-of-field-to-return', array-of-callbacks-and-schema() )
	register_rest_field( 'page', 'post-meta', array(
		'get_callback' => 'woostify_get_post_meta_for_api',
		'schema'       => null,
		)
	);

	register_rest_field( 'btf_builder', 'post-meta', array(
	   'get_callback'    => 'woostify_get_post_meta_for_api',
	   'schema'          => null,
		)
	);
}

function woostify_get_post_meta_for_api( $object ) {
	//get the id of the post object array
	$post_id = $object['id'];

	//return the post meta
	return get_post_meta($post_id);
}

add_action( 'template_redirect', 'woostify_collect_post_id' );

function woostify_collect_post_id()
{
	static $id = 0;

	if ( 'template_redirect' === current_filter() && is_singular() )
		$id = get_the_ID();

	return $id;
}


function woostify_filter_section() {
	$filter = array(
		'banner__free' => __( 'Banner', 'woostify-sites-library' ),
		'categories' => __( 'Categories', 'woostify-sites-library' ),
		'call-to-action' => __( 'Call To Action', 'woostify-sites-library' ),
		'product' => __( 'Product', 'woostify-sites-library' ),
		'service' => __( 'Service', 'woostify-sites-library' ),
		'instagram' => __( 'Instagram', 'woostify-sites-library' ),
		'subscribe' => __( 'Subscribe', 'woostify-sites-library' ),
		'slideshow' => __( 'Slide', 'woostify-sites-library' ),
		'testimonial' => __( 'Testimonial', 'woostify-sites-library' ),
		'blog' => __( 'Blog', 'woostify-sites-library' ),
		'brand' => __( 'Brand', 'woostify-sites-library' ),
		'topbar' => __( 'Top bar', 'woostify-sites-library' ),
		'countdown' => __( 'Countdown', 'woostify-sites-library' ),
		'video' => __( 'Video', 'woostify-sites-library' ),
		'contact' => __( 'Contact', 'woostify-sites-library' ),
		'team' => __( 'Team', 'woostify-sites-library' ),
		'counter' => __( 'Counter', 'woostify-sites-library' ),
		'archive' => __( 'Archive', 'woostify-sites-library' ),
	);
	return $filter;
}

function woostify_filter_pages() {
	$filter = array(
		'free' => __( 'Free', 'woostify-sites-library' ),
		'pro'  => __( 'Pro', 'woostify-sites-library' ),
	);
	return $filter;
}

function woostify_filter_footer() {
	$filter = array();
	return $filter;
}

function woostify_filter_header() {
	$filter = array();
	return $filter;
}

function woostify_filter_shop() {
	$filter = array(
		'shop' => __( 'Shop', 'woostify-sites-library' ),
		'shopsingle' => __( 'Shop Single', 'woostify-sites-library' ),
		'cart' => __( 'Cart', 'woostify-sites-library' ),
		'checkout' => __( 'Check Out', 'woostify-sites-library' ),
		'myaccount' => __( 'My Account', 'woostify-sites-library' ),
		'thankyou' => __( 'Thank You', 'woostify-sites-library' ),
	);
	return $filter;
}
