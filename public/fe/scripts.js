document.addEventListener("DOMContentLoaded", () => {
    const hamburger = document.querySelector('.hamburger');
    const navLinks = document.querySelector('.nav-links');

    if (hamburger && navLinks) {
        hamburger.addEventListener('click', () => {
            navLinks.classList.toggle('active');

            // Check if the close button exists
            let closeMenuButton = navLinks.querySelector('.close-menu');
            if (!closeMenuButton) {
                closeMenuButton = document.createElement('span');
                closeMenuButton.textContent = '×'; // Close icon
                closeMenuButton.classList.add('close-menu');
                navLinks.appendChild(closeMenuButton);

                // Add event listener to close the menu
                closeMenuButton.addEventListener('click', () => {
                    navLinks.classList.remove('active');
                });
            }
        });
    }
});

