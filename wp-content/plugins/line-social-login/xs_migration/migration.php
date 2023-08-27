<?php

namespace WP_Social\Xs_Migration;

use WP_Social\Inc\Admin_Settings;

/**
 * Class Migration
 *
 * @package WP_Social\Xs_Migration
 */
class Migration extends Data_Migration {

	/**
	 *
	 * @param $wpOptionKey
	 * @param $executionPlanKey
	 * @param $existingOption
	 *
	 * @return array
	 */
	public function convert_from_1_3_0_to_1_3_1($wpOptionKey, $executionPlanKey, $existingOption) {

		$log = $existingOption['execution_plan'][$executionPlanKey]['log'];

		return [
			'status' => 'success',
			'log' => $log,
		];
	}


	/**
	 *
	 * @param $wpOptionKey
	 * @param $executionPlanKey
	 * @param $existingOption
	 *
	 * @return array
	 */
	public function convert_from_1_3_1_to_1_3_2($wpOptionKey, $executionPlanKey, $existingOption) {

		$log = $existingOption['execution_plan'][$executionPlanKey]['log'];

		return [
			'status' => 'success',
			'log' => $log,
		];
	}


	/**
	 *
	 * @param $wpOptionKey
	 * @param $executionPlanKey
	 * @param $existingOption
	 *
	 * @return array
	 */
	public function convert_from_1_3_2_to_1_3_3($wpOptionKey, $executionPlanKey, $existingOption) {

		$log = $existingOption['execution_plan'][$executionPlanKey]['log'];

		return [
			'status' => 'success',
			'log' => $log,
		];
	}


	/**
	 *
	 * @param $wpOptionKey
	 * @param $executionPlanKey
	 * @param $existingOption
	 *
	 * @return array
	 */
	public function convert_from_1_3_3_to_1_3_4($wpOptionKey, $executionPlanKey, $existingOption) {

		$log = $existingOption['execution_plan'][$executionPlanKey]['log'];

		return [
			'status' => 'success',
			'log' => $log,
		];
	}


	/**
	 *
	 * @param $wpOptionKey
	 * @param $executionPlanKey
	 * @param $existingOption
	 *
	 * @return array
	 */
	public function convert_from_1_3_4_to_1_3_5($wpOptionKey, $executionPlanKey, $existingOption) {

		$log = $existingOption['execution_plan'][$executionPlanKey]['log'];

		$checkList = $existingOption['execution_plan'][$executionPlanKey]['progress'][__FUNCTION__]['check_list'];
		$weightLifted = 0; #this value will be the programmers intuition, our goal is to not to give work more than 10 seconds

		if(empty($checkList)) {

			$checkList['option_updated'] = false;
			$checkList['form_data_processed'] = false;

			$existingOption['execution_plan'][$executionPlanKey]['progress'][__FUNCTION__]['check_list'] = $checkList;
		}


		if($checkList['option_updated'] === false) {

			$opt = $this->prepareOption_1_3_4_to_1_3_5();

			if(!empty($opt)) {

				foreach($opt as $opKey => $opVal) {

					//update_option($opKey, $opVal);
				}
			}

			$weightLifted += 30;    # AR: feeling it may take 3 seconds to return the result so putting 3*10 = 30;

			$checkList['option_updated'] = true;

			$existingOption['execution_plan'][$executionPlanKey]['progress'][__FUNCTION__]['check_list'] = $checkList;
		}


		if($weightLifted <= 100 && $checkList['form_data_processed'] === false) {

			$tmp = [];

			if(empty($existingOption['execution_plan'][$executionPlanKey]['progress'][__FUNCTION__]['form_data_processed'])) {

				#this is not hardcoded, we are assuming we have to query the post table and this is the total posts
				$tmp['total'] = 300;
				#We will process 50 queries per request, so this is mysql limit in the query
				$tmp['rate'] = 50;
				#This is the starting/progress done, in query it will be offset
				$tmp['offset'] = 0;
				#This is calculated from rate * offset
				$tmp['done'] = 0;

				$existingOption['execution_plan'][$executionPlanKey]['progress'][__FUNCTION__]['form_data_processed'] = $tmp;

			} else {

				$tmp = $existingOption['execution_plan'][$executionPlanKey]['progress'][__FUNCTION__]['form_data_processed'];
			}

			#Now we do not want to process more than 10 seconds[imagined],
			#Also keep checking if we finished all the data from database
			while($weightLifted < 100 && $tmp['done'] < $tmp['total']) {

				$tmp['offset']++;
				$tmp['done'] = $tmp['offset'] * $tmp['rate'];

				//do the work here
				//
				//

				#Now check if above work is the last of it, if then finish the task
				if($tmp['done'] >= $tmp['total']) {
					//this task is finished..
					$existingOption['execution_plan'][$executionPlanKey]['progress'][__FUNCTION__]['check_list']['form_data_processed'] = true;
				}

				$weightLifted += 70;    #feeling it may take 7 seconds or less
			}


			$existingOption['execution_plan'][$executionPlanKey]['progress'][__FUNCTION__]['form_data_processed'] = $tmp;

			if($weightLifted >= 100) {
				$existingOption['execution_plan'][$executionPlanKey]['progress'][__FUNCTION__]['status'] = self::STATUS_METHOD_PAUSED;
			}
		}

		#Now check if all the checklist is completed...
		$done = true;

		foreach($checkList as $item) {

			if($item === false) $done = false;
		}

		if($done === true) {

			#this means this method is completed all the work it supposed to do
			$existingOption['execution_plan'][$executionPlanKey]['progress'][__FUNCTION__]['status'] = self::STATUS_FINISHED;
		}


		//update_option($wpOptionKey, $existingOption);

		return [
			'status' => 'success',
			'log' => $log,
		];
	}


