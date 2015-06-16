(function() {
  var AKSB;

  jQuery(window).load(function() {
    AKSB.load();
  });

  AKSB = {
    load: function() {
      var aksb_wrap;
      aksb_wrap = jQuery('#aksb-buttons-wrap');
      if (aksb_wrap.length) {
        jQuery.ajax({
          error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus);
          },
          beforeSend: function(jqXHR) {},
          success: function(data, textStatus, jqXHR) {
            if (data) {
              aksb_wrap.html(data);
            }
          },
          url: aksb.url,
          dataType: "html",
          type: 'POST',
          async: true,
          data: {
            action: 'aksb_load_sharing_buttons',
            security: jQuery('#aksb-sharing-buttons-security').val(),
            post_id: aksb.post_id
          }
        });
      }
    }
  };

}).call(this);
