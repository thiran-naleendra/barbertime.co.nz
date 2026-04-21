@extends('layouts.public', ['title' => 'Services'])

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

    .service-wrap {
        max-width: 1100px;
        margin: 0 auto;
    }

    /* CARD */
    .svc-card {
        background: var(--panel);
        border: 1px solid var(--line);
        border-radius: 18px;
        box-shadow: 0 12px 34px rgba(0, 0, 0, .35);
        padding: 18px;
        height: 100%;
        transition: transform .15s ease, border-color .15s ease, box-shadow .15s ease;
        display: flex;
        flex-direction: column;
    }

    .svc-card:hover {
        transform: translateY(-2px);
        border-color: rgba(255, 255, 255, .18);
        box-shadow: 0 16px 44px rgba(0, 0, 0, .45);
    }

    /* IMAGE */
    .svc-image {
        width: 100%;
        height: 180px;
        border-radius: 14px;
        object-fit: cover;
        margin-bottom: 14px;
        border: 1px solid var(--line2);
        background: #0b0c10;
    }

    .svc-top {
        display: flex;
        justify-content: space-between;
        gap: 14px;
        align-items: flex-start;
    }

    .svc-name {
        font-weight: 900;
        color: #fff;
        font-size: 16px;
        line-height: 1.2;
    }

    .svc-meta {
        margin-top: 6px;
        font-size: 12px;
        color: var(--muted);
    }

    .svc-price {
        text-align: right;
        white-space: nowrap;
    }

    .svc-price .amount {
        font-weight: 900;
        color: #fff;
        font-size: 16px;
        line-height: 1.2;
    }

    .svc-price .cur {
        font-size: 11px;
        color: var(--muted);
        margin-top: 2px;
    }

    .svc-desc {
        margin-top: 12px;
        font-size: 13px;
        color: var(--muted);
        line-height: 1.45;
        flex-grow: 1;
    }

    .svc-actions {
        margin-top: 14px;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-cta {
        background: var(--white);
        border-color: var(--white);
        color: #0b0c10;
        border-radius: 999px;
        padding: 8px 16px;
        font-weight: 800;
    }

    .btn-ghost {
        background: transparent;
        border: 1px solid var(--line);
        color: var(--text);
        border-radius: 999px;
        padding: 8px 16px;
        font-weight: 700;
    }
</style>

<!-- HERO -->
<div class="page-hero p-4 p-md-5 mb-5 text-center">
    <h1 class="display-6 mb-2" style="color:black;font-weight:900;">Our Services</h1>
    <p class="mb-0" style="color:black;">Choose a service and book your appointment online.</p>
</div>

<div class="service-wrap">
    <div class="row g-4">

        @forelse($services as $service)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="svc-card">

                    {{-- ✅ SERVICE IMAGE --}}
                    @if($service->image_path)
                        <img
                            src="{{ Storage::url($service->image_path) }}"
                            alt="{{ $service->name }}"
                            class="svc-image">
                    @else
                        <img
                            src="{{ asset('images/service-placeholder.jpg') }}"
                            alt="Service image"
                            class="svc-image">
                    @endif

                    <div class="svc-top">
                        <div>
                            <div class="svc-name">{{ $service->name }}</div>
                            @if($service->duration_minutes)
                                <div class="svc-meta">
                                    Duration: {{ $service->duration_minutes }} min
                                </div>
                            @endif
                        </div>

                        <div class="svc-price">
                            @if ((float)$service->price > 0)
                                <div class="amount">${{ number_format((float)$service->price, 2) }}</div>
                                <div class="cur">NZD</div>
                            @else
                                <div class="amount">To be confirmed at salon</div>
                            @endif
                        </div>
                    </div>

                    <div class="svc-desc">
                        {{ $service->description
                            ? \Illuminate\Support\Str::limit($service->description, 160)
                            : 'Professional service offered at our salon.' }}
                    </div>

                    <div class="svc-actions">
                        <a href="{{ route('book') }}" class="btn btn-cta">Book Now →</a>
                        <a href="{{ route('contact') }}" class="btn btn-ghost">Ask a Question</a>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info mb-0">No services available right now.</div>
            </div>
        @endforelse

    </div>
</div>
@endsection
