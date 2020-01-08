jQuery( function($) {

	function is_email( email ) {
	    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	    return re.test(String(email).toLowerCase());
	}

	/*****************************************************/
	/* Toolkit page
	/*****************************************************/
	$(document).on( 'click', '.dpsp-tool-wrapper .dpsp-switch label', function(e) {
		
		var $actions_wrapper = $(this).closest('.dpsp-tool-actions');
		var $action_settings = $actions_wrapper.find('.dpsp-tool-settings');

		// Add Loading Overlay
		$action_settings.fadeOut(200);
		$actions_wrapper.append('<div class="dpsp-tool-actions-overlay"><div class="spinner"></div></div>');
		$actions_wrapper.find('.dpsp-tool-actions-overlay').animate({opacity: 1}, 200);

		// Get tool to activate/deactivate
		var tool 		 = $(this).siblings('input').data('tool');
		var tool_setting = $(this).siblings('input').data('tool-activation');

		if( tool != 'undefined' ) {

			if( $actions_wrapper.hasClass('dpsp-inactive') ) {

				activateTool( tool_setting ).done( function( response ) {
					if( response == 1 ) {
						$actions_wrapper.find('.dpsp-tool-actions-overlay').animate({opacity: 0}, 200, function() { $(this).remove() });
						$actions_wrapper.removeClass('dpsp-inactive').addClass('dpsp-active');
						$actions_wrapper.find('span').text('Active');
						$action_settings.fadeIn(200);
					}
				});	

			} else {

				deactivateTool( tool_setting ).done( function( response ) {
					if( response == 1 ) {
						$actions_wrapper.find('.dpsp-tool-actions-overlay').animate({opacity: 0}, 200, function() { $(this).remove() });
						$actions_wrapper.removeClass('dpsp-active').addClass('dpsp-inactive');
						$actions_wrapper.find('span').text('Inactive');

						hideMenuItem( tool );
					}
				});

			}
			
		}

	});

	
	/*
	 * Make an AJAX call to activate a tool
	 */
	function activateTool( setting ) {

		var data = {
			'action' 	: 'dpsp_activate_tool',
			'dpsptkn'	: $('#dpsptkn').val(),
			'setting'	: setting
		}

		return $.post( ajaxurl, data, function() {});

	}

	/*
	 * Make an AJAX call to deactivate a tool
	 */
	function deactivateTool( setting ) {

		var data = {
			'action' 	: 'dpsp_deactivate_tool',
			'dpsptkn'	: $('#dpsptkn').val(),
			'setting'	: setting
		}

		return $.post( ajaxurl, data, function() {});

	}


	/*
	 * Hides the menu item from the WP sidebar for a given location
	 */
	function hideMenuItem( location ) {

		location = location.replace('share_', '').replace('follow_', '').replace( '_', '-' );

		var $menuItems = $('#toplevel_page_dpsp-social-pug .wp-submenu li a');

		$menuItems.each( function() {
			if( $(this).attr('href').indexOf( location ) != -1 )
				$(this).parent().hide();
		});

	}


	/*
	 * Initialize jQuery select2
	 *
	 */
	if( $.fn.select2 ) {
		$('.dpsp-setting-field-select select').select2({
			minimumResultsForSearch : Infinity
		}).on('select2:open', function() {
	  		var container = $('.select2-container').last();
	  		container.addClass('dpsp-select2');
		});
	}


	/*
	 * Initialize jQuery sortable
	 *
	 */
	$( function() {
		$('.dpsp-social-platforms-sort-list').sortable({
			handle: '.dpsp-sort-handle',
			placeholder: 'dpsp-sort-placeholder',
			containment: '#wpwrap'
		});
	});


	/*
	 * Social newtworks checkboxes
	 *
	 */
	$(document).on( 'click', '#dpsp-networks-selector .dpsp-network-item', function() {
		$this = $(this);
		$checkbox = $this.children('.dpsp-network-item-checkbox');

		if( $this.attr('data-checked') )
			$this.removeAttr('data-checked');
		else
			$this.attr('data-checked', 'true');

	});


	$(document).on( 'click', '#dpsp-select-networks', function(e) {

		e.preventDefault();

		if( $('#dpsp-networks-selector-wrapper').hasClass('dpsp-active') ) {

			$('#dpsp-networks-selector-wrapper').removeClass('dpsp-active');

			$('#dpsp-networks-selector-wrapper').stop().fadeOut( 250, function() {

				if( $('.dpsp-social-platforms-sort-list').find('li').length == 0 ) {

					$('#dpsp-sortable-networks-empty').stop().fadeIn(400);
					$('#dpsp-sortable-networks-empty').addClass('dpsp-active');

				} else {

					$('.dpsp-social-platforms-sort-list').stop().fadeIn(400);
					$('.dpsp-social-platforms-sort-list').addClass('dpsp-active');

				}

			});

		} else {

			// Hide the Select Networks button
			$('#dpsp-select-networks').hide();

			$('#dpsp-networks-selector-wrapper').addClass('dpsp-active');

			if( $('.dpsp-social-platforms-sort-list').find('li').length == 0 ) {

				$('.dpsp-social-platforms-sort-list').hide();

				$('#dpsp-sortable-networks-empty').removeClass('dpsp-active');
				$('#dpsp-sortable-networks-empty').stop().fadeOut( 250, function() {

					$('#dpsp-networks-selector-wrapper').stop().fadeIn( 250 );

				});

			} else {

				$('.dpsp-social-platforms-sort-list').removeClass('dpsp-active');
				$('.dpsp-social-platforms-sort-list').stop().fadeOut( 250, function() {

					$('#dpsp-networks-selector-wrapper').stop().fadeIn( 250 );

				});

			}

		}
		
	});

	
	/**
	 * Apply Selection button action
	 *
	 * This will look at what social networks are checked in the Networks Selector
	 * panel and add them to the Networks Sortable panel
	 *
	 */
	$(document).on( 'click', '#dpsp-networks-selector-footer a', function(e) {
		
		e.preventDefault();

		// Show the Select Networks button
		$('#dpsp-select-networks').show();

		// Parse each network from the selector panel
		$('#dpsp-networks-selector .dpsp-network-item').each( function() {

			$this = $(this);

			var dataNetwork 	= $this.attr('data-network');
			var dataNetworkName = $this.attr('data-network-name');

			if( ! $this.attr('data-checked') ) {

				removeSortableNetworkItem( dataNetwork );

			} else {

				var alreadyInList = false;

				$('.dpsp-social-platforms-sort-list li').each( function() {
					if( $(this).attr('data-network') == dataNetwork )
						alreadyInList = true;
				});

				if( alreadyInList )
					return alreadyInList;

				addSortableNetworkItem( dataNetwork, dataNetworkName );
			}

		});

		// Hide Networks Selector panel
		$('#dpsp-networks-selector-wrapper').removeClass('dpsp-active').stop().fadeOut( 250, function() {

			// If there are no networks in the sortable list display the empty placeholder
			if( $('.dpsp-social-platforms-sort-list').find('li').length == 0 ) {

				$('#dpsp-sortable-networks-empty').stop().fadeIn(250);
				$('#dpsp-sortable-networks-empty').addClass('dpsp-active');

			// If there are no networks in the sortable list display the Networks Sortable panel
			} else {

				$('.dpsp-social-platforms-sort-list').stop().fadeIn(250);
				$('.dpsp-social-platforms-sort-list').addClass('dpsp-active');

			}

		});

	});


	/**
	 * Selects the edit label field from the sortable list when the admin
	 * clicks on the edit label button
	 *
	 */
	$(document).on( 'click', '.dpsp-list-edit-label', function(e) {

		e.preventDefault();

		$(this).closest('li').find( '.dpsp-list-input-wrapper input' ).focus().select();

	});


	/**
	 * Removes the social network from the sortable list when clicking
	 * on the .dpsp-list-remove class and also uncheckes the social 
	 * network from the selectable networks list
	 *
	 */
	$(document).on( 'click', '.dpsp-list-remove', function(e) {

		e.preventDefault();

		var dataNetwork = $(this).closest('li').attr('data-network');

		removeSortableNetworkItem( dataNetwork );

		$('#dpsp-networks-selector .dpsp-network-item[data-network="' + dataNetwork + '"]').removeAttr('data-checked');

		// If there are no networks in the sortable list display the empty placeholder
		if( $('.dpsp-social-platforms-sort-list').find('li').length == 0 ) {

			$('#dpsp-sortable-networks-empty').stop().fadeIn(250);
			$('#dpsp-sortable-networks-empty').addClass('dpsp-active');

			$('.dpsp-social-platforms-sort-list').removeClass('dpsp-active');

		}

	});


	/**
	 * Function that adds a given item from the Networks Sortable panel
	 *
	 */
	function addSortableNetworkItem( slug, name ) {
		
		if( slug == 'undefined')
			return false;

		if( name == 'undefined')
			return false;

		var html = '';

		var location = $('input[name="dpsp_buttons_location"]').val();

		html += '<li data-network="' + slug + '">';
			html += '<div class="dpsp-sort-handle ui-sortable-handle"><!-- --></div>';
			html += '<div class="dpsp-list-icon dpsp-list-icon-social dpsp-icon-' + slug + ' dpsp-background-color-network-' + slug + '"><!-- --></div>';
			html += '<div class="dpsp-list-input-wrapper"><input type="text" placeholder="' + 'This button has no label text.' + '" name="' + location + '[networks][' + slug + '][label]" value="' + name + '"></div>';
			
			// List item actions
			html += '<div class="dpsp-list-actions">';
				html += '<a class="dpsp-list-edit-label dpsp-transition" href="#"><span class="dashicons dashicons-edit"></span>' + 'Edit Label' + '</a>';
				html += '<a class="dpsp-list-remove dpsp-transition" href="#"><span class="dashicons dashicons-no-alt"></span>' + 'Remove' + '</a>';
			html += '</div>';
		html += '</li>';

		$('.dpsp-social-platforms-sort-list').append( html );

		// Set the last class for the last list item
		$('.dpsp-social-platforms-sort-list li').removeClass('dpsp-last');
		$('.dpsp-social-platforms-sort-list li').last().addClass('dpsp-last');

	}


	/**
	 * Function that removes a given item from the Networks Sortable panel
	 *
	 */
	function removeSortableNetworkItem( slug ) {

		$('.dpsp-social-platforms-sort-list li[data-network="' + slug + '"]').remove();

		// Set the last class for the last list item
		$('.dpsp-social-platforms-sort-list li').removeClass('dpsp-last');
		$('.dpsp-social-platforms-sort-list li').last().addClass('dpsp-last');

		if( $('.dpsp-social-platforms-sort-list li').length == 0 ) {

			$('.dpsp-social-platforms-sort-list').fadeOut(1);
			$('.dpsp-social-platforms-sort-list').removeClass('dpsp-active');
		
		}

	}


	$(document).ready( function() {
		$('.dpsp-network-btn').attr('href', '#');
	});

	$(document).on( 'click', '.dpsp-network-btn', function(e) {
		e.preventDefault();
		$(this).closest('label').click();
	});


	/*
	 * Disable inputs for certain networks sortable panels
	 *
	 */
	$(document).on( 'focus', '.dpsp-page-mobile .dpsp-list-input-wrapper input', function() {
		$(this).blur();
	});


	/*
	 * Set the shape of the network buttons on page load and dynamicly
	 *
	 */
	$(document).on('click', '.dpsp-setting-field-button-shape input', function() {
		$(this)
			.closest('.dpsp-page-wrapper')
			.find('.dpsp-networks-btns-wrapper')
			.parent()
			.removeClass('dpsp-shape-circle dpsp-shape-rounded dpsp-shape-rectangular')
			.addClass('dpsp-shape-' + $(this).val() );
	});


	/*
	 * Show and hide back-end settings tool-tips
	 *
	 */
	$(document).on( 'mouseenter', '.dpsp-setting-field-tooltip-icon', function() {
		$(this).siblings('div').css('opacity', 1).css('visibility', 'visible');
	});
	$(document).on( 'mouseleave', '.dpsp-setting-field-tooltip-icon', function() {
		$(this).siblings('div').css('opacity', 0).css('visibility', 'hidden');
	});

	$(document).on( 'mouseenter', '.dpsp-setting-field-tooltip-wrapper.dpsp-has-link', function() {
		$(this).find('div').css('opacity', 1).css('visibility', 'visible');
	});
	$(document).on( 'mouseleave', '.dpsp-setting-field-tooltip-wrapper.dpsp-has-link', function() {
		$(this).find('div').css('opacity', 0).css('visibility', 'hidden');
	});


	/**
	 * Mark the last .dpsp-setting-field-wrapper element for each card
	 *
	 */
	$(document).on( 'change', '.dpsp-setting-field-wrapper *', function() {

		$('.dpsp-card-inner').each( function() {

			$(this).find('.dpsp-setting-field-wrapper').removeClass('dpsp-last');
			$(this).find('.dpsp-setting-field-wrapper:not(.disabled)').last().addClass('dpsp-last');

		});

	});

	$('.dpsp-setting-field-wrapper *').first().trigger('change');


	/*
	 * Disable / enable settings that depend on other settings
	 *
	 */
	$( function() {

		// Set settings options
		$checkbox_shares 	   = $('.dpsp-setting-field-show-share-count input[type=checkbox]');
		$checkbox_total_shares = $('.dpsp-setting-field-show-total-share-count input[type=checkbox]');
		$checkbox_count_round  = $('.dpsp-setting-field-share-count-round input[type=checkbox]');

		$wrapper_checkbox_count_round = $checkbox_count_round.closest('.dpsp-setting-field-wrapper');


		// Disable and enable total share count position
		if( !$checkbox_total_shares.is(':checked') ) {
			$checkbox_total_shares.closest('.dpsp-setting-field-wrapper').next().addClass('disabled');
			$checkbox_total_shares.closest('.dpsp-setting-field-wrapper').next().find('select').attr( 'disabled', true );
		}

		$checkbox_total_shares.change( function() {
			if( !$checkbox_total_shares.is(':checked') ) {
				$checkbox_total_shares.closest('.dpsp-setting-field-wrapper').next().addClass('disabled');
				$checkbox_total_shares.closest('.dpsp-setting-field-wrapper').next().find('select').attr( 'disabled', true );
			} else {
				$checkbox_total_shares.closest('.dpsp-setting-field-wrapper').next().removeClass('disabled');
				$checkbox_total_shares.closest('.dpsp-setting-field-wrapper').next().find('select').attr( 'disabled', false );
			}
		});


		// Disable and enable share count round
		// Disable and enable minimum share count
		enable_disable_count_round();

		$checkbox_shares.change( function() {
			enable_disable_count_round();
		});

		$checkbox_total_shares.change( function() {
			enable_disable_count_round();
		});

		function enable_disable_count_round() {
			if( !$checkbox_total_shares.is(':checked') && !$checkbox_shares.is(':checked') ) {
				$wrapper_checkbox_count_round.addClass('disabled');
				$checkbox_count_round.attr( 'disabled', true );
			} else {
				$wrapper_checkbox_count_round.removeClass('disabled');
				$checkbox_count_round.attr( 'disabled', false );
			}
		}

	});

	/**********************************************************/
	/* Refresh statistics in "Share Statistics" meta-box
	/**********************************************************/
	$(document).on( 'click', '#dpsp-refresh-share-counts', function(e) {

		e.preventDefault();

		if( $(this).hasClass('disabled') )
			return false;

		$refresh_button = $(this);
		$spinner 		= $refresh_button.siblings('.spinner');

		$refresh_button.addClass( 'disabled' );
		$spinner.css( 'visibility', 'visible' );

		$('.dpsp-statistic-bar-wrapper-network').css( 'opacity', 0.6 );

		var data = {
			action 	: 'dpsp_refresh_share_counts',
			nonce  	: $refresh_button.siblings('[name="dpsp_refresh_share_counts"]').val(),
			post_id	: parseInt( $('#post_ID').val() )
		}

		$.post( ajaxurl, data, function( response ) {

			if( response ) {
				$('.dpsp-statistic-bars-wrapper').replaceWith( response );
			}

		});

	});


	/**********************************************************/
	/* Display the Facebook authorization fields, based on the share counts provider
	/**********************************************************/
	$(document).on( 'change', '[name="dpsp_settings[facebook_share_counts_provider]"]', function() {

		$('.dpsp-setting-field-facebook-authorize-app').hide();
		$('.dpsp-setting-field-facebook-app-id, .dpsp-setting-field-facebook-app-secret').hide();

		// Authorized app
		if( $(this).val() == 'authorized_app' )
			$('.dpsp-setting-field-facebook-authorize-app').show();

		// Own app
		if( $(this).val() == 'own_app' )
			$('.dpsp-setting-field-facebook-app-id, .dpsp-setting-field-facebook-app-secret').show();

	});

	$('[name="dpsp_settings[facebook_share_counts_provider]"]').trigger( 'change' );


    /**
     * Enable/disable the submit button when the users write in the textarea
     *
     */
    $(document).on( 'keyup', '#dpsp-deactivate-modal [name=dpsp_disable_text]', function() {

    	if( $(this).val() != '' )
    		$('#dpsp-feedback-submit').attr( 'disabled', false );
    	else
    		$('#dpsp-feedback-submit').attr( 'disabled', true );

    });

    /**
     * Enable/disable the submit button when the users completes their email address
     *
     */
    $(document).on( 'keyup', '#dpsp-deactivate-modal [name=dpsp_disable_from]', function() {

    	if( is_email( $(this).val() ) )
    		$('#dpsp-feedback-submit').attr( 'disabled', false );
    	else
    		$('#dpsp-feedback-submit').attr( 'disabled', true );

    });

    $('#dpsp-feedback-submit').click(function (e) {
        e.preventDefault();        
        $('#dpsp-deactivate-modal').hide();        
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            dataType: 'json',
            data: {
                action: 'dpsp_send_deactivation_feedback',
                data: $('#dpsp-deactivate-modal form').serialize()
            },
            complete: function (MLHttpRequest, textStatus, errorThrown) {
                $('#dpsp-deactivate-modal').remove();
                window.location.href = $('.wp-admin.plugins-php tr[data-slug="social-pug"] .row-actions .deactivate a').attr('href');   
            }
        });      
    });
    
    $('#dpsp-only-deactivate').click(function (e) {
        e.preventDefault();
        $('#dpsp-deactivate-modal').hide();        
        $('#dpsp-deactivate-modal').remove();
        window.location.href = $('.wp-admin.plugins-php tr[data-slug="social-pug"] .row-actions .deactivate a').attr('href');
        
    });    
    
    $('.dpsp-deactivate-close').click(function (e) {
        e.preventDefault();
        $('#dpsp-deactivate-modal').hide();
    });

});