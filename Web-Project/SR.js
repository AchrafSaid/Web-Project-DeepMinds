document.addEventListener("DOMContentLoaded", function () {
    const cars = [
        { id: "jeep-compass", availableDates: [1, 3, 5, 10, 12, 14, 15, 19, 20, 22, 25, 28, 30] },
        { id: "land-rover", availableDates: [1, 2, 3, 6, 9, 10, 11, 12, 18, 20, 23, 24, 29, 30] },
        { id: "toyota-land-cruiser", availableDates: [2, 3, 4, 7, 9, 10, 13, 15, 16, 17, 19, 21, 24, 27, 31] },
        { id: "range-rover", availableDates: [1, 4, 8, 14, 22, 28] },
        { id: "mercedes-benz", availableDates: [1, 7, 10, 15, 19, 20, 21, 23, 25, 26, 29] },
        { id: "bmw-x3", availableDates: [2, 3, 11, 15, 16, 20, 26, 31] },
        { id: "Hyundai-Sonata", availableDates: [1, 5, 10, 11, 12, 15, 19, 20, 25, 30] },
        { id: "Mazda-3-Saloon", availableDates: [2, 6, 12, 15, 18, 19, 20, 24, 27, 31] },
        { id: "BMW-4-Series", availableDates: [1, 3, 9, 13, 17, 21, 24, 25, 29] },
        { id: "Maserati-Ghibli", availableDates: [4, 8, 10, 14, 22, 25, 28] },
        { id: "Toyota-Camry", availableDates: [2, 7, 13, 19, 23, 29, 30] },
        { id: "Toyota-Mark-X", availableDates: [1, 6, 11, 16, 20, 26, 31] }
    ];

    const today = new Date().getDate();

    cars.forEach(car => {
        const button = document.querySelector(`#${car.id}`);
        if (car.availableDates.includes(today)) {
            button.value = "Available";
            button.classList.remove("NON");
        } else {
            button.value = "Not-Available";
            button.classList.add("NON");
        }
    });
});