@extends('layouts.public', ['title' => 'Products'])

@section('content')
    <style>
        :root {
            --bg: #0b0c10;
            --panel: #000000;
            --text: #000000;
            --muted: rgba(255, 255, 255, 0.72);
            --line: rgba(255, 255, 255, .12);
            --line2: rgba(255, 255, 255, .08);
            --white: #ffffff;
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

        .section-title {
            font-weight: 900;
            letter-spacing: .2px;
            color: var(--text);
        }

        .muted-on-dark {
            color: var(--muted) !important;
        }

        /* PRODUCT CARD */
        .product-card {
            position: relative;
            border-radius: 18px;
            overflow: hidden;
            background: #000;
            box-shadow: 0 12px 34px rgba(0, 0, 0, .35);
        }

        .product-img {
            width: 100%;
            height: 320px;
            object-fit: cover;
            display: block;
        }

        /* Overlay */
        .product-overlay {
            position: absolute;
            inset: auto 0 0 0;
            padding: 16px;
            background: linear-gradient(to top,
                    rgba(0, 0, 0, .85),
                    rgba(0, 0, 0, .45),
                    rgba(0, 0, 0, 0));
        }

        .product-title {
            color: #000000;
            font-weight: 800;
            font-size: 16px;
            margin-bottom: 4px;
        }

        .product-desc {
            font-size: 13px;
            color: rgba(0, 0, 0, 0.75);
            margin-bottom: 6px;
        }

        .product-price {
            font-size: 18px;
            font-weight: 900;
            color: #fff;
        }


        /* Buttons BW */
        .btn-add {
            background: var(--white);
            border-color: var(--white);
            color: #0b0c10;
            border-radius: 999px;
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 800;
        }

        .btn-add:hover {
            background: #e8edf5;
            border-color: #e8edf5;
            color: #0b0c10;
        }

        /* WHY BOX */
        .why-box {
            border-radius: 18px;
            background: var(--panel);
            border: 1px solid var(--line);
            box-shadow: 0 18px 46px rgba(0, 0, 0, .45);
            color: var(--text);
        }

        .cat-icon {
            width: 42px;
            height: 42px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, .06);
            border: 1px solid var(--line2);
            color: #fff;
            font-weight: 900;
            flex: 0 0 auto;
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
        <h1 class="display-6 section-title mb-2">Premium Products</h1>
        <p class=" mb-0">
            Discover our curated collection of professional-grade beauty products for your daily routine
        </p>
    </div>

    <!-- PRODUCTS GRID -->
    <div class="row g-4 justify-content-center">
        @forelse($products as $product)
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="product-card">

                    @if ($product->image_path)
                        <img class="product-img" src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}">
                    @else
                        <div class="product-img d-flex align-items-center justify-content-center text-white">
                            No image
                        </div>
                    @endif

                    <!-- Overlay -->
                    <div class="product-overlay">
                        <div class="product-title">{{ $product->name }}</div>

                        @if ($product->description)
                            <div class="product-desc">
                                {{ \Illuminate\Support\Str::limit($product->description, 40) }}
                            </div>
                        @endif

                        {{-- <div class="product-price">
                            ${{ number_format((float) $product->price, 2) }}
                        </div> --}}
                    </div>

                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info mb-0">No products available right now.</div>
            </div>
        @endforelse
    </div>


    <!-- WHY OUR PRODUCTS -->
    <div class="my-5 d-flex justify-content-center">
        <div class="why-box p-4 p-md-5" style="max-width: 900px; width: 100%;">
            <h3 class="h4  text-center mb-4" style="color: white; font-weight: 900;
      letter-spacing: .2px;">Why Our
                Products?</h3>

            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <div class="d-flex gap-3">
                        <div class="cat-icon">★</div>
                        <div>
                            <div class="fw-semibold text-white">Professional Grade</div>
                            <div class="small muted-on-dark">Same products used by our salon experts.</div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="d-flex gap-3">
                        <div class="cat-icon">✓</div>
                        <div>
                            <div class="fw-semibold text-white">Natural Ingredients</div>
                            <div class="small muted-on-dark">High-quality, ethically sourced ingredients.</div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="d-flex gap-3">
                        <div class="cat-icon">❤</div>
                        <div>
                            <div class="fw-semibold text-white">Cruelty-Free</div>
                            <div class="small muted-on-dark">Never tested on animals, safe and ethical.</div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="d-flex gap-3">
                        <div class="cat-icon">✦</div>
                        <div>
                            <div class="fw-semibold text-white">Expert Recommendations</div>
                            <div class="small muted-on-dark">Curated selection recommended by our team.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('book') }}" class="btn btn-add btn-lg px-4">Book Appointment →</a>
            </div>
        </div>
    </div>
@endsection
