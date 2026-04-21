@extends('layouts.public', ['title' => 'Gallery'])

@section('content')

<style>
  :root{
      --bg:#0b0c10;
      --panel:#111318;
      --text:#f5f7fa;
      --muted:rgba(255,255,255,.72);
      --line:rgba(255,255,255,.12);
      --line2:rgba(255,255,255,.08);
      --white:#ffffff;
  }

  .section-title{
      font-weight: 900;
      letter-spacing: .2px;
      color: var(--text);
  }
  .muted-on-dark{ color: var(--muted) !important; }

  /* HERO */
  .page-hero{
      border-radius: 18px;
      border: 1px solid var(--line);
      background:
        radial-gradient(1000px 380px at 20% 0%, rgba(255,255,255,.10), transparent 60%),
        radial-gradient(700px 260px at 90% 30%, rgba(255,255,255,.07), transparent 60%),
        linear-gradient(180deg, rgba(255,255,255,.06), rgba(255,255,255,.02));
      box-shadow: 0 18px 46px rgba(0,0,0,.45);
      color: var(--text);
  }

  /* GRID WRAP */
  .gallery-wrap{
      max-width: 1100px;
      margin: 0 auto;
  }

  /* CARD */
  .gallery-card{
      border: 1px solid var(--line);
      border-radius: 18px;
      overflow: hidden;
      background: var(--panel);
      box-shadow: 0 12px 34px rgba(0,0,0,.35);
      transition: transform .18s ease, border-color .18s ease, box-shadow .18s ease;
  }
  .gallery-card:hover{
      transform: translateY(-2px);
      border-color: rgba(255,255,255,.18);
      box-shadow: 0 16px 44px rgba(0,0,0,.45);
  }

  .gallery-img{
      width: 100%;
      height: 180px;
      object-fit: cover;
      display:block;
      transition: transform .25s ease;
      background: rgba(255,255,255,.04);
  }
  .gallery-card:hover .gallery-img{
      transform: scale(1.03);
  }

  @media (min-width: 768px) { .gallery-img{ height: 190px; } }
  @media (min-width: 992px) { .gallery-img{ height: 200px; } }

  /* CTA (BLACK background, WHITE text) */
  .cta{
      border-radius: 18px;
      background: #0b0c10;
      border: 1px solid var(--line);
      color: #fff;
      box-shadow: 0 18px 46px rgba(0,0,0,.45);
  }
  .cta h2, .cta p{ color:#fff !important; }
  .cta p{ opacity:.75; }

  /* BUTTON BW */
  .btn-cta{
      background: var(--white);
      border-color: var(--white);
      color: #0b0c10;
      border-radius: 999px;
      padding: 10px 22px;
      font-weight: 800;
  }
  .btn-cta:hover{
      background: #e8edf5;
      border-color: #e8edf5;
      color: #0b0c10;
  }

  /* Alerts */
  .alert-info{
      background: rgba(255,255,255,.06);
      border: 1px solid var(--line);
      color: var(--text);
  }
</style>

<!-- HERO -->
<div class="page-hero p-4 p-md-5 mb-5 text-center">
    <h1 class="display-6  mb-2" style="color: black; font-weight: 900;
      letter-spacing: .2px;">Our Gallery</h1>
    <p class=" mb-0" style="color: black;">
        Explore our portfolio of stunning transformations and beauty creations
    </p>
</div>

<!-- GALLERY GRID -->
<div class="gallery-wrap">
    <div class="row g-3 g-md-4 justify-content-center">
        @forelse($images as $img)
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ asset('storage/'.$img->image_path) }}"
                   target="_blank"
                   class="text-decoration-none">

                    <div class="gallery-card">
                        <img class="gallery-img"
                             src="{{ asset('storage/'.$img->image_path) }}"
                             alt="{{ $img->title ?? 'Gallery Image' }}">
                    </div>

                    @if($img->title)
                        <div class="small mt-2 text-center" style="color: black; font-weight: 500;">
                            {{ $img->title }}
                        </div>
                    @endif
                </a>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info mb-0">No photos yet.</div>
            </div>
        @endforelse
    </div>
</div>

<!-- CTA -->
<div class="container my-5">
    <div class="cta p-4 p-md-5 text-center">
        <h2 class="h4 section-title mb-2">Ready to Transform Your Look?</h2>
        <p class="mb-4">
            Book an appointment and let our talented team create your perfect style
        </p>
        <a href="{{ route('book') }}" class="btn btn-cta">
            Book Appointment →
        </a>
    </div>
</div>

@endsection
