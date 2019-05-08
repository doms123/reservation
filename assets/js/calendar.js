$(document).ready(function() {
  const baseUrl = $('body').attr('data-url');

  $.ajax({
    type: 'GET',
    url: `${baseUrl}/calendarList`,
    success: function({ success, result }) {
      if (success) {
        if (result.length) {
          const maxLoop = result.length;
          let events = [];
          for (let x = 0; x < maxLoop; x++) {
            const { guestName, name, status, checkIn, checkOut } = result[x];
            let statusTxt = '';
            let color = '';
            if (status == 1) {
              statusTxt = 'Confirmed';
              color = '#00a65a';
            } else if (status == 2) {
              statusTxt = 'Pending';
              color = '#0073b7';
            } else if (status == 3) {
              statusTxt = 'Cancelled';
              color = '#dd4b39';
            }
            events.push({
              title: `${guestName} - ${name} - ${statusTxt}`,
              start: moment(checkIn).format('YYYY/MM/DD hh:mm'),
              end: moment(checkOut).format('YYYY/MM/DD hh:mm'),
              backgroundColor: color,
              borderColor: color
            });
          }

          fullCalendar(events);
        }
      }
    }
  });

  function fullCalendar(events) {
    $('#calendar').fullCalendar({
      header    : {
        left  : 'prev,next today',
        center: 'title',
        right : 'month,agendaWeek,agendaDay'
      },
      buttonText: {
        today: 'today',
        month: 'month',
        week : 'week',
        day  : 'day'
      },
      events,
      editable  : false,
      droppable : false,
      displayEventTime: false
    });
  }
});