<?php
/**
 * class-affiliates-settings-general.php
 *
 * Copyright (c) 2010 - 2015 "kento" Karim Rahimpur www.itthinx.com
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
 * @since affiliates 2.8.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * General settings section.
 */
class Affiliates_Settings_General extends Affiliates_Settings {

	/**
	 * Renders the general settings section.
	 */
	public static function section() {

		global $wp, $wpdb, $affiliates_options, $wp_roles;

		if ( isset( $_REQUEST['subsection'] ) && $_REQUEST['subsection'] === 'robot-cleaner' ) {
			Affiliates_Robot_Cleaner::admin();
			echo '<p style="border-top: 1px solid #ccc; margin: 8px 0; padding: 8px 0;">';
			if ( !isset( $_REQUEST['action'] ) ) {
				$url = add_query_arg(
					array( 'section' => 'general' ),
					admin_url( 'admin.php?page=affiliates-admin-settings' )
				);
			} else {
				$url = add_query_arg(
					array( 'section' => 'general', 'subsection' => 'robot-cleaner' ),
					admin_url( 'admin.php?page=affiliates-admin-settings' )
				);
			}
			printf(
				'<a class="button" href="%s">%s</a>',
				esc_url( $url ),
				esc_html__( '後退', 'affiliates' )
			);
			echo '</p>';
			return;
		}

		$robots_table = _affiliates_get_tablename( 'robots' );

		if ( isset( $_POST['submit'] ) ) {

			if (
				isset( $_POST[AFFILIATES_ADMIN_SETTINGS_NONCE] ) &&
				wp_verify_nonce( $_POST[AFFILIATES_ADMIN_SETTINGS_NONCE], 'admin' )
			) {

				// robots
				$robots = wp_filter_nohtml_kses( trim ( $_POST['robots'] ) );
				$wpdb->query( "DELETE FROM $robots_table" );
				if ( !empty( $robots ) ) {
					$robots = str_replace( ",", "\n", $robots );
					$robots = str_replace( "\r", "", $robots );
					$robots = explode( "\n", $robots );
					foreach ( $robots as $robot ) {
						$robot = trim( $robot );
						if (!empty($robot)) {
							$query = $wpdb->prepare( "INSERT INTO $robots_table (name) VALUES (%s);", $robot );
							$wpdb->query( $query );
						}
					}
				}

				$pname = !empty( $_POST['pname'] ) ? trim( $_POST['pname'] ) : get_option( 'aff_pname', AFFILIATES_PNAME );
				$forbidden_names = array();
				if ( !empty( $wp->public_query_vars ) ) {
					$forbidden_names += $wp->public_query_vars;
				}
				if ( !empty( $wp->private_query_vars ) ) {
					$forbidden_names += $wp->private_query_vars;
				}
				if ( !empty( $wp->extra_query_vars ) ) {
					$forbidden_names += $wp->extra_query_vars;
				}
				if ( !preg_match( '/[a-z_]+/', $pname, $matches ) || !isset( $matches[0] ) || $pname !== $matches[0] ) {
					$pname = get_option( 'aff_pname', AFFILIATES_PNAME );
					echo '<div class="error">' . __( '聯屬營銷 URL 參數名稱<strong>尚未更改</strong>，建議名稱<em>​​無效</em>。 只允許使用小寫字母和下劃線 _。', 'affiliates' ) . '</div>';
				} else if ( in_array( $pname, $forbidden_names ) ) {
					$pname = get_option( 'aff_pname', AFFILIATES_PNAME );
					echo '<div class="error">' . __( '聯屬營銷 URL 參數名稱<strong>尚未更改</strong>，建議的名稱<em>​​被禁止</em>。', 'affiliates' ) . '</div>';
				}
				$old_pname = get_option( 'aff_pname', AFFILIATES_PNAME );
				if ( $pname !== $old_pname ) {
					update_option( 'aff_pname', $pname );
					affiliates_update_rewrite_rules();
					echo '<div class="info">' .
						'<p>' .
						sprintf(
							__( '聯屬營銷URL 參數名稱<strong>已更改</strong>，從<em><strong>%s</strong></em> 更改為<em><strong>%s</strong></em> 。', 'affiliates' ),
							$old_pname,
							$pname
						) .
						'</p>' .
						'<p class="warning">' .
						__( '如果您的聯屬營銷人員使用基於之前的聯屬營銷 URL 參數名稱的聯屬營銷鏈接，他們<strong>需要</strong>更新其聯屬營銷鏈接。', 'affiliates' ) .
						'</p>' .
						'<p class="warning">' .
						__( '除非傳入的聯屬營銷鏈接反映當前的聯屬營銷 URL 參數名稱，否則不會記錄任何联屬營銷點擊、訪問或推薦。', 'affiliates' ) .
						'</p>' .
						'</div>';
				}

				$redirect = !empty( $_POST['redirect'] );
				if ( $redirect ) {
					if ( get_option( 'aff_redirect', null ) === null ) {
						add_option( 'aff_redirect', 'yes', '', 'no' );
					} else {
						update_option( 'aff_redirect', 'yes' );
					}
				} else {
					delete_option( 'aff_redirect' );
				}

				$encoding_id = $_POST['id_encoding'];
				if ( true ) { // key_exists( $encoding_id, affiliates_get_id_encodings() )
					// important: must use normal update_option/get_option otherwise we'd have a per-user encoding
					update_option( 'aff_id_encoding', $encoding_id );
				}

				$rolenames = $wp_roles->get_names();
				$caps = array(
					AFFILIATES_ACCESS_AFFILIATES => __( 'Access affiliates', 'affiliates' ),
					AFFILIATES_ADMINISTER_AFFILIATES => __( 'Administer affiliates', 'affiliates' ),
					AFFILIATES_ADMINISTER_OPTIONS => __( 'Administer options', 'affiliates' ),
				);
				foreach ( $rolenames as $rolekey => $rolename ) {
					$role = $wp_roles->get_role( $rolekey );
					foreach ( $caps as $capkey => $capname ) {
						$role_cap_id = $rolekey.'-'.$capkey;
						if ( !empty($_POST[$role_cap_id] ) ) {
							$role->add_cap( $capkey );
						} else {
							$role->remove_cap( $capkey );
						}
					}
				}
				// prevent locking out
				_affiliates_assure_capabilities();

				if ( !affiliates_is_sitewide_plugin() ) {
					delete_option( 'aff_delete_data' );
					add_option( 'aff_delete_data', !empty( $_POST['delete-data'] ), '', 'no' );
				}

				self::settings_saved_notice();
			}
		}

		$robots = '';
		$db_robots = $wpdb->get_results( "SELECT name FROM $robots_table", OBJECT );
		foreach ($db_robots as $db_robot ) {
				$robots .= $db_robot->name . "\n";
		}

		$pname    = get_option( 'aff_pname', AFFILIATES_PNAME );
		$redirect = get_option( 'aff_redirect', false );

		$id_encoding = get_option( 'aff_id_encoding', AFFILIATES_NO_ID_ENCODING );
		$id_encoding_select = '';
		$encodings = affiliates_get_id_encodings();
		if ( !empty( $encodings ) ) {
			$id_encoding_select .= '<label class="id-encoding" for="id_encoding">' . __('會員 ID 編碼', 'affiliates' ) . '</label>';
			$id_encoding_select .= '<select class="id-encoding" name="id_encoding">';
			foreach ( $encodings as $key => $value ) {
				if ( $id_encoding == $key ) {
					$selected = ' selected="selected" ';
				} else {
					$selected = '';
				}
				$id_encoding_select .= '<option ' . $selected . ' value="' . esc_attr( $key ) . '">' . esc_attr( $value ) . '</option>';
			}
			$id_encoding_select .= '</select>';
		}

		$rolenames = $wp_roles->get_names();
		$caps = array(
			AFFILIATES_ACCESS_AFFILIATES => __( 'Access affiliates', 'affiliates' ),
			AFFILIATES_ADMINISTER_AFFILIATES => __( 'Administer affiliates', 'affiliates' ),
			AFFILIATES_ADMINISTER_OPTIONS => __( 'Administer options', 'affiliates' ),
		);
		$caps_table = '<table class="affiliates-permissions">';
		$caps_table .= '<thead>';
		$caps_table .= '<tr>';
		$caps_table .= '<td class="role">';
		$caps_table .= __( 'Role', 'affiliates' );
		$caps_table .= '</td>';
		foreach ( $caps as $cap ) {
			$caps_table .= '<td class="cap">';
			$caps_table .= $cap;
			$caps_table .= '</td>';
		}
		$caps_table .= '</tr>';
		$caps_table .= '</thead>';
		$caps_table .= '<tbody>';
		foreach ( $rolenames as $rolekey => $rolename ) {
			$role = $wp_roles->get_role( $rolekey );
			$caps_table .= '<tr>';
			$caps_table .= '<td>';
			$caps_table .= translate_user_role( $rolename );
			$caps_table .= '</td>';
			foreach ( $caps as $capkey => $capname ) {
				if ( $role->has_cap( $capkey ) ) {
					$checked = ' checked="checked" ';
				} else {
					$checked = '';
				}
				$caps_table .= '<td class="checkbox">';
				$role_cap_id = $rolekey.'-'.$capkey;
				$caps_table .= '<input type="checkbox" name="' . $role_cap_id . '" id="' . $role_cap_id . '" ' . $checked . '/>';
				$caps_table .= '</td>';
			}
			$caps_table .= '</tr>';
		}
		$caps_table .= '</tbody>';
		$caps_table .= '</table>';

		$delete_data = get_option( 'aff_delete_data', false );

		do_action( 'affiliates_settings_general_before_form' );

		echo
			'<form action="" name="options" method="post">' .
			'<div>';

		echo
			'<h3>' . __( '關聯 URL 參數名稱', '關聯', 'affiliates' ) . '</h3>' .
			'<p>' .
			'<input class="pname" name="pname" type="text" value="' . esc_attr( $pname ) . '" />' .
			'</p>' .
			'<p>' .
			sprintf( __( '當前聯屬營銷 URL 參數名稱為：<b>%s</b>', 'affiliates' ), $pname ) .
			'</p>' .
			'<p>' .
			sprintf( __( '默認聯屬營銷 URL 參數名稱為 <em>%s</em>。', 'affiliates' ), AFFILIATES_PNAME ) .
			'</p>' .
			'<p class="description warning">' .
			__( '注意：如果您更改此設置並分發了附屬鏈接或永久鏈接，請確保這些鏈接已更新。 除非傳入的聯屬鏈接反映當前 URL 參數名稱，否則不會記錄聯屬點擊、訪問或推薦。', 'affiliates' ) .
			'</p>';

		echo
			'<h3>' . __( '重定向', 'affiliates' ) . '</h3>' .
			'<p>' .
			'<label>' .
			sprintf( '<input class="redirect" name="redirect" type="checkbox" %s/>', $redirect ? ' checked="checked" ' : '' ) .
			' ' .
			__( '重定向', 'affiliates' ) .
			'</label>' .
			'</p>' .
			'<p class="description">' .
			__( '在檢測到聯屬鏈接點擊後，重定向到不帶聯屬 URL 參數的目標。', 'affiliates' ) .
			'</p>';

		echo
			'<h3>' . __( '會員 ID 編碼', 'affiliates' ) . '</h3>' .
			'<p>' .
			$id_encoding_select .
			'</p>' .
			'<p>' .
			sprintf( __( '當前有效的編碼是：<b>%s</b>', 'affiliates' ), $encodings[$id_encoding] ) .
			'</p>' .
			'<p class="description warning">' .
			__( '注意：如果您更改此設置並分發了附屬鏈接或永久鏈接，請確保這些鏈接已更新。 除非傳入的聯屬鏈接反映當前編碼，否則不會記錄聯屬點擊、訪問或推薦。', 'affiliates' ) .
			'</p>';

		echo
			'<h3>' . __( '權限', 'affiliates' ) . '</h3>' .
			'<p>' .
			__( '不要在此處為​​附屬機構分配開放訪問權限。', 'affiliates' ) .
			' ' .
			__( '本節僅旨在向特權角色授予對附屬管理功能的管理訪問權限。', 'affiliates' ) .
			'</p>' .
			$caps_table .
			'<p class="description">' .
			__( '將保留最少的權限集。', 'affiliates' ) .
			'<br/>' .
			__( '如果您將自己鎖在門外，請請求管理員幫助。', 'affiliates' ) .
			'</p>';

		echo
			'<h3>' . __( '機器人', 'affiliates' ) . '</h3>' .
			'<p>' .
			//'<label for="robots">' . __( 'Robots', 'affiliates' ) . '</label>' .
			'<textarea id="robots" name="robots" rows="10" cols="45">' . wp_filter_nohtml_kses( $robots ) . '</textarea>' .
			'</p>' .
			'<p>' .
			__( '這些機器人對聯屬鏈接的點擊將被標記或不記錄。 每行放置一個條目。', 'affiliates' ) .
			'</p>';
		echo '<p>' .
			sprintf(
				esc_html__( '使用機器人清潔器刪除機器人中現有的命中：%s', 'affiliates' ),
				sprintf(
					'<a class="button" href="%s">%s</a>',
					add_query_arg(
						array( 'section' => 'general', 'subsection' => 'robot-cleaner' ),
						admin_url( 'admin.php?page=affiliates-admin-settings' )
					),
					esc_html__( '掃地機器人', 'affiliates' )
				)
			);
		echo '</p>';

		if ( !affiliates_is_sitewide_plugin() ) {
			echo
				'<h3>' . __( '停用和數據持久化', 'affiliates' ) . '</h3>' .
				'<p>' .
				'<label>' .
				'<input name="delete-data" type="checkbox" ' . ( $delete_data ? 'checked="checked"' : '' ) . '/>' .
				' ' .
				__( '停用時刪除所有插件數據', 'affiliates' ) .
				'</label>' .
				'</p>' .
				'<p class="description warning">' .
				__( '注意：如果在插件停用時此選項處於活動狀態，則所有附屬機構和推薦數據都將被刪除。 如果您想檢索有關您的聯屬會員及其推薦的數據並打算停用該插件，請確保備份您的數據或不要啟用此選項。 啟用此選項即表示您同意對任何數據丟失或由此產生的任何其他後果承擔全部責任。', 'affiliates' ) .
				'</p>';
		}

		echo
			'<p>' .
			wp_nonce_field( 'admin', AFFILIATES_ADMIN_SETTINGS_NONCE, true, false ) .
			'<input class="button button-primary" type="submit" name="submit" value="' . __('節省', 'affiliates' ) . '"/>' .
			'</p>' .
			'</div>' .
			'</form>';

		do_action( 'affiliates_settings_general_after_form' );

		
	}
}
