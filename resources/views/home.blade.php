@extends('layouts.app')

@section('content')
    @include('components.hero')
    @include('components.stats')
    @include('components.about')
    @include('components.pricing')
    @include('components.trainers')
    @include('components.booking')
    @include('components.cta')
@endsection
