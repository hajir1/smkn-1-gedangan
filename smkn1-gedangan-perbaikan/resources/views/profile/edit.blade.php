@php($inAdmin = auth()->user()->isAdmin())
@extends($inAdmin ? 'admin.layouts.app' : 'frontend.layouts.app')

@section('title', 'Pengaturan Akun')
@section('eyebrow', 'Akun')
@section('hide_contact', true)

@section('content')
    @unless ($inAdmin)
        @include('frontend.partials.page-hero', ['title' => 'Pengaturan Akun', 'eyebrow' => 'Akun', 'crumbs' => [['Pengaturan Akun']]])
    @endunless

    <div class="{{ $inAdmin ? '' : 'mx-auto max-w-4xl px-4 py-16 sm:px-6' }} space-y-6">
        <div class="card p-6 sm:p-8">@include('profile.partials.update-profile-information-form')</div>
        <div class="card p-6 sm:p-8">@include('profile.partials.update-password-form')</div>
        @if ($user->isDeletable() && ! $inAdmin)
            <div class="card p-6 sm:p-8">@include('profile.partials.delete-user-form')</div>
        @endif
    </div>
@endsection
