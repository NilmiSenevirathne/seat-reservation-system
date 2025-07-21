document.addEventListener('DOMContentLoaded', () => {
  const buttons = document.querySelectorAll('.cancel-btn');
  console.log('Cancel buttons found:', buttons.length);

  buttons.forEach(button => {
    button.addEventListener('click', async (e) => {
      e.preventDefault();

      const reservationId = button.getAttribute('data-reservation-id');
      if (!reservationId) return;

      if (!confirm('Are you sure you want to cancel this reservation?')) return;

      try {
        const formData = new FormData();
        formData.append('cancel_id', reservationId);

        // Use current page URL or adjust path to your cancellation PHP handler
        const response = await fetch(window.location.href, {
          method: 'POST',
          body: formData
        });

        const result = await response.json();

        if (result.success) {
          alert('Reservation cancelled successfully.');

          const row = button.closest('tr');
          if (!row) return;

          const statusCell = row.querySelector('td.status');
          if (statusCell) statusCell.textContent = 'cancelled';

          const actionCell = button.parentElement;
          if (actionCell) actionCell.textContent = 'N/A';

          const pastTableBody = document.querySelector('#past-reservations tbody');
          if (pastTableBody) pastTableBody.appendChild(row);

        } else {
          alert(result.message || 'Failed to cancel reservation.');
        }
      } catch (error) {
        alert('An error occurred while cancelling the reservation.');
        console.error(error);
      }
    });
  });
});
