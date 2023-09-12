<?php
/**
 * class-affiliates-dashboard-shoplist.php
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
 * @author Jon
 * @package affiliates-pro
 * @since affiliates-pro 4.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Dashboard section: ShopList
 */
class Affiliates_Dashboard_ShopList extends Affiliates_Dashboard_Section_Table {

    protected static $section_order = 300;

    private $search = null;

    protected static $defaults = array(
        'from_date'          => null,
        'thru_date'          => null,
        'per_page'           => self::PER_PAGE_DEFAULT,
        'status'             => array( AFFILIATES_SHOPLIST_STATUS_ACCEPTED, AFFILIATES_SHOPLIST_STATUS_REJECTED )
    );

    /**
     * {@inheritDoc}
     */
    public static function get_section_order() { return self::$section_order; }

    /**
     * {@inheritDoc}
     */
    public static function get_name() { return __( '可共享頁面', 'affiliates' ); }

    /**
     * {@inheritDoc}
     */
    public static function get_key() { return 'shoplist'; }

    /**
     * Filter by user's search query string ...
     *
     * @return string
     */
    public function get_search() { return $this->search; }

    public function get_url( $params = array() ) {
        // Hook the middleware function to the 'init' action
        // add_action( 'init', 'my_custom_middleware' );
        $IX31514 = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $IX31514 = remove_query_arg( 'clear_filters', $IX31514 );
        $IX31514 = remove_query_arg( 'apply_filters', $IX31514 );
        foreach ( $this->url_parameters as $IX34149 ) {
            $IX31514 = remove_query_arg( $IX34149, $IX31514 );
            $IX87242 = null;
            switch ( $IX34149 ) {
                case 'per_page' :
                    $IX87242 = $this->get_per_page();
                    break;
               case 'from_date' :
                   $IX87242 = $this->get_from_date();
                   break;
               case 'thru_date' :
                   $IX87242 = $this->get_thru_date();
                   break;
               case 'orderby' :
                   $IX87242 = $this->get_orderby();
                   break;
               case 'order' :
                   $IX87242 = $this->get_sort_order();
                   break;
               case 'referral-search':
               case 'search' :
                   $IX87242 = $this->get_search();
                   break;
            }
            if ( $IX87242 !== null ) {
                $IX31514 = add_query_arg( $IX34149, $IX87242, $IX31514 );
            }
        }
        foreach ( $params as $IX20198 => $IX87242 ) {
            $IX31514 = remove_query_arg( $IX20198, $IX31514 );
            if ( $IX87242 !== null ) {
                $IX31514 = add_query_arg( $IX20198, $IX87242, $IX31514 );
            }
        }
        return $IX31514;
    }

    public static function init() {  }

    public function __construct( $params = array() )
    {


    }

    public function my_custom_middleware() {
        // Perform your middleware logic here
        // For example, you can check if a user is logged in or perform some validation
        // If the condition fails, you can redirect or display an error message
        if ( ! is_user_logged_in() ) {
            wp_redirect( home_url() );
            exit;
        }
        else {
            echo "URL---------------------------------------";
            die;
        }
    }

    public function render() {
        $error_message = "";
        ?>
        <style>
            .table {
                display: table;
                width: 100%;
                margin: auto;
                min-width: 100%;
            }

            .row {
                display: table-row;
                width: 100% !important;
                margin: auto;
            }

            .cell {
                display: table-cell;
                padding: 10px;
                text-align: center;
                min-width: 150px;
            }

            .cell:nth-child(even) {
                background-color: #f2f2f2;
            }

            .save_btn {
                border: none !important;
                background: transparent !important;
            }

            .cell:nth-child(odd) {
                background-color: #e6e6e6;
            }
        </style>
        <h6>请购买一种代币来分享该项目。</h6>

        <?php
        global $wpdb;

        $products = $wpdb->get_results($wpdb->prepare(
            "SELECT `ID`, `post_title`, `post_name`, `post_content` FROM {$wpdb->posts} WHERE `post_type` = %s AND `post_status` = %s ORDER BY `post_title` ASC;",
            'product', 'publish'
        ));
        $table_name = $wpdb->prefix . 'share_products';
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
                id INT(11) NOT NULL AUTO_INCREMENT,
                user_id VARCHAR(255) NOT NULL,
                post_id VARCHAR(255) NOT NULL,
                status VARCHAR(255) NOT NULL,
                affiliate_id VARCHAR(255) NOT NULL,
                token VARCHAR(255) NOT NULL,
                created_date VARCHAR(255) NOT NULL,
                updated_date VARCHAR(255) NOT NULL,
                PRIMARY KEY (id)
            ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );


