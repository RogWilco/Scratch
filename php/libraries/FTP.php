<?php
/**
 * Handles remote FTP connections and performs standard operations on remote
 * files and directories.
 * 
 * Note: Currently supports UNIX hosts. Support for Windows-based hosts is not
 * yet fully implemented.
 *
 * @author Nick Williams
 * @version 1.0.0
 */
class FTP implements ArrayAccess, Countable, SeekableIterator {
	const TIMEOUT = 90;
	
	const MODE_BINARY = FTP_BINARY;
	const MODE_ASCII = FTP_ASCII;
	
	const SYS_UNIX = 'UNIX';
	const SYS_WIN32 = 'WIN32';

	protected $_connection;
	protected $_blocking = true;
	protected $_hostname;
	protected $_hostport = 21;
	protected $_username;
	protected $_password;
	protected $_path;
	protected $_systype;
	protected $_ds = '/';
	protected $_iPosition = 0;
	
	/**
	 * Initializes a connection using the specified URI.
	 *
	 * @param string $uri a URI describingi the desired FTP resource
	 */
	public function __construct($uri, $autoConnect = true) {
		// Parse the URI
		$components = parse_url($uri);
		
		if($components['scheme'] == 'ftp') {
			foreach($components as $component => $value) {
				switch($component) {
					case 'host':
						$this->_hostname = $value;
						break;
						
					case 'port':
						$this->_port = $value;
						break;
						
					case 'user':
						$this->_username = $value;
						break;
						
					case 'pass':
						$this->_password = $value;
						break;
						
					case 'path':
						$this->_path = $value;
						break;
				}
			}
			
			if($autoConnect) {
				$this->connect();
			}
		}
		else {
			throw new Exception('Invalid scheme specified. Only FTP is supported.');
		}
	}
	
	/**
	 * Automatically triggered when the object is no longer needed. Any
	 * open FTP connections will be terminated.
	 */
	public function __destruct() {
		if($this->_connection) {
			$this->disconnect();
		}
	}
	
	/**
	 * Returns the total number of entities (files and directories) contained
	 * within the present working directory.
	 *
	 * @return int the calculated total
	 * @throws Exception when no active connection is available
	 */
	public function count() {
		return count($this->rawlist());
	}
	
	/**
	 * Checks if the specified offset exists for the present working directory.
	 *
	 * @param mixed $offset the offset to be checked
	 * @return bool whether or not the offset exists
	 * @throws Exception when no active connection is available
	 */
	public function offsetExists($offset) {
		// Setup
		$result = false;
		$tempPath = false;
		
		if(strpos($offset, $this->ds)) {
			$tempPath = true;
			$end = strrpos($offset, $this->ds);
			$origPath = $this->pwd();
			$newPath = substr($offset, 0, $end) . $this->ds;
			$offset = substr($offset, $end + 1);
			
			$this->chdir($newPath);
		}

		$entities = $this->rawlist('-1F');
		
		if(count($entities)) {
			if(preg_match('/^[d\-]{1}[\-rwx]{9}/', $entities[0])) {
				$result = (bool) count(preg_grep('/^\S+\s+\S+\s+\S+\s+\S+\s+\S+\s+\S+\s+\S+\s+\S+\s+((.*)+)$/', $entities));
			}
			else {
				$result = (in_array($offset, $entities) || in_array($offset . '*', $entities));
			}
		}
		
		if($tempPath) {
			$this->chdir($origPath);
		}
	}
	
