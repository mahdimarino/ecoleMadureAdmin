@extends('layouts.master')

@section('page_title', 'Notifications')

@section('content')

<div class="card">

    <div class="card-header header-elements-inline">

        <h6 class="card-title">
            Notifications
        </h6>

    </div>


    <div class="card-body">

        @forelse($notifications as $notification)

            <div
                class="media p-3 mb-2 border rounded
                {{ $notification->read_at ? '' : 'bg-light' }}"
            >

                <div class="mr-3">

                    <span class="btn btn-danger btn-sm rounded-circle">

                        <i class="icon-warning22"></i>

                    </span>

                </div>


                <div class="media-body">

                    <div class="d-flex justify-content-between">

                        <h6 class="mb-1">

                            {{ $notification->title }}

                        </h6>


                        @if(!$notification->read_at)

                            <span class="badge badge-primary">
                                New
                            </span>

                        @endif

                    </div>


                    <p class="mb-1">

                        {{ $notification->message }}

                    </p>


                    <small class="text-muted">

                        {{ $notification->created_at->format('d/m/Y H:i') }}

                    </small>


                    {{-- @if(!$notification->read_at)

                        <form
                            method="POST"
                            action="{{ route(
                                'parent.notifications.read',
                                $notification->id
                            ) }}"
                            class="mt-2"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="btn btn-sm btn-light"
                            >

                                Mark as read

                            </button>

                        </form>

                    @endif --}}

                </div>

            </div>

        @empty

            <div class="text-center text-muted py-5">

                <i class="icon-bell2 icon-2x d-block mb-2"></i>

                No notifications yet.

            </div>

        @endforelse


        @if($notifications->hasPages())

            <div class="mt-3">

                {{ $notifications->links() }}

            </div>

        @endif

    </div>

</div>

@endsection