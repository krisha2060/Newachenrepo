<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEWA Chen</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/virtualvinodh/aksharamukha/aksharamukha-front/src/statics/fonts.css">
    <!-- <style src="{{ asset('web\css\styles.css') }}"></style> -->
    <link rel="stylesheet" href="{{ asset('web/css/styles.css') }}">
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    @yield('styles')

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</head>



<body>
       <div class="pillar pillar-left">
    <img  src="{{asset('web\images\pillarleft2.png')}}" alt="Left Pillar">
</div>

<div class="pillar pillar-right">
     <img  src="{{asset('web\images\pillarright1.png')}}" alt="Right Pillar">
</div>

<div class="mobilebg">
     <img  src="{{asset('web\images\door.png')}}" >
</div>

    <header>
        <div class="container">
            <div class="top-bar">
                <div>
                    <a href="#"><i class="fas fa-map-marker-alt"></i> 5/296 Camden Valley Way, Narellan, NSW, Australia, 2567</a>
                </div>
                <div>
                    <a href="tel:+61 451 211 959"><i class="fas fa-phone"></i>+61 451 211 959</a>
                    <a href="mailto:newa.catering.sydney@gmail.com"><i class="far fa-envelope"></i> newa.catering.sydney@gmail.com</a>
                </div>
            </div>
            <div class="main-header">
                <div class="logo">
                    <img src="{{asset('web\images\logooo.svg')}}" alt="NewaChen Logo">
                    <img src="{{asset('web\images\logonameeee.png')}}" alt="NewaChen ">
                </div>
                <nav>
                    <ul>
                        <li><a href="{{ route(name: 'home') }}">Home</a></li>
                        <li><a href="{{ url('/') }}#about">About</a></li>
                        
                        <li><a href="{{ route('reservation') }}">Reservation</a></li>                    <!--     <li><a href="#contact">Contact</a></li>-->
                       
                    </ul>
                </nav>
                <a href="{{ route('reservation') }}" class="btn-primary">Book</a>
                <button class="mobile-toggle"><i class="fas fa-bars"></i></button>
            </div>
        </div>
        
    </header>
    <div class="main-content">
        @yield('content')
        
    </div>
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-tiktok"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    
                </div>
                <div class="footer-menu">
                    <a href="#about">About</a>
                    <a href="#reservation">Reservation</a>
                </div>
                <div class="copyright">
                    © Copyright NewaChen.
                </div>
            </div>
        </div>
    </footer>

<script>
function initCarousel(carouselId) {
    let currentPage = 0;
    const carousel = document.getElementById(carouselId);
    if (!carousel) return null;
    const pages = carousel.querySelectorAll('.menu-page');

    function showPage(index) {
        pages.forEach((p, i) => {
            p.style.display = i === index ? 'block' : 'none';
        });
    }

    showPage(0);

    return {
        next: () => {
            currentPage = (currentPage + 1) % pages.length;
            showPage(currentPage);
        },
        prev: () => {
            currentPage = (currentPage - 1 + pages.length) % pages.length;
            showPage(currentPage);
        }
    };
}


window.lunch = initCarousel('lunch-carousel');
window.dinner = initCarousel('dinner-carousel');
window.drinks = initCarousel('drinks-carousel');
window.package = initCarousel('package-carousel');

   window.addEventListener("scroll", function () {
        const secondLogo = document.querySelector(".logo img:nth-child(2)");

        if (window.scrollY > 10) {
            secondLogo.classList.add("hide");
        } else {
            secondLogo.classList.remove("hide");
        }
    });


    // Auto slideshow
setInterval(() => {
    const slides = document.querySelectorAll('.slide');
    const current = document.querySelector('.slide.active');
    if (!current || slides.length === 0) return;
    const next = current.nextElementSibling || slides[0];
    current.classList.remove('active');
    next.classList.add('active');
}, 5000);

// Mobile menu toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    const mobileToggle = document.querySelector('.mobile-toggle');
    const nav = document.querySelector('nav');
    
    if (mobileToggle && nav) {
        mobileToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            nav.classList.toggle('active');
            this.innerHTML = nav.classList.contains('active') 
                ? '<i class="fas fa-times"></i>' 
                : '<i class="fas fa-bars"></i>';

                console.log("clicked");
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!nav.contains(e.target) && !mobileToggle.contains(e.target)) {
                nav.classList.remove('active');
                mobileToggle.innerHTML = '<i class="fas fa-bars"></i>';
            }
        });
        
        // Close menu when clicking a link
        nav.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function() {
                nav.classList.remove('active');
                mobileToggle.innerHTML = '<i class="fas fa-bars"></i>';
            });
        });
    }
    
    // Fix for arrow images on mobile
    const menuArrows = document.querySelectorAll('.menu-carousel h1 span[style*="cursor:pointer"]');
    menuArrows.forEach(arrow => {
        arrow.style.marginTop = '-30px';
        arrow.style.alignSelf = 'flex-end';
    });
});

// Run on page load
document.addEventListener('DOMContentLoaded', function() {
    // Add class to trigger animations
    document.body.classList.add('page-loaded');
    
    // Initialize hero slider (no auto-slide, just first slide)
    const slides = document.querySelectorAll('.slide');
    slides.forEach((slide, index) => {
        slide.classList.remove('active');
    });
    
    // Show first slide
    if (slides.length > 0) {
        slides[0].classList.add('active');
    }
    
    // Remove animation class after animations complete
    setTimeout(() => {
        document.body.classList.remove('page-loaded');
    }, 2000); // After all animations finish





    
});



</script>
 
@yield('scripts')
</body>
</html>