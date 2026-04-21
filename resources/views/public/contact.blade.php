@extends('layouts.public', ['title' => 'Contact'])

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

        .contact-wrap {
            max-width: 1100px;
            margin: 0 auto;
        }

        /* INFO CARD */
        .info-card {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 16px 18px;
            box-shadow: 0 12px 34px rgba(0, 0, 0, .35);
        }

        .icon-dot {
            width: 38px;
            height: 38px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, .06);
            border: 1px solid var(--line2);
            color: #fff;
            font-weight: 900;
            flex: 0 0 auto;
            font-size: 15px;
        }

        /* MAP */
        .map-box {
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid var(--line);
            box-shadow: 0 18px 46px rgba(0, 0, 0, .45);
            background: var(--panel);
        }

        .map-placeholder {
            padding: 32px;
            color: var(--muted);
            text-align: center;
        }

        /* Alerts */
        .alert-info {
            background: rgba(255, 255, 255, .06);
            border: 1px solid var(--line);
            color: var(--text);
        }
    </style>

    <!-- HERO -->
    <div class="page-hero p-4 p-md-5 mb-5 text-center">
        <h1 class="display-6  mb-2" style="color: black; font-weight: 900;
      letter-spacing: .2px;">Contact Us</h1>
        <p class=" mb-0" style="color: black;">
            Get in touch to book your appointment or ask any questions
        </p>
    </div>

    <div class="contact-wrap">
        <div class="row g-4 align-items-start">

            <!-- LEFT -->
            <div class="col-12 col-lg-6">
                <h2 class="h4 section-title mb-2">Visit Us</h2>
                <p class="muted-on-dark mb-4">
                    We’d love to see you. Use the contact details below or visit our location on the map.
                </p>

                <div class="d-grid gap-3">

                    <!-- Address -->
                    <div class="info-card">
                        <div class="d-flex gap-3 align-items-start">
                            <div class="icon-dot">📍</div>
                            <div>
                                <div class="fw-semibold text-white">Address</div>
                                <div class="small muted-on-dark">
                                    {{ $contact['address'] ?: '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="info-card">
                        <div class="d-flex gap-3 align-items-start">
                            <div class="icon-dot">☎</div>
                            <div>
                                <div class="fw-semibold text-white">Phone</div>
                                <div class="small muted-on-dark">
                                    {{ $contact['phone'] ?: '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="info-card">
                        <div class="d-flex gap-3 align-items-start">
                            <div class="icon-dot">✉</div>
                            <div>
                                <div class="fw-semibold text-white">Email</div>
                                <div class="small muted-on-dark">
                                    {{ $contact['email'] ?: '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Opening Hours -->
                    <div class="info-card">
                        <div class="d-flex gap-3 align-items-start">
                            <div class="icon-dot">🕒</div>
                            <div>
                                <div class="fw-semibold text-white">Opening Hours</div>
                                <div class="small muted-on-dark">
                                    Monday – Friday: 9:00 AM – 8:00 PM<br>
                                    Saturday: 9:00 AM – 6:00 PM<br>
                                    Sunday: 10:00 AM – 5:00 PM
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- RIGHT -->
            <div class="col-12 col-lg-6">
                <div class="map-box">
                    @if (!empty($contact['map_embed']))
                        <div class="ratio ratio-4x3">
                            {!! $contact['map_embed'] !!}
                        </div>
                    @else
                        <div class="map-placeholder">
                            Map not set yet. Admin can add it from Settings.
                        </div>
                    @endif
                </div>

                @if (!empty($contact['salon_name']))
                    <div class="small muted-on-dark mt-2 text-center">
                        {{ $contact['salon_name'] }}
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection
