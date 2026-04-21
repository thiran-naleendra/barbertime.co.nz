@extends('layouts.public', ['title' => 'Home'])

@section('content')
    <style>
        :root {
            --bg: #0b0c10;
            --panel: #111318;
            --muted: #a7b0ba;
            --text: #f5f7fa;
            --line: rgba(255, 255, 255, .12);
            --line2: rgba(255, 255, 255, .08);
            --white: #ffffff;
        }

        /* HERO */
        .hero {
            min-height: 520px;
            border-radius: 18px;
            overflow: hidden;
            background:
                linear-gradient(rgba(0, 0, 0, 0.55),
                    rgba(0, 0, 0, 0.75)),
                url("/images/main.jpg") center / cover no-repeat;
            color: var(--text);
            border: 1px solid var(--line);
            box-shadow: 0 18px 46px rgba(0, 0, 0, .45);
        }

        .hero .btn-primary-custom {
            background: var(--white);
            border-color: var(--white);
            color: #0b0c10;
            border-radius: 999px;
            font-weight: 700;
        }

        .hero .btn-primary-custom:hover {
            background: #e8edf5;
            border-color: #e8edf5;
            color: #0b0c10;
        }

        .btn-outline-custom {
            border: 1px solid rgba(255, 255, 255, .35);
            color: var(--white);
            background: transparent;
            border-radius: 999px;
            font-weight: 700;
        }

        .btn-outline-custom:hover {
            border-color: rgba(255, 255, 255, .55);
            background: rgba(255, 255, 255, .08);
            color: var(--white);
        }

        .section-title {
            font-weight: 900;
            letter-spacing: .2px;
        }

        .section-title-2 {
            font-weight: 900;
            letter-spacing: .2px;
            color: rgb(0, 0, 0);
        }

        /* Dark cards (services cards) */
        .soft-card {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 16px;
            box-shadow: 0 12px 34px rgba(0, 0, 0, .35);
            color: var(--text);
        }

        /* Muted text helpers */
        .muted-on-dark {
            color: rgba(255, 255, 255, .72) !important;
        }

        .muted-on-light {
            color: rgba(0, 0, 0, .60) !important;
        }

        /* About image grid */
        .img-grid {
            column-count: 2;
            /* ✅ masonry */
            column-gap: 12px;
        }

        .img-grid img {
            width: 100%;
            height: auto;
            display: block;
            margin-bottom: 12px;
            object-fit: cover;
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, .06);
            box-shadow: 0 10px 26px rgba(0, 0, 0, .18);
            filter: none;
            transition: transform .18s ease;
            break-inside: avoid;
            /* ✅ prevent breaks */
        }

        .img-grid img:hover {
            transform: translateY(-2px);
        }


        /* Stats */
        .stats-box {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            margin-top: 18px;
        }

        .stat {
            min-width: 150px;
            padding: 14px 16px;
            border: 1px solid rgba(0, 0, 0, .10);
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 10px 26px rgba(0, 0, 0, .10);
        }

        .stat .num {
            font-size: 22px;
            font-weight: 900;
            letter-spacing: .2px;
            color: #0b0c10;
        }

        .stat .lbl {
            font-size: 12px;
            color: rgba(0, 0, 0, .60);
        }

        /* CTA (BLACK background + WHITE text) */
        .cta {
            border-radius: 18px;
            background: #0b0c10;
            border: 1px solid rgba(255, 255, 255, .12);
            color: #fff;
            box-shadow: 0 18px 46px rgba(0, 0, 0, .45);
        }

        .cta .section-title,
        .cta h2,
        .cta p {
            color: #fff !important;
        }

        .cta p {
            opacity: .75;
        }

        .cta .btn {
            background: #fff;
            border-color: #fff;
            color: #0b0c10;
            border-radius: 999px;
            font-weight: 800;
            padding: 10px 22px;
        }

        .cta .btn:hover {
            background: #e8edf5;
            border-color: #e8edf5;
            color: #0b0c10;
        }


        /* ✅ Reviews section UI (matches your style) */
        .review-shell {
            border-radius: 18px;
            border: 1px solid rgba(0, 0, 0, .10);
            background: #fff;
            box-shadow: 0 12px 34px rgba(0, 0, 0, .10);
            overflow: hidden;
        }

        .review-head {
            padding: 18px;
            border-bottom: 1px solid rgba(0, 0, 0, .08);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .review-title {
            font-weight: 900;
            letter-spacing: .2px;
            margin: 0;
        }

        .review-sub {
            margin: 0;
            color: rgba(0, 0, 0, .60);
            font-size: 13px;
        }

        .google-pill {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .g-badge {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, .06);
            font-weight: 900;
            color: #0b0c10;
        }

        .rating-big {
            font-size: 34px;
            font-weight: 900;
            line-height: 1;
            color: #0b0c10;
        }

        .rating-meta {
            font-size: 12px;
            color: rgba(0, 0, 0, .60);
        }

        .rev-card {
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, .10);
            background: #fff;
            box-shadow: 0 10px 22px rgba(0, 0, 0, .08);
            padding: 14px;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .rev-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 6px;
        }

        .rev-name {
            font-weight: 900;
            font-size: 14px;
            line-height: 1.2;
            color: #0b0c10;
        }

        .rev-time {
            font-size: 12px;
            color: rgba(0, 0, 0, .55);
        }

        .rev-stars {
            color: #f59e0b;
            font-size: 14px;
            white-space: nowrap;
        }

        .rev-text {
            font-size: 13px;
            color: rgba(0, 0, 0, .72);
            margin-top: 6px;
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* ✅ carousel controls look nicer on white */
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            filter: invert(1) grayscale(1) brightness(0.2);
        }

        /* ✅ spacing inside carousel */
        .rev-slide-pad {
            padding: 16px;
        }

        /* ✅ Make the "Write a review" button consistent */
        .btn-review {
            border-radius: 999px;
            font-weight: 800;
            padding: 10px 16px;
        }

        /* carosul */
        .review-shell {
            border-radius: 18px;
            border: 1px solid rgba(0, 0, 0, .10);
            background: #fff;
            box-shadow: 0 12px 34px rgba(0, 0, 0, .10);
            overflow: hidden;
        }

        .review-head {
            padding: 18px;
            border-bottom: 1px solid rgba(0, 0, 0, .08);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .g-badge {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, .06);
            font-weight: 900;
            color: #0b0c10;
        }

        .rating-big {
            font-size: 34px;
            font-weight: 900;
            line-height: 1;
            color: #0b0c10;
        }

        .rating-meta {
            font-size: 12px;
            color: rgba(0, 0, 0, .60);
        }

        .rev-card {
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, .10);
            background: #fff;
            box-shadow: 0 10px 22px rgba(0, 0, 0, .08);
            padding: 14px;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .rev-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 6px;
        }

        .rev-name {
            font-weight: 900;
            font-size: 14px;
            line-height: 1.2;
            color: #0b0c10;
        }

        .rev-time {
            font-size: 12px;
            color: rgba(0, 0, 0, .55);
        }

        .rev-stars {
            color: #f59e0b;
            font-size: 14px;
            white-space: nowrap;
        }

        .rev-text {
            font-size: 13px;
            color: rgba(0, 0, 0, .72);
            margin-top: 6px;
        }

        .btn-review {
            border-radius: 999px;
            font-weight: 800;
            padding: 10px 16px;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            filter: invert(1) grayscale(1) brightness(0.2);
        }

        .hero-logo {
            width: 60%;
            max-width: 420px;
            /* 👈 control desktop size */
            height: auto;

        }

        /* ✅ AJ / Owner section */
        .owner-card {
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, .10);
            background: #fff;
            box-shadow: 0 12px 34px rgba(0, 0, 0, .10);
        }

        .owner-img {
            width: 100%;
            height: 100%;
            min-height: 320px;
            object-fit: cover;
            display: block;
        }

        .owner-pad {
            padding: 22px;
        }

        .owner-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border-radius: 999px;
            padding: 8px 12px;
            background: rgba(0, 0, 0, .06);
            color: #0b0c10;
            font-weight: 800;
            font-size: 12px;
            margin-bottom: 10px;
        }

        @media (max-width: 576px) {
            .owner-pad {
                padding: 18px;
            }

            .owner-img {
                min-height: 260px;
            }
        }


        /* Large screens */
        @media (min-width: 992px) {
            .hero-logo {
                max-width: 400px;
                /* 👈 BIG logo on desktop */
            }
        }

        /* Extra large screens */
        @media (min-width: 1400px) {
            .hero-logo {
                max-width: 620px;
            }
        }
    </style>

    <!-- HERO -->
    <div class="hero d-flex align-items-center mb-5">
        <div class="container py-5">
            <div class="row align-items-center">

                {{-- LEFT : TEXT --}}
                <div class="col-12 col-lg-7 text-center text-lg-start mb-4 mb-lg-0">
                    <h1 class="display-5 fw-bold mb-3">
                        Barbertime.nz
                    </h1>

                    {{-- <p class="lead muted-on-dark mb-4">
                    Experience luxury hair and beauty services in a relaxing atmosphere.
                </p> --}}

                    <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-lg-start">
                        <a href="{{ route('book') }}" class="btn btn-primary-custom btn-lg px-4">
                            Book Appointment →
                        </a>
                        <a href="{{ route('services') }}" class="btn btn-outline-custom btn-lg px-4">
                            View Services
                        </a>
                    </div>
                </div>

                {{-- RIGHT : LOGO --}}
                <div class="col-12 col-lg-5 text-center text-lg-end">
                    <img src="{{ asset('images/logo.png') }}" alt="Barbertime.nz Logo" class="hero-logo">
                </div>


            </div>
        </div>
    </div>


    <!-- OUR SERVICES -->
    <div class="container mb-5">
        <div class="text-center mb-4">
            <h2 class="section-title-2">Our Services</h2>
            <p class="muted-on-light mb-0">
                Discover our range of professional beauty and wellness services
            </p>
        </div>

        <div class="row g-3 justify-content-center">
            <div class="col-12 col-md-4">
                <div class="soft-card p-4 h-100">
                    <div class="fw-semibold mb-2">Men’s Haircut</div>
                    <div class="small muted-on-dark">
                        Expert cuts, coloring, and styling for all hair types.
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="soft-card p-4 h-100">
                    <div class="fw-semibold mb-2">Children’s Haircut</div>
                    <div class="small muted-on-dark">
                        Rejuvenating treatments for glowing, healthy skin.
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="soft-card p-4 h-100">
                    <div class="fw-semibold mb-2">Eyebrow Threading</div>
                    <div class="small muted-on-dark">
                        Precise eyebrow shaping using threading for a clean, sharp look.
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('services') }}" class="btn btn-outline-dark rounded-pill px-4">
                View All Services →
            </a>
        </div>
    </div>

    <!-- ✅ OWNER / AJ SECTION -->
    <div class="container mb-5">
        <div class="owner-card">
            <div class="row g-0 align-items-stretch">
                {{-- IMAGE --}}
                <div class="col-12 col-lg-5">
                    {{-- ✅ change image path to your real image --}}
                    <img src="{{ asset('images/1000017120.webp') }}" alt="AJ - Founder of Barbertimenz" class="owner-img">
                </div>

                {{-- TEXT --}}
                <div class="col-12 col-lg-7">
                    <div class="owner-pad">
                        <div class="owner-badge">Founder • Barber • Barbertimenz</div>

                        <h2 class="section-title-2 mb-2">Meet AJ</h2>

                        <p class="muted-on-light">
                            With over 8 years of hands-on experience in the barbering industry, AJ is a skilled professional
                            dedicated to delivering precision cuts and exceptional grooming services.
                        </p>

                        <p class="muted-on-light">
                            As the founder and owner of Barbertimenz, AJ has built a reputation for quality, consistency,
                            and
                            attention to detail. His passion for barbering goes beyond haircuts — it’s about creating
                            confidence,
                            style, and a personalized experience for every client who walks through the door.
                        </p>

                        <p class="muted-on-light mb-3">
                            Through Barbertimenz, AJ continues to set high standards in modern barbering while maintaining a
                            welcoming
                            and professional atmosphere.
                        </p>

                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('book') }}" class="btn btn-outline-dark rounded-pill px-4">
                                Book with AJ →
                            </a>
                            <a href="{{ route('services') }}" class="btn btn-outline-dark rounded-pill px-4">
                                View Services →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- GOOGLE REVIEWS (CAROUSEL) -->
    @php
        $googleReviewLink = 'https://maps.app.goo.gl/12Av8cUeRdkdLYeH6';

        $reviews = [
            [
                'name' => 'Gimsara Kulathunga',
                'time' => '5 days ago',
                'stars' => 5,
                'text' =>
                    'Really happy with the service. The barber was skilled, took time to understand what I wanted, and delivered a great haircut. Clean shop and good atmosphere. Will definitely come back.',
            ],
            [
                'name' => 'Edward',
                'time' => 'a month ago',
                'stars' => 5,
                'text' =>
                    'Visiting from London and needed a good trim. AJ did a clean and professional job on my beard for a great price. Will be coming back next time!',
            ],
            [
                'name' => 'J Squad',
                'time' => 'a month ago',
                'stars' => 5,
                'text' =>
                    'Man what a place to get a cut 🔥🔥🔥 The boys kept it professional and clean. Came here before a wedding and grateful we did!',
            ],
            [
                'name' => 'James Owens',
                'time' => '2 months ago',
                'stars' => 5,
                'text' =>
                    'Awesome haircut and even better service. AJ truly cares and looks after clients. Go get a skin fade and change your barber permanently.',
            ],
            [
                'name' => 'THA DIAMOND',
                'time' => '2 months ago',
                'stars' => 5,
                'text' =>
                    'I just walk pass this places and got a haircut today. The barber was quite friendly and he did a good job.',
            ],
            [
                'name' => 'Mathew Roberts',
                'time' => '2 months ago',
                'stars' => 5,
                'text' =>
                    'Fantastic haircut by Ajay today. Great to hear about his vision for the new shop and a really skilled barber. I will be back',
            ],
        ];

        // desktop: chunk to 3 cards per slide
        $desktopChunks = array_chunk($reviews, 3);
    @endphp



    <div class="container mb-5">
        <div class="text-center mb-4">
            <h3 class="section-title-2">Google Reviews</h3>
            <p class="muted-on-light mb-0">What our customers say about Barbertime.nz</p>
        </div>

        <div class="review-shell">
            <div class="review-head">
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div class="d-flex align-items-center gap-2">
                        <div class="g-badge">G</div>
                        <div>
                            <div style="font-weight:900; color: black;">Google Rating</div>
                            <div class="small text-muted">Based on customer reviews</div>
                        </div>
                    </div>

                    <div class="ms-0 ms-md-3">
                        <div class="rating-big">5.0</div>
                        <div class="rev-stars">★★★★★</div>
                        <div class="rating-meta">23 reviews</div>
                    </div>
                </div>

                <a href="{{ $googleReviewLink }}" target="_blank" rel="noopener" class="btn btn-outline-dark btn-review">
                    Write a review
                </a>
            </div>

            {{-- ✅ MOBILE CAROUSEL (1 per slide) --}}
            <div class="d-md-none">
                <div id="googleReviewsMobile" class="carousel slide" data-bs-ride="carousel" data-bs-touch="true">
                    <div class="carousel-indicators">
                        @foreach ($reviews as $i => $r)
                            <button type="button" data-bs-target="#googleReviewsMobile"
                                data-bs-slide-to="{{ $i }}" class="{{ $i === 0 ? 'active' : '' }}"
                                aria-current="{{ $i === 0 ? 'true' : 'false' }}"
                                aria-label="Slide {{ $i + 1 }}"></button>
                        @endforeach
                    </div>

                    <div class="carousel-inner p-3">
                        @foreach ($reviews as $i => $r)
                            <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                                <div class="rev-card">
                                    <div class="rev-top">
                                        <div>
                                            <div class="rev-name">{{ $r['name'] }}</div>
                                            <div class="rev-time">{{ $r['time'] }}</div>
                                        </div>
                                        <div class="rev-stars">{{ str_repeat('★', (int) $r['stars']) }}</div>
                                    </div>
                                    <div class="rev-text">{{ $r['text'] }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- <button class="carousel-control-prev" type="button" data-bs-target="#googleReviewsMobile"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#googleReviewsMobile"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button> --}}
                </div>
            </div>

            {{-- ✅ DESKTOP CAROUSEL (3 per slide, responsive columns) --}}
            <div class="d-none d-md-block">
                <div id="googleReviewsDesktop" class="carousel slide" data-bs-ride="carousel" data-bs-touch="true">
                    <div class="carousel-indicators">
                        @foreach ($desktopChunks as $i => $c)
                            <button type="button" data-bs-target="#googleReviewsDesktop"
                                data-bs-slide-to="{{ $i }}" class="{{ $i === 0 ? 'active' : '' }}"
                                aria-current="{{ $i === 0 ? 'true' : 'false' }}"
                                aria-label="Slide {{ $i + 1 }}"></button>
                        @endforeach
                    </div>

                    <div class="carousel-inner p-3">
                        @foreach ($desktopChunks as $i => $chunk)
                            <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                                <div class="row g-3">
                                    @foreach ($chunk as $r)
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="rev-card">
                                                <div class="rev-top">
                                                    <div>
                                                        <div class="rev-name">{{ $r['name'] }}</div>
                                                        <div class="rev-time">{{ $r['time'] }}</div>
                                                    </div>
                                                    <div class="rev-stars">{{ str_repeat('★', (int) $r['stars']) }}</div>
                                                </div>
                                                <div class="rev-text">{{ $r['text'] }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- <button class="carousel-control-prev" type="button" data-bs-target="#googleReviewsDesktop"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#googleReviewsDesktop"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button> --}}
                </div>
            </div>

            {{-- <div class="px-3 py-3 border-top d-flex flex-column flex-md-row justify-content-between gap-2">
                <div class="small text-muted">Want to see more? Open Google Maps.</div>
                <a href="{{ $googleReviewLink }}" target="_blank" rel="noopener" class="small text-decoration-none">
                    Open in Google Maps →
                </a>
            </div> --}}
        </div>
    </div>




    <!-- ABOUT / WELCOME -->
    <div class="container mb-5">
        <div class="row g-4 align-items-center">
            <div class="col-12 col-lg-6">
                <h2 class="section-title-2">Welcome to Barbertime.nz</h2>
                <p class="muted-on-light">
                    With over 8 years of experience, we are dedicated to providing exceptional beauty services
                    in a warm and inviting atmosphere. Our team stays current with the latest trends and techniques
                    to ensure you receive the best care possible.
                </p>

                <p class="muted-on-light mb-0">
                    Whether you're looking for a fresh new look or just need some pampering,
                    we're here to help you look and feel your best.
                </p>

                <div class="stats-box">
                    <div class="stat">
                        <div class="num">8+</div>
                        <div class="lbl">Years Experience</div>
                    </div>
                    <div class="stat">
                        <div class="num">5000+</div>
                        <div class="lbl">Happy Clients</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="img-grid">
                    <img src="{{ asset('images/1000015932.jpg') }}" alt="Salon">
                    <img src="{{ asset('images/1000013406.jpg') }}" alt="Salon">
                    <img src="{{ asset('images/1000015933.jpg') }}" alt="Salon">

                    <img src="{{ asset('images/1000015935.jpg') }}" alt="Salon">


                </div>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div class="container mb-5">
        <div class="cta p-4 p-md-5 text-center">
            <h2 class="section-title mb-2">Ready for a New Look?</h2>
            <p class="mb-4">
                Book your appointment today and let our experts transform your style.
            </p>
            <a href="{{ route('book') }}" class="btn btn-lg px-4">
                Book Now →
            </a>
        </div>
    </div>
@endsection
