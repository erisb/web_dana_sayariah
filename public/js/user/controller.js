$(document).ready(function () {

//  $(window).resize(function(){
    if ($(window).width() < 992) {
      $('#sidebar').addClass('active');
      $('#collapse_button').addClass('active');
      $('#content').addClass('active');
      $('#header').addClass('active');
    }

//  });

  $('#collapse_button').click(function() {
    $('#sidebar').toggleClass('active');
    $('#collapse_button').toggleClass('active');
    $('#content').toggleClass('active');
    $('#header').toggleClass('active');
  });

  $('.notification i').click(function() {
    $('.notification_content').toggle();
  });


})
