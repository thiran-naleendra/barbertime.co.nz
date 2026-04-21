@extends('layouts.public', ['title' => 'Book Appointment'])

@section('content')
<style>
    :root {
        --bg: #0b0c10;
        --panel: #111318;
        --text: #f5f7fa;
        --muted: rgba(255, 255, 255, .72);
        --line: rgba(255, 255, 255, .12);
        --line2: rgba(255, 255, 255, .08);
        --white: #ffffff;
    }

    .section-title {
        font-weight: 900;
        letter-spacing: .2px;
        color: var(--text);
    }

    .muted-on-dark {
        color: var(--muted) !important;
    }

    /* HERO */
    .page-hero {
        border-radius: 18px;
        border: 1px solid var(--line);
        background:
            radial-gradient(1000px 380px at 20% 0%, rgba(255, 255, 255, .10), transparent 60%),
            radial-gradient(700px 260px at 90% 30%, rgba(255, 255, 255, .07), transparent 60%),
            linear-gradient(180deg, rgba(255, 255, 255, .06), rgba(255, 255, 255, .02));
        box-shadow: 0 18px 46px rgba(0, 0, 0, .45);
        color: var(--text);
    }

    .book-wrap {
        max-width: 980px;
        margin: 0 auto;
    }

    /* INFO PILL */
    .info-pill {
        background: var(--panel);
        border: 1px solid var(--line);
        border-radius: 16px;
        padding: 12px 16px;
        color: var(--text);
        box-shadow: 0 10px 26px rgba(0, 0, 0, .30);
    }

    /* FORM CARD */
    .form-card {
        background: var(--panel);
        border-radius: 18px;
        border: 1px solid var(--line);
        box-shadow: 0 18px 46px rgba(0, 0, 0, .45);
        overflow: hidden;
        color: var(--text);
    }

    /* INPUTS */
    .form-label {
        color: var(--text);
        font-weight: 600;
    }

    .form-control,
    .form-select {
        background-color: #0f1115;
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, .18);
        border-radius: 14px;
        padding: 12px 14px;
    }

    .form-control::placeholder {
        color: rgba(255, 255, 255, .45);
    }

    .form-control:focus,
    .form-select:focus {
        background-color: #0f1115;
        color: #ffffff;
        border-color: rgba(255, 255, 255, .35);
        box-shadow: none;
    }

    /* Dropdown options (limited support, but helps) */
    .form-select option {
        background-color: #ffffff;
        color: #000000;
    }

    /* Selected option highlight */
    .form-select option:checked {
        background-color: #000000;
        color: #ffffff;
    }

    /* BUTTONS */
    .btn-cta {
        background: var(--white);
        border-color: var(--white);
        color: #0b0c10;
        border-radius: 999px;
        padding: 10px 22px;
        font-weight: 800;
    }

    .btn-cta:hover {
        background: #e8edf5;
        border-color: #e8edf5;
        color: #0b0c10;
    }

    .btn-ghost {
        background: transparent;
        border: 1px solid var(--line);
        color: var(--text);
        border-radius: 999px;
        padding: 10px 22px;
        font-weight: 700;
    }

    .btn-ghost:hover {
        background: rgba(255, 255, 255, .06);
        border-color: rgba(255, 255, 255, .25);
        color: var(--text);
    }

    /* ALERTS */
    .alert-danger {
        background: rgba(220, 38, 38, .12);
        border: 1px solid rgba(220, 38, 38, .35);
        color: #fecaca;
    }

    /* ✅ TIME SLOT UI */
    .slot-wrap {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .slot-btn {
        border-radius: 999px;
        padding: 9px 14px;
        font-weight: 800;
        border: 1px solid rgba(255, 255, 255, .18);
        background: rgba(255, 255, 255, .04);
        color: #fff;
        transition: transform .12s ease, background .12s ease, border-color .12s ease;
    }

    .slot-btn:hover {
        transform: translateY(-1px);
        border-color: rgba(255, 255, 255, .35);
        background: rgba(255, 255, 255, .07);
    }

    .slot-btn[disabled] {
        opacity: .38;
        cursor: not-allowed;
        transform: none;
    }

    .slot-btn.is-selected {
        background: #fff;
        border-color: #fff;
        color: #0b0c10;
    }

    /* ✅ BARBER DROPDOWN (CUSTOM WITH IMAGE) */
    .barber-dd {
        position: relative;
        width: 100%;
    }

    .barber-dd-trigger {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        background-color: #0f1115;
        color: #fff;
        border: 1px solid rgba(255, 255, 255, .18);
        border-radius: 14px;
        padding: 12px 14px;
        cursor: pointer;
        user-select: none;
    }

    .barber-dd-trigger:focus {
        outline: none;
        border-color: rgba(255, 255, 255, .35);
    }

    .barber-dd-left {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 0;
    }

    .barber-dd-avatar {
        width: 34px;
        height: 34px;
        border-radius: 999px;
        object-fit: cover;
        border: 1px solid rgba(255, 255, 255, .15);
        flex: 0 0 auto;
    }

    .barber-dd-name {
        font-weight: 700;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .barber-dd-muted {
        color: rgba(255, 255, 255, .55);
        font-weight: 700;
    }

    .barber-dd-caret {
        flex: 0 0 auto;
        opacity: .8;
    }

    .barber-dd-menu {
        position: absolute;
        top: calc(100% + 8px);
        left: 0;
        right: 0;
        z-index: 50;
        background: #0f1115;
        border: 1px solid rgba(255, 255, 255, .18);
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 18px 46px rgba(0, 0, 0, .55);
        max-height: 320px;
        overflow-y: auto;
        display: none;
    }

    .barber-dd.open .barber-dd-menu {
        display: block;
    }

    .barber-dd-item {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border: 0;
        background: transparent;
        color: #fff;
        text-align: left;
        cursor: pointer;
    }

    .barber-dd-item:hover {
        background: rgba(255, 255, 255, .06);
    }

    .barber-dd-item.is-active {
        background: rgba(255, 255, 255, .10);
    }

    .barber-dd-item img {
        width: 34px;
        height: 34px;
        border-radius: 999px;
        object-fit: cover;
        border: 1px solid rgba(255, 255, 255, .15);
        flex: 0 0 auto;
    }

    .barber-dd-item span {
        font-weight: 800;
    }

    /* Mobile: bigger tap targets */
    @media (max-width: 576px) {
        .barber-dd-trigger {
            padding: 14px 14px;
        }

        .barber-dd-item {
            padding: 12px 12px;
        }
    }

    /* ✅ POLICIES UI */
    .policy-box {
        background: rgba(255, 255, 255, .04);
        border: 1px solid rgba(255, 255, 255, .14);
        border-radius: 16px;
        padding: 14px;
        color: var(--text);
    }

    .policy-box h6 {
        font-weight: 900;
        margin: 0 0 8px 0;
    }

    .policy-scroll {
        max-height: 260px;
        overflow: auto;
        padding-right: 6px;
    }

    .policy-scroll::-webkit-scrollbar {
        width: 8px;
    }

    .policy-scroll::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, .18);
        border-radius: 999px;
    }

    .policy-text {
        color: rgba(255, 255, 255, .78);
        line-height: 1.55;
        font-size: .95rem;
    }

    .policy-divider {
        border-top: 1px solid rgba(255, 255, 255, .12);
        margin: 12px 0;
    }

    .agree-row {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-top: 10px;
    }

    .agree-row input {
        margin-top: 4px;
    }

    .agree-label {
        color: rgba(255, 255, 255, .88);
        font-weight: 700;
    }
