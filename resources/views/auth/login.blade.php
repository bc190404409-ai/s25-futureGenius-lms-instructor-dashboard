@extends('layouts.guest')

@section('content')
    @include('auth.partials.login-card', ['action' => route('login'), 'title' => 'Login', 'subtitle' => 'Sign in to your instructor account', 'submitText' => 'Login', 'showSocial' => true])
@endsection