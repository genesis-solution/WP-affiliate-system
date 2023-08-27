<?php

namespace WP_Social\Xs_Migration;


/**
 * Class Data_Migration
 *
 * @package WP_Social\Xs_Migration
 */
abstract class Data_Migration implements Migration_Contract {

	const STATUS_DONE       = 'done';
	const STATUS_QUEUED     = 'queued';
	const STATUS_RUNNING    = 'running';

	const STATUS_FINISHED   = 'finished';
	const STATUS_INITIATED  = 'initiated';

	const STATUS_METHOD_PAUSED      = 'paused';
	const STATUS_METHOD_EXECUTED    = 'executed';
	const STATUS_METHOD_EXECUTING   = 'executing';

	/**
	 * @param $txtDomain
	 * @param $versionFrom
	 * @param $versionTo
	 *
	 * @return mixed
	 */
	public function input($txtDomain, $versionFrom, $versionTo) {

		#$versionFrom = '1.1.9';
		#$versionTo   = '1.2.0';
		$optionKey = 'data_migration_'.$txtDomain.'_log';

		$from   = str_replace('.', '_', trim($versionFrom));
		$to     = str_replace('.', '_', trim($versionTo));

		$frm = $this->makeFullVersionKey($from);
		$trm = $this->makeFullVersionKey($to);

		$log        = [];
		$verCache   = [];
		$exPKey     = $frm.'_'.$trm;

		$verCache['o_from'] = $versionFrom;
		$verCache['u_from'] = $from;
		$verCache['p_from'] = $frm;
		$verCache['o_to']   = $versionTo;
		$verCache['u_to']   = $to;
		$verCache['p_to']   = $trm;

		$existingOption = get_option($optionKey);

		if(!$existingOption) {

			$existingOption             = [];
			$existingOption['status']   = self::STATUS_INITIATED;
			$existingOption['plan_key'] = $exPKey;

			$cStack = $this->getCallStacks([], $frm, $trm);

			$existingOption['map'] = $cStack['map'];

			$existingOption['execution_plan'][$exPKey]['status']    = self::STATUS_RUNNING;
			$existingOption['execution_plan'][$exPKey]['stack']     = $cStack['stack'];
			$existingOption['execution_plan'][$exPKey]['available'] = $cStack['func'];
			$existingOption['execution_plan'][$exPKey]['executing'] = '';
			$existingOption['execution_plan'][$exPKey]['executed']  = [];
			$existingOption['execution_plan'][$exPKey]['failed']    = [];
			$existingOption['execution_plan'][$exPKey]['progress']  = [];
			$existingOption['execution_plan'][$exPKey]['log']       = [];
			$existingOption['execution_plan'][$exPKey]['version']   = $verCache;

			$existingOption['plan_log'][$exPKey] = 'Execution plan '.$exPKey. ' initiated at '.date('Y-m-d H:i:s'). ' .' . PHP_EOL;

			$log[] = 'Conversion initiated for version '. $versionFrom .' to '. $versionTo. ' at '.date('Y-m-d H:i:s').'.';
			$log[] = 'Execution plan prepared.';
			$log[] = 'Execution plan saved into database.';


			if(empty($existingOption['execution_plan'][$exPKey]['stack'])) {

				$log[] = '- No Conversion method found for '. $versionFrom .' to '. $versionTo .'';
				$log[] = '-- exiting....';
				$log[] = 'Execution plan executed at '.date('Y-m-d H:i:s').'.';
				$log[] = '----------------------------------------------------------';


				$existingOption['execution_plan'][$exPKey]['status'] = self::STATUS_FINISHED;
				$existingOption['execution_plan'][$exPKey]['log']   = $log;
				$existingOption['plan_log'][$exPKey] .= 'Execution plan '.$exPKey. ' finished at '.date('Y-m-d H:i:s'). ' .' . PHP_EOL;
				$existingOption['status']   = self::STATUS_FINISHED;

				//update_option($optionKey, $existingOption);

				return [
					'status' => 'success',
					'log' => $log,
				];
			}

			$curExecMethod = array_shift($existingOption['execution_plan'][$exPKey]['stack']);

			$existingOption['execution_plan'][$exPKey]['executing'] = $curExecMethod;
			$existingOption['execution_plan'][$exPKey]['progress'][$curExecMethod] = [
				'status' => self::STATUS_QUEUED,
				'check_list' => [],
			];


			$log[] = 'Execution plan '.$exPKey.' has started at '.date('Y-m-d H:i:s').'.';
			$log[] = '- Conversion method '. $curExecMethod . ' entered into queue at '.date('Y-m-d H:i:s').'.';
			$log[] = '-- Method '.$curExecMethod.' is executing....';


			$existingOption['execution_plan'][$exPKey]['log'] = $log;
			$existingOption['execution_plan'][$exPKey]['log'][] = '-- ....';
			$existingOption['execution_plan'][$exPKey]['progress'][$curExecMethod]['status'] = self::STATUS_METHOD_EXECUTING;

			//update_option($optionKey, $existingOption);

			return $this->$curExecMethod($optionKey, $exPKey, $existingOption);
			//return $existingOption;
		}

		#We have reached this point,
		#this means we do not have previously saved progress into database
		#Now we are checking the status of the execution plan....

		if($existingOption['status'] === self::STATUS_INITIATED) {

			#this is the initiated plan key, it must be defined by the programmer when status is set to initiated.
			$planKey    = $existingOption['plan_key'];
			$planStat   = $existingOption['execution_plan'][$planKey]['status'];
			$log        = $existingOption['execution_plan'][$planKey]['log'];

			if($planStat === self::STATUS_DONE) {

				#the execution plan has been executed but some how the status of the migration status is not finished
				#If a plan is done then migration status must be finished............................................
				#So we will do nothing but change the migration status finished......................................
				#though this should never happened...................................................................

				$existingOption['status'] = self::STATUS_FINISHED;

				$log[] = '-- ! Migration status is initiated but execution plan ' .$planKey. ' is finished. This is a potential bug, we are finishing the execution plan at '.date('Y-m-d H:i:s');
				$log[] = '------------------------------------------------------------------------------';

				$existingOption['execution_plan'][$planKey]['log'] = $log;

				//update_option($optionKey, $existingOption);

				return [
					'status' => 'success',
					'log' => $log,
				];
			}

			#Execution plan is not finished................
			#We will execute all the methods from stack....
			$mtdKey     = $existingOption['execution_plan'][$planKey]['executing'];
			$mtdStat    = $existingOption['execution_plan'][$planKey]['progress'][$mtdKey]['status'];

			if($mtdStat == self::STATUS_QUEUED || $mtdStat == self::STATUS_METHOD_PAUSED) {

				$existingOption['execution_plan'][$planKey]['progress'][$mtdKey] = [
					'status' => self::STATUS_METHOD_EXECUTING,
				];

				//update_option($optionKey, $existingOption);

				return $this->$mtdKey($optionKey, $planKey, $existingOption);
			}

			if($mtdStat == self::STATUS_METHOD_EXECUTING) {

				#Someone initiated the method execution, so in this interval we will do nothing.
				return $log;
			}

			if($mtdStat == self::STATUS_METHOD_EXECUTED) {

				#the method we were executing and it was finished, now we will enter new method in execution queue.
				#this method will enter into executed stack...................................................

				$existingOption['execution_plan'][$planKey]['executed'][] = $mtdKey;
				$existingOption['execution_plan'][$planKey]['executing'] = '';

				if(empty($existingOption['execution_plan'][$planKey]['stack'])) {

					#All the method from call stack has been executed
					#Now we will finish the plan and the migration...

					$existingOption['status'] = self::STATUS_FINISHED;
					$existingOption['execution_plan'][$planKey]['status'] = self::STATUS_DONE;
					//$existingOption['execution_plan'][$planKey]['version'] = $verCache;
					$existingOption['plan_key'] = '';


					$log[] = 'Conversion method '.$mtdKey.' has finished all its conversion and check list.';
					$log[] = 'Calling stack is finished.';
					$log[] = 'Execution plan executed and data conversion from '.$verCache['o_from']. ' to '.$verCache['o_to'].' at '.date('Y-m-d H:i:s').'.';
					$log[] = '...................................................................................';

					$existingOption['execution_plan'][$planKey]['log'] = $log;

					//update_option($optionKey, $existingOption);

					return [
						'status' => 'success',
						'log' => $log,
					];
				}

				#Call stack is not finished,
				#So we will queued the next method from stack

				$nx = array_pop($existingOption['execution_plan'][$planKey]['stack']);

				$existingOption['execution_plan'][$planKey]['executing'] = $nx;

				$existingOption['execution_plan'][$planKey]['progress'][$nx] = [
					'status' => self::STATUS_METHOD_EXECUTING,
					'check_list' => [],
				];

				$log[] = '- Conversion method '. $nx . ' entered into queue at '.date('Y-m-d H:i:s').'.';
				$log[] = '-- Method '. $nx. ' is executing...';

				$existingOption['execution_plan'][$planKey]['log'] = $log;
				$existingOption['execution_plan'][$planKey]['log'][] = '-- ....';

				//update_option($optionKey, $existingOption);

				return $this->$nx($optionKey, $planKey, $existingOption);
			}

			return [
				'status' => 'error',
				'log' => [
					'Execution mtdStat error, method undefined.'
				],
			];
		}

		if($existingOption['status'] === self::STATUS_FINISHED) {

			#In scenario could happen like someone initiated plan 001003003_001003004
			#and now they want to migrate/initiate plan 001003004_001003005..........
			#........................................................................

			if(empty($existingOption['execution_plan'][$exPKey])) {

				$existingOption['status']   = self::STATUS_INITIATED;
				$existingOption['plan_key'] = $exPKey;

				$cStack = $this->getCallStacks([], $frm, $trm);

				$existingOption['map'] = $cStack['map'];

				$existingOption['execution_plan'][$exPKey]['status']    = self::STATUS_RUNNING;
				$existingOption['execution_plan'][$exPKey]['stack']     = $cStack['stack'];
				$existingOption['execution_plan'][$exPKey]['available'] = $cStack['func'];
				$existingOption['execution_plan'][$exPKey]['executing'] = '';
				$existingOption['execution_plan'][$exPKey]['executed']  = [];
				$existingOption['execution_plan'][$exPKey]['failed']    = [];
				$existingOption['execution_plan'][$exPKey]['progress']  = [];
				$existingOption['execution_plan'][$exPKey]['log']       = [];
				$existingOption['execution_plan'][$exPKey]['version']   = $verCache;

				$existingOption['plan_log'][$exPKey] = 'Execution plan '.$exPKey. ' initiated at '.date('Y-m-d H:i:s'). ' .' . PHP_EOL;

				$log[] = 'Conversion initiated for version '. $versionFrom .' to '. $versionTo. ' at '.date('Y-m-d H:i:s').'.';
				$log[] = 'Execution plan prepared.';
				$log[] = 'Execution plan saved into database.';


				if(empty($existingOption['execution_plan'][$exPKey]['stack'])) {

					$log[] = '- No Conversion method found for '. $versionFrom .' to '. $versionTo .'';
					$log[] = '-- exiting the execution plan....';
					$log[] = 'Calling stack is finished.';
					$log[] = 'Execution plan executed and data conversion from '.$versionFrom. ' to '.$versionTo.' at '.date('Y-m-d H:i:s').'.';
					$log[] = '...................................................................................';

					$existingOption['execution_plan'][$exPKey]['status'] = self::STATUS_FINISHED;
					$existingOption['execution_plan'][$exPKey]['log']   = $log;
					$existingOption['plan_log'][$exPKey] .= 'Execution plan '.$exPKey. ' finished at '.date('Y-m-d H:i:s'). ' .' . PHP_EOL;
					$existingOption['status']   = self::STATUS_FINISHED;

					//update_option($optionKey, $existingOption);

					return [
						'status' => 'success',
						'log' => $log,
					];
				}

				$curExecMethod = array_shift($existingOption['execution_plan'][$exPKey]['stack']);

				$existingOption['execution_plan'][$exPKey]['executing'] = $curExecMethod;
				$existingOption['execution_plan'][$exPKey]['progress'][$curExecMethod] = [
					'status' => self::STATUS_QUEUED,
					'check_list' => [],
				];


				$log[] = 'Execution plan '.$exPKey.' has started at '.date('Y-m-d H:i:s').'.';
				$log[] = '- Conversion method '. $curExecMethod . ' entered into queue at '.date('Y-m-d H:i:s').'.';
				$log[] = '-- Method '.$curExecMethod.' is executing....';

				$existingOption['execution_plan'][$exPKey]['log'] = $log;
				$existingOption['execution_plan'][$exPKey]['log'][] = '-- ....';
				$existingOption['execution_plan'][$exPKey]['progress'][$curExecMethod]['status'] = self::STATUS_METHOD_EXECUTING;

				//update_option($optionKey, $existingOption);

				return $this->$curExecMethod($optionKey, $exPKey, $existingOption);
				//return $existingOption;
			}


			#This is the scenario where migration status is finished
			#and there are also configuration with execution plan
			#.......................................................

			#Now execution plan could be finished
			#that means user already migrated version $from to $to [e.g 1.3.4 to 1.3.5]
			#and they again trying to migrate same version to version
			#..........................................................................
			if($existingOption['execution_plan'][$exPKey]['status'] === self::STATUS_DONE) {

				return [
					'status' => 'success',
					'log' => $existingOption['execution_plan'][$exPKey]['log'],
				];
			}

			#In no scenario this should happened, only when there is a mistake from programmer or corrupt data.

			return [
				'status' => 'error',
				'log' => [
					'Could not act on given request. Logical flow detected.'
				],
			];
		}


		return [
			'status' => 'error',
			'log' => [
				'Exiting...data is corrupted.'
			],
		];
	}


