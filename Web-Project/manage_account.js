document.addEventListener("DOMContentLoaded", function() {
    // Fetch the user data from the PHP file
    fetch('get_user_data.php')
        .then(response => response.json())
        .then(data => {
            // Update user details
            document.getElementById("user-name").innerText = data.user.name;
            document.getElementById("user-email").innerText = data.user.email;
            document.getElementById("user-address").innerText = data.user.address;
            document.getElementById("user-phone").innerText = data.user.phone;

            // Populate reservations table
            const reservationTable = document.getElementById("reservation-table");
            data.reservations.forEach(reservation => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${reservation.id}</td>
                    <td>${reservation.booking_date}</td>
                    <td>${reservation.pickup_date}</td>
                    <td>${reservation.return_date}</td>
                    <td>${reservation.pickup_location}</td>
                    <td>${reservation.vehicle_model}</td>
                `;
                reservationTable.appendChild(row);
            });
        })
        .catch(error => console.error('Error fetching data:', error));
});
