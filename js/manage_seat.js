
// Modal Handling
document.getElementById('openAddModal').onclick = () => {
  document.getElementById('addModal').style.display = 'flex';
};

function closeAddModal() { 
  document.getElementById('addModal').style.display = 'none'; 
}

function openUpdateModal(id, seatNum, location) {
  document.getElementById('update_seat_id').value = id;
  document.getElementById('update_seat_num').value = seatNum;
  document.getElementById('update_location').value = location;
  document.getElementById('updateModal').style.display = 'flex';
}

function closeUpdateModal() { 
  document.getElementById('updateModal').style.display = 'none'; 
}

// Close modals when clicking outside
window.onclick = function(e) {
  if (e.target == document.getElementById('addModal')) closeAddModal();
  if (e.target == document.getElementById('updateModal')) closeUpdateModal();
};

// Search Functionality
document.getElementById('searchInput').addEventListener('input', function() {
  const filter = this.value.toLowerCase();
  const rows = document.querySelectorAll('#seatsTable tbody tr');
  
  rows.forEach(row => {
    const seatNum = row.cells[1].textContent.toLowerCase();
    const location = row.cells[2].textContent.toLowerCase();
    row.style.display = (seatNum.includes(filter) || location.includes(filter)) ? '' : 'none';
  });
});

// Location Filter
document.getElementById('locationFilter').addEventListener('change', function() {
  const filter = this.value;
  const rows = document.querySelectorAll('#seatsTable tbody tr');
  
  rows.forEach(row => {
    const location = row.cells[2].textContent;
    row.style.display = (!filter || location === filter) ? '' : 'none';
  });
});


// Modal functions
function openAddModal() {
    document.getElementById('addModal').style.display = 'block';
    document.getElementById('location').addEventListener('change', updateSeatNumber);
}

function closeAddModal() {
    document.getElementById('addModal').style.display = 'none';
}

function openUpdateModal(seat_id, seat_num, location) {
    document.getElementById('updateModal').style.display = 'block';
    document.getElementById('update_seat_id').value = seat_id;
    document.getElementById('update_seat_num').value = seat_num;
    document.getElementById('update_location').value = location;
}

function closeUpdateModal() {
    document.getElementById('updateModal').style.display = 'none';
}

// Auto-fill seat number based on location
function updateSeatNumber() {
    const location = document.getElementById('location').value;
    const seatNumInput = document.getElementById('seat_num');
    const loadingIndicator = document.getElementById('seat_num_loading');
    
    if (location) {
        loadingIndicator.style.display = 'inline-block';
        seatNumInput.value = '';
        
        fetch(`?get_next_seat=1&location=${encodeURIComponent(location)}`)
            .then(response => response.json())
            .then(data => {
                seatNumInput.value = data.seat_num;
                loadingIndicator.style.display = 'none';
            })
            .catch(error => {
                console.error('Error fetching next seat number:', error);
                loadingIndicator.style.display = 'none';
                seatNumInput.value = '';
                seatNumInput.placeholder = 'Error generating number';
            });
    } else {
        seatNumInput.value = '';
        loadingIndicator.style.display = 'none';
    }
}

// Close modals when clicking outside
window.onclick = function(event) {
    if (event.target.className === 'modal') {
        event.target.style.display = 'none';
    }
}

// Initialize modal button
document.getElementById('openAddModal').addEventListener('click', openAddModal);

// Search functionality
document.getElementById('searchInput').addEventListener('input', function() {
    const searchValue = this.value.toLowerCase();
    const rows = document.querySelectorAll('#seatsTable tbody tr');
    
    rows.forEach(row => {
        const seatNum = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
        const location = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
        
        if (seatNum.includes(searchValue) || location.includes(searchValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Filter by location
document.getElementById('locationFilter').addEventListener('change', function() {
    const filterValue = this.value.toLowerCase();
    const rows = document.querySelectorAll('#seatsTable tbody tr');
    
    rows.forEach(row => {
        const location = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
        
        if (filterValue === '' || location === filterValue.toLowerCase()) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
