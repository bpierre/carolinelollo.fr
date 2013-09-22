(function($){
  $(function(){
    
    var $window = $(window);
    
    // Bar Height
    var $blackBar = $('#blackBar'),
        blackBarBottomMargin = 39;
    if ($blackBar.length > 0) {
      $window.resize(function() {
        // blackbar height = window height - bottom margin - top margin
        $blackBar.height($window.height() - blackBarBottomMargin - ($blackBar.css('top').slice(0,-2)-0));
      }).resize();
    }
    
    // empty img titles
    $('.single .post img').attr('title', '');
    
  });
})(jQuery);
