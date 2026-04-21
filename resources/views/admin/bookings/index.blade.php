@extends('layouts.admin', ['title' => 'Bookings'])

@section('content')
<style>
    .page-head{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:12px;
        flex-wrap:wrap;
        margin-bottom:16px;
    }
    .card-soft{
        border: 1px solid rgba(0,0,0,.08);
        border-radius: 18px;
        box-shadow: 0 10px 26px rgba(0,0,0,.06);
        overflow:hidden;
        background:#fff;
    }
    .bk-card{
        border: 1px solid rgba(0,0,0,.08);
        border-radius: 16px;
        background:#fff;
        box-shadow: 0 10px 22px rgba(0,0,0,.06);
        padding: 14px;
    }
    .bk-id{ font-size:12px; color:#6c757d; }
    .bk-title{ font-weight:800; line-height:1.2; }
    .bk-meta{ font-size:12px; color:#6c757d; }

    /* ✅ Pagination mobile fix */
    .pagination-wrap{
        overflow-x:auto;
        -webkit-overflow-scrolling: touch;
    }
    .pagination{
        flex-wrap: nowrap;
        gap: 6px;
        margin-bottom: 0;
    }
    .page-item .page-link{
        border-radius: 10px !important;
        padding: 8px 12px;
        white-space: nowrap;
    }

    /* hide big results text on small screens */
    @media (max-width: 576px){
        .pagination-summary{ display:none; }
    }
</style>

<div class="page-head">
    <div>
        <h1 class="h5 fw-semibold mb-1">Bookings</h1>
        <div class="text-muted small">View booking requests and manage statuses.</div>
    </div>
</div>

{{-- 🔍 SEARCH / FILTER BAR --}}
<form method="GET" class="card-soft p-3 mb-3">
    <div class="row g-2 align-items-end">
        <div class="col-12 col-md-4">
            <label class="form-label small">Search</label>
            <input type="text"
                   name="q"
                   value="{{ request('q') }}"
                   class="form-control"
                   placeholder="Customer name, email or phone">
        </div>

        <div class="col-6 col-md-3">
            <label class="form-label small">Status</label>
            <select name="status" class="form-select">
                <option value="">All</option>
                @foreach(['pending','confirmed','paid','cancelled'] as $st)
                    <option value="{{ $st }}" @selected(request('status')===$st)>
                        {{ ucfirst($st) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-6 col-md-3">
            <label class="form-label small">Date</label>
            <input type="date"
                   name="date"
                   value="{{ request('date') }}"
                   class="form-control">
        </div>

        <div class="col-12 col-md-2 d-grid">
            <button class="btn btn-dark">Search</button>
        </div>

        {{-- ✅ Clear button --}}
        <div class="col-12 col-md-2 d-grid">
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary">
                Clear
            </a>
        </div>
    </div>
</form>

@php
    $badgeClass = fn($s) => match($s){
        'pending'=>'text-bg-warning',
        'paid'=>'text-bg-info',
        'confirmed'=>'text-bg-success',
        'cancelled'=>'text-bg-danger',
        default=>'text-bg-secondary'
    };
@endphp

{{-- 📱 MOBILE (Cards) --}}
<div class="d-md-none d-grid gap-3">
@forelse($bookings as $b)
    <div class="bk-card">
        <div class="d-flex justify-content-between align-items-start gap-2">
            <div>
                <div class="bk-id">#{{ $b->id }}</div>
                <div class="bk-title mt-1">{{ optional($b->service)->name ?? '—' }}</div>
                <div class="bk-meta mt-1">
                    {{ $b->booking_start_at->timezone('Pacific/Auckland')->format('d M Y, h:i A') }} (NZ)
                </div>
            </div>
            <span class="badge {{ $badgeClass($b->status) }}">{{ strtoupper($b->status) }}</span>
        </div>

        <div class="mt-3">
            <div class="fw-semibold">{{ $b->customer_name }}</div>
            <div class="bk-meta">{{ $b->customer_email }} • {{ $b->customer_phone }}</div>
        </div>

        <a class="btn btn-outline-primary btn-sm w-100 mt-3"
           href="{{ route('admin.bookings.show',$b) }}">View</a>
    </div>
@empty
    <div class="text-center text-muted py-4">No bookings found.</div>
@endforelse
</div>

{{-- 🖥 DESKTOP (Table) --}}
<div class="card-soft d-none d-md-block">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Date / Time</th>
                <th>Service</th>
                <th>Customer</th>
                <th>Status</th>
                <th class="text-end">View</th>
            </tr>
            </thead>
            <tbody>
            @forelse($bookings as $b)
                <tr>
                    <td class="text-muted">#{{ $b->id }}</td>
                    <td class="text-nowrap">
                        {{ $b->booking_start_at->timezone('Pacific/Auckland')->format('d M Y, h:i A') }}
                    </td>
                    <td>{{ optional($b->service)->name ?? '—' }}</td>
                    <td>
                        <div class="fw-semibold">{{ $b->customer_name }}</div>
                        <div class="small text-muted">{{ $b->customer_email }} • {{ $b->customer_phone }}</div>
                    </td>
                    <td>
                        <span class="badge {{ $badgeClass($b->status) }}">{{ strtoupper($b->status) }}</span>
                    </td>
                    <td class="text-end">
                        <a class="btn btn-outline-primary btn-sm"
                           href="{{ route('admin.bookings.show',$b) }}">View</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No bookings found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ✅ Pagination (fixed for mobile) --}}
@if($bookings->hasPages())
    <div class="mt-3 d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2">
        <div class="small text-muted pagination-summary">
            Showing {{ $bookings->firstItem() }} to {{ $bookings->lastItem() }} of {{ $bookings->total() }} results
        </div>

        <div class="pagination-wrap ms-sm-auto">
            {{ $bookings->appends(request()->query())->onEachSide(0)->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endif
@endsection
