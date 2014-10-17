<?php

namespace steinm6\CronHelper;

/**
 * Class CronHelper
 */
class CronHelper
{
	/**
	 * @var resource
	 */
	protected $file;

	/**
	 * @var string
	 */
	protected $filename;

	public function __construct($lockfile)
	{
		$this->file     = fopen($lockfile, 'w');
		$this->filename = $lockfile;
	}

	/**
	 * Locks the job and creates a locktime-file
	 *
	 * @return bool
	 */
	public function lock()
	{
		if (flock($this->file, LOCK_EX | LOCK_NB)) {
			file_put_contents($this->filename . "time", time()); // store starttime
			return true;
		}

		return false;
	}

	/**
	 * Unlock
	 */
	public function unlock()
	{
		unlink($this->filename);
		unlink($this->filename . "time");
	}

	/**
	 * Returns time passed since lock() was called in seconds
	 *
	 * @return int Seconds passed since lock
	 */
	public function getLockDuration()
	{
		$f    = fopen($this->filename . "time", "r");
		$time = intval(fread($f, filesize($this->filename . "time")));
		fclose($f);

		return time() - $time;
	}
}