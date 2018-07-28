/**
 * 
 * @authors JiangDing (jiangdingjd@gmail.com)
 * @date    2017-11-06 14:10:05
 * @version 0.1
 */

;(function($, window, document){

  // å®šä¹‰æ’ä»¶åå­—
  var pluginName = "alertBox";
  // è®¾ç½®æ’ä»¶é»˜è®¤å‚æ•°
  var defaults = {
    zIndex: 99999,  //å¼¹å‡ºå±‚å®šä½å±‚çº§
    title: '',  //æ ‡é¢˜æ–‡å­—
    lTxt: '',   //å·¦è¾¹æŒ‰é’®æ–‡å­—å†…å®¹
    lBgColor: "#D4D4D4",  //å·¦è¾¹æŒ‰é’®èƒŒæ™¯é¢œè‰²
    lFontColor: "#333",   //å·¦è¾¹æŒ‰é’®æ–‡å­—é¢œè‰²
    lCallback: function(){},    //å·¦è¾¹æŒ‰é’®å›žè°ƒå‡½æ•°
    rTxt: '',   //å³è¾¹æŒ‰é’®æ–‡å­—å†…å®¹
    rBgColor: "#ED6465",  //å³è¾¹æŒ‰é’®èƒŒæ™¯é¢œè‰²
    rFontColor: "#fff",   //å³è¾¹æŒ‰é’®æ–‡å­—é¢œè‰²
    rCallback: function(){}   //å³è¾¹æŒ‰é’®å›žè°ƒå‡½æ•°
  };

  function AlertBox(element, options){
    this.element = element;
    this.settings = $.extend({}, defaults, options);
    this.init();
  }

  AlertBox.prototype = {
    // åˆå§‹åŒ–å¼¹çª—
    init: function(){
      var that = this;
      var element = this.element;
        
      that.render(element);
      that.setStyle();
      that.show();
      that.trigger(element);
    },

    // åˆ›å»ºå¼¹çª—
    create: function(element){
      var that = this,
      $this = $(element),
      title = that.settings.title,
      zIndex = that.settings.zIndex,
      lTxt = that.settings.lTxt,
      rTxt = that.settings.rTxt,
      alertHTML = [];

      alertHTML[0] = '<div class="alert_panel"><h3 class="alert_title">' + title + '</h3>';
      alertHTML[1] = '<div class="alert_btn_group"><span class="alert_left_btn">'+ lTxt + '</span>';
      alertHTML[2] = '<span class="alert_right_btn">' + rTxt + '</span></div>';
      alertHTML[3] = '<div class="alert_close_btn"><p style="margin:0;">&#10005</p></div></div>';
      alertHTML[4] = '<div id="alert_mask"></div>';
      return alertHTML;
    },

    // æ¸²æŸ“å¼¹çª—
    render: function(element){
      var that = this,
        $this = $(element),
        alertHTML = that.create($this);
      $('body').append('<div id="alert_box"></div>');

      $('#alert_box').replaceWith(alertHTML[0] + alertHTML[1] + alertHTML[2] + alertHTML[3]);
      $('body').append(alertHTML[4]);
    },

    // æ˜¾ç¤ºå¼¹çª—
    show: function(){
      setTimeout(function(){
        $('.alert_panel').addClass('show');
      },50)

      $('#alert_mask').show();
    },

    // éšè—å¼¹çª—
    hide: function(element){
      var $this = $(element),
        $alertBox = $('.alert_panel');
      
      // ä¼˜åŒ–å¤„ç†ï¼ˆå¦‚æžœä¸removeæŽ‰ï¼Œå¤šæ¬¡è§¦å‘å¼¹çª—ä¼šç”Ÿæˆå¾ˆå¤šæ–°çš„DOMï¼‰
      $alertBox.remove();
      setTimeout(function(){
        $('#alert_mask').remove();
      },150)
    },

    // è®¾ç½®å¼¹çª—æ ·å¼
    setStyle: function(){
      var that = this;

      // è®¾ç½®å¼¹çª—å®šä½å±‚çº§
      $('.alert_panel').css({
        'z-index': that.settings.zIndex
      });

      //é®ç½©å±‚æ ·å¼
      $('#alert_mask').css({
        'height': $(window).height() + 'px',
        'z-index': that.settings.zIndex - 1
      });

      // æŒ‰é’®æ ·å¼
      $('.alert_left_btn').css({
        'color': that.settings.lFontColor,
        'backgroundColor': that.settings.lBgColor
      })

      $('.alert_right_btn').css({
        'color': that.settings.rFontColor,
        'backgroundColor': that.settings.rBgColor
      })
    },

    // å¼¹çª—ç³»åˆ—äº‹ä»¶
    trigger: function(element, event){
      var that = this,
        $this = $(element);

      // å…³é—­å¼¹çª—äº‹ä»¶è§¦å‘
      $('.alert_close_btn, .alert_left_btn, .alert_right_btn').on('click',function(){
        that.hide();
        $('.alert_panel').removeClass('show');
        $('#alert_mask').remove();
      });

      // å·¦è¾¹æŒ‰é’®å›žè°ƒå¤„ç†
      if($.isFunction(that.settings.lCallback)){
        $('.alert_left_btn').on('click',function(){
          that.settings.lCallback();
        });
      }

      // å³è¾¹æŒ‰é’®å›žè°ƒå¤„ç†
      if($.isFunction(that.settings.rCallback)){
        $('.alert_right_btn').on('click',function(){
          that.settings.rCallback();
        });
      }
    }
  };

  // è°ƒç”¨
  $.fn[pluginName] = function(options) {
    this.each(function() {
      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new AlertBox(this, options));     
      }
      new AlertBox(this, options);
    });
   return this;
  };

})(jQuery, window, document)