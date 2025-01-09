<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | Enhance My Stay</title>
    <link rel="stylesheet" href="/fe/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

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
<section class="about-hero">
    <div class="about-hero-container">
        <h1>ABOUT US</h1>
        <p>
            Introducing Enhance My Stay, where innovation meets hospitality. Founded in 2019, we’ve developed a huge amount of expertise in the world of travel technology, revolutionising the way hotels interact with their guests.
        </p>
        <img src="fe/images/about-hero-image.png" alt="About Us Hero" class="centered-image">
    </div>
</section>

<!-- Our Story Section -->
<section class="our-story">
    <div class="our-story-container">
        <h2>OUR STORY</h2>
        <p>
            In the early days, we focused on building robust solutions for the OTA market, driven by our expertise in data analytics and artificial intelligence. We realised that by understanding guest behaviour and preferences, we could significantly improve the booking process.
        </p>
        <p>
            Our AI-powered platform became a game-changer, offering highly personalised accommodation recommendations that met and exceeded travellers' expectations.
        </p>
    </div>
</section>

<!-- Upsell Tools Section -->
<section class="upsell-tools">
    <div class="upsell-tools-container">
        <div class="left-image">
            <img src="fe/images/upsell-tools.png" alt="Upsell Tools">
        </div>
        <div class="text">
            <p>
                As we grew, so did our vision. We expanded our offerings to include powerful upsell tools designed to maximise pre-arrival engagement.
            </p>
            <p>
                By strategically targeting guests 1-3 weeks before their arrival, our platform taps into key insights about guest spending behaviour, ensuring that upsell offers are not only timely but also highly relevant.
            </p>
            <p>
                This approach has proven to enhance guest satisfaction and drive additional revenue for hotels. It’s this success that led us to make the decision to solely focus on helping hotels generate additional income with pre-arrival upsells.
            </p>
        </div>
    </div>
</section>

<!-- Mission Section -->
<section class="mission">
    <div class="mission-container">
        <h2>OUR MISSION</h2>
        <p>
            Our mission is to democratise access to advanced technology for hotels of all sizes, enabling them to enhance their profitability and guest satisfaction through intuitive, cost-effective solutions. We are committed to providing tools that are easy to use, require minimal technical expertise, and are financially accessible, ensuring that every hotel can thrive in the digital age.
        </p>
        <img src="fe/images/mission-image.png" alt="Our Mission" class="centered-image">
    </div>
</section>

<!-- Solutions Section -->
<section class="solutions">
    <div class="solutions-container">
        <div class="white-box">
            <div class="left-image">
                <img src="fe/images/hotel-image.png" alt="Hotel">
            </div>
            <div class="text">
                <p>
                    Whether you're a boutique hotel looking to personalise guest experiences or a large chain aiming to boost pre-arrival revenue (or any other type of accommodation provider), Enhance My Stay offers the solutions you need to succeed. Together, let's create exceptional stays and unforgettable memories.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer id="enhance-footer">
    <div class="footer-container">
        <!-- Header Section -->
        <h2>Unlock the Power of Upsells for Your Guests</h2>
        <div class="cta-buttons">
            <a href="https://enhancemystay.com/register" class="btn btn-primary">Start Now ></a>
            <a href="https://calendly.com/enhancemystay">Book Demo ></a>
        </div>

        <hr />

        <!-- Footer Content Section -->
        <div class="footer-content">
            <!-- Left Side: Logo -->
            <div class="footer-left">
                <img src="fe/images/logo.png" alt="Enhance My Stay Logo" class="footer-logo" />
            </div>

            <!-- Right Side: Mascot -->
            <div class="footer-right">
                <img src="fe/images/mascot.png" alt="Mascot" class="footer-mascot" />
            </div>
        </div>

        <div class="footer-bottom">
            <!-- Footer Navigation -->
            <ul class="footer-menu">
                <li><a href="/">Home</a></li>
                <li><a href="/contact">Contact</a></li>
                <li><a href="https://enhancemystay.com/register">Get Started</a></li>
            </ul>
            <a href="https://www.linkedin.com/company/enhancemystay" target="_blank" class="footer-linkedin">
                <img src="fe/images/linkedin-icon.png" alt="LinkedIn" />
            </a>
        </div>

        <!-- Copyright -->
        <div class="footer-copyright">
            Copyright © 2024 Travel Global Limited. All rights reserved.
        </div>
    </div>
</footer>

<script src="/fe/scripts.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800, // Animation duration (in milliseconds)
        once: false, // Animations should happen on every scroll
        offset: 200, // Trigger animations slightly before the element comes into view
    });
</script>


</body>
</html>
