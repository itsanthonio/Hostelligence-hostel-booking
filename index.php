<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- Favicon -->
   
    
    <title>Hostelligence - Student Hostel Management</title>
     <!-- Favicon links -->
     <link rel="icon" type="image/x-icon" href="images/favicon_io/favicon.ico">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon_io/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon_io/favicon-32x32.png">
    <link rel="apple-touch-icon" href="images/favicon_io/apple-touch-icon.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
  
    <style>
        /* Custom Styles */
        .hamburger {
            cursor: pointer;
            width: 24px;
            height: 24px;
            position: relative;
            background: none;
            border: none;
            padding: 0;
        }

        .hamburger-line {
            display: block;
            width: 24px;
            height: 2px;
            background: #e0f2fe;
            margin: 6px 0;
            transition: 0.4s;
        }

        .hamburger.active .hamburger-line:nth-child(1) {
            transform: rotate(-45deg) translate(-5px, 6px);
        }

        .hamburger.active .hamburger-line:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active .hamburger-line:nth-child(3) {
            transform: rotate(45deg) translate(-5px, -6px);
        }

        .mobile-menu {
            position: fixed;
            top: 0;
            right: -100%;
            width: 100%;
            height: 100vh;
            background: rgba(3, 105, 161, 0.9); /* Deep blue background */
            transition: 0.4s;
            z-index: 40;
        }

        .mobile-menu.active {
            right: 0;
        }

        .carousel {
            position: relative;
            height: 100vh;
            overflow: hidden;
        }

        .slides {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        .slides.active {
            opacity: 1;
        }

        .facility-card {
            transition: transform 0.3s ease-in-out;
        }

        .facility-card:hover {
            transform: translateY(-5px);
        }

        .custom-btn::after {
            background: rgba(224, 242, 254, 0.2); /* Light blue hover effect */
        }
    </style>
</head>
<body class="antialiased bg-blue-50 text-blue-900">
    <!-- Navigation -->
    <nav class="fixed w-full z-50 px-6 py-6 bg-blue-800 text-white transition-all duration-300" id="navbar">
        <div class="container mx-auto flex justify-between items-center">
            <div class="text-2xl font-bold">HOSTELLIGENCE</div>
            
            <!-- Hamburger Menu Button -->
            <div class="md:hidden">
                <button class="hamburger" id="menuBtn" aria-label="Menu">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </button>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex space-x-4">
                <a href="actions/login.php" class="px-6 py-2 border border-blue-300 rounded-full hover:bg-blue-300 hover:text-blue-900 transition duration-300">
                    Student Login
                </a>
                <a href="actions/registration.php" class="px-6 py-2 bg-blue-300 text-blue-900 rounded-full hover:bg-blue-400 transition duration-300">
                    Register
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Carousel -->
    <div class="carousel">
        <div class="slides active" style="background: url('images/hero.avif') center/cover;"></div>
        <div class="slides" style="background: url('images/hero2.jpg') center/cover;"></div>
        <div class="slides" style="background: url('images/hero3.jpg') center/cover;"></div>

       <!-- Navigation Arrows -->
       <button class="absolute left-8 top-1/2 transform -translate-y-1/2 z-20 bg-blue-900 bg-opacity-50 p-4 rounded-full text-white hover:bg-opacity-75 transition" onclick="changeSlide(-1)">←</button>
       <button class="absolute right-8 top-1/2 transform -translate-y-1/2 z-20 bg-blue-900 bg-opacity-50 p-4 rounded-full text-white hover:bg-opacity-75 transition" onclick="changeSlide(1)">→</button>

        <!-- Overlay Content -->
        <div class="absolute inset-0 bg-blue-800 bg-opacity-40 flex flex-col justify-center items-center text-white z-10">
            <h1 class="text-6xl md:text-7xl font-bold mb-6 text-center max-w-5xl px-4 fade-in">
                Your Home Away from Home
            </h1>
            <p class="text-xl md:text-2xl mb-12 text-center max-w-2xl px-4 fade-in">
                Comfortable, Secure, and Convenient Student Accommodation
            </p>
            <div class="flex space-x-4">
                <a href="login.php" class="custom-btn group relative inline-flex items-center justify-center px-12 py-4 text-lg font-medium tracking-wider border border-white rounded-full hover:bg-white hover:text-blue-900 transition-all duration-300">
                    BOOK A ROOM
                </a>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <section class="py-24 bg-blue-100">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-4xl font-bold mb-8">About Hostelligence</h2>
                <div class="w-24 h-1 bg-blue-600 mx-auto mb-8"></div>
                <p class="text-lg text-blue-800 mb-8 leading-relaxed">
                    Hostelligence is a modern hostel management platform designed to provide students with comfortable, secure, and convenient accommodation solutions.
                </p>
                <p class="text-lg text-blue-800 leading-relaxed">
                    Our platform offers seamless room booking, real-time availability, and comprehensive facilities management to ensure a hassle-free living experience.
                </p>
            </div>
        </div>
    </section>

    <!-- Facilities Section -->
    <section class="py-24 bg-blue-50">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-center mb-16">Our Facilities</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="facility-card bg-white rounded-lg shadow-lg p-8 text-center">
                    <div class="text-4xl mb-4">📡</div>
                    <h3 class="text-2xl font-bold mb-4 text-blue-700">Wi-Fi</h3>
                    <p class="text-blue-600">High-speed internet access throughout the hostel.</p>
                </div>
                <div class="facility-card bg-white rounded-lg shadow-lg p-8 text-center">
                    <div class="text-4xl mb-4">📚</div>
                    <h3 class="text-2xl font-bold mb-4 text-blue-700">Study Rooms</h3>
                    <p class="text-blue-600">Dedicated spaces for focused academic work.</p>
                </div>
                <div class="facility-card bg-white rounded-lg shadow-lg p-8 text-center">
                    <div class="text-4xl mb-4">🔒</div>
                    <h3 class="text-2xl font-bold mb-4 text-blue-700">24/7 Security</h3>
                    <p class="text-blue-600">Round-the-clock security to ensure student safety.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-blue-900 text-blue-300 py-16">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-center mb-8">
                <div class="mb-8 md:mb-0">
                    <h3 class="text-3xl font-bold mb-4">HOSTELLIGENCE</h3>
                    <p>Your Comfortable Campus Residence</p>
                </div>
            </div>
            <div class="border-t border-blue-700 pt-8 text-center">
                <p>&copy; 2024 Hostelligence. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu functionality
        const menuBtn = document.getElementById('menuBtn');
        const mobileMenu = document.querySelector('.mobile-menu');
        const navbar = document.getElementById('navbar');

        menuBtn.addEventListener('click', () => {
            menuBtn.classList.toggle('active');
            mobileMenu.classList.toggle('active');
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!menuBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
                menuBtn.classList.remove('active');
                mobileMenu.classList.remove('active');
            }
        });

        // Carousel functionality
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slides');

        function changeSlide(direction) {
            slides[currentSlide].classList.remove('active');
            currentSlide = (currentSlide + direction + slides.length) % slides.length;
            slides[currentSlide].classList.add('active');
        }

        // Auto advance slides
        setInterval(() => changeSlide(1), 5000);

        // Navbar background on scroll
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                navbar.classList.add('bg-black');
            } else {
                navbar.classList.remove('bg-black');
            }
        });

        // Intersection Observer for fade-in animations
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe all facility cards
        document.querySelectorAll('.facility-card').forEach(card => {
            observer.observe(card);
        });
    </script>
</body>
</html>