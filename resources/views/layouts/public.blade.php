<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    <!-- Android / PWA -->
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --bg: #ffffff;
            --card: #111318;
            --muted: #9aa3ad;
            --text: #f5f7fa;
            --line: rgba(255, 255, 255, .10);
            --accent: #ffffff;
        }

        body {
            background: #ffffff;
            color: var(--text);
        }

        .bw-wrap {
            max-width: 1100px;
            margin: 0 auto;
        }

        /* NAVBAR */
        .bw-nav {
            background: rgba(11, 12, 16, .92);
            border-bottom: 1px solid var(--line);
            backdrop-filter: blur(8px);
        }

        .bw-brand {
            font-weight: 900;
            letter-spacing: .2px;
            color: #fff !important;
        }

        .bw-nav .nav-link {
            color: rgba(255, 255, 255, .80) !important;
            font-weight: 600;
            padding: .65rem .85rem;
            border-radius: 12px;
        }

        .bw-nav .nav-link:hover {
            color: #fff !important;
            background: rgba(255, 255, 255, .06);
        }

        .bw-nav .nav-link.active {
            color: #0b0c10 !important;
            background: #fff;
            font-weight: 800;
        }

        /* Mobile collapse panel */
        .bw-collapse {
            background: rgba(17, 19, 24, .96);
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 10px;
            margin-top: 10px;
        }

        /* Toggler */
        .navbar-toggler {
            border: 1px solid rgba(255, 255, 255, .25) !important;
            border-radius: 12px;
            padding: .45rem .6rem;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        /* ✅ Make Book button full width on mobile */
        .btn-book {
            background: #fff;
            border-color: #fff;
            color: #0b0c10;
            border-radius: 999px;
            font-weight: 800;
            padding: 10px 16px;
            width: 100%;
            text-align: center;
        }

        .btn-book:hover {
            background: #e9eef5;
            border-color: #e9eef5;
            color: #0b0c10;
        }

        @media (min-width: 992px) {
            .btn-book {
                width: auto;
                padding: 8px 16px;
            }

            .bw-collapse {
                background: transparent;
                border: 0;
                padding: 0;
                margin-top: 0;
            }
        }

        /* Footer */
        .bw-footer {
            border-top: 1px solid var(--line);
            background: rgba(11, 12, 16, .92);
            color: rgba(255, 255, 255, .70);
        }

        /* ✅ NEW: Social links */
        .bw-footer a {
            color: rgba(255, 255, 255, .85);
            text-decoration: none;
        }

        .bw-footer a:hover {
            color: #fff;
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, .22);
            transition: transform .18s ease, background .18s ease, border-color .18s ease;
        }

        .social-links a:hover {
            background: rgba(255, 255, 255, .10);
            border-color: rgba(255, 255, 255, .35);
            transform: translateY(-2px);
        }

        .footer-inner {
            gap: 12px;
        }

        @media (max-width: 767.98px) {
            .footer-inner {
                flex-direction: column;
                text-align: center;
            }

            .social-links {
                justify-content: center !important;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg bw-nav sticky-top">
        <div class="container">
            <a class="navbar-brand bw-brand" href="{{ route('home') }}">
                {{ config('app.name', 'Salon') }}
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarPublic"
                aria-controls="navbarPublic" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon" style="filter: invert(1) grayscale(1) brightness(2);"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarPublic">
                <div class="bw-collapse ms-lg-auto">
                    <ul class="navbar-nav ms-lg-auto mb-2 mb-lg-0 align-items-lg-center gap-lg-1">

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('services') ? 'active' : '' }}"
                                href="{{ route('services') }}">Services</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('products') ? 'active' : '' }}"
                                href="{{ route('products') }}">Products</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('gallery') ? 'active' : '' }}"
                                href="{{ route('gallery') }}">Gallery</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"
                                href="{{ route('contact') }}">Contact</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}"
                                href="{{ route('login') }}">Login</a>
                        </li>

                        <li class="nav-item mt-2 mt-lg-0 ms-lg-2">
                            <a class="btn btn-book" href="{{ route('book') }}">Book Now →</a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        @yield('content')
    </main>

    <!-- ✅ UPDATED FOOTER -->
    <footer class="bw-footer">
        <div class="container py-3 small">
            <div class="footer-inner d-flex align-items-center justify-content-between flex-wrap">

                <div>
                    © {{ date('Y') }} {{ config('app.name', 'Salon') }}. All rights reserved.
                </div>

                <div class="d-flex align-items-center gap-3 justify-content-end social-links">

                    <!-- Instagram -->
                    <a href="https://www.instagram.com/barbertime.nz?igsh=MWpkaGE2YmMwazBqdg==" target="_blank"
                        rel="noopener" aria-label="Instagram">
                        <svg width="18" height="18" viewBox="0 0 16 16" fill="currentColor">
                            <path
                                d="M8 0C5.829 0 5.556.01 4.703.048 3.85.087 3.252.222 2.733.414a4.92 4.92 0 0 0-1.778 1.034A4.92 4.92 0 0 0 .92 3.226c-.192.52-.327 1.118-.366 1.971C.516 6.051.507 6.324.507 8.495s.01 2.444.048 3.297c.039.853.174 1.451.366 1.971.206.56.476 1.033.92 1.478a4.92 4.92 0 0 0 1.478.92c.52.192 1.118.327 1.971.366.853.038 1.126.048 3.297.048s2.444-.01 3.297-.048c.853-.039 1.451-.174 1.971-.366a4.92 4.92 0 0 0 1.478-.92 4.92 4.92 0 0 0 .92-1.478c.192-.52.327-1.118.366-1.971.038-.853.048-1.126.048-3.297s-.01-2.444-.048-3.297c-.039-.853-.174-1.451-.366-1.971a4.92 4.92 0 0 0-.92-1.478A4.92 4.92 0 0 0 13.267.414c-.52-.192-1.118-.327-1.971-.366C10.443.01 10.17 0 8 0Zm0 3.892A4.108 4.108 0 1 1 3.892 8 4.103 4.103 0 0 1 8 3.892Zm4.271-.46a.96.96 0 1 1-.96.96.96.96 0 0 1 .96-.96Z" />
                        </svg>
                    </a>

                    <!-- TikTok -->
                    <a href="https://www.tiktok.com/@barbertime.nz?_r=1&_t=ZS-938z5buTEo9" target="_blank"
                        rel="noopener" aria-label="TikTok">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M12.667 0h3.09c.116 1.005.572 1.956 1.308 2.734.736.777 1.67 1.289 2.676 1.472v3.11c-1.67-.055-3.296-.5-4.694-1.286v6.145c0 3.086-2.504 5.59-5.59 5.59S3.867 15.26 3.867 12.175c0-3.086 2.504-5.59 5.59-5.59.214 0 .427.012.64.036v3.212a2.378 2.378 0 1 0 1.27 2.342V0Z" />
                        </svg>
                    </a>

                    <span class="d-none d-md-inline" style="opacity:.75;">WebX Tech Solutions</span>
                </div>

                <div class="d-md-none" style="opacity:.75;">WebX Tech Solutions</div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
