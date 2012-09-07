<?php
/**
 * Provides a standardized blueprint for implementing the sinleton pattern.
 *
 * @author Nick Williams
 * @version 1.0.0
 * @created 09/07/2012
 * @updated 09/07/2012
 */
abstract class Singleton {
	/**
	 * @var Object contains a single instance of the current class
	 */
	protected static $_instance;

	/**
	 * Initializes a new instance and stores it internally.
	 *
	 * @return object the newly created instance
	 */
	public static function init() {
		// Setup
		$class = get_called_class();
		$reflection = new ReflectionClass($class);
		$args = func_get_args();

		// Initialize New Instance
		static::$_instance = $reflection->newInstanceArgs($args);

		return static::$_instance;
	}

	/**
	 * Deinitializes the currently stored instance.
	 *
	 * @return void
	 */
	public static function deinit() {
		unset(self::$_instance);
	}

	/**
	 * Retrieves the currently stored instance.
	 *
	 * @throws \Exception if an instance hasn't been initialized
	 * @return mixed the currently stored instance
	 */
	public static function instance() {
		if(!isset(self::$_instance)) {
			throw new \Exception('No singleton instance is available for this class. Ensure the ::init() method has been invoked.');
		}

		return static::$_instance;
	}
}