	/**
	 * Retrieves the file matching the specified offset.
	 *
	 * @param mixed $offset the offset representing the file to be retrieved
	 * @return string the corresponding file's contents
	 * @throws Exception when no active connection is available
	 */
	public function offsetGet($offset) {
		// Setup
		$result = null;
		$tempPath = false;
		
		if(strpos($offset, $this->ds)) {
			$tempPath = true;
			$end = strrpos($offset, $this->ds);
			$origPath = $this->pwd();
			$newPath = substr($offset, 0, $end) . $this->ds;
			$offset = substr($offset, $end + 1);
			
			$this->chdir($newPath);
		}

		$entities = $this->rawlist('-1F');
		
		if(is_array($entities) && count($entities)) {
			if((preg_match('/^[d\-]{1}[\-rwx]{9}/', $entities[0]) && count(preg_grep('/^\S+\s+\S+\s+\S+\s+\S+\s+\S+\s+\S+\s+\S+\s+\S+\s+((.*)+)$/', $entities)))
					|| (in_array($offset, $entities) || in_array($offset . '*', $entities))) {
				$temp = fopen('php://temp', 'r+');
				
				if($this->fget($temp, $offset, self::MODE_ASCII, 0)) {
					rewind($temp);
					$result = stream_get_contents($temp);
				}
			}
		}
		
		if($tempPath) {
			$this->chdir($origPath);
		}
		
		return $result;
	}
	
	/**
	 * Writes the specified value as the contents of the file represented by
	 * the specified offset.
	 *
	 * @param mixed $offset the offset representing the remote file
	 * @param string $value the data to be written to the remote file
	 * @throws Exception when no active connection is available
	 */
	public function offsetSet($offset, $value) {
		// Setup
		$tempPath = false;
		
		if(strpos($offset, $this->ds)) {
			$tempPath = true;
			$end = strrpos($offset, $this->ds);
			$origPath = $this->pwd();
			$newPath = substr($offset, 0, $end) . $this->ds;
			$offset = substr($offset, $end + 1);
			
			$this->chdir($newPath);
		}

		$entities = $this->rawlist('-1F');
		
		if(is_array($entities) && count($entities)) {
			if((preg_match('/^[d\-]{1}[\-rwx]{9}/', $entities[0]) && count(preg_grep('/^\S+\s+\S+\s+\S+\s+\S+\s+\S+\s+\S+\s+\S+\s+\S+\s+((.*)+)$/', $entities)))
					|| (in_array($offset, $entities) || in_array($offset . '*', $entities))) {
				$this->offsetUnset($offset);
			}
		}
		
		$temp = fopen('php://temp', 'r+');
			
		fwrite($temp, $value);
		rewind($temp);
		
		$this->fput($offset, $temp, self::MODE_ASCII, 0);
		
		if($tempPath) {
			$this->chdir($origPath);
		}
	}
	
	/**
	 * Deletes the remote file denoted by the specified offset.
	 *
	 * @param mixed $offset the offset representing the remote file
	 * @throws Exception when no active connection is available
	 */
	public function offsetUnset($offset) {
		// Setup
		$tempPath = false;
		
		if(strpos($offset, $this->ds)) {
			$tempPath = true;
			$end = strrpos($offset, $this->ds);
			$origPath = $this->pwd();
			$newPath = substr($offset, 0, $end) . $this->ds;
			$offset = substr($offset, $end + 1);
			
			$this->chdir($newPath);
		}

		$entities = $this->rawlist('-1F');
		
		if(is_array($entities) && count($entities)) {
			if((preg_match('/^[d\-]{1}[\-rwx]{9}/', $entities[0]) && count(preg_grep('/^\S+\s+\S+\s+\S+\s+\S+\s+\S+\s+\S+\s+\S+\s+\S+\s+((.*)+)$/', $entities)))
					|| (in_array($offset, $entities) || in_array($offset . '*', $entities))) {
				$this->delete($offset);
			}
		}
		
		if($tempPath) {
			$this->chdir($origPath);
		}
	}
	
	/**
	 * Moves the internal pointer to the entity having the specified position.
	 *
	 * @param int $position the desired position to seek
	 */
	public function seek($position) {
		// Require Active Connection
		$this->_getCurrentConnection();
		
		$this->_iPosition = $position;
		
		if(!$this->valid()) {
			throw new OutOfBoundsException('Invalid seek position: ' . $position);
		}
	}
	
	/**
	 * Retrieves the entity to which the current internal pointer references.
	 *
	 * @return string the contents of the requested entity (if a file), null if a directory
	 */
	public function current() {
		// Require Active Connection
		$this->_getCurrentConnection();
		
		// Retrieve Directory Contents
		$entities = $this->ls();
		
		return $this->offsetGet($entities[$this->_iPosition]);
	}
	
