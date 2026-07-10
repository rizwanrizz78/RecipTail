document.addEventListener('DOMContentLoaded', function() {

	// Mobile Menu Toggle
	const menuToggle = document.querySelector('.menu-toggle');
	const primaryMenu = document.querySelector('.primary-menu');

	if ( menuToggle && primaryMenu ) {
		menuToggle.addEventListener('click', function() {
			primaryMenu.classList.toggle('active');
			const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
			menuToggle.setAttribute('aria-expanded', !isExpanded);
		});
	}

	// Search Overlay Toggle
	const searchToggleBtn = document.querySelector('.header-search-toggle');
	const searchOverlay = document.querySelector('.search-overlay');
	const searchCloseBtn = document.querySelector('.search-overlay-close');

	if ( searchToggleBtn && searchOverlay && searchCloseBtn ) {
		searchToggleBtn.addEventListener('click', function(e) {
			e.preventDefault();
			searchOverlay.classList.add('active');
			const searchInput = searchOverlay.querySelector('input[type="search"]');
			if ( searchInput ) {
				setTimeout(() => searchInput.focus(), 100);
			}
		});

		searchCloseBtn.addEventListener('click', function(e) {
			e.preventDefault();
			searchOverlay.classList.remove('active');
		});

		// Close on Escape key
		document.addEventListener('keydown', function(e) {
			if ( e.key === 'Escape' && searchOverlay.classList.contains('active') ) {
				searchOverlay.classList.remove('active');
			}
		});
	}
});
