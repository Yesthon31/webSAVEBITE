import './bootstrap';
import { Calendar } from '@fullcalendar/core';  // FullCalendar Core
import dayGridPlugin from '@fullcalendar/daygrid';  // Plugin untuk tampilan grid bulan
import interactionPlugin from '@fullcalendar/interaction';  // Plugin untuk interaksi

document.addEventListener('DOMContentLoaded', function () {
    // Initialize calendar if element exists
    var calendarEl = document.getElementById('calendar');
    if (calendarEl) {
        var calendar = new Calendar(calendarEl, {
            plugins: [dayGridPlugin, interactionPlugin],
            initialView: 'dayGridMonth',
            events: [
                { title: 'Event 1', start: '2025-05-10', allDay: true },
                { title: 'Event 2', start: '2025-05-15', allDay: true }
            ]
        });
        calendar.render();
    }
});
