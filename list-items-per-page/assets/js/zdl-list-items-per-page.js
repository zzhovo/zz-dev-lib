jQuery(function(){
	var _lock = false;
	jQuery('.' + zdl_list_items_per_page_data.switch_container_class + ' select').change(function(){
		if(false === _lock){
			_lock = true;
		}else{
			return;
		}

		var data = {
			'action':       zdl_list_items_per_page_data.change_action,
			'preference':   jQuery(this).data('preference'),
			'value' :       jQuery(this).val()
		};

		data[zdl_list_items_per_page_data.nonce_name] = jQuery('#' + zdl_list_items_per_page_data.nonce_name).val();

		jQuery.ajax({
			type: "POST",
			url: zdl_list_items_per_page_data.ajax_url,
			data: data,
			success: function(response){
				location.reload();
				_lock = false;
			}
		});
	});
});