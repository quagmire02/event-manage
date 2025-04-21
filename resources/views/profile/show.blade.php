@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">My Profile</h3>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                            Edit Profile
                        </a>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Name:</div>
                        <div class="col-md-8">{{ $user->name }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Email:</div>
                        <div class="col-md-8">{{ $user->email }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">User Type:</div>
                        <div class="col-md-8">{{ ucfirst($user->user_type) }}</div>
                    </div>

                    @if($user->isStudent() || $user->isClub())
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Student ID:</div>
                            <div class="col-md-8">{{ $user->student_id }}</div>
                        </div>
                    @endif

                    @if($user->isClub())
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Club Representative ID:</div>
                            <div class="col-md-8">{{ $user->club_representative_id }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Club Representative Phone:</div>
                            <div class="col-md-8">{{ $user->club_representative_phone }}</div>
                        </div>
                    @endif

                    @if($profile)
                        @if($profile->address)
                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">Address:</div>
                                <div class="col-md-8">{{ $profile->address }}</div>
                            </div>
                        @endif

                        @if($profile->current_semester)
                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">Current Semester:</div>
                                <div class="col-md-8">{{ $profile->current_semester }}</div>
                            </div>
                        @endif

                        @if($profile->department)
                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">Department:</div>
                                <div class="col-md-8">{{ $profile->department }}</div>
                            </div>
                        @endif

                        @if($profile->bio)
                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">Bio:</div>
                                <div class="col-md-8">{{ $profile->bio }}</div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 