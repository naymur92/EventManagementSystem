@extends('layouts.app')

@section('title', 'ইউজার প্রোফাইল | পাসওয়ার্ড চেঞ্জ')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        {{-- <h1 class="h3 mb-2 text-gray-800">Change Password</h1> --}}

        <div class="row justify-content-center">
            <div class="col-12 col-xl-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h5 class="m-0 text-primary">ইউজার পাসওয়ার্ড চেঞ্জ</h5>
                        <div class="ms-auto">
                            <div class="btn-list">
                                <x-back-button href="{{ route('dashboard') }}"></x-back-button>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('user-profile.update-password') }}" method="POST" onsubmit="swalConfirmationOnSubmit(event, 'আপনি কি নিশ্চিত?');">
                        @csrf
                        @method('put')

                        <div class="card-body">
                            <div class="row">

                                {{-- password --}}
                                <div class="form-group col-12 col-lg-6 mb-3">
                                    <label for="_pass" class="col-form-label font-14">ইন্টার নিউ পাসওয়ার্ড <span class="text-danger"><i
                                                class="fas fa-xs fa-asterisk"></i></span></label>

                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="_pass" placeholder="পাসওয়ার্ড">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                {{-- confirm password --}}
                                <div class="form-group col-12 col-lg-6 mb-3">
                                    <label for="_pass_conf" class="col-form-label font-14">ইন্টার পাসওয়ার্ড এগেইন <span class="text-danger"><i
                                                class="fas fa-xs fa-asterisk"></i></span></label>

                                    <input type="password" name="password_confirmation" class="form-control @error('password') is-invalid @enderror" id="_pass_conf"
                                        placeholder="রিটাইপ পাসওয়ার্ড">

                                    @error('password')
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