        // Updating with share_product
        if(isset($_POST['share_product']) && isset($_POST["product_id"]))
        {
            if ( is_user_logged_in() )
            {
                $post_id = $_POST["product_id"];

                $user_id = get_current_user_id();
                $status = "accept";
                $affiliate_user = affiliates_get_user_affiliate($user_id);
                if (!empty($affiliate_user) && count($affiliate_user) > 0)
                {
                    $affiate_id = $affiliate_user[0];
                    $new_token = $user_id.'_'.$post_id.'_'.time();

                    // Checking if it was already saved.
                    $shares = $wpdb->get_results($wpdb->prepare(
                        "SELECT `id` FROM {$table_name} WHERE `user_id` = %s AND `post_id` = %s;",
                        $user_id, $post_id
                    ));
                    if (!empty($shares) && count($shares) > 0)
                    {
                        $error_message = "您已經分享過該產品。 請聯繫管理員重新分享。";
                      //  exit;
                    }
                    else
                    {
                        $new_share_data = array();
                        $new_share_data["user_id"] = $user_id;
                        $new_share_data["post_id"] = $post_id;
                        $new_share_data["status"] = $status;
                        $new_share_data["affiliate_id"] = $affiate_id;
                        $new_share_data["token"] = $new_token;
                        $inserted_id = $wpdb->insert($table_name, $new_share_data);
                        $lastid = $wpdb->insert_id;
                        $error_message = "您刚刚成功共享了该项目。";
                    }
                }
                else {
                    $error_message = "您尚未在聯盟系統中註冊。";
                }
            }
            else {
                $error_message = "請登錄以分享令牌。";
            }

        }

        if ($error_message != "")
        {
            echo '<p>'.$error_message.'</p>';
        }

        if (isset($_POST['select_token_value']) && isset($_POST['token_user_id']))
        {
            $token_user_id = $_POST['token_user_id'];
            $select_token_value = $_POST['select_token_value'];
            if (isset($token_user_id) && isset($select_token_value))
            {
                $_token_user['id'] = $token_user_id;
                $updateData['status'] = $select_token_value;
                $wpdb->update($table_name,$updateData, $_token_user);
            }
            else {
                $error_message = "請選擇待處理的用戶並更改狀態。";
            }
        }

        // For admin
        if (false && is_super_admin() || is_admin())
        {
            $pending_token_users = $wpdb->get_results("SELECT * FROM {$table_name};");
            echo "<div class='row'>";
            echo '<div class="col-12" style="border-bottom: 1px solid gray">'.
                    '<div class="table">'.
                        '<div class="cell" style="width: 16.66%;">用戶 ID/姓名</div>'.
                        '<div class="cell" style="width: 16.66%;">用戶郵箱</div>'.
                        '<div class="cell" style="width: 33.33%">代幣</div>'.
                        '<div class="cell" style="width: 16.66%;">產品視圖</div>'.
                        '<div class="cell" style="width: 16.66%;">地位</div>'.
                    '</div>'.
                '</div>';

            foreach ($pending_token_users as $token_user) {

                $product = $wpdb->get_row($wpdb->prepare(
                    "SELECT `ID`, `post_title`, `post_name`, `post_content` FROM {$wpdb->posts} WHERE `ID` = %s;",
                    $token_user->post_id
                ));
                $user_info = get_userdata($token_user->user_id);
                $token = "";
                $status = "";
                if (!empty($product) && $user_info) {
                    $token = $token_user->token;
                    $status = '<form name="token_form" id="token_form_'.$token_user->id.'" method="post" action="">'.
                                    '<input type="hidden" name="token_user_id" value="'.$token_user->id.'">'.
                                    '<select name="select_token_value" value="'.$token_user->status.'" onchange="document.getElementById(\''."token_form_".$token_user->id.'\').submit()">'.
                                        '<option value="accept" '.($token_user->status == "accept" ? "selected" : "").'>接受</option>'.
                                        '<option value="pending" '.($token_user->status == "pending" ? "selected" : "").'>待辦的</option>'.
                                        '<option value="delete" '.($token_user->status == "delete" ? "selected" : "").'>刪除</option>'.
                                        '<option value="share" '.($token_user->status == "share" ? "selected" : "").'>分享</option>'.
                                    '</select>'.
                                '</form>';

                        echo '<div class="col-12">'.
                                '<div class="table">'.
                                    '<div class="cell" style="width: 16.66%;">'.$token_user->user_id."/".$user_info->display_name.'</div>'.
                                    '<div class="cell" style="width: 16.66%;">'.$user_info->user_email.'</div>'.
                                    '<div class="cell" style="width: 33.33%">'.$token.'</div>'.
                                    '<div class="cell" style="width: 16.66%;">'.
                                        '<a href="'.get_permalink($product->ID).'" target="_blank">看法</a>'.
                                    '</div>'.
                                    '<div class="cell" style="width: 16.66.33%;">'.
                                        $status.
                                    '</div>'.
                                '</div>'.
                            '</div>';
                }
            }
            echo "</div>";

            echo '<div style="margin: 30px"></div>';
        }

