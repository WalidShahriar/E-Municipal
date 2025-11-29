@extends('layouts.app', ['navbarClass' => 'navbar-transparent'])

@section('title', 'Home | Dhaka')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('content')

<div id="main_content_1">
    <video autoplay muted loop playsinline class="back-video" id="hero_video">
        <source src="{{ asset('videos/VN20251129_174719.mp4') }}" type="video/mp4">    
    </video>

    <div class="video-overlay"></div>

    <div class="hero-content">
        <h1>Welcome to Dhaka</h1>
        <p>The City of History and Culture. We're a great place <br> to live, work, and play.</p>

        <a href="#main_content_2" class="hero-button" id="hero-button1">Explore Dhaka</a>
    </div>

    <button id="video_btn" onclick="toggleVideo()">&#9646;</button>
</div>



<div id="services_section">
    <div id="services_4">
        <a href="/service" id="services_4_1" class="service_4_box">
            <h3>Request a Service</h3>
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

<div id="main_content_2">
    <!-- Parallax background -->
    <div class="parallax-bg" style="background-image: url('{{ asset('images/bangladesh.jpg') }}')"></div>
    
    <!-- Parallax content -->
    <div class="parallax-content">
        <h2 class="explore-title">Explore Dhaka</h2>
        <p class="explore-subtitle">Discover the Rich History and Culture of Bangladesh's Capital</p>
        
        <div class="landmark-cards">
            <!-- Landmark 1: Lalbagh Fort -->
            <div class="landmark-card">
                <img src="{{ asset('images/Lallbag.jpg') }}" alt="Lalbagh Fort" class="card-image">
                <div class="card-content">
                    <h3>Lalbagh Fort</h3>
                    <p>A magnificent 17th-century fort, one of Dhaka's most iconic historical monuments, showcasing Mughal architecture and heritage.</p>
                </div>
            </div>

            <!-- Landmark 2: National Parliament House -->
            <div class="landmark-card">
                <img src="{{ asset('images/National.jpg') }}" alt="Parliament House" class="card-image">
                <div class="card-content">
                    <h3>National Parliament House</h3>
                    <p>An architectural masterpiece designed by Louis Kahn, representing Bangladesh's democratic institutions and modern design.</p>
                </div>
            </div>

            <!-- Landmark 3: Ahsan Manzil -->
            <div class="landmark-card">
                <img src="{{ asset('images/Ahsan.jpg') }}" alt="Ahsan Manzil" class="card-image">
                <div class="card-content">
                    <h3>Ahsan Manzil</h3>
                    <p>The stunning pink palace once home to Dhaka's elite, now a museum preserving the city's noble heritage and craftsmanship.</p>
                </div>
            </div>

            <!-- Landmark 4: Star Mosque -->
            <div class="landmark-card">
                <img src="{{ asset('images/Star.jpg') }}" alt="Star Mosque" class="card-image">
                <div class="card-content">
                    <h3>Star Mosque</h3>
                    <p>An ornately decorated 19th-century mosque featuring beautiful blue-painted geometric patterns and intricate Islamic design.</p>
                </div>
            </div>

            <!-- Landmark 5: Dhakeshwari Temple -->
            <div class="landmark-card">
                <img src="{{ asset('images/Dhakeshwari.jpg') }}" alt="Dhakeshwari Temple" class="card-image">
                <div class="card-content">
                    <h3>Dhakeshwari Temple</h3>
                    <p>One of the oldest Hindu temples in Dhaka, an important religious site and a testament to the city's diverse cultural heritage.</p>
                </div>
            </div>

            <!-- Landmark 6: Ramna Batamul -->
            <div class="landmark-card">
                <img src="{{ asset('images/Ramna.jpg') }}" alt="Ramna Batamul" class="card-image">
                <div class="card-content">
                    <h3>Ramna Batamul</h3>
                    <p>A serene green space in the heart of the city, ideal for relaxation and experiencing Dhaka's modern recreational culture.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script src="{{ asset('js/home.js') }}"></script>
@endsection