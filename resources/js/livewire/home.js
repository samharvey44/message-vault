import { TempusDominus } from "@eonasdan/tempus-dominus";

const datepicker = new TempusDominus(
    document.querySelector("input[name='expiry']"),
    {
        display: {
            icons: {
                type: "icons",
                time: "fa-solid fa-clock",
                date: "fa-solid fa-calendar",
                up: "fa-solid fa-arrow-up",
                down: "fa-solid fa-arrow-down",
                previous: "fa-solid fa-chevron-left",
                next: "fa-solid fa-chevron-right",
                today: "fa-solid fa-calendar-check",
                clear: "fa-solid fa-trash",
                close: "fa-solid fa-xmark",
            },
            sideBySide: false,
            calendarWeeks: false,
            viewMode: "calendar",
            toolbarPlacement: "bottom",
            keepOpen: false,
            buttons: {
                today: false,
                clear: false,
                close: false,
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
            inline: false,
            theme: "auto",
        },
    }
);
