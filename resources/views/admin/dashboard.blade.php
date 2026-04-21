@extends('layouts.admin', ['title' => 'Dashboard'])

@section('content')
<style>
    .dash-card{
        border: 1px solid rgba(0,0,0,.08);
        border-radius: 18px;
        background: #fff;
        padding: 18px;
        box-shadow: 0 10px 26px rgba(0,0,0,.06);
        transition: transform .15s ease, box-shadow .15s ease, border-color .15s ease;
        height: 100%;
    }
    .dash-card:hover{
        transform: translateY(-2px);
        box-shadow: 0 16px 34px rgba(0,0,0,.10);
        border-color: rgba(0,0,0,.14);
    }
    .dash-icon{
        width: 46px;
        height: 46px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(0,0,0,.06);
        font-size: 20px;
    }
    .dash-sub{
        font-size: 12px;
        color: #6c757d;
    }

    /* ✅ FullCalendar mobile fixes */
    #bookingCalendar{
        width: 100%;
        overflow-x: auto;
    }
    .fc .fc-toolbar{
        flex-wrap: wrap;
        gap: 8px;
    }
    .fc .fc-toolbar-title{
        font-size: 1rem;
        font-weight: 700;
    }
    .fc .fc-button{
        border-radius: 999px;
        padding: .35rem .6rem;
        font-size: .85rem;
    }
    .fc .fc-timegrid-slot-label,
    .fc .fc-timegrid-axis-cushion{
        font-size: 12px;
    }

    @media (max-width: 575.98px){
        .dash-card{ padding: 14px; }
        .fc .fc-toolbar-title{ font-size: .95rem; }
        .fc .fc-button{ padding: .3rem .5rem; font-size: .8rem; }
    }
</style>

<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 mb-4">
    <div>
        <h1 class="h5 fw-semibold mb-1">Dashboard</h1>
        <div class="dash-sub">Manage your salon content</div>
    </div>

    
</div>

{{-- ✅ Top quick cards --}}
<div class="row g-3">
    <div class="col-12 col-md-6 col-lg-3">
        <a href="{{ route('admin.services.index') }}" class="text-decoration-none text-dark">
            <div class="dash-card">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="dash-icon">✂️</div>
                    <span class="badge text-bg-light">Manage</span>
                </div>
                <div class="fw-bold">Services</div>
                <div class="dash-sub mb-3">Add / edit service list & prices</div>
                <span class="btn btn-dark btn-sm rounded-pill px-3">Open</span>
            </div>
        </a>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
        <a href="{{ route('admin.products.index') }}" class="text-decoration-none text-dark">
            <div class="dash-card">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="dash-icon">🧴</div>
                    <span class="badge text-bg-light">Manage</span>
                </div>
                <div class="fw-bold">Products</div>
                <div class="dash-sub mb-3">Upload product images & pricing</div>
                <span class="btn btn-dark btn-sm rounded-pill px-3">Open</span>
            </div>
        </a>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
        <a href="{{ route('admin.gallery.index') }}" class="text-decoration-none text-dark">
            <div class="dash-card">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="dash-icon">🖼️</div>
                    <span class="badge text-bg-light">Manage</span>
                </div>
                <div class="fw-bold">Gallery</div>
                <div class="dash-sub mb-3">Add photos for your website</div>
                <span class="btn btn-dark btn-sm rounded-pill px-3">Open</span>
            </div>
        </a>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
        <a href="{{ route('admin.bookings.index') }}" class="text-decoration-none text-dark">
            <div class="dash-card">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="dash-icon">📅</div>
                    <span class="badge text-bg-light">Manage</span>
                </div>
                <div class="fw-bold">Bookings</div>
                <div class="dash-sub mb-3">View requests & update status</div>
                <span class="btn btn-dark btn-sm rounded-pill px-3">Open</span>
            </div>
        </a>
    </div>
</div>

{{-- ✅ Calendar + Upcoming section (separate row) --}}
<div class="row g-3 mt-2">
    <div class="col-12 col-lg-8">
        <div class="dash-card">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 mb-3">
                <div>
                    <div class="fw-bold">Bookings Calendar</div>
                    <div class="dash-sub">View booked time slots</div>
                </div>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-dark btn-sm rounded-pill">
                    View All
                </a>
            </div>

            <div id="bookingCalendar"></div>

            <div class="dash-sub mt-3 d-flex flex-wrap gap-2">
                <span class="badge" style="background:#f59e0b;color:#111;">Pending</span>
                <span class="badge" style="background:#22c55e;color:#111;">Confirmed</span>
                <span class="badge" style="background:#3b82f6;color:#111;">Paid</span>
                <span class="badge" style="background:#ef4444;color:#111;">Cancelled</span>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-4">
        <div class="dash-card">
            <div class="fw-bold mb-1">Upcoming</div>
            <div class="dash-sub mb-3">Next bookings</div>

            @if(isset($upcoming) && $upcoming->count())
                <div class="d-grid gap-2">
                    @foreach($upcoming as $b)
                        <a href="{{ route('admin.bookings.show', $b) }}"
                           class="text-decoration-none text-dark">
                            <div class="border rounded-3 p-2">
                                <div class="small text-muted">#{{ $b->id }}</div>
                                <div class="fw-semibold">{{ optional($b->service)->name ?? 'Booking' }}</div>
                                <div class="small text-muted">
                                    {{ $b->booking_start_at->timezone('Pacific/Auckland')->format('d M Y, h:i A') }} (NZ)
                                </div>
                                <div class="small">{{ $b->customer_name }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-muted small">No upcoming bookings.</div>
            @endif
        </div>
    </div>
</div>

{{-- FullCalendar --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const el = document.getElementById('bookingCalendar');
    if (!el) return;

    const calendar = new FullCalendar.Calendar(el, {
    timeZone: 'Pacific/Auckland', // ✅ important
    initialView: window.innerWidth < 768 ? 'listWeek' : 'timeGridWeek',
    height: 'auto',
    nowIndicator: true,
    navLinks: true,
    dayMaxEvents: true,

    headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: window.innerWidth < 768 ? 'listWeek,dayGridMonth' : 'timeGridDay,timeGridWeek,dayGridMonth'
    },

    events: {
        url: '{{ route('admin.bookings.calendar.events') }}',
        failure: function() {
            alert('Calendar events failed to load. Check route/auth/json.');
        }
    },

    eventTimeFormat: { hour: '2-digit', minute: '2-digit', meridiem: true },

    windowResize: function() {
        calendar.changeView(window.innerWidth < 768 ? 'listWeek' : 'timeGridWeek');
    }
});


    calendar.render();
});
</script>
@endsection
