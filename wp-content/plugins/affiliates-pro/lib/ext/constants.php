<?php
/**
 * constants.php
 *
 * Copyright (c) 2011 "kento" Karim Rahimpur www.itthinx.com
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
 * @package affiliates-pro
 * @since affiliates-pro 1.0.0
 */

/**
 * @var system version
 */
define( 'AFFILIATES_PRO_DEFAULT_VERSION', '1.0.0' );

/**
 * @var string plugin domain
 */
define( 'AFFILIATES_PRO_PLUGIN_DOMAIN', 'affiliates' );

/**
 * @var string plugin directory on the server
 */
define( 'AFFILIATES_PRO_PLUGIN_DIR', basename( dirname( AFFILIATES_PRO_FILE ) ) );

/**
 * @var string plugin url
 */
define( 'AFFILIATES_PRO_PLUGIN_URL', plugin_dir_url( AFFILIATES_PRO_FILE ) );

/**
 * @var boolean
 */
define( 'AFFILIATES_PRO_ALWAYS_ENQUEUE_FOR_SHORTCODES', 'affiliates-pro-AEFS' );

/**
 * @var string Rates type: rate
 */
define( 'AFFILIATES_PRO_RATES_TYPE_RATE', 'rate');

/**
 * @var string Rates type: amount
 */
define( 'AFFILIATES_PRO_RATES_TYPE_AMOUNT', 'amount');

/**
 * @var string Rates type: formula
 */
define( 'AFFILIATES_PRO_RATES_TYPE_FORMULA', 'formula');
