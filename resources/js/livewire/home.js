import { TempusDominus, Namespace } from "@eonasdan/tempus-dominus";

const initializeDatepicker = () => {
    const dateInput = document.querySelector("input[name='expiry']");

    const datePicker = new TempusDominus(dateInput, {
        defaultDate: new Date(document.getElementById("default-expiry").value),
        display: {
            icons: {
                type: "icons",
                time: "bi bi-clock",
                date: "bi bi-calendar-date",
                up: "bi bi-arrow-up-short",
                down: "bi bi-arrow-down-short",
                previous: "bi bi-arrow-left-short",
                next: "bi bi-arrow-right-short",
                today: "bi bi-calendar-check",
                clear: "bi bi-x",
                close: "bi bi-x-circle",
            },
            viewMode: "calendar",
            toolbarPlacement: "bottom",
            buttons: {
                today: true,
                clear: false,
                close: true,
            },
            components: {
                calendar: true,
                date: true,
                month: true,
                year: true,
                decades: true,
                clock: true,
                hours: true,
                minutes: true,
                seconds: false,
                useTwentyfourHour: undefined,
            },
        },
        localization: {
            format: "dd/MM/yyyy HH:mm",
        },
        promptTimeOnDateChange: true,
        restrictions: {
            minDate: new Date(),
        },
    });

    // Load the widget onto the page, preventing rough animation on first focus
    datePicker.toggle();
    datePicker.toggle();

    // Initialize Livewire property
    dateInput.dispatchEvent(new Event("input"));

    datePicker.subscribe(Namespace.events.change, () => {
        dateInput.dispatchEvent(new Event("input"));
    });
};

window.addEventListener("DOMContentLoaded", () => {
    initializeDatepicker();
});

initializeDatepicker();
