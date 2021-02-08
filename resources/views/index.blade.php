@extends('layout')

@section('title','Cacahuarte')




@section('content')

@include('partials/banner')
@include('partials/why-about-us')
@include('partials/about-us')
{{-- @include('partials/clients') --}}
@include('partials/values')
@include('partials/portafolio')
@include('partials/team')
{{-- @include('partials/pricing') --}}
@include('partials/faq')
@include('partials/contact')

@endsection()