	/**
	 * Returns the current position of the internal pointer.
	 *
	 * @return int the current position index
	 */
	public function key() {
		// Require Active Connection
		$this->_getCurrentConnection();
		
		return $this->_iPosition;
	}
	
	/**
	 * Advances the internal pointer.
	 */
	public function next() {
		// Require Active Connection
		$this->_getCurrentConnection();
		
		++$this->_iPosition;
	}
	
	/**
	 * Reverses the internal pointer.
	 */
	public function rewind() {
		// Require Active Connection
		$this->_getCurrentConnection();
		
		$this->_iPosition = 0;
	}
	
	/**
	 * Indicates whether or not the current position references a
	 * valid file or directory.
	 *
	 * @return bool whether or not the current position is valid
	 */
	public function valid() {
		// Require Active Connection
		$this->_getCurrentConnection();
		
		// Retrieve Directory Contents
		$entities = $this->ls();
		
		return array_key_exists($this->_iPosition, $entities);
	}
	
	/**
	 * Retrieves the currently active connection. Triggers an exception if
	 * an active connection is not available.
	 *
	 * @return resource the currently active connection
	 * @throws Exception when no active connection is available
	 */
	protected function _getCurrentConnection() {
		if(!$this->_connection) {
			$backtrace = debug_backtrace();
			$class = $backtrace[1]['class'];
			$method = $backtrace[1]['function'];
			
			throw new Exception($class . '::' . $method . '() requires an active FTP connection.');
		}
		
		return $this->_connection;
	}
	
	/**
	 * Attempts to make a connection using the currently stored properties.
	 *
	 * @return bool whether or not the connection was successful
	 */
	public function connect() {
		// Setup
		$result = false;
	
		// Close Existing Connection
		$this->disconnect();
	
		// Make Connection
		if($this->_port && $this->_port != 21) {
			$this->_connection = ftp_connect($this->_hostname, $this->_port);
		}
		else {
			$this->_connection = ftp_connect($this->_hostname);
		}
		
		// Authenticate
		if($this->_connection) {
			$result = true;
			
			if($this->_username) {
				$result = ftp_login($this->_connection, $this->_username, $this->_password);
			}
		}
		
		// Change Directory
		if($this->_path) {
			$this->chdir($this->_path);
		}
		
		$this->_path = $this->pwd();
		
		switch($this->systype()) {
			default:
			case 'UNIX':
				$this->_systype = self::SYS_UNIX;
				break;
		}
		
		// Directory Separator
		switch($this->_systype) {
			default:
			case self::SYS_UNIX:
				$this->_ds = '/';
				break;
				
			case self::SYS_WIN32:
				$this->_ds = '\\';
				break;
		}
		
		return $result;
	}
	
	/**
	 * Disconnects an open FTP connection.
	 *
	 * @return bool whether or not the connection was closed successfully
	 */
	public function disconnect() {
		// Setup
		$result = true;
		
		if($this->_connection) {
			$result = ftp_close($this->_connection);
		}
		
		return $result;
	}
	
	/**
	 * Returns an array of all entities within the current directory.
	 *
	 */
	public function ls() {
		// Setup
		$result = array();
		
		// Retrieve Directory Contents
		$entities = $this->rawlist('-1F');
		
		// Parse File/Directory Names
		if(is_array($entities) && count($entities)) {
			$result = preg_filter('/^(\S+\s+\S+\s+\S+\s+\S+\s+\S+\s+\S+\s+\S+\s+\S+\s+)?/', '', $entities);
			$result = preg_grep('/^([^.]|\.(?!\/$|(\.(?=\/$))))(.*)$/', $result);
		}
		
		return $result;
	}
	
