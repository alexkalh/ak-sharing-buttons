"use strict";

jQuery(window).load ->
	AKSB.load()
	return

AKSB =	
	load: () ->
		aksb_wrap = jQuery '#aksb-buttons-wrap'
		
		if aksb_wrap.length

			jQuery.ajax
				error: (jqXHR, textStatus, errorThrown) ->
					console.log textStatus
					return
				
				beforeSend: (jqXHR) ->				
					return 
				
				success: (data, textStatus, jqXHR) ->
					if(data)
						aksb_wrap.html data
					return

				url: aksb.url
				dataType: "html"
				type: 'POST'
				async: true
				data:						
					action: 'aksb_load_sharing_buttons'
					security: jQuery('#aksb-sharing-buttons-security').val()
					post_id: aksb.post_id

		return