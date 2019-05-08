$(document).ready(function() {
  const baseUrl = $('body').attr('data-url');

  $('.loginForm').submit(function() {
    $(".loginBtn").attr('disabled', true);

    const username = $('.username').val();
    const pass = $('.pass').val();
    
    $.ajax({
      type: 'POST',
      url: `${baseUrl}/login`,
      data: { username, pass },
      success: ({ success }) => {
        $(".loginBtn").removeAttr('disabled');
        if (success) {
          window.location.replace(`${baseUrl}/dashboard`);
        } else {
          $.toast({
            heading: 'Error',
            text: 'Incorrect username or password',
            icon: 'error',
            loader: false,
            position: 'bottom-center'
          });
        }
      }
    })

    return false;
  });
});