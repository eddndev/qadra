<div class="py-2">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

        <!-- Module Header -->
        <div class="flex items-center justify-between">
            <div>
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2">
                        <li><span class="text-sm font-medium text-slate-500">Audiencias</span></li>
                        <li><span class="text-slate-400">/</span></li>
                        <li><span class="text-sm font-medium text-indigo-600">Calendario</span></li>
                    </ol>
                </nav>
                <x-slot name="header">Audiencias</x-slot>
                <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-800">Calendario de Audiencias</h1>
            </div>
            <button wire:click="$dispatch('create-hearing')"
                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white transition-colors bg-indigo-600 rounded-lg shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Agendar Audiencia
            </button>
        </div>

        <!-- Calendar Card -->
        <div class="overflow-hidden bg-white border shadow-sm rounded-xl border-slate-200">
            <div class="p-5">
                <div id="calendar" wire:ignore></div>
            </div>
        </div>
    </div>

    @assets
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <style>
        /* Vivid Light Theme - Qadra Updated */
        :root {
            --fc-button-text-color: #4f46e5;
            /* Indigo-600 */
            --fc-button-bg-color: transparent;
            --fc-button-border-color: transparent;
            --fc-button-hover-bg-color: #eef2ff;
            /* Indigo-50 */
            --fc-button-hover-border-color: transparent;
            --fc-button-active-bg-color: #e0e7ff;
            /* Indigo-100 */
            --fc-button-active-border-color: transparent;

            --fc-border-color: #f1f5f9;
            /* Slate-100 */
            --fc-today-bg-color: #fafafa;
        }

        /* Toolbar Styling */
        .fc .fc-toolbar.fc-header-toolbar {
            margin-bottom: 1.5rem;
        }

        .fc .fc-toolbar-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            /* Slate-800 */
            text-transform: capitalize;
            font-family: 'Inter', sans-serif;
        }

        /* Custom Navigation Buttons */
        .fc .fc-button-primary {
            background-color: var(--fc-button-bg-color);
            border-color: var(--fc-button-border-color);
            color: var(--fc-button-text-color);
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.2s;
            box-shadow: none !important;
        }

        .fc .fc-button-primary:hover {
            background-color: var(--fc-button-hover-bg-color);
            color: #4338ca;
            /* Indigo-700 */
        }

        .fc .fc-button-primary:not(:disabled).fc-button-active {
            background-color: #4f46e5;
            /* Indigo-600 - Valid Active State */
            color: white;
        }

        /* Grid Header - The "Vivid" Light Part */
        .fc-theme-standard th {
            border: none;
            background-color: #f0f9ff;
            /* Sky-50 */
            padding: 12px 0;
        }

        .fc-col-header-cell-cushion {
            color: #0284c7;
            /* Sky-600 - Vivid Light Blue */
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            text-decoration: none !important;
        }

        /* Grid Body */
        .fc-daygrid-day-frame {
            min-height: 40px;
            padding: 2px;
        }

        .fc-daygrid-day-top {
            flex-direction: row;
            padding: 4px 8px;
        }

        .fc-daygrid-day-number {
            color: #64748b;
            /* Slate-500 */
            font-weight: 500;
            font-size: 0.9rem;
            text-decoration: none !important;
        }

        .fc-day-today {
            background-color: #f8fafc !important;
            /* Very subtle slate */
        }

        .fc-day-today .fc-daygrid-day-number {
            color: #4f46e5;
            font-weight: 800;
            background-color: #eef2ff;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Events - Modern Chips */
        .fc-event {
            border: none;
            background-color: white;
            border-left: 4px solid #4f46e5;
            /* Vivid Indigo Strip */
            box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            border-radius: 0 4px 4px 0;
            padding: 3px 6px;
            margin: 2px 4px;
            font-size: 0.75rem;
            font-weight: 500;
            color: #334155;
            /* Slate-700 */
            transition: transform 0.1s;
        }

        .fc-event:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -1px rgb(0 0 0 / 0.1);
            color: #4f46e5;
        }

        .fc-event.urgent {
            border-left-color: #ef4444;
            /* Red-500 */
            background-color: #fef2f2;
        }
    </style>
    @endassets

    @script
    <script>
        document.addEventListener('livewire:initialized', function () {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                themeSystem: 'standard',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    day: 'Día',
                },
                locale: 'es',
                firstDay: 1,
                navLinks: true,
                editable: false,
                dayMaxEvents: 3,
                height: 'auto',
                aspectRatio: 2.0,
                fixedWeekCount: false,

                events: @json($this->getEvents()),

                eventClassNames: function (arg) {
                    if (arg.event.extendedProps.status === 'urgent') {
                        return ['urgent'];
                    }
                    return [];
                }
            });

            calendar.render();
        });
    </script>
    @endscript

    <!-- Register Global Hearing Form -->
    <livewire:hearings.hearing-form />
</div>