	/**
	 * Allocates space for a file to be uploaded (on servers that
	 * support/require the ALLOC command).
	 *
	 * @param int $fileSize the number of bytes to be allocated
	 * @param string &$result a textual representation of the server's response, returned by reference
	 * @return bool whether or not the operation was successful
	 * @throws Exception if an active connection isn't available
	 */
	public function alloc($fileSize, &$result) {
		return ftp_alloc($this->_getCurrentConnection(), $fileSize, $result);
	}
	
	/**
	 * Changes to the parent directory.
	 *
	 * @return bool whether or not the operation was successful
	 * @throws Exception if an active connection isn't available
	 */
	public function cdup() {
		return ftp_cdup($this->_getCurrentConnection());
	}
	
	/**
	 * Changes the present working directory to the specified path.
	 *
	 * @param string $path the desired path to be used
	 * @return bool whether or not the operation was successful
	 * @throws Exception if an active connection isn't available
	 */
	public function chdir($path) {
		return ftp_chdir($this->_getCurrentConnection(), $path);
	}
	
	/**
	 * Sets permissions on the specified file on the remote server.
	 *
	 * @param int $mode the new permissions, given as an octal value
	 * @param string $filename the name of the file to be modified
	 * @return bool whether or not the operation was successful
	 * @throws Exception if an active connection isn't available
	 */
	public function chmod($mode, $filename) {
		return ftp_chmod($this->_getCurrentConnection(), $mode, $filename);
	}
	
	/**
	 * Deletes the specified file on the remote server.
	 *
	 * @param string $path the path describing the file to be deleted
	 * @return bool whether or not the operation was successful
	 * @throws Exception if an active connection isn't available
	 */
	public function delete($path) {
		return ftp_delete($this->_getCurrentConnection(), $path);
	}
	
	/**
	 * Requests the execution of a command on the remote server.
	 *
	 * @param string $command the command to be executed
	 * @return bool whether or not the operation was successful
	 * @throws Exception if an active connection isn't available
	 */
	public function exec($command) {
		return ftp_exec($this->_getCurrentConnection(), $command);
	}
	
	/**
	 * Retrieves a file from the remote server and writes it to a local resource.
	 *
	 * @param resource $localResource the local resource to which the file will be written
	 * @param string $remoteFile the path to the remote file
	 * @param int $mode the transfer mode (FTP::MODE_ASCII or FTP::MODE_BINARY)
	 * @param int $resumePosition the position in the remote file at which to start downloading
	 */
	public function fget($localResource, $remoteFile, $mode = FTP::MODE_BINARY, $resumePosition = 0) {
		return ftp_fget($this->_getCurrentConnection(), $localResource, $remoteFile, $mode, $resumePosition);
	}
	
	/**
	 * Writes to a file on the remote server with data from a local resource.
	 *
	 * @param string $remoteFile the path to the remote file
	 * @param resource $localResource the local resource from which the file will be written
	 * @param int $mode the transfer mode (FTP::MODE_ASCII or FTP::MODE_BINARY)
	 * @param int $startPosition the position in the remote file at which to start writing
	 */
	public function fput($remoteFile, $localResource, $mode = FTP::MODE_BINARY, $startPosition = 0) {
		return ftp_fput($this->_getCurrentConnection(), $remoteFile, $localResource, $mode, $startPosition);
	}
	
	/**
	 * Downloads a file from the remote server.
	 *
	 * @param string $localFile the path to the local file
	 * @param string $remoteFile the path to the remote file
	 * @param int $mode the transfer mode (FTP::MODE_ASCII or FTP::MODE_BINARY)
	 * @param int $resumePosition the position in the remote file at which to start downloading
	 * @return bool whether or not the operation was successful
	 * @throws Exception if an active connection isn't available
	 */
	public function get($localFile, $remoteFile, $mode = FTP::MODE_BINARY, $resumePosition = 0) {
		return ftp_get($this->_getCurrentConnection(), $localFile, $remoteFile, $mode, $resumePosition);
	}
	
	/**
	 * Returns the modified timestamp of the specified file.
	 *
	 * @param string $remoteFile the file to be examined
	 * @return int the last modified time as a Unix timestamp
	 * @throws Exception if an active connection isn't available
	 */
	public function mdtm($remoteFile) {
		return ftp_mdtm($this->_getCurrentConnection(), $remoteFile);
	}
	
