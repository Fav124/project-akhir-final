@extends('layouts.app-tailwind')

@section('page_title', 'Dashboard')
@section('page_subtitle', 'Ringkasan kesehatan dan aktivitas terkini')

@section('content')
    <livewire:dashboard.realtime-dashboard />
@endsection
