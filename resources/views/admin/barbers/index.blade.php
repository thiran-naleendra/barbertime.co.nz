@extends('layouts.admin')

@section('content')
<style>
  /* ===== Barber List (Admin) ===== */
  .barbers-title {
    font-weight: 800;
    letter-spacing: .2px;
  }

  .barbers-card {
    background: #fff;
    border: 1px solid rgba(0,0,0,.08);
    border-radius: 14px;
    overflow: hidden;
  }

  .barber-avatar {
    width: 54px;
    height: 54px;
    border-radius: 12px;
    object-fit: cover;
    border: 1px solid rgba(0,0,0,.10);
    background: #f3f4f6;
  }

  .badge-soft {
    font-weight: 700;
    border-radius: 999px;
    padding: .35rem .65rem;
  }
  .badge-soft-success {
    background: rgba(25,135,84,.12);
    color: #198754;
    border: 1px solid rgba(25,135,84,.22);
  }
  .badge-soft-danger {
    background: rgba(220,53,69,.12);
    color: #dc3545;
    border: 1px solid rgba(220,53,69,.22);
  }

  /* Mobile cards (hide table, show cards) */
  .barbers-mobile { display: none; }

  @media (max-width: 576px) {
    .barbers-table { display: none; }
    .barbers-mobile { display: block; }

    .barber-mobile-item {
      background: #fff;
      border: 1px solid rgba(0,0,0,.08);
      border-radius: 14px;
      padding: 14px;
      margin-bottom: 12px;
    }

    .barber-mobile-top {
      display: flex;
      gap: 12px;
      align-items: center;
    }

    .barber-mobile-name {
      font-weight: 800;
      font-size: 1.05rem;
      margin: 0;
      line-height: 1.2;
    }

    .barber-mobile-meta {
      font-size: .9rem;
      color: rgba(0,0,0,.65);
      margin-top: 4px;
    }

    .barber-mobile-actions .btn {
      width: 100%;
    }
  }
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="barbers-title mb-0">Barbers</h3>
  <a href="{{ route('admin.barbers.create') }}" class="btn btn-primary">
    Add Barber
  </a>
</div>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- ===== Desktop / Tablet Table ===== --}}
<div class="barbers-table barbers-card">
  <div class="table-responsive">
    <table class="table table-bordered align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th style="width:90px;">Image</th>
          <th>Name</th>
          <th style="width:120px;">Active</th>
          <th style="width:90px;">Sort</th>
          <th style="width:190px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($barbers as $barber)
          <tr>
            <td>
              @if($barber->image_url)
                <img src="{{ $barber->image_url }}" class="barber-avatar" alt="{{ $barber->name }}">
              @else
                <div class="barber-avatar d-flex align-items-center justify-content-center">
                  <span class="text-muted fw-bold">N/A</span>
                </div>
              @endif
            </td>

            <td class="fw-semibold">{{ $barber->name }}</td>

            <td>
              @if($barber->is_active)
                <span class="badge badge-soft badge-soft-success">Active</span>
              @else
                <span class="badge badge-soft badge-soft-danger">Inactive</span>
              @endif
            </td>

            <td>{{ $barber->sort_order }}</td>

            <td>
              <div class="d-flex gap-2">
                <a class="btn btn-sm btn-warning" href="{{ route('admin.barbers.edit', $barber) }}">Edit</a>

                <form method="POST" action="{{ route('admin.barbers.destroy', $barber) }}"
                      onsubmit="return confirm('Delete this barber?')">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-danger">Delete</button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center py-4 text-muted">No barbers found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- ===== Mobile Card View ===== --}}
<div class="barbers-mobile mt-3">
  @forelse($barbers as $barber)
    <div class="barber-mobile-item">
      <div class="barber-mobile-top">
        @if($barber->image_url)
          <img src="{{ $barber->image_url }}" class="barber-avatar" alt="{{ $barber->name }}">
        @else
          <div class="barber-avatar d-flex align-items-center justify-content-center">
            <span class="text-muted fw-bold">N/A</span>
          </div>
        @endif

        <div class="flex-grow-1">
          <p class="barber-mobile-name">{{ $barber->name }}</p>
          <div class="barber-mobile-meta">
            Status:
            @if($barber->is_active)
              <span class="badge badge-soft badge-soft-success">Active</span>
            @else
              <span class="badge badge-soft badge-soft-danger">Inactive</span>
            @endif
            <span class="ms-2">Sort: <strong>{{ $barber->sort_order }}</strong></span>
          </div>
        </div>
      </div>

      <div class="barber-mobile-actions mt-3 d-grid gap-2">
        <a class="btn btn-warning" href="{{ route('admin.barbers.edit', $barber) }}">Edit</a>

        <form method="POST" action="{{ route('admin.barbers.destroy', $barber) }}"
              onsubmit="return confirm('Delete this barber?')">
          @csrf
          @method('DELETE')
          <button class="btn btn-danger">Delete</button>
        </form>
      </div>
    </div>
  @empty
    <div class="barber-mobile-item text-center text-muted">
      No barbers found.
    </div>
  @endforelse
</div>

<div class="mt-3">
  {{ $barbers->links() }}
</div>
@endsection
