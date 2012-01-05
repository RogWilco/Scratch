<?php
/**
 * A class for caching form data.
 *
 * @author Nick Williams
 * @version 1.0.0
 */
class FormCache implements ArrayAccess, Countable, SeekableIterator {
	protected static $_forms = array();
	protected $_values = array();

	/**
	 * Initializes a new FormCache object.
	 *
	 * @param array $values optional values to include during initialization
	 */
	public function __construct($values = array()) {
		if(count($values)) {
			$this->_values = $values;
		}
	}

	/**
	 * Saves stored form caches to the session.
	 */
	public static function sleep() {
		if(!session_id()) {
			session_start();
		}

		$_SESSION['formcache'] = self::$_forms;
	}

	/**
	 * Loads stored form caches from the session.
	 */
	public static function wakeup() {
		if(!session_id()) {
			session_start();
		}

		self::$_forms = $_SESSION['formcache'];
	}

	/**
	 * Stores the specified FormCache for later use (can be preserved across
	 * page loads).
	 *
	 * @param string $form the name of the form whose cache is to be stored
	 * @param FormCache $cache a valid FormCache instance
	 */
	public static function store($form, $cache) {
		if($cache instanceof FormCache) {
			self::$_forms[$form] = $cache;
		}
		else {
			throw new Exception('Unknown value specified, only valid FormCache objects can be stored.');
		}
	}

	/**
	 * Loads the requested form cache if stored, otherwise returns false.
	 *
	 * @param string $form the name of the form whose cache is to be returned
	 * @return mixed either the corresponding FormCache or false if not found
	 */
	public static function load($form) {
		if(self::$_forms[$form] instanceof self) {
			return self::$_forms[$form];
		}
		else {
			return new self();
		}
	}

	/**
	 * Adds the specified field's value to the cache.
	 *
	 * @param string $field the name of the field to add to the cache
	 */
	public function add($field) {
		if(isset($_POST[$field])) {
			$this->set($field, $_POST[$field]);
		}
	}

	/**
	 * Clears the specified value from the cache, or clears the entire cache
	 * when no field is specified.
	 *
	 * @param string $field the field to clear
	 */
	public function clear($field = null) {
		if($field === null) {
			$this->_values = array();
		}
		else {
			$this->offsetUnset($field);
		}
	}

	/**
	 * Sets the specified value, or uses an optional default if empty.
	 *
	 * @param string $name the name of the value to set
	 * @param mixed $value the value to set
	 * @param mixed $default a default value to set
	 */
	public function set($name, $value, $default = null) {
		if(empty($value)) {
			$this->__set($name, $default);
		}
		else {
			$this->__set($name, $value);
		}
	}

	/**
	 * Gets the requested value, or an optional default if not found.
	 *
	 * @param string $name the name of the valueu to get
	 * @param mixed $default a default value to return
	 * @return mixed the corresponding value
	 */
	public function get($name, $default = null) {
		if(!isset($this->_values[$name])) {
			return $default;
		}
		else {
			return $this->__get($name);
		}
	}

	/**
	 * Sets the specified value.
	 *
	 * @param string $name the name of the value to set
	 * @param mixed $value the value
	 */
	public function __set($name, $value) {
		$this->_values[$name] = $value;
	}

	/**
	 * Retrieves the requested value.
	 *
	 * @param string $name the name of the value to retrieve
	 * @return mixed the corresponding value
	 */
	public function __get($name) {
		return $this->_values[$name];
	}

	/**
	 * Checks if the specified value is currently set.
	 *
	 * @param string $name the name of the value to check
	 * @return boolean whether or not the value is set
	 */
	public function __isset($name) {
		return $this->offsetExists($name);
	}

	/**
	 * Unsets the specified value if set.
	 *
	 * @param string $name the name of the value to unset
	 */
	public function __unset($name) {
		$this->offsetUnset($name);
	}

		/**
	 * Checks if the specified offset is in use.
	 *
	 * @param mixed $offset the offset to check
	 * @return boolean whether or not the specified offset exists
	 */
	public function offsetExists($offset) {
		return array_key_exists($offset, $this->_values);
	}

	/**
	 * Retrieves the element at the specified offset.
	 *
	 * @param mixed $offset the offset to use
	 * @return mixed the corresponding element
	 */
	public function offsetGet($offset) {
		if($this->offsetExists($offset)) {
			return $this->_values[$offset];
		}
		else {
			return null;
		}
	}

	/**
	 * Sets the element at the specified offset to the specified value.
	 *
	 * @param mixed $offset the offset at which to set the value
	 * @param mixed $value the value to apply
	 */
	public function offsetSet($offset, $value) {
		$this->_values[$offset] = $value;
	}

	/**
	 * Unsets the element at the specified offset.
	 *
	 * @param mixed $offset the offset of the element to unset
	 */
	public function offsetUnset($offset) {
		unset($this->_values[$offset]);
	}

	/**
	 * Return the total number of stored elements.
	 *
	 * @return integer the total number of stored elements
	 */
	public function count() {
		return count($this->_values);
	}

	/**
	 * Return the current element.
	 *
	 * @return mixed the element
	 */
	public function current() {
		return current($this->_values);
	}

	/**
	 * Return the key of the current element.
	 *
	 * @return integer the current element's key
	 */
	public function key() {
		return key($this->_values);
	}

	/**
	 * Move forward to the next element.
	 *
	 * @return boolean returns TRUE on success, FALSE on failure
	 */
	public function next() {
		return next($this->_values);
	}

	/**
	 * Rewind to the first element.
	 *
	 * @return boolean returns TRUE on success, FALSE on failure
	 */
	public function rewind() {
		return reset($this->_values);
	}

	/**
	 * Seek to an absolute position.
	 *
	 * @param integer $index position to seek to
	 */
	public function seek($index) {
		$this->rewind();
		$position = 0;

		while($position < $index && $this->valid()) {
			$this->next();
			$position++;
		}

		if(!$this->valid()) {
			throw new Exception('Invalid seek position.');
		}
	}

	/**
	 * Check if there is a current element after calls to rewind() or next().
	 *
	 * @return boolean whether or not the internal pointer points to a valid element
	 */
	public function valid() {
		return (current($this->_values) !== false);
	}
}