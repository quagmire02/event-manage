@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">
                        @if(auth()->user()->isAdmin())
                            All Events
                        @elseif(auth()->user()->isStudent())
                            Available Events
                        @else
                            My Events
                        @endif
                    </h3>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(auth()->user()->isClub())
                        <div class="mb-4">
                            <a href="{{ route('events.create') }}" class="btn btn-primary">
                                Create New Event
                            </a>
                        </div>
                    @endif

                    @if($events->isEmpty())
                        <div class="alert alert-info">
                            @if(auth()->user()->isAdmin())
                                No events have been created yet.
                            @elseif(auth()->user()->isStudent())
                                No upcoming events are available at the moment.
                            @else
                                You haven't created any events yet.
                            @endif
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Event Name</th>
                                        <th>Club</th>
                                        <th>Date</th>
                                        <th>Venue</th>
                                        @if(!auth()->user()->isStudent())
                                            <th>Status</th>
                                        @endif
                                        @if(auth()->user()->isStudent())
                                            <th>Registration</th>
                                        @endif
                                        @if(auth()->user()->isAdmin())
                                            <th>Actions</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($events as $event)
                                        <tr>
                                            <td>{{ $event->event_name }}</td>
                                            <td>{{ $event->club_name }}</td>
                                            <td>{{ $event->event_date->format('M d, Y') }}</td>
                                            <td>{{ $event->venue }}</td>
                                            @if(!auth()->user()->isStudent())
                                                <td>
                                                    <span class="badge bg-{{ $event->status === 'approved' ? 'success' : ($event->status === 'pending' ? 'warning' : 'danger') }}">
                                                        {{ ucfirst($event->status) }}
                                                    </span>
                                                </td>
                                            @endif
                                            @if(auth()->user()->isStudent())
                                                <td>
                                                    <a href="{{ $event->registration_form_link }}" target="_blank" class="btn btn-sm btn-primary">
                                                        Register
                                                    </a>
                                                </td>
                                            @endif
                                            @if(auth()->user()->isAdmin())
                                                <td>
                                                    @if($event->status === 'pending')
                                                        <form action="{{ route('events.approve', $event) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                                        </form>
                                                        <form action="{{ route('events.reject', $event) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 