	/**
	 *
	 */
	private function prepareOption_1_3_4_to_1_3_5() {

		$keySDC = 'xs_style_setting_data_counter';
		$keySDS = 'xs_style_setting_data_share';


		$oldStructureOptions = [
			$keySDC => [
				'login_button_style' => 'style-class',
			],

			$keySDS => [
				'login_button_style' => 'style-class',
				'login_button_content' => 'style_name',
				'login_content' => '',
			]
		];


		$newStructureOptions = [
			$keySDC => [
				'login_button_style' => [
					'style' => 'style-1:wslu-none'
				],
			],

			$keySDS => [
				'login_button_content' => 'right_content', #def value

				'login_content' => 'before_content', #def value

				'main_content' => [
					'style' => 'style-1:wslu-none',
					'show_social_count_share' => '1',
				],

				'fixed_display' => [
					'style' => 'style-1:wslu-none',
					'show_social_count_share' => '1',
				],
			]
		];


		if(get_option($oldStructureOptions[$keySDC])) {

			if(!empty($oldStructureOptions[$keySDC]['login_button_style'])) {

				$styleArr = Admin_Settings::counter_styles();

				if( method_exists( \WP_Social_Pro\Inc\Admin_Settings::class, 'counter_hover_effects' ) ){

					$hoverArr = \WP_Social_Pro\Inc\Admin_Settings::counter_hover_effects();

				}else{

					$hoverArr = \WP_Social_Pro\Inc\Admin_Settings::$counter_hover_effects;
					
				}

				$foundKey = 'style-1';
				$defHoverKey = 'none-none';

				foreach($styleArr as $key => $item) {

					if($item['class'] == $oldStructureOptions[$keySDC]['login_button_style']) {

						$foundKey = $key;

						break;
					}
				}


				$newStructureOptions[$keySDC]['login_button_style']['style'] = $styleArr[$foundKey]['class'] . ':' . $hoverArr[$defHoverKey]['class'];

			} else {

				unset($newStructureOptions[$keySDC]);
			}
		}


		if(get_option($oldStructureOptions[$keySDS])) {

			if(!empty($oldStructureOptions[$keySDS]['login_content'])) {

				$newStructureOptions[$keySDS]['login_content'] = $oldStructureOptions[$keySDS]['login_content'];
			}

			if(!empty($oldStructureOptions[$keySDS]['login_button_content'])) {

				$newStructureOptions[$keySDS]['login_button_content'] = $oldStructureOptions[$keySDS]['login_button_content'];
			}

			if(!empty($oldStructureOptions[$keySDS]['login_button_style'])) {

				$styleArr = Admin_Settings::share_styles();

				if( method_exists( \WP_Social_Pro\Inc\Admin_Settings::class, 'share_hover_effects' ) ){
					
					$hoverArr = \WP_Social_Pro\Inc\Admin_Settings::share_hover_effects();
	
				}else{
	
					$hoverArr = \WP_Social_Pro\Inc\Admin_Settings::$share_hover_effects;					
				}

				
				$foundKey = 'style-1';
				$defHoverKey = 'none-none';

				foreach($styleArr as $key => $item) {

					if($item['class'] == $oldStructureOptions[$keySDC]['login_button_style']) {

						$foundKey = $key;

						break;
					}
				}

				$newStructureOptions[$keySDS]['main_content']['style'] = $styleArr[$foundKey]['class'] . ':' . $hoverArr[$defHoverKey]['class'];
				$newStructureOptions[$keySDS]['fixed_display']['style'] = $styleArr[$foundKey]['class'] . ':' . $hoverArr[$defHoverKey]['class'];
			}
		}

	}

}