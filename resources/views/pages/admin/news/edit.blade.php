
@extends('layouts.master')

@section('page_title', 'Edit News')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="row mb-3">
        <div class="col-md-8">
            <h2>Edit News</h2>
        </div>

        <div class="col-md-4 text-right">
            <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i>
                Back to News
            </a>
        </div>
    </div>


    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Please fix the following errors:</strong>

            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="card">

        <div class="card-header">
            <strong>Edit News Article</strong>
        </div>

        <div class="card-body">

            <form
                action="{{ route('admin.news.update', $news) }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf
                @method('PUT')


                {{-- ========================= --}}
                {{-- Basic Information --}}
                {{-- ========================= --}}

                <h5 class="mb-3">
                    Basic Information
                </h5>


                {{-- Title --}}
                <div class="form-group">

                    <label for="title">
                        Title <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="title"
                        id="title"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title', $news->title) }}"
                        placeholder="Enter news title"
                        required
                    >

                    @error('title')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                {{-- Slug --}}
                <div class="form-group">

                    <label for="slug">
                        Slug
                    </label>

                    <input
                        type="text"
                        name="slug"
                        id="slug"
                        class="form-control @error('slug') is-invalid @enderror"
                        value="{{ old('slug', $news->slug) }}"
                        placeholder="example-news-title"
                    >

                    <small class="form-text text-muted">
                        The URL-friendly version of the title.
                    </small>

                    @error('slug')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                {{-- Category --}}
                <div class="form-group">

                    <label for="category">
                        Category
                    </label>

                    <input
                        type="text"
                        name="category"
                        id="category"
                        class="form-control @error('category') is-invalid @enderror"
                        value="{{ old('category', $news->category) }}"
                        placeholder="e.g. School News, Events, Announcements"
                    >

                    @error('category')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                {{-- Summary --}}
                <div class="form-group">

                    <label for="summary">
                        Short Description
                    </label>

                    <textarea
                        name="summary"
                        id="summary"
                        rows="3"
                        class="form-control @error('summary') is-invalid @enderror"
                        placeholder="Short description of the news..."
                    >{{ old('summary', $news->summary) }}</textarea>

                    <small class="form-text text-muted">
                        A short description that can be displayed in news listings.
                    </small>

                    @error('summary')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                <hr>


                {{-- ========================= --}}
                {{-- Article Content --}}
                {{-- ========================= --}}

                <h5 class="mb-3">
                    Article Content
                </h5>


                {{-- Content --}}
                <div class="form-group">

                    <label for="content">
                        Content <span class="text-danger">*</span>
                    </label>

                    <textarea
                        name="content"
                        id="content"
                        rows="12"
                        class="form-control @error('content') is-invalid @enderror"
                        placeholder="Write your news article here..."
                        required
                    >{{ old('content', $news->content) }}</textarea>

                    @error('content')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                <hr>


                {{-- ========================= --}}
                {{-- Featured Image --}}
                {{-- ========================= --}}

                <h5 class="mb-3">
                    Featured Image
                </h5>


                {{-- Current Image --}}
                @if($news->image)

                    <div class="form-group">

                        <label>
                            Current Image
                        </label>

                        <div class="mb-3">

                            <img
                                src="{{ asset('storage/' . $news->image) }}"
                                alt="{{ $news->title }}"
                                style="
                                    max-width: 300px;
                                    max-height: 200px;
                                    object-fit: cover;
                                    border-radius: 6px;
                                    border: 1px solid #ddd;
                                "
                            >

                        </div>

                    </div>

                @endif


                {{-- New Image --}}
                <div class="form-group">

                    <label for="image">
                        {{ $news->image ? 'Replace Featured Image' : 'Featured Image' }}
                    </label>

                    <input
                        type="file"
                        name="image"
                        id="image"
                        class="form-control-file @error('image') is-invalid @enderror"
                        accept="image/jpg,image/jpeg,image/png,image/webp"
                    >

                    <small class="form-text text-muted">
                        Leave empty to keep the current image.
                        Recommended formats: JPG, PNG or WebP. Maximum size: 5 MB.
                    </small>

                    @error('image')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                <hr>


                {{-- ========================= --}}
                {{-- Call To Action --}}
                {{-- ========================= --}}

                <h5 class="mb-3">
                    Button / Call To Action
                </h5>


                {{-- Button Text --}}
                <div class="form-group">

                    <label for="button_text">
                        Button Text
                    </label>

                    <input
                        type="text"
                        name="button_text"
                        id="button_text"
                        class="form-control @error('button_text') is-invalid @enderror"
                        value="{{ old('button_text', $news->button_text) }}"
                        placeholder="e.g. Read More, Learn More"
                    >

                    @error('button_text')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                {{-- Button URL --}}
                <div class="form-group">

                    <label for="button_url">
                        Button URL
                    </label>

                    <input
                        type="text"
                        name="button_url"
                        id="button_url"
                        class="form-control @error('button_url') is-invalid @enderror"
                        value="{{ old('button_url', $news->button_url) }}"
                        placeholder="https://example.com/page"
                    >

                    <small class="form-text text-muted">
                        Optional link for the button.
                    </small>

                    @error('button_url')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                <hr>


                {{-- ========================= --}}
                {{-- Publishing --}}
                {{-- ========================= --}}

                <h5 class="mb-3">
                    Publishing
                </h5>


                <div class="row">

                    {{-- Published --}}
                    <div class="col-md-6">

                        <div class="form-group">

                            <div class="custom-control custom-switch">

                                <input
                                    type="checkbox"
                                    name="is_published"
                                    value="1"
                                    id="is_published"
                                    class="custom-control-input"
                                    {{ old('is_published', $news->is_published) ? 'checked' : '' }}
                                >

                                <label
                                    class="custom-control-label"
                                    for="is_published"
                                >
                                    Publish this news article
                                </label>

                            </div>

                            <small class="form-text text-muted">
                                Enable this to make the article published.
                            </small>

                            @error('is_published')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                    </div>


                    {{-- Featured --}}
                    <div class="col-md-6">

                        <div class="form-group">

                            <div class="custom-control custom-switch">

                                <input
                                    type="checkbox"
                                    name="is_featured"
                                    value="1"
                                    id="is_featured"
                                    class="custom-control-input"
                                    {{ old('is_featured', $news->is_featured) ? 'checked' : '' }}
                                >

                                <label
                                    class="custom-control-label"
                                    for="is_featured"
                                >
                                    Featured Article
                                </label>

                            </div>

                            <small class="form-text text-muted">
                                Featured articles can be highlighted on the website.
                            </small>

                            @error('is_featured')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                    </div>

                </div>


                {{-- Published At --}}
                <div class="form-group">

                    <label for="published_at">
                        Publication Date
                    </label>

                    <input
                        type="datetime-local"
                        name="published_at"
                        id="published_at"
                        class="form-control @error('published_at') is-invalid @enderror"
                        value="{{ old(
                            'published_at',
                            $news->published_at
                                ? $news->published_at->format('Y-m-d\TH:i')
                                : ''
                        ) }}"
                    >

                    <small class="form-text text-muted">
                        Set the date and time when this article should be published.
                    </small>

                    @error('published_at')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                <hr>


                {{-- ========================= --}}
                {{-- Form Actions --}}
                {{-- ========================= --}}

                <div class="d-flex justify-content-between">

                    <a
                        href="{{ route('admin.news.index') }}"
                        class="btn btn-secondary"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        <i class="fa fa-save"></i>
                        Update News
                    </button>

                </div>


            </form>

        </div>

    </div>

</div>

@endsection

