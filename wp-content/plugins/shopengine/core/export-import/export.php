<?php

namespace ShopEngine\Core\Export_Import;

use ShopEngine\Core\Builders\Action;
use ShopEngine\Core\Builders\Templates;

class Export {

	public function init() {

		add_action('rss2_head', [$this, 'add_options_in_export_file']);
	}

	public function add_options_in_export_file() {
        ?>
        <wp_options>
            <wp_option>
                <name>
                    <?php
                    echo esc_html(Action::ACTIVATED_TEMPLATES);
                    ?>
                </name>
                <val>
                    <?php
                    echo esc_js(get_option(Action::ACTIVATED_TEMPLATES));
                    ?>
                </val>
            </wp_option>
        </wp_options>
        <?php
    }
}

