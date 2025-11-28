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

<div id="main_content_2">
    <div id="services_4">
        <a href="/services" id="services_4_1" class="service_4_box">
            <h3>Explore Services</h3>
            <p>Discover a wide range of municipal services available to you.</p>
        </a>
        
        <a href="/complaints" id="services_4_2" class="service_4_box">
            <h3>File a Complaint</h3>
            <p>Report issues and help us improve our city services.</p>
        </a>
        
        <a href="/payment" id="services_4_3" class="service_4_box">
            <h3>Pay Bills</h3>
            <p>Conveniently pay your municipal bills online.</p>
        </a>

        <a href="/updates" id="services_4_4" class="service_4_box">
            <h3>Get Updates</h3>
            <p>Stay informed with the latest news and updates from the city.</p>
        </a>
    </div>

</div>

@endsection

@section('scripts')
    <script src="{{ asset('js/home.js') }}"></script>
@endsection