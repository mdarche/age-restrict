(function($) {
  $('#age-yes').click(function(e) {
    e.preventDefault();
    Cookies.set('age-restrict', '1odIH93Ldme82dLsvx98SlW2x', { expires: 7 });
    $('.ar-overlay').addClass('hide');
    $('body').removeClass('age-restrict');
  });
})(jQuery);