	/**
	 *
	 * @param array $data
	 */
	public function output(array $data) {

		if(!empty($data['option'])) {

			foreach($data['option'] as $opKey => $opVal) {

				update_option($opKey, $opVal);
			}
		}
	}


	/**
	 *
	 * @param $versionMap
	 * @param $frm
	 * @param $trm
	 *
	 * @return array
	 */
	private function getCallStacks($versionMap, $frm, $trm) {

		$callStack = [];
		$conversionMethods = [];
		$methods = get_class_methods($this);

		foreach($methods as $method) {

			if(substr($method, 0, 13) === 'convert_from_') {

				$conversionMethods[] = $method;

				$tmp = str_replace('convert_from_', '', $method);
				$tmp = explode('_to_', $tmp);

				$vl = $this->makeFullVersionKey($tmp[0]);
				$vh = $this->makeFullVersionKey($tmp[1]);

				$versionMap[$vl] = $tmp[0];
				$versionMap[$vh] = $tmp[1];
			}
		}


		ksort($versionMap);

		foreach($versionMap as $k => $v) {

			if($k >= $frm && $k < $trm) {

				$fnc = '';

				foreach($conversionMethods as $conversionMethod) {

					if(strpos($conversionMethod, 'convert_from_'.$v) !== false) {

						$fnc = $conversionMethod;

						break;
					}
				}

				if(!empty($fnc)) {
					$callStack[] = $fnc;
				}
			}
		}

		return [
			'map' => $versionMap,
			'func' => $conversionMethods,
			'stack' => $callStack,
		];
	}

	/**
	 *
	 * @param $string
	 *
	 * @return string
	 */
	public function makeFullVersionKey($string) {

		$fr = explode('_', $string);

		$frm = array_map(function($item){
			return str_pad($item, 3, '0', STR_PAD_LEFT);
		}, $fr);

		return implode('', $frm);
	}

}