        echo "<div class='row'>";
        echo '<div class="col-12" style="border-bottom: 1px solid gray">'.
                '<div class="table">'.
                    '<div class="cell" style="width: 8.33%;">ID</div>'.
                    '<div class="cell" style="width: 16.66%;">產品名稱</div>'.
                    '<div class="cell">產品內容</div>'.
                    '<div class="cell" style="width: 8.33%;">查看頁面</div>'.
                    '<div class="cell" style="width: 16.66%;">地位</div>'.
                '</div>'.
            '</div>';

        $user_id = get_current_user_id();
        foreach ($products as $product) {
            $shared_value_by_post_id = $wpdb->get_row($wpdb->prepare(
                "SELECT `user_id`, `status`, `token` FROM {$table_name} WHERE `post_id` = %s;",
                $product->ID
            ));
            $token = "";
            $status = '<form name="product" method="post" action="">'.
                        '<input type="hidden" name="product_id" value="'.$product->ID.'">'.
                        '<input type="submit" name="share_product" class="save_btn" value="购买 TOKEN">'.
                '</form>';
            if (empty($shared_value_by_post_id)) {
//                $token = $shared_value_by_post_id->token;
//                if ($shared_value_by_post_id->status == "pending" || $shared_value_by_post_id->status == "accept" || $shared_value_by_post_id->status == "delete") {
//                    if($shared_value_by_post_id->user_id == $user_id || is_super_admin() || is_admin())
//                        $status = $shared_value_by_post_id->status; // "" share, pending, accept,delete
//                    else
//                    {
//                        $status = "由某人處理";
//                        $token = "***";
//                    }
//                }

            echo '<div class="col-12">'.
                    '<div class="table">'.
                        '<div class="cell" style="width: 8.33%;">'.$product->ID.'</div>'.
                        '<div class="cell" style="width: 16.66%;">'.$product->post_title.'</div>'.
                        '<div class="cell" style="text-align: left">'.$product->post_content.'</div>'.
                        '<div class="cell" style="width: 8.33%;">'.
                            '<a href="'.get_permalink($product->ID).'" target="_blank">看法</a>'.
                        '</div>'.
                        '<div class="cell" style="width: 16.66%;">'.
                            $status.
                        '</div>'.
                    '</div>'.
                '</div>';
            }
        }
        echo "</div>";
//        $shortcode_output = do_shortcode('[products]');
//        echo $shortcode_output;
    }

    protected function setup_query_filters( &$filters, &$filter_params ) {
        global $wpdb, $affiliates_db;
        $IX92454 = $this->get_affiliate_id();
        $filters = " WHERE 1=%d ";
        $filter_params = array( 1 );
        if ( $this->from_date ) {
            $IX31829 = DateHelper::u2s( $this->from_date );
        }
        if ( $this->thru_date ) {
            $IX82275 = DateHelper::u2s( $this->thru_date, 24*3600 );
        }
        if ( $this->from_date && $this->thru_date ) {
            $filters .= " AND r.datetime >= %s AND r.datetime <= %s "; $filter_params[] = $IX31829; $filter_params[] = $IX82275;
        }
        else if ( $this->from_date ) {
            $filters .= " AND r.datetime >= %s "; $filter_params[] = $IX31829;
        }
        else if ( $this->thru_date ) {
            $filters .= " AND r.datetime < %s "; $filter_params[] = $IX82275;
        }
        $filters .= " AND r.affiliate_id = %d ";
        $filter_params[] = $IX92454;
        $IX57366 = '';
        if ( is_array( $this->status ) && count( $this->status ) > 0 ) {
            $IX57366 = " AND ( r.status IS NULL OR r.status IN ('" . implode( "','", array_map( 'esc_sql', $this->status ) ) . "') ) ";
            $filters .= $IX57366;
        }
        $IX16460 = $wpdb->posts;
        $IX29658 = $affiliates_db->get_tablename( 'referral_items' );
        if ( $this->search !== null ) {
            $filters .= " AND r.referral_id IN ( SELECT DISTINCT ri.referral_id FROM $IX29658 ri LEFT JOIN $IX16460 p ON p.ID = ri.object_id AND ri.type = p.post_type WHERE p.post_title LIKE %s ) ";
            $filter_params[] = '%' . $wpdb->esc_like( $this->search ) . '%';
        }
    }
}
Affiliates_Dashboard_ShopList::init();
