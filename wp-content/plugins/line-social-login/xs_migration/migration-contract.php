<?php

namespace WP_Social\Xs_Migration;


interface Migration_Contract {

	public function input($txtDomain, $versionFrom, $versionTo);

	public function output(array $data);
}