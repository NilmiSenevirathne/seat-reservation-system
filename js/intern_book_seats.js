document.addEventListener('DOMContentLoaded', function () {
  const buttons = document.querySelectorAll('.book-btn');

  buttons.forEach(button => {
    button.addEventListener('click', function (e) {
      e.preventDefault();

      const seatId = this.getAttribute('data-seat-id');
      const date = this.getAttribute('data-date');

      if (confirm(`Are you sure you want to book seat ID ${seatId} for ${date}?`)) {
        fetch('intern_book_seats.php', {  // ✅ FIXED: same file!
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `seat_id=${encodeURIComponent(seatId)}&date=${encodeURIComponent(date)}`
        })
          .then(response => response.json())
          .then(data => {
            alert(data.message);
            if (data.success) {
              // Optionally reload to refresh available seats
              window.location.reload();
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while booking the seat.');
          });
      }
    });
  });
});
