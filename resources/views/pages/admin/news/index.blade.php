
@extends('layouts.master') @section('page_title', 'Create News') @section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 mb-1">News</h1>
            <p class="text-muted mb-0">
                Manage your news articles.
            </p>
        </div>

        <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Create News
        </a>

    </div>


    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>
    @endif


    {{-- Filters --}}
    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <form method="GET"
                  action="{{ route('admin.news.index') }}">

                <div class="row g-3">

                    {{-- Search --}}
                    <div class="col-md-4">

                        <label class="form-label">
                            Search
                        </label>

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search by title or category..."
                            value="{{ request('search') }}"
                        >

                    </div>


                    {{-- Category --}}
                    <div class="col-md-2">

                        <label class="form-label">
                            Category
                        </label>

                        <select name="category"
                                class="form-select">

                            <option value="">
                                All Categories
                            </option>

                            @foreach($categories as $category)

                                <option
                                    value="{{ $category }}"
                                    {{ request('category') === $category ? 'selected' : '' }}
                                >
                                    {{ $category }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Status --}}
                    <div class="col-md-2">

                        <label class="form-label">
                            Status
                        </label>

                        <select name="status"
                                class="form-select">

                            <option value="">
                                All Status
                            </option>

                            <option value="published"
                                {{ request('status') === 'published' ? 'selected' : '' }}>
                                Published
                            </option>

                            <option value="draft"
                                {{ request('status') === 'draft' ? 'selected' : '' }}>
                                Draft
                            </option>

                        </select>

                    </div>


                    {{-- Featured --}}
                    <div class="col-md-2">

                        <label class="form-label">
                            Featured
                        </label>

                        <select name="featured"
                                class="form-select">

                            <option value="">
                                All
                            </option>

                            <option value="1"
                                {{ request('featured') === '1' ? 'selected' : '' }}>
                                Featured
                            </option>

                            <option value="0"
                                {{ request('featured') === '0' ? 'selected' : '' }}>
                                Not Featured
                            </option>

                        </select>

                    </div>


                    {{-- Buttons --}}
                    <div class="col-md-2 d-flex align-items-end">

                        <div class="d-flex gap-2 w-100">

                            <button type="submit"
                                    class="btn btn-primary flex-fill">
                                Filter
                            </button>

                            <a href="{{ route('admin.news.index') }}"
                               class="btn btn-outline-secondary">
                                Reset
                            </a>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- News Table --}}
    <div class="card shadow-sm">

        <div class="card-body p-0">

            @if($news->count())

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th style="width: 70px;">
                                    Image
                                </th>

                                <th>
                                    Title
                                </th>

                                <th>
                                    Category
                                </th>

                                <th>
                                    Status
                                </th>

                                <th>
                                    Featured
                                </th>

                                <th>
                                    Published
                                </th>

                                <th style="width: 180px;" class="text-end">
                                    Actions
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($news as $article)

                                <tr>

                                    {{-- Image --}}
                                    <td>

                                        @if($article->image)

                                            <img
                                                src="{{ asset('storage/' . $article->image) }}"
                                                alt="{{ $article->title }}"
                                                style="
                                                    width: 55px;
                                                    height: 55px;
                                                    object-fit: cover;
                                                    border-radius: 6px;
                                                "
                                            >

                                        @else

                                            <div
                                                class="bg-light d-flex align-items-center justify-content-center"
                                                style="
                                                    width: 55px;
                                                    height: 55px;
                                                    border-radius: 6px;
                                                "
                                            >
                                                <i class="fas fa-image text-muted"></i>
                                            </div>

                                        @endif

                                    </td>


                                    {{-- Title --}}
                                    <td>

                                        <div class="fw-semibold">
                                            {{ $article->title }}
                                        </div>

                                        @if($article->summary)

                                            {{-- <small class="text-muted">
                                                {{ Str::limit($article->summary, 80) }}
                                            </small> --}}

                                        @endif

                                    </td>


                                    {{-- Category --}}
                                    <td>

                                        @if($article->category)

                                            <span class="badge bg-light text-dark">
                                                {{ $article->category }}
                                            </span>

                                        @else

                                            <span class="text-muted">
                                                —
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Status --}}
                                    <td>

                                        @if($article->is_published)

                                            <span class="badge bg-success">
                                                Published
                                            </span>

                                        @else

                                            <span class="badge bg-secondary">
                                                Draft
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Featured --}}
                                    <td>

                                        @if($article->is_featured)

                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-star"></i>
                                                Featured
                                            </span>

                                        @else

                                            <span class="text-muted">
                                                —
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Published Date --}}
                                    <td>

                                        @if($article->published_at)

                                            {{ $article->published_at->format('M d, Y') }}

                                        @else

                                            <span class="text-muted">
                                                —
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Actions --}}
                                    <td class="text-end">

                                        <a
                                            href="{{ route('admin.news.edit', $article) }}"
                                            class="btn btn-sm btn-outline-primary"
                                        >
                                            <i class="fas fa-edit"></i>
                                            Edit
                                        </a>


                                        <form
                                            action="{{ route('admin.news.destroy', $article) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this news article?');"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                            >
                                                <i class="fas fa-trash"></i>
                                                Delete
                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


                {{-- Pagination --}}
                <div class="p-3">

                    {{ $news->links() }}

                </div>


            @else

                {{-- Empty State --}}
                <div class="text-center py-5">

                    <div class="mb-3">
                        <i class="fas fa-newspaper fa-3x text-muted"></i>
                    </div>

                    <h5>
                        No news articles found
                    </h5>

                    <p class="text-muted">
                        There are no news articles matching your filters.
                    </p>

                    <a
                        href="{{ route('admin.news.create') }}"
                        class="btn btn-primary"
                    >
                        <i class="fas fa-plus"></i>
                        Create News
                    </a>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection

