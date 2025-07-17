(function ($) {
  "use strict";

  // Chiudi navbar quando clicchi su un link o voce dropdown
  $('.navbar-collapse a, .dropdown-menu a').on('click', function () {
    $(".navbar-collapse").collapse('hide');
  });

  // Funzione: verifica se elemento è visibile e aggiunge classe 'active'
  function isScrollIntoView(elem) {
    var docViewTop = $(window).scrollTop();
    var docViewBottom = docViewTop + $(window).height();
    var elemTop = $(elem).offset().top;
    var elemBottom = elemTop + $(window).height() * 0.5;

    if (elemBottom <= docViewBottom && elemTop >= docViewTop) {
      $(elem).addClass('active');
    } else {
      $(elem).removeClass('active');
    }
  }

  // Funzione: regola altezza timeline inner
  function adjustTimelineInnerHeight() {
    var container = $('#vertical-scrollable-timeline')[0];
    if (container) {
      var bottom = container.getBoundingClientRect().bottom - $(window).height() * 0.5;
      $(container).find('.inner').css('height', bottom + 'px');
    }
  }

  // On scroll: timeline e altezza inner
  $(window).on('scroll', function () {
    $('#vertical-scrollable-timeline li').each(function () {
      isScrollIntoView(this);
    });
    adjustTimelineInnerHeight();
  });

  // Primo settaggio altezza timeline
  $(document).ready(function () {
    adjustTimelineInnerHeight();
  });

  // Scroll senza mostrare #section_X nell'URL
  $('.navbar-nav .nav-link[href^="#"]').on('click', function (e) {
    var target = $(this).attr('href');
    if (target.startsWith('#') && $(target).length) {
      e.preventDefault();
      var offset = $(target).offset().top - 90;
      $('html, body').animate({ scrollTop: offset }, 0, function () {
        if (window.history.replaceState) {
          window.history.replaceState(null, null, window.location.pathname + window.location.search);
        }
      });
    }
  });

})(window.jQuery);
