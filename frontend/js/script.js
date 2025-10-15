$(function () {
  if (!location.hash) location.hash = '#home';

  var app = $.spapp({
    defaultView: '#home',
    templateDir: './views/'   
  });
  app.run();

  
  function setActive() {
    var view = location.hash || '#home';
    $('#navigation a').removeClass('active');
    $('#navigation a[href="' + view + '"]').addClass('active');
  }
  setActive();
  $(window).on('hashchange', setActive);
});
