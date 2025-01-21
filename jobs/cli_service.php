<?php

$root_dir = dirname(dirname(__FILE__));
$i = 1;
while (true) {

	// send queue
	syslog(LOG_INFO, 'sending queued email.');
	exec("php {$root_dir}/public/index.php cli_service send_email_queue");

	// resend every 5 minutes
	if ($i % 5 == 0) {
		syslog(LOG_INFO, 'resending failed email.');
		exec("php {$root_dir}/public/index.php cli_service resend_failed_email");		
	}

	// check eclink payments
	syslog(LOG_INFO, 'check eclink payment.');
	exec("php {$root_dir}/public/index.php cli_service check_committed_payments");

	$i++;
	sleep(60);
}