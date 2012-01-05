<?php
/**
 * URL Object
 *
 * Provides an object representation of a URL upon which operations can be made.
 *
 * @author Nick Williams
 * @version 1.0.0
 */
class URL implements ArrayAccess, Countable, SeekableIterator {
	protected $_protocol;
	protected $_host;
	protected $_port;
	protected $_username;
	protected $_password;
	protected $_path;
	protected $_fragment;
	protected $_params;

	/**
	 * Initializes a new URL object.
	 *
	 * @param mixed $urlString a URL string with which to initialize, or true to use the current request URL
	 */
	public function __construct($urlString = null) {
		// Default to Current URL
		if($urlString === null) {
			$urlString = 'http' . ($_SERVER['HTTPS'] ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . ($_SERVER['SERVER_PORT'] != '80' ? ':' . $_SERVER['SERVER_PORT'] : '') . $_SERVER['REQUEST_URI'];
		}

		// Parse URL
		$parts = parse_url($urlString);

		if($parts) {
			$this->_protocol = $parts['scheme'];
			$this->_host = $parts['host'];
			$this->_port = $parts['port'];
			$this->_username = $parts['user'];
			$this->_password = $parts['pass'];
			$this->_path = $parts['path'];
			$this->_fragment = $parts['fragment'];
			$this->_params = array();

			$params = explode('&', $parts['query']);

			foreach($params as $param) {
				list($key, $value) = array_map('urldecode', explode('=', $param));
				$this->_params[$key] = $value;
			}
		}
	}

	/**
	 * Returns the current URL as a string.
	 *
	 * @return string the assembled URL
	 */
	public function __toString() {
		// Build: Protocol
		$result = $this->_protocol . '://';

		// Build: Username/Password
		if($this->_username) {
			$result .= $this->_username;

			if($this->_password) {
				$result .= ':' . $this->_password;
			}

			$result .= '@';
		}

		// Build: Host
		$result .= $this->_host;

		// Build: Port
		if($this->_port) {
			$result .= ':' . $this->_port;
		}

		// Build: Path
		if($this->_path) {
			$result .= $this->_path;
		}

		// Build: Parameters
		if(is_array($this->_params) && count($this->_params)) {
			$result .= '?' . http_build_query($this->_params);
		}

		// Build: Fragment
		if($this->_fragment) {
			$result .= '#' . urlencode($this->_fragment);
		}

		return $result;
	}

	/**
	 * Sets the specified property. Valid properties include protocol, host,
	 * port, username, password, path, and fragment.
	 *
	 * @param string $name the name of the property to be set
	 * @param string $value the value to assign to the specified property
	 */
	public function __set($name, $value) {
		switch($name) {
			default:
				throw new Exception('Invalid property "' . $name . '" specified.');
				break;

			case 'protocol':
			case 'host':
			case 'port':
			case 'username':
			case 'password':
			case 'path':
			case 'fragment':
				$this->_{$name} = $value;
				break;
		}
	}

	/**
	 * Retrieves the current value for the specified property. Valid properties
	 * include protocol, host, port, username, password, path, and fragment.
	 *
	 * @return string the corresponding property's value
	 */
	public function __get($name) {
		switch($name) {
			default:
				throw new Exception('Invalid property "' . $name . '" specified.');
				break;

			case 'protocol':
			case 'host':
			case 'port':
			case 'username':
			case 'password':
			case 'path':
			case 'fragment':
				return $this->_{$name};
				break;
		}
	}

	/**
	 * Checks if the specified URL parameter exists.
	 *
	 * @param string $offset the name of the parameter to be checked
	 * @return boolean whether or not the parameter exists
	 */
	public function  offsetExists($offset) {
		return isset($this->_params[$offset]);
	}

	/**
	 * Retrieves the requested URL parameter.
	 *
	 * @param string $offset the name of the parameter to be retrieved
	 * @return string the corresponding parameter's value
	 */
	public function  offsetGet($offset) {
		return isset($this->_params[$offset]) ? $this->_params[$offset] : null;
	}

	/**
	 * Sets the specified URL parameter to the specified value.
	 *
	 * @param string $offset the name of the parameter to be set
	 * @param string $value the value to be assigned
	 */
	public function  offsetSet($offset, $value) {
		if($value === null) {
			$this->offsetUnset($offset);
		}
		else {
			$this->_params[$offset] = $value;
		}
	}

	/**
	 * Removes the specified URL parameter.
	 *
	 * @param string $offset the name of the parameter to be removed
	 */
	public function  offsetUnset($offset) {
		unset($this->_params[$offset]);
	}

	/**
	 * Returns the total number of URL parameters currently set.
	 *
	 * @return integer the calculated total
	 */
	public function count() {
		return count($this->_params);
	}

	/**
	 * Returns the value of the current parameter.
	 *
	 * @return string the corresponding value
	 */
	public function current() {
		return current($this->_params);
	}

	/**
	 * Returns the key for the current parameter.
	 *
	 * @return scalar the current key
	 */
	public function key() {
		return key($this->_params);
	}

	/**
	 * Advances the internal array pointer for the currently stored parameters.
	 */
	public function next() {
		return next($this->_params);
	}

	/**
	 * Rewinds the internal array pointer for the currently stored parameters.
	 */
	public function rewind() {
		return reset($this->_params);
	}

	/**
	 * Checks if the current internal array pointer is pointing to a valid parameter.
	 */
	public function valid() {
		return (current($this->_params) !== false);
	}

	/**
	 * Attempts to move the internal array pointer to the specified location.
	 *
	 * @param int $index the desired position
	 */
	public function  seek($index) {
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
	 * Returns a copy of the current URL object.
	 *
	 * @param array $params an optional array of parameters to add/replace within the copied URL
	 * @return self the newly created copy
	 */
	public function copy($params = array()) {
		// Setup
		$result = new self($this->__toString());

		foreach($params as $key => $value) {
			$result[$key] = $value;
		}

		return $result;
	}
}