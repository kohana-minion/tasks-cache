<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Purges the application, requires at least one cache configuration group to be 
 * specified
 *
 * Available config options: 
 *
 * --cache=cache1[,cache2,cache2...]
 *  
 *  Specify the caches to clear, each item in the list is the key of a cache 
 *  config group in config/cache.php
 *
 *  This is a required config option
 *
 * @author Matt Button <matthew@sigswitch.com>
 */
class Minion_Task_Cache_Purge extends Minion_Task
{
	/**
	 * An array of config options that this task can accept
	 */
	protected $_config = array('cache');

	/**
	 * Clears the cache
	 */
	public function execute(array $config)
	{
		if (empty($config['cache']))
		{
			return Minion_CLI::write('Please specify a set of cache configs.', 'red');
		}

		$config['cache'] = trim($config['cache'], ',');

		$caches = explode(',', $config['cache']);

		foreach ($caches as $cache)
		{
			Cache::instance($cache)
				->delete_all();
		}

		return Minion_CLI::write('Cleared caches for '.$config['cache'], 'green');
	}
}
