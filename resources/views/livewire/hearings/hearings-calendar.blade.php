<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                
                <div id="calendar" wire:ignore></div>

            </div>
        </div>
    </div>

    @assets
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    @endassets

    @script
    <script>
        document.addEventListener('livewire:initialized', function () {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                locale: 'es',
                events: @json($this->getEvents()), // Initial load
                eventClick: function(info) {
                    // Optional: Open modal instead of navigating
                    // info.jsEvent.preventDefault(); 
                    // alert('Event: ' + info.event.title);
                },
                eventDidMount: function(info) {
                    // Tooltip or custom rendering
                    // info.el.title = info.event.extendedProps.status;
                }
            });

            calendar.render();
        });
    </script>
    @endscript
</div>
