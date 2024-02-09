/*!
* Start Bootstrap - Agency v7.0.12 (https://startbootstrap.com/theme/agency)
* Copyright 2013-2023 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-agency/blob/master/LICENSE)
*/
//
// Scripts
// 

window.addEventListener('DOMContentLoaded', event => {

    // Shrink the navbar when page is scrolled
    document.addEventListener('scroll', () => {
        const navbarCollapsible = document.body.querySelector('#mainNav');
        if (navbarCollapsible) {
            navbarCollapsible.classList.toggle('navbar-shrink', window.scrollY > 0);
        }
    });

    //  Activate Bootstrap scrollspy on the main nav element
    const mainNav = document.body.querySelector('#mainNav');
    if (mainNav) {
        new bootstrap.ScrollSpy(document.body, {
            target: '#mainNav',
            rootMargin: '0px 0px -40%',
        });
    };

    // Collapse responsive navbar when toggler is visible
    const navbarToggler = document.body.querySelector('.navbar-toggler');
    const responsiveNavItems = [].slice.call(
        document.querySelectorAll('#navbarResponsive .nav-link')
    );
    responsiveNavItems.map(function (responsiveNavItem) {
        responsiveNavItem.addEventListener('click', () => {
            if (window.getComputedStyle(navbarToggler).display !== 'none') {
                navbarToggler.click();
            }
        });
    });
});


document.addEventListener('DOMContentLoaded', function () {
    // Get all service checkboxes
    var serviceCheckboxes = document.querySelectorAll('.serviceCheckbox');

    // Add event listener for each checkbox
    serviceCheckboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', calculateTotal);
    });

    // Get all barber radio buttons
    var barberRadios = document.querySelectorAll('.barber-radio');

    // Add event listener for each radio button
    barberRadios.forEach(function (radio) {
        radio.addEventListener('change', updateSelectedBarber);
    });

    // Get the date input element
    var dateInput = document.querySelector('input[name="datetime"]');

    // Add event listener for date input change
    dateInput.addEventListener('change', calculateTotal);

    function calculateTotal() {
        // Get all checked checkboxes
        var checkedCheckboxes = document.querySelectorAll('.serviceCheckbox:checked');
        var totalPrice = 0;
        var totalDuration = 0;

        // Clear previous selected services
        document.getElementById('selectedServicesList').innerHTML = '';

        // Calculate total price and duration
        checkedCheckboxes.forEach(function (checkbox) {
            var name = checkbox.dataset.name;
            var price = parseFloat(checkbox.dataset.price);
            var duration = parseInt(checkbox.dataset.duration);

            // Update the total price and duration on the page
            totalPrice += price;
            totalDuration += duration;

            // Display selected services
            var listItem = document.createElement('li');
            listItem.textContent = name + ' - RM' + price.toFixed(2) + ' (' + duration + ' minutes)';
            document.getElementById('selectedServicesList').appendChild(listItem);
        });

        // Update the total price and duration on the page
        document.getElementById('totalPrice').textContent = 'Total Price: RM' + totalPrice.toFixed(2);
        document.getElementById('totalDuration').textContent = 'Total Duration: ' + totalDuration + ' minutes';

        // Update the date and time information if a valid date is available
        var startDateTimeInput = document.querySelector('input[name="datetime"]');
        var startDateTime = startDateTimeInput ? startDateTimeInput.value : null;

        if (startDateTime) {
            var formattedStartDateTime = formatDateTime(new Date(startDateTime));
            var formattedEndDateTime = calculateEndDateTime(startDateTime, totalDuration);

            document.getElementById('dateTimeInfo').textContent =
                'Date and Time: ' + formattedStartDateTime + ' - ' + formattedEndDateTime;
        }
    }

    // Function to format date and time
    function formatDateTime(dateTime) {
        var options = {
            weekday: 'short',
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric'
        };
        return dateTime.toLocaleDateString('en-US', options);
    }

    // Function to calculate end date time based on start date time and total duration
    function calculateEndDateTime(startDateTime, totalDuration) {
        var startDate = new Date(startDateTime);
        var endDate = new Date(startDate.getTime() + totalDuration * 60000); // Convert minutes to milliseconds

        // Format end date time without time zone information
        var formattedEndDateTime = formatDateTime(endDate).replace(/\sGMT.*$/, '');

        return formattedEndDateTime;
    }

    function updateSelectedBarber() {
        var selectedBarberIdInput = document.querySelector('input[name="barber_id"]:checked');
        var selectedBarberNameElement = document.getElementById('selectedBarberName');
        var selectedBarberImageElement = document.getElementById('selectedBarberImage');

        if (selectedBarberIdInput) {
            var selectedBarberId = selectedBarberIdInput.value;
            var selectedBarberName = document.querySelector('.barber-label[for="barber' + selectedBarberId + '"] span').textContent;
            var selectedBarberImageSrc = document.querySelector('.barber-label[for="barber' + selectedBarberId + '"] img').src;

            // Display selected barber name
            selectedBarberNameElement.textContent = 'Barber: ' + selectedBarberName;

            // Use the onload event to check if the image is successfully loaded
            selectedBarberImageElement.onload = function () {
                selectedBarberImageElement.style.display = 'block'; // Show the image
            };

            // Set the maximum width and height for the displayed image
            selectedBarberImageElement.style.maxWidth = '100px'; // Adjust the width as needed
            selectedBarberImageElement.style.maxHeight = '100px'; // Adjust the height as needed

            // Set the source, triggering the onload event
            selectedBarberImageElement.src = selectedBarberImageSrc;
        } else {
            // If no barber is selected, hide the image and clear the source
            selectedBarberNameElement.textContent = ''; // Clear the text
            selectedBarberImageElement.src = ''; // Clear the source
            selectedBarberImageElement.style.display = 'none'; // Hide the image
        }
    }
});

document.addEventListener('DOMContentLoaded', function() {
        var serviceLabels = document.querySelectorAll('.service-label');

        serviceLabels.forEach(function(serviceLabel) {
            serviceLabel.addEventListener('click', function() {
                // Toggle the 'clicked' class on the button
                this.classList.toggle('clicked');
            });
        });
    });