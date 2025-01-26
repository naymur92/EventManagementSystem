@extends('layouts.app')

@section('title', 'ইউজার প্রোফাইল | এডিট')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        {{-- <h1 class="h3 mb-2 text-gray-800">Edit User Profile</h1> --}}

        <div class="row justify-content-center">
            <div class="col-12 col-xl-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h5 class="m-0 text-primary">ইউজার প্রোফাইল এডিট</h5>
                        <div class="ms-auto">
                            <div class="btn-list">
                                <x-back-button href="{{ route('user-profile.show') }}"></x-back-button>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('user-profile.update') }}" method="POST" onsubmit="swalConfirmationOnSubmit(event, 'আপনি কি নিশ্চিত?');">
                        @csrf
                        @method('put')

                        <div class="card-body">
                            <div class="row">

                                {{-- name --}}
                                <div class="form-group col-12 col-lg-6 mb-3">
                                    <label for="_name" class="col-form-label font-14">নাম <span class="text-danger"><i class="fas fa-xs fa-asterisk"></i></span></label>

                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="_name" value="{{ old('name', $user->name) }}"
                                        placeholder="নাম">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                {{-- email/ user id --}}
                                <div class="form-group col-12 col-lg-6 mb-3">
                                    <label for="_email_id" class="col-form-label font-14">ই-মেইল <span class="text-danger"><i class="fas fa-xs fa-asterisk"></i></span></label>

                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="_email_id"
                                        value="{{ old('email', $user->email) }}" placeholder="abc@example.com">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <input class="btn btn-primary" type="submit" value="আপডেট">
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
