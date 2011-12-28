/**
 * Form Utilities
 *
 * Provides the ability to hijack traditional form submissions in order to
 * process them without triggering a postback. Also supports the use of
 * default text values for fields that are automatically cleared on focus.
 *
 * @author Nick Williams
 * @version 1.0.0
 */
jQuery(function($) {
	try {
		// =====================================================================
		// Form Submission Hijacking
		// =====================================================================
		$('form').live('submit', function(e) {
			try {
				// Setup
				var target = null;
				var $this = $(this);
				var params = {};

				// Clear Default Values
				$(this).find('input').each(function(index, value) {
					if($(value).attr('title') == $(value).val()) {
						$(value).val('');
					}
				});

				$(this).find('textarea').each(function(index, value) {
					if($(value).attr('title') == $(value).val()) {
						$(value).val('');
					}
				});

				// Validate
				var valid = true;
				var message = 'Your submission could not be processed. Please resolve the following and try again:<ul>';

				$(this).find('input, select, textarea').filter('[data-required]').each(function(key, value) {
					value = $(value);

					if(!$.trim(value.val())) {
						valid = false;

						message += '<li>' + value.data('required') + '</li>';
					}
				});

				message += '</ul>';

				if(!valid) {
					utils.alert('error', message);
					$(this).find('input[type=password]').val('');
				}
				else {
					var form = $this.serializeArray();

					// Assemble Form Data
					$.each(form, function() {
						if(params[this.name]) {
							if(!params[this.name].push) {
								params[this.name] = [params[this.name]];
							}

							params[this.name].push(this.value || '');
						}
						else {
							params[this.name] = this.value || '';
						}
					});

					var parts = $this.attr('action').split('.');
					var method = parts.shift();
					params._action = parts.join('.');

					if(method == 'local') {
						$this.trigger('response', params);
					}
					else if(method == 'ajax') {
						// Submit AJAX Request (based on form's action attribute)
						$.ajax({
							type: 'POST',
							url: 'ajax.php',
							data: params,
							dataType: 'json',
							success: function(data) {
								$this.trigger('response', data);
							}
						});
					}
				}

				$(this).find('input, select, textarea').blur();
				e.preventDefault();
				return false;
			}
			catch(ex) {
				utils.alert('error', 'An error occurred while processing your submission. Please try again or contact a website administrator.');
				console.log(ex);
				e.preventDefault();
				return false;
			}
		});

		// =====================================================================
		// Default Text
		// =====================================================================
		
		// @todo "generify" this, code was pulled directly from a project
		
		$('input[type=text]:not(.title), textarea').live('focus', function(e) {
			if($(this).val() == $(this)[0].title) {
				$(this).val('');
			}

			$(this).removeClass('default');
		});

//		$('input[type=text].number').live('click', function(e) {
//			$(this).parent().find('input[type=number]').show().trigger('focus');
//			$(this).hide();
//		});

		$('input[type=text], textarea').live('blur', function(e) {
			if($(this).val() == '' || $(this).val() == $(this)[0].title) {
				$(this).val($(this)[0].title);
				$(this).addClass('default');
			}
			else {
				$(this).removeClass('default');
			}
		});

		

		$('input[type=number], input[type=password]').live('focus', function() {
			$(this).parent().find('.title').val('');
		});

		$('input[type=number], input[type=password]').live('blur', function() {
			if($(this).parent().find('.title').length == 0) {
				$(this).before('<input class="' + $(this).attr('class') + ' default title" disabled="disabled" readonly="readonly" type="text" name="" title="" value="" />');
			}

			if($(this).val() == '') {
				$(this).parent().find('.title').val($(this).attr('title'));
			}

			if($(this).attr('type') == 'number') {
				$(this).width($(this).parent().find('.title').width() + 13);
			}
		});

//		$('input[type=number]').live('blur', function(e) {
//			if($(this).val() == '') {
//				$(this).hide();
//				$('<input class="' + $(this).attr('class') + ' default number" readonly="readonly" type="text" name="' + $(this).attr('name') + '" title="' + $(this).attr('title') + '"value="' + $(this).attr('title') + '" />').appendTo($(this).parent());
//			}
//			else {
//
//			}
//		});

		$('input[type=text], input[type=number], input[type=password], textarea').blur();
	}
	catch(ex) {
		console.error(ex, 'An unexpected error occurred with the current form. Please try reloading the application or contact a website administrator.');
		return false;
	}
});