@extends('layouts.app-tailwind')

@section('title', 'Inventaris Obat')

@section('page_title', 'Inventaris Obat')
@section('page_subtitle', 'Manajemen Stok & Distribusi')

@section('content')
    <livewire:obat.obat-index />
@endsection
