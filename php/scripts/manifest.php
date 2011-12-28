<?php
/**
 * HTML 5 Manifest Generator
 *
 * A "smart" manifest generator, allowing for wildcards in filenames and
 * directories. Specifies which documents should be cached, require a
 * network connection, or can fallback to a cache if a connection is not
 * available.
 *
 * @author Nick Williams
 * @version 1.0.0
 */

// =============================================================================
// Configuration
// =============================================================================

// -----------------------------------------------------------------------------
// Options
// -----------------------------------------------------------------------------
$options = array(
	'always_unique' => true				// Every page load returns unique manifest (whether modified or not).
);

// -----------------------------------------------------------------------------
// Manifest Structure
// -----------------------------------------------------------------------------
// Defines the what files should be included in each section.

$manifest = array(
	'CACHE' => array(
		'css/*',
		'img/*.*',
		'js/*',
		'tmpl/*',
		'favicon.ico',
		'index.php'
	),
	'NETWORK' => array(
		'ajax.php'
	),
	'FALLBACK' => array()
);

// -----------------------------------------------------------------------------
// Ignore Patterns
// -----------------------------------------------------------------------------
// Files listed above that match these regular expression patterns will be
// ignored.

$ignore = array(
	'/^manifest/',			// manifest*.*
	'/\.manifest$/'			// *.manifest
);

// =============================================================================

// Output Headers
header('Content-Type: text/cache-manifest');

// Process Manifest
foreach($manifest as $section => $files) {
	if($section != 'FALLBACK') {
		$manifest[$section] = traversePaths($files);
	}
}

/**
 * Traverses the specified array of paths, extracting all filenames for paths
 * with wildcards.
 *
 * @param array $paths the paths to be traversed
 * @return array the corresponding list of files
 */
function traversePaths($paths = array()) {
	// Setup
	$result = array();

	while($paths && $path = array_pop($paths)) {
		if($path == '*') {
			$path = './*';
		}

		$pos = strpos($path, '*');

		if($pos && $pos == (strlen($path) - 1) && substr($path, -2, 1) == '/') {
			// Directory Contents
			$path = substr($path, 0, -1);
			$dir = opendir($path);

			if($path == './') {
				$path = '';
			}

			while($dir && $file = readdir($dir)) {
				if(ignore($file)) continue;

				if(is_dir($path . $file)) {
					$paths[] = $path . $file . '/*';
				}
				else {
					$result[] = $path . $file;
				}
			}
		}
		// Partial Filename
		elseif($pos) {
			$parts = explode('/', $path);

			if(is_array($parts)) {
				$pattern = array_pop($parts);
				$path = implode('/', $parts);
			}
			else {
				$pattern = $parts;
				$path = '';
			}

			$dir = opendir($path);

			if((strpos($pattern, '*') - 1) != strlen($pattern)) {
				$patternParts = explode('*', $patternParts);
				$pre = $patternParts[0];
				$post = $patternParts[1];
			}
			else {
				$pre = substr($pattern, 0, -1);
				$post = '';
			}

			while($dir && $file = readdir($dir)) {
				if(ignore($file)) continue;

				if(is_file($path . '/' . $file)) {
					if($pattern == '*.*' || ($pre == substr($file, 0, strlen($pre)) && $post == substr($file, -1 * strlen($post)))) {
						$result[] = $path . '/' . $file;
					}
				}
			}
		}
		else {
			$result[] = $path;
		}
	}

	return $result;
}

/**
 * Checks if the specified filename should be ignored when parsing directory
 * listings.
 *
 * @param string $file the filename to be checked
 * @return boolean whether or not the file should be ignored
 */
function ignore($file) {
	// Setup
	global $ignore;
	$result = false;
	
	foreach($ignore as $pattern) {
		if(preg_match($pattern, $file)) {
			$result = true;
			break;
		}
	}
	
	return $result;
}

// Output Manifest
echo 'CACHE MANIFEST' . "\n";
echo "\n";

if($options['always_unique']) {
	echo '# Updated:' . "\t" . date('Y-m-d g:i:s A') . "\n";
}

echo "\n";

foreach($manifest as $section => $files) {
	echo $section . ':' . "\n";

	if(is_array($files)) {
		foreach($files as $file) {
			echo $file . "\n";
		}
	}

	echo "\n";
}