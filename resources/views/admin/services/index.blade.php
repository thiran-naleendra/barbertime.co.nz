@extends('layouts.admin', ['title' => 'Services'])

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
    .svc-mobile-card{
        border: 1px solid rgba(0,0,0,.08);
        border-radius: 16px;
        background:#fff;
        box-shadow: 0 10px 22px rgba(0,0,0,.06);
        padding: 14px;
    }
    .svc-meta{
        font-size:12px;
        color:#6c757d;
    }
    .svc-actions .btn{
        border-radius:999px;
        padding: 6px 12px;
        font-weight:600;
    }
    .svc-name{
        font-weight:800;
        line-height:1.2;
    }

    /* ✅ Image styles */
    .svc-thumb{
        width:64px;
        height:64px;
        border-radius:14px;
        object-fit:cover;
        border: 1px solid rgba(0,0,0,.08);
        box-shadow: 0 8px 18px rgba(0,0,0,.08);
        background:#f1f3f5;
        flex: 0 0 auto;
    }
    .svc-thumb--sm{
        width:54px;
        height:54px;
        border-radius:12px;
    }
    .svc-thumb-placeholder{
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:11px;
        color:#6c757d;
    }
</style>

<div class="page-head">
    <div>
        <h1 class="h5 fw-semibold mb-1">Services</h1>
        <div class="text-muted small">Manage service list, pricing, and visibility.</div>
    </div>

    <a class="btn btn-dark btn-sm rounded-pill px-3" href="{{ route('admin.services.create') }}">
        + Add Service
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- ✅ MOBILE VIEW (Cards) --}}
<div class="d-md-none">
    <div class="d-grid gap-3">
        @forelse($services as $service)
            <div class="svc-mobile-card">
                <div class="d-flex justify-content-between align-items-start gap-3">

                    {{-- ✅ Image --}}
                    <div>
                        @if(!empty($service->image_path))
                            <img class="svc-thumb svc-thumb--sm"
                                 src="{{ Storage::url($service->image_path) }}"
                                 alt="{{ $service->name }}">
                        @else
                            <div class="svc-thumb svc-thumb--sm svc-thumb-placeholder">
                                No Image
                            </div>
                        @endif
                    </div>

                    <div class="flex-grow-1">
                        <div class="svc-name">{{ $service->name }}</div>

                        @if($service->description)
                            <div class="text-muted small mt-1">
                                {{ \Illuminate\Support\Str::limit($service->description, 90) }}
                            </div>
                        @endif

                        <div class="svc-meta mt-2">
                            <div>Price: <strong>${{ number_format((float)$service->price, 2) }}</strong> NZD</div>
                            <div>Duration: <strong>{{ $service->duration_minutes ? $service->duration_minutes.' min' : '-' }}</strong></div>
                        </div>
                    </div>

                    <div>
                        @if($service->is_active)
                            <span class="badge text-bg-success">Active</span>
                        @else
                            <span class="badge text-bg-secondary">Hidden</span>
                        @endif
                    </div>
                </div>

                <div class="svc-actions mt-3 d-flex gap-2">
                    <a class="btn btn-outline-primary btn-sm flex-grow-1"
                       href="{{ route('admin.services.edit', $service) }}">Edit</a>

                    <form action="{{ route('admin.services.destroy', $service) }}"
                          method="POST" class="flex-grow-1"
                          onsubmit="return confirm('Delete this service?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger btn-sm w-100" type="submit">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center text-muted py-4">No services yet.</div>
        @endforelse
    </div>
</div>

{{-- ✅ DESKTOP VIEW (Table) --}}
<div class="card-soft d-none d-md-block">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th style="min-width: 320px;">Service</th>
                    <th class="text-nowrap">Price (NZD)</th>
                    <th class="text-nowrap">Duration</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($services as $service)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            {{-- ✅ Image --}}
                            @if(!empty($service->image_path))
                                <img class="svc-thumb"
                                     src="{{ Storage::url($service->image_path) }}"
                                     alt="{{ $service->name }}">
                            @else
                                <div class="svc-thumb svc-thumb-placeholder">
                                    No Image
                                </div>
                            @endif

                            <div>
                                <div class="fw-semibold">{{ $service->name }}</div>
                                @if($service->description)
                                    <div class="small text-muted">
                                        {{ \Illuminate\Support\Str::limit($service->description, 90) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </td>

                    <td class="text-nowrap">${{ number_format((float)$service->price, 2) }}</td>
                    <td class="text-nowrap">{{ $service->duration_minutes ? $service->duration_minutes.' min' : '-' }}</td>
                    <td>
                        @if($service->is_active)
                            <span class="badge text-bg-success">Active</span>
                        @else
                            <span class="badge text-bg-secondary">Hidden</span>
                        @endif
                    </td>
                    <td class="text-end text-nowrap">
                        <div class="btn-group">
                            <a class="btn btn-outline-primary btn-sm"
                               href="{{ route('admin.services.edit', $service) }}">Edit</a>

                            <form action="{{ route('admin.services.destroy', $service) }}"
                                  method="POST"
                                  onsubmit="return confirm('Delete this service?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm" type="submit">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">No services yet.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $services->links() }}
</div>
@endsection
