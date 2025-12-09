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
        <a href="/Service" id="services_4_1" class="service_4_box">
            <h3>Request a Service</h3>
            <p>Discover a wide range of municipal services available to you.</p>
        </a>

        <a href="/complaint_portal" id="services_4_2" class="service_4_box">
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

<button class="chat-toggle-btn" onclick="toggleChat()" id="chat-toggle-button">
    <svg class="chat-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M20 2H4C2.9 2 2 2.9 2 4V22L6 18H20C21.1 18 22 17.1 22 16V4C22 2.9 21.1 2 20 2Z" fill="currentColor"/>
    </svg>
    <span class="chat-btn-text">Chat Support</span>
    <span class="chat-badge">1</span>
</button>

<div class="chat-container" id="chat-window">
    <div class="chat-header">
        <div class="chat-header-content">
            <div class="chat-avatar">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 1H5C3.89 1 3 1.89 3 3V21C3 22.11 3.89 23 5 23H11V21H5V3H13V9H21ZM14 10V12H22V10H14ZM14 14V16H22V14H14ZM14 18V20H19V18H14Z" fill="currentColor"/>
                </svg>
            </div>
            <div class="chat-header-info">
                <h3>Dhaka City Assistant</h3>
                <p class="chat-status">Online • Usually replies instantly</p>
            </div>
        </div>
        <button class="chat-close-btn" onclick="toggleChat()" aria-label="Close chat">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </button>
    </div>
    <div class="chat-body" id="chat-messages">
        <div class="chat-welcome">
            <div class="bot-message">
                <div class="message-avatar">AI</div>
                <div class="message-content">
                    <div class="message-text">Hello! 👋 I'm your Dhaka City Assistant. I can help you with:</div>
                    <div class="message-options">
                        <span class="option-chip">Bangladesh Festivals</span>
                        <span class="option-chip">Human Support</span>
                    </div>
                    <div class="message-time">Just now</div>
                </div>
            </div>
        </div>
    </div>
    <div class="chat-footer">
        <div class="chat-input-wrapper">
            <input type="text" id="chat-input" placeholder="Type your message here..." onkeypress="handleEnter(event)">
            <button class="chat-send-btn" onclick="sendMessage()" aria-label="Send message">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 21L23 12L2 3V10L17 12L2 14V21Z" fill="currentColor"/>
                </svg>
            </button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script src="{{ asset('js/home.js') }}"></script>
@endsection