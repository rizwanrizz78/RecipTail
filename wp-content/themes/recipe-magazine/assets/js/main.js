document.addEventListener('DOMContentLoaded', function() {

	// Mobile Menu Toggle
	const menuToggle = document.querySelector('.menu-toggle');
	const rightNav = document.querySelector('.header-right-nav');

	if ( menuToggle && rightNav ) {
		menuToggle.addEventListener('click', function() {
			rightNav.classList.toggle('active');
			const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
			menuToggle.setAttribute('aria-expanded', !isExpanded);
		});
	}

});
