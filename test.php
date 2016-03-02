<?php

require 'vendor/autoload.php';

use Jaybizzle\Rankinity;

$test = new Rankinity('26484d02dfd00e3470e74f0d86a620df');

//$r = $test->limit(1)->getEnvironments();

// $r = $test
// 	->environment_id(6113)
// 	->triggerDeployment();

//$t = $test->getProjects();
$t = $test->project('558d1d93c9268eb9950000f3')->searchEngine('5250108048d943be4c000923')->search('Aerospace engineering graduate programme')->getRanks();

//$test->triggerDeployment();

var_dump($t);
