<?php

require "quickex/utils/UID.php";

for($i = 0; $i < 10; $i++) {
	$uid = \quickex\utils\UID::generate();
	var_dump($uid);
}

