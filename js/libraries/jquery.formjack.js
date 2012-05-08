/**
 * FormJack
 *
 * Provides the ability to hijack traditional form submissions in order to
 * process them without triggering a postback.
 *
 * @author Nick Williams
 * @version 1.0.0
 */
(function($) {
	/**
	 * Default settings, extended with provided options at invocation.
	 */
	var settings = {
		eventName: 'response',		// The desired name for the custom event that is triggered on submitted forms.
		parseNames: false			// Whether or not to parse dot-separated field names into object literals.
	};

	/**
	 * Utility for building a multidimensional single-branch object literal
	 * using the specified array of strings as its nodes.
	 *
	 * @param nodes the nodes making up the branch
	 * @param value the value to be assigned to the innermost node
	 * @return the resulting object literal
	 */
	var buildObject = function(nodes, value) {
		var result = {};

		if(nodes.length) {
			var node = nodes.shift();

			if(node.substr(-2) == '[]') {
				node = node.substring(0, (node.length - 2));
				result[node] = [];

				result[node].push(buildObject(nodes, value));
			}
			else {
				result[node] = buildObject(nodes, value);
			}
		}
		else {
			result = value;
		}

		return result;
	};

	/**
	 * Utility for extending object literals. A modified version of
	 * jQuery's (1.7.2) $.extend() function.
	 *
	 * @return the resulting object literal
	 */
	var merge = function() {
		var options, name, src, copy, copyIsArray, clone,
			target = arguments[0] || {},
			i = 1,
			length = arguments.length,
			deep = false;

		// Handle a deep copy situation
		if ( typeof target === "boolean" ) {
			deep = target;
			target = arguments[1] || {};
			// skip the boolean and the target
			i = 2;
		}

		// Handle case when target is a string or something (possible in deep copy)
		if ( typeof target !== "object" && !jQuery.isFunction(target) ) {
			target = {};
		}

		// extend jQuery itself if only one argument is passed
		if ( length === i ) {
			target = this;
			--i;
		}

		for ( ; i < length; i++ ) {
			// Only deal with non-null/undefined values
			if ( (options = arguments[ i ]) != null ) {
				// Extend the base object
				for ( name in options ) {
					src = target[ name ];
					copy = options[ name ];

					// Prevent never-ending loop
					if ( target === copy ) {
						continue;
					}

					// Recurse if we're merging plain objects or arrays
					if ( deep && copy && ( jQuery.isPlainObject(copy) || (copyIsArray = jQuery.isArray(copy)) ) ) {
						if ( copyIsArray ) {
							copyIsArray = false;
							clone = src && jQuery.isArray(src) ? src : [];

						} else {
							clone = src && jQuery.isPlainObject(src) ? src : {};
						}

						// Never move original objects, clone them
						target[ name ] = merge( deep, clone, copy );

						// Don't bring in undefined values
					} else if ( copy !== undefined ) {
						if(jQuery.isArray(target)) {
							target.push(copy);
						}
						else {
							target[ name ] = copy;
						}
					}
				}
			}
		}

		// Return the modified object
		return target;
	};

	/**
	 * Form Submission Hijacking
	 *
	 * Supported protocols/schemes and what they do:
	 *
	 * 		[paths]		Normal form submission behavior.
	 * 		http(s)://	Normal form submission behavior.
	 * 		ajax://		Triggers an AJAX HTTP request.
	 * 		ajaxs://	Triggers an AJAX HTTP request over SSL.
	 * 		local://	Triggers a local event with the form data attached.
	 *
	 * Note: Form actions using ajax:// or ajaxs:// will honor the defined
	 * method attribute (POST/GET).
	 */
	$.fn.formjack = function(options) {
		$.extend(true, settings, options);

		$(this).live('submit', function(e) {
			try {
				// Setup
				var $this = $(this);
				var action = $this.attr('action');
				var pattern = /^((.*):\/\/)*(.*)/;
				var matches = action.match(pattern);
				var params = {};

				matches.shift();
				matches.shift();

				var scheme = matches.shift();

				switch(scheme) {
					default:
						return true;
						break;

					case 'ajax':
					case 'ajaxs':
					case 'local':
						var form = $this.serializeArray();

						// Assemble Form Data
						$.each(form, function() {
							var nodes = [this.name];

							if(settings.parseNames && this.name.indexOf('.')) {
								nodes = this.name.split('.');
							}

							merge(true, params, buildObject(nodes, (this.value || '')));
						});

						if(scheme == 'ajax' || scheme == 'ajaxs') {
							$.ajax({
								type: $this.attr('method'),
								url: action.replace(/^ajax:\/\//, 'http://').replace(/^ajaxs:\/\//, 'https://'),
								data: params,
								dataType: 'json',
								success: function(data) {
									$this.trigger(settings.eventName, data);
								}
							});
						}
						else if(scheme == 'local') {
							$this.trigger(settings.eventName, params);
						}

						e.preventDefault();
						break;
				}
			}
			catch(ex) {
				console.error(ex);
				e.preventDefault();
				return false;
			}
		});
	};
})(jQuery);
