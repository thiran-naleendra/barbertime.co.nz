@extends('layouts.admin', ['title' => 'Products'])

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
    .prod-mobile-card{
        border: 1px solid rgba(0,0,0,.08);
        border-radius: 16px;
        background:#fff;
        box-shadow: 0 10px 22px rgba(0,0,0,.06);
        padding: 14px;
    }
    .prod-thumb{
        width: 92px;
        height: 72px;
        border-radius: 14px;
        object-fit: cover;
        background: #f3f4f6;
        border: 1px solid rgba(0,0,0,.06);
        flex: 0 0 auto;
    }
    .prod-name{
        font-weight: 800;
        line-height: 1.2;
    }
    .prod-meta{
        font-size:12px;
        color:#6c757d;
    }
    .prod-actions .btn{
        border-radius:999px;
        padding: 6px 12px;
        font-weight:600;
    }
</style>

<div class="page-head">
    <div>
        <h1 class="h5 fw-semibold mb-1">Products</h1>
        <div class="text-muted small">Manage products, pricing and visibility.</div>
    </div>

    <a class="btn btn-dark btn-sm rounded-pill px-3" href="{{ route('admin.products.create') }}">
        + Add Product
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- ✅ MOBILE VIEW (Cards) --}}
<div class="d-md-none">
    <div class="d-grid gap-3">
        @forelse($products as $product)
            <div class="prod-mobile-card">
                <div class="d-flex gap-3 align-items-start">
                    @if($product->image_path)
                        <img class="prod-thumb" src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}">
                    @else
                        <div class="prod-thumb d-flex align-items-center justify-content-center text-muted small">
                            No image
                        </div>
                    @endif

                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <div>
                                <div class="prod-name">{{ $product->name }}</div>
                                @if($product->description)
                                    <div class="text-muted small mt-1">
                                        {{ \Illuminate\Support\Str::limit($product->description, 90) }}
                                    </div>
                                @endif
                            </div>

                            <div class="text-end">
                                @if($product->is_active)
                                    <span class="badge text-bg-success">Active</span>
                                @else
                                    <span class="badge text-bg-secondary">Hidden</span>
                                @endif
                            </div>
                        </div>

                        <div class="prod-meta mt-2">
                            Price: <strong>${{ number_format((float)$product->price, 2) }}</strong> NZD
                        </div>

                        <div class="prod-actions mt-3 d-flex gap-2">
                            <a class="btn btn-outline-primary btn-sm flex-grow-1"
                               href="{{ route('admin.products.edit', $product) }}">Edit</a>

                            <form class="flex-grow-1" method="POST"
                                  action="{{ route('admin.products.destroy', $product) }}"
                                  onsubmit="return confirm('Delete this product?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm w-100" type="submit">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center text-muted py-4">No products yet.</div>
        @endforelse
    </div>
</div>

{{-- ✅ DESKTOP VIEW (Table) --}}
<div class="card-soft d-none d-md-block">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th style="width: 110px;">Image</th>
                    <th style="min-width: 280px;">Product</th>
                    <th class="text-nowrap">Price (NZD)</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($products as $product)
                <tr>
                    <td>
                        @if($product->image_path)
                            <img src="{{ asset('storage/'.$product->image_path) }}"
                                 class="rounded"
                                 style="width:90px;height:60px;object-fit:cover;">
                        @else
                            <div class="text-muted small">No image</div>
                        @endif
                    </td>
                    <td>
                        <div class="fw-semibold">{{ $product->name }}</div>
                        @if($product->description)
                            <div class="small text-muted">
                                {{ \Illuminate\Support\Str::limit($product->description, 90) }}
                            </div>
                        @endif
                    </td>
                    <td class="text-nowrap">${{ number_format((float)$product->price, 2) }}</td>
                    <td>
                        @if($product->is_active)
                            <span class="badge text-bg-success">Active</span>
                        @else
                            <span class="badge text-bg-secondary">Hidden</span>
                        @endif
                    </td>
                    <td class="text-end text-nowrap">
                        <div class="btn-group">
                            <a class="btn btn-outline-primary btn-sm"
                               href="{{ route('admin.products.edit', $product) }}">Edit</a>

                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                  onsubmit="return confirm('Delete this product?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm" type="submit">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No products yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $products->links() }}
</div>
@endsection
