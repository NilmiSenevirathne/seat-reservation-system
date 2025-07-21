document.addEventListener('DOMContentLoaded', function() {
  const sidebar = document.getElementById('sidebar');
  const sidebarToggle = document.getElementById('sidebarToggle');
  
  // Toggle sidebar on button click
  sidebarToggle.addEventListener('click', function() {
    sidebar.classList.toggle('active');
  });
  
  // Close sidebar when clicking outside on mobile
  document.addEventListener('click', function(event) {
    if (window.innerWidth <= 768 && 
        !sidebar.contains(event.target) && 
        event.target !== sidebarToggle) {
      sidebar.classList.remove('active');
    }
  });
  
  // Highlight active menu item based on current page
  const currentPage = window.location.pathname.split('/').pop();
  const menuLinks = document.querySelectorAll('.menu-link');
  
  menuLinks.forEach(link => {
    const href = link.getAttribute('href').split('/').pop();
    if (href === currentPage) {
      link.parentElement.classList.add('active');
    }
    
    // Close sidebar when clicking a link on mobile
    link.addEventListener('click', function() {
      if (window.innerWidth <= 768) {
        sidebar.classList.remove('active');
      }
    });
  });
});