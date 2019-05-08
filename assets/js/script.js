$(document).ready(function() {
  const activePage = $('section.content').attr('data-page');
  $('.sidebar-menu li').removeClass('active');
  $('.sidebar-menu').find(`.${activePage}`).addClass('active');
});