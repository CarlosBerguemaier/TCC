$(document).ready(function() {
    $(".collapse").on('show.bs.collapse', function() {
      $(".collapse").not(this).collapse('hide');
    });
  });