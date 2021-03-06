cron-helper
===========

Simple helper to prevent parallel cronjob execution


Installation
-------------

### Composer

Require <code>"steinm6/cron-helper": "dev-master"</code>

### Manually

Just include the file <code>src/CronHelper.php</code>


Usage
------------

Initialize the CronHelper with a filename. The CronHelper will use this filename for locking up.

<code>$cron = new CronHelper('myfilename');</code>

To lock the execution call the lock()-function. To unlock the cronjob use the unlock()-function. You may determine how long the cronjob was locked by calling the getLockDuration()-function, which returns the time passed since the lock() in seconds.

Here is a basic example on how to use the CronHelper:

```php
use steinm6\CronHelper\CronHelper;

// Initialize CronHelper
$cron = new CronHelper('lockfile-name');

// lock this job
if ($cron->lock()) {
	foreach($x as $y){
		// You might want to reset the timer, to prevent running into the unlock() below...
		$cron->resetTimer();
		
		// Do something
		sleep(10);
	}
	$cron->unlock();
} else {
  // If the lock persists for 3600 seconds, something went wrong. Remove the lock so that the next cronjob is executed.
	if ($cron->getLockDuration() > 3600)
		$cron->unlock();
}

```
