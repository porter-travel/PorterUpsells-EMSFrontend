<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Enhance My Stay</title>
    <link rel="stylesheet" href="/fe/styles.css">
    <script src="/fe/scripts.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js"></script>

</head>
<body>
<!-- Header -->
<header class="navbar">
    <div class="container">
        <div class="logo">
            <a href="/">
                <img src="fe/images/logo.png" alt="Enhance My Stay Logo">
            </a>
        </div>
        <nav class="nav">
            <ul class="nav-links">
                <li><a href="/">Home</a></li>
                <li><a href="/about">About Us</a></li>
                <li><a href="/contact">Contact</a></li>
                <li><a href="https://enhancemystay.com/login" class="btn btn-signin">Sign In ></a></li>
            </ul>
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </nav>


    </div>
</header>

<!-- Hero Section -->
<section class="contact-hero" style="background-color: #F7F8C6;">
    <div class="contact-hero-container">
        <h1>GET IN TOUCH</h1>
    </div>
</section>

<!-- Contact Form Section -->
<section class="contact-form-section">
    <div class="contact-form-container">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div id="message-container"></div>

            <form id="contact-form" class="contact-form" action="/submit-contact-form" method="post">
                @csrf
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>

                <label for="company">Company/Hotel Name</label>
                <input type="text" id="company" name="company" value="{{ old('company') }}">

                <label for="message">Message</label>
                <textarea id="message" name="message" rows="5" required>{{ old('message') }}</textarea>

{{--<button type="submit">Send</button>--}}
                <button type="submit" class="btn btn-primary g-recaptcha"
                        data-sitekey="6Le7wbIqAAAAAAiTNCo57jYjq57BF4fouKs9hULT"
                        data-callback='onSubmit'
                        data-action='submit'>Send</button>
            </form>
    </div>
</section>

<!-- Alternate Contact Options Section -->
<section class="alternate-contact-section" style="background-color: #D0F0F4;">
    <div class="alternate-contact-container">
        <h2>Prefer to Reach Us Another Way?</h2>
        <p>Email: <a href="mailto:hi@enhancemystay.com">hi@enhancemystay.com</a></p>
        <p>Live Demo: <a href="https://calendly.com/enhancemystay">Book a time with us here</a></p>
    </div>
</section>

<!-- Footer -->
<footer id="enhance-footer">
    <div class="footer-container">
        <h2>READY TO ENHANCE YOUR GUEST EXPERIENCE?</h2>
        <div class="cta-buttons">
            <a href="#" class="btn btn-primary">Start Now ></a>
            <a href="#">Book Demo ></a>
        </div>
        <hr>
        <div class="footer-content">
            <div class="footer-left">
                <img src="fe/images/logo.png" alt="Enhance My Stay Logo" class="footer-logo">
            </div>
            <div class="footer-right">
                <img src="fe/images/mascot.png" alt="Mascot" class="footer-mascot">
            </div>
        </div>
        <div class="footer-bottom">
            <ul class="footer-menu">
                <li><a href="/">Home</a></li>
                <li><a href="/about">About</a></li>
                <li><a href="https://enhancemystay.com/register">Get Started</a></li>
            </ul>
            <a href="https://www.linkedin.com/company/enhancemystay" target="_blank" class="footer-linkedin">
                <img src="fe/images/linkedin-icon.png" alt="LinkedIn">
            </a>
        </div>
        <div class="footer-copyright">
            Copyright © 2024 Travel Global Limited. All rights reserved
        </div>
    </div>
</footer>

<script src="/fe/scripts.js"></script>

<script>
    function onSubmit(token) {
        document.getElementById("contact-form").submit();
    }
</script>


</body>
</html>