</style>

<!-- HERO -->
<div class="page-hero p-4 p-md-5 mb-5 text-center">
    <h1 class="display-6 mb-2" style="color: black; font-weight: 900; letter-spacing: .2px;">Book Appointment</h1>
    <p class="mb-0" style="color: black;">
        Fill the form and submit your booking request. (Payment will be added later)
    </p>
</div>

<div class="book-wrap">

    <!-- BOOKING FEE -->
    <div class="info-pill mb-3 text-center">
        Booking fee:
        <strong>${{ number_format($bookingFee, 2) }} NZD</strong>
        <span class="muted-on-dark"> (will be charged later)</span>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger mb-3">
        {{ $errors->first() }}
    </div>
    @endif

    <!-- FORM -->
    <div class="form-card">
        <div class="card-body p-4 p-md-5">
            <form method="POST" action="{{ route('book.store') }}" id="bookingForm">
                @csrf

                <div class="row g-3">

                    {{-- ✅ BARBER DROPDOWN (IMAGE + NAME) --}}
                    <div class="col-12">
                        <label class="form-label">Select Barber</label>

                        {{-- Hidden select keeps same backend field name (DO NOT REMOVE) --}}
                        <select name="barber_name" id="barberSelect" class="form-select d-none" required>
                            <option value="">Select barber</option>
                            @foreach ($barbers as $b)
                            <option value="{{ $b->name }}"
                                data-image="{{ $b->image_url ?? '' }}"
                                {{ old('barber_name') === $b->name ? 'selected' : '' }}>
                                {{ $b->name }}
                            </option>
                            @endforeach
                        </select>

                        {{-- Custom dropdown UI --}}
                        <div class="barber-dd" id="barberDd">
                            <button type="button" class="barber-dd-trigger" id="barberDdTrigger" aria-haspopup="listbox"
                                aria-expanded="false">
                                <div class="barber-dd-left">
                                    <img id="barberDdAvatar" class="barber-dd-avatar" src=""
                                        alt="" style="display:none;">
                                    <div class="barber-dd-name" id="barberDdLabel">
                                        <span class="barber-dd-muted">Select barber</span>
                                    </div>
                                </div>
                                <div class="barber-dd-caret">▾</div>
                            </button>

                            <div class="barber-dd-menu" id="barberDdMenu" role="listbox">
                                @foreach ($barbers as $b)
                                <button type="button"
                                    class="barber-dd-item"
                                    data-name="{{ $b->name }}"
                                    data-image="{{ $b->image_url ?? '' }}">
                                    @if(!empty($b->image_url))
                                    <img src="{{ $b->image_url }}" alt="{{ $b->name }}">
                                    @else
                                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='68' height='68'%3E%3Crect width='68' height='68' rx='34' fill='%2322262e'/%3E%3Ctext x='34' y='41' font-size='18' text-anchor='middle' fill='%23ffffff' font-family='Arial'%3E%3F%3C/text%3E%3C/svg%3E" alt="">
                                    @endif
                                    <span>{{ $b->name }}</span>
                                </button>
                                @endforeach
                            </div>
                        </div>

                        @error('barber_name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Service</label>
                        <select name="service_id" id="serviceSelect" class="form-select" required>
                            <option value="">Select service</option>
                            @foreach ($services as $service)
                            <option value="{{ $service->id }}"
                                {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                {{ $service->name }} – ${{ number_format((float) $service->price, 2) }} NZD
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Preferred Date</label>
                        <input type="date" id="dateInput" name="date" class="form-control"
                            value="{{ old('date') }}" required>
                    </div>

                    {{-- ✅ TIME SLOTS --}}
                    <div class="col-12 col-md-6">
                        <label class="form-label">Preferred Time</label>

                        <input type="hidden" name="time" id="selectedTime" value="{{ old('time') }}">

                        <div class="slot-wrap" id="slotWrap">
                            <div class="small muted-on-dark">
                                Select service and date to load available time slots.
                            </div>
                        </div>

                        <div class="small text-danger mt-2 d-none" id="slotError"></div>
                        <div class="small muted-on-dark mt-2 d-none" id="slotHint">
                            Selected time: <span class="fw-semibold text-white" id="slotSelectedLabel"></span>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="customer_name" class="form-control" placeholder="Enter your name"
                            value="{{ old('customer_name') }}" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Phone</label>
                        <input type="text" name="customer_phone" class="form-control" placeholder="+64 ..."
                            value="{{ old('customer_phone') }}" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Email</label>
                        <input type="email" name="customer_email" class="form-control" placeholder="you@email.com"
                            value="{{ old('customer_email') }}" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Please specify the services you would like in the comment box
                            below.</label>
                        <textarea name="notes" id="notesField" class="form-control" rows="4"
                            placeholder="Any special requests or questions?">{{ old('notes') }}</textarea>
                    </div>

                    {{-- ✅ POLICIES START --}}
                    <div class="col-12">
                        <div class="policy-box">
                            <div class="policy-scroll">
                                <h6>Cancellation Policy</h6>
                                <div class="policy-text">
                                    No cancellations or changes allowed within 24 hours of the appointment.
                                </div>

                                <div class="policy-divider"></div>

                                <h6>Late Policy</h6>
                                <div class="policy-text">
                                    On time, or a little early for your scheduled appointment is ideal. We do understand
                                    this isn’t always possible. If you are running late, please give us a heads up and call
                                    or message ahead.
                                    <br><br>
                                    If you are running late by 10 mins or more, we may have to reschedule your appointment.
                                    This is to ensure we have sufficient time to deliver the service and experience you deserve.
                                </div>

                                <div class="policy-divider"></div>

                                <h6>Cancellation and No-Show Policy</h6>
                                <div class="policy-text">
                                    We understand sometimes the unexpected happens and you cannot make an appointment.
                                    We would appreciate 24 hours-notice, if possible. This gives our Executive Cuts team plenty
                                    of time to fill the now vacant appointment.
                                    <br><br>
                                    Please do not be offended, if you repeatedly miss appointments without giving us notice,
                                    we will have no choice but to inform you that we can no longer accept your online bookings.
                                    We will of course accept a walk-in appointment with you, if we have an available opening.
                                </div>

                                <div class="policy-divider"></div>

                                <h6>Privacy Policy</h6>
                                <div class="policy-text">
                                    We will not use any information collected about you from your use of the website referred
                                    to above unless you have actively agreed to it being used in a specific manner. We will not
                                    contact you to discuss a product or service unless you have expressly requested that contact.
                                    Executive cuts LTD takes care to ensure that it adheres to the provisions of the Unsolicited
                                    Electronic Messages Act 2007 and will only collect and use information from you on this website
                                    in accordance with the Act and the Privacy Act 1993.
                                    <br><br>
                                    We will not under any circumstances release, sell, publish, or give away personal information
                                    to any other person or organisation unless required by law or subject to the consent of the
                                    information supplier. Information obtained from website users may be collated and used for
                                    statistical purposes, but will not identify the user in any way.
                                    <br><br>
                                    We will not collect from you any sensitive information relating to the prohibited grounds of
                                    discrimination set out in the Human Rights 1993 (namely, sex, marital …)
                                </div>
                            </div>

                            <div class="agree-row">
                                <input type="checkbox" id="agreePolicies" name="agree_policies" value="1"
                                    {{ old('agree_policies') ? 'checked' : '' }} required>
                                <label for="agreePolicies" class="agree-label">
                                    I agree
                                </label>
                            </div>

                            @error('agree_policies')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror

                            <div class="small muted-on-dark mt-2">
                                You must agree to our policies before submitting your booking.
                            </div>
                        </div>
                    </div>
                    {{-- ✅ POLICIES END --}}

                </div>

                <div class="mt-4 d-flex flex-column flex-sm-row gap-2">
                    <button class="btn btn-cta" type="submit" id="submitBtn">
                        Send Booking Request →
                    </button>
                    <a href="{{ route('services') }}" class="btn btn-ghost">
                        View Services
                    </a>
                </div>

                <div class="small muted-on-dark mt-3">
                    After submitting, you will receive an email confirmation.
                    We will contact you to confirm your booking.
                </div>
            </form>
        </div>
    </div>

</div>

{{-- ✅ Slots Loader JS + Barber dropdown + Barber -> slots --}}
<script>
    (function() {
        const serviceSelect = document.getElementById('serviceSelect');
        const dateInput = document.getElementById('dateInput');
        const slotWrap = document.getElementById('slotWrap');
        const selectedTime = document.getElementById('selectedTime');
        const slotError = document.getElementById('slotError');
        const slotHint = document.getElementById('slotHint');
        const slotSelectedLabel = document.getElementById('slotSelectedLabel');
        const form = document.getElementById('bookingForm');

        // ✅ Hidden <select> (keeps same backend field)
        const barberSelect = document.getElementById('barberSelect');

        // ✅ Custom barber dropdown elements
        const barberDd = document.getElementById('barberDd');
        const barberDdTrigger = document.getElementById('barberDdTrigger');
        const barberDdMenu = document.getElementById('barberDdMenu');
        const barberDdLabel = document.getElementById('barberDdLabel');
        const barberDdAvatar = document.getElementById('barberDdAvatar');

        // ✅ policies checkbox
        const agreePolicies = document.getElementById('agreePolicies');

        function setError(msg) {
            slotError.textContent = msg;
            slotError.classList.remove('d-none');
        }

        function clearError() {
            slotError.textContent = '';
            slotError.classList.add('d-none');
        }

        function resetSelectedTime() {
            selectedTime.value = '';
            slotHint.classList.add('d-none');
            slotWrap.querySelectorAll('.slot-btn').forEach(b => b.classList.remove('is-selected'));
        }

        function renderSlots(slots) {
            slotWrap.innerHTML = '';
            clearError();

            if (!slots || !slots.length) {
                slotWrap.innerHTML =
                    '<div class="small muted-on-dark">No available slots for this day.</div>';
                return;
            }

            /* =========================
               ✅ EDIT AREA (SHOP HOURS)
               ========================= */

            const OPEN_HOUR = 9; // 9 AM
            const CLOSE_HOUR_WEEKDAY = 19; // 7 PM (Mon-Sat)
            const CLOSE_HOUR_SUNDAY = 16; // 4 PM (Sunday)

            const MORNING_END = 12; // before 12 = Morning

            /* ========================= */

            // detect selected day
            const selectedDate = new Date(dateInput.value);
            const isSunday = selectedDate.getDay() === 0;

            const CLOSE_HOUR = isSunday ? CLOSE_HOUR_SUNDAY : CLOSE_HOUR_WEEKDAY;

            const morning = [];
            const afternoon = [];

            slots.forEach(s => {
                const hh = parseInt(s.time.split(':')[0], 10);

                // ✅ filter by shop hours
                if (hh < OPEN_HOUR || hh >= CLOSE_HOUR) {
                    return;
                }

                if (hh < MORNING_END) {
                    morning.push(s);
                } else {
                    afternoon.push(s);
                }
            });

            function buildGroup(title, list) {
                if (!list.length) return null;

                const section = document.createElement('div');
                section.className = 'w-100';

                const heading = document.createElement('div');
                heading.className = 'small muted-on-dark fw-semibold mb-2 mt-3';
                heading.textContent = title;

                const wrap = document.createElement('div');
                wrap.className = 'slot-wrap';

                list.forEach(s => {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'slot-btn';
                    btn.textContent = s.time;

                    if (!s.available) {
                        btn.disabled = true;
                    } else {
                        btn.addEventListener('click', () => {
                            selectedTime.value = s.time;

                            slotWrap.querySelectorAll('.slot-btn')
                                .forEach(b => b.classList.remove('is-selected'));

                            btn.classList.add('is-selected');
                            slotSelectedLabel.textContent = s.time;
                            slotHint.classList.remove('d-none');
                            clearError();
                        });
                    }

                    wrap.appendChild(btn);
                });

                section.appendChild(heading);
                section.appendChild(wrap);

                return section;
            }

            const morningSection = buildGroup('Morning (9AM – 12PM)', morning);
            const afternoonSection = buildGroup(
                isSunday ? 'Afternoon (12PM – 4PM)' : 'Afternoon (12PM – 7PM)',
                afternoon
            );

            if (morningSection) slotWrap.appendChild(morningSection);
            if (afternoonSection) slotWrap.appendChild(afternoonSection);
        }


        async function loadSlots() {
            const serviceId = serviceSelect.value;
            const date = dateInput.value;
            const barber = barberSelect.value;

            resetSelectedTime();

            if (!serviceId || !date || !barber) {
                slotWrap.innerHTML =
                    '<div class="small muted-on-dark">Select service, date, and barber to load available time slots.</div>';
                return;
            }

            slotWrap.innerHTML = '<div class="small muted-on-dark">Loading time slots...</div>';

            try {
                const url =
                    `{{ route('book.slots') }}?service_id=${serviceId}&date=${date}&barber=${encodeURIComponent(barber)}`;

                const res = await fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!res.ok) throw new Error();

                const json = await res.json();
                renderSlots(json.slots || []);
            } catch {
                slotWrap.innerHTML = '';
                setError('Could not load time slots. Please try again.');
            }
        }

        // ✅ Custom Barber Dropdown logic
        function closeBarberMenu() {
            barberDd.classList.remove('open');
            barberDdTrigger.setAttribute('aria-expanded', 'false');
        }

        function openBarberMenu() {
            barberDd.classList.add('open');
            barberDdTrigger.setAttribute('aria-expanded', 'true');
        }

        function setBarber(name, imageUrl) {
            // set hidden select value
            barberSelect.value = name;

            // update UI label + avatar
            barberDdLabel.textContent = name;

            if (imageUrl) {
                barberDdAvatar.src = imageUrl;
                barberDdAvatar.style.display = 'block';
                barberDdAvatar.alt = name;
            } else {
                barberDdAvatar.style.display = 'none';
                barberDdAvatar.src = '';
                barberDdAvatar.alt = '';
            }

            // active state in menu
            barberDdMenu.querySelectorAll('.barber-dd-item').forEach(btn => {
                btn.classList.toggle('is-active', btn.dataset.name === name);
            });

            closeBarberMenu();

            // reload slots after barber selection
            loadSlots();
        }

        // Trigger open/close
        barberDdTrigger.addEventListener('click', () => {
            barberDd.classList.contains('open') ? closeBarberMenu() : openBarberMenu();
        });

        // Click on menu item
        barberDdMenu.querySelectorAll('.barber-dd-item').forEach(btn => {
            btn.addEventListener('click', () => {
                setBarber(btn.dataset.name, btn.dataset.image || '');
            });
        });

        // Close on outside click
        document.addEventListener('click', (e) => {
            if (!barberDd.contains(e.target)) closeBarberMenu();
        });

        // Close on ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeBarberMenu();
        });

        // ✅ Initialize from old() selected value if exists
        (function initBarberFromOldValue() {
            const oldValue = barberSelect.value;
            if (!oldValue) {
                // default label
                barberDdLabel.innerHTML = '<span class="barber-dd-muted">Select barber</span>';
                barberDdAvatar.style.display = 'none';
                return;
            }
            const opt = barberSelect.querySelector(`option[value="${CSS.escape(oldValue)}"]`);
            const img = opt ? (opt.getAttribute('data-image') || '') : '';
            setBarber(oldValue, img);
        })();

        // Load slots when service/date changes
        serviceSelect.addEventListener('change', loadSlots);
        dateInput.addEventListener('change', loadSlots);

        form.addEventListener('submit', function(e) {
            if (!barberSelect.value) {
                e.preventDefault();
                setError('Please select a barber before submitting.');
                barberDd.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                return;
            }

            if (!selectedTime.value) {
                e.preventDefault();
                setError('Please select a time slot before submitting.');
                slotWrap.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                return;
            }

            if (agreePolicies && !agreePolicies.checked) {
                e.preventDefault();
                setError('Please agree to the policies before submitting.');
                agreePolicies.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                return;
            }
        });

    })();
</script>

@endsection