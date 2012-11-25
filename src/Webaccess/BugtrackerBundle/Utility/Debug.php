<?php

namespace Webaccess\BugtrackerBundle\Utility;

class Debug {

	static public function dd($string) {
		echo '<pre>';
		var_dump($string);
		echo '</pre>';
		die;
	}
}