	/**
	 * Creates the specified directory.
	 *
	 * @param string $path the path for the desired directory
	 * @return mixed either the created directory's name, or false on failure
	 * @throws Exception if an active connection isn't available
	 */
	public function mkdir($path) {
		return ftp_mkdir($this->_getCurrentConnection(), $path);
	}
	
	/**
	 * Toggles passive mode on or off.
	 *
	 * @param bool $pasv whether or not passive mode should be enabled
	 * @return bool whether or not the operation was successful
	 * @throws Exception if an active connection isn't available
	 */
	public function pasv($pasv) {
		return ftp_pasv($this->_getCurrentConnection(), $pasv);
	}
	
	/**
	 * Uploads a file to the remote server.
	 *
	 * @param string $remoteFile the path to the remote file
	 * @param string $localFile the path to the local file
	 * @param int $mode the transfer mode (FTP::MODE_ASCII or FTP::MODE_BINARY)
	 * @param int $startPosition the position in the remote file at which to start uploading
	 * @return bool whether or not the operation was successful
	 * @throws Exception if an active connection isn't available
	 */
	public function put($remoteFile, $localFile, $mode = FTP::MODE_BINARY, $startPosition = 0) {
		return ftp_put($this->_getCurrentConnection(), $remoteFile, $localFile, $mode, $startPosition);
	}
	
	/**
	 * Returns the present working directory for an active connection.
	 *
	 * @return mixed either the current path, or false on failure
	 * @throws Exception if an active connection isn't available
	 */
	public function pwd() {
		return ftp_pwd($this->_getCurrentConnection());
	}
	
	/**
	 * Sends a raw FTP command to the server.
	 *
	 * @param string $command the command to be used
	 * @return array the server's response as an array of strings
	 * @throws Exception if an active connection isn't available
	 */
	public function raw($command) {
		return ftp_raw($this->_getCurrentConnection(), $command);
	}
	
	/**
	 * Retrieves detailed list of files in the present working directory.
	 *
	 * @param string $path the path to the desired directory
	 * @param bool $recursive whether or not to recursively list all files in subdirectories (LIST -R)
	 * @return array the corresponding list
	 * @throws Exception if an active connection isn't available
	 */
	public function rawlist($path = '', $recursive = false) {
		return ftp_rawlist($this->_getCurrentConnection(), ($path ? $path : $this->_path), $recursive);
	}
	
	/**
	 * Renames a file or directory.
	 *
	 * @param string $oldName the current name of the file or directory
	 * @param string $newName the new name to be used
	 * @return bool whether or not the operation was successful
	 * @throws Exception if an active connection isn't available
	 */
	public function rename($oldName, $newName) {
		return ftp_rename($this->_getCurrentConnection(), $oldName, $newName);
	}
	
	/**
	 * Removes a directory.
	 *
	 * @param string $path the path describing the directory to be removed
	 * @return bool whether or not the operation was successful
	 * @throws Exception if an active connection isn't available
	 */
	public function rmdir($path) {
		return ftp_rmdir($this->_getCurrentConnection(), $path);
	}
	
	/**
	 * Sends a SITE command to the server.
	 *
	 * @param string $command the command to be used
	 * @return bool whether or not the operation was successful
	 * @throws Exception if an active connection isn't available
	 */
	public function site($command) {
		return ftp_site($this->_getCurrentConnection(), $command);
	}
	
	/**
	 * Checks the size of the specified file.
	 *
	 * @param string $path the path to the file
	 * @return int the corresponding size of the file, or -1 on failure
	 * @throws Exception if an active connection isn't available
	 */
	public function size($path) {
		return ftp_size($this->_getCurrentConnection(), $path);
	}
	
	/**
	 * Returns the system type identifier of the remote server.
	 *
	 * @return string the remote system type, or false on failure
	 * @throws Exception if an active connection isn't available
	 */
	public function systype() {
		return ftp_systype($this->_getCurrentConnection());
	}
}