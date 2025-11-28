@extends('layouts.app', ['navbarClass' => 'navbar-transparent'])

@section('title', 'Home | Dhaka')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('content')

<div id="main_content_1">
    <video autoplay muted loop playsinline class="back-video" id="hero_video">
        <source src="{{ asset('videos/VN20251127_153506_2.mp4') }}" type="video/mp4">    
    </video>

    <div class="video-overlay"></div>

    <div class="hero-content">
        <h1>Welcome to Dhaka</h1>
        <p>The City of History and Culture. We're a great place <br> to live, work, and play.</p>

        <a href="/services.html" class="hero-button" id="hero-button1">Explore Dhaka</a>
    </div>

    <button id="video_btn" onclick="toggleVideo()">&#9646;</button>
</div>

@endsection

@section('scripts')
    <script src="{{ asset('js/home.js') }}"></script>
@endsection