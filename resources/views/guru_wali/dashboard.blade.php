@extends('layouts.app')
@section('page_title','Dashboard Guru')
@section('content')
<div class="container py-4">
  <div class="alert alert-info">
    Halo, {{ auth()->user()->name }}! Ini dashboard guru. Silakan gunakan menu "Bimbingan".
  </div>
</div>
@endsection

