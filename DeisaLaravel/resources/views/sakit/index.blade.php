@extends('layouts.app-tailwind')

@section('title', 'Catatan Medis')

@section('page_title', 'Catatan Medis')
@section('page_subtitle', 'Log Kesehatan & Penanganan')

@section('content')
    <livewire:sakit.sakit-index />
@endsection
