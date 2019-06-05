<?php
define('NETWORK_SIZE', 8);

require_once 'class.network.php';



try {
	$n = new Network(NETWORK_SIZE);

	$n->connect(1, 2);
	$n->connect(2, 6);
	$n->connect(1, 6);
	$n->connect(2, 4);

	$n->connect(5, 8);


//	if ( $n->query(1, 2) ) echo '1 and 2 connected';
//	else echo '1 and 2 NOT connected';
//
//	if ( $n->query(1, 3) ) echo '1 and 3 connected';
//	else echo '1 and 3 NOT connected';
//
//	if ( $n->query(1, 6) ) echo '1 and 6 connected';
//	else echo '1 and 6 NOT connected';
//
	if ( $n->query(1, 4) ) echo '1 and 4 connected';
	else echo '1 and 4 NOT connected';


} catch (Exception $e) {
	echo 'Caught exception: ',  $e->getMessage(), "\n";
}


?>