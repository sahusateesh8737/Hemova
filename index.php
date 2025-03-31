<?php
session_start();
include 'dbconnection.php';

// Check if user is logged in
$isLoggedIn = isset($_SESSION['currUserID']);
$isHospitalLoggedIn = isset($_SESSION['hospital_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Hemova</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    .flip-card {
        background-color: transparent;
        width: 350px;
        height: 450px;
        perspective: 1000px;
        font-family: sans-serif;
        opacity: 0;
        transform: translateX(-100px);
        transition: all 0.8s ease-out;
    }

    .flip-card.slide-in {
        opacity: 1;
        transform: translateX(0);
    }

    /* Add staggered delay for each card */
    .flip-card:nth-child(1).slide-in { transition-delay: 0.1s; }
    .flip-card:nth-child(2).slide-in { transition-delay: 0.3s; }
    .flip-card:nth-child(3).slide-in { transition-delay: 0.5s; }
    .flip-card:nth-child(4).slide-in { transition-delay: 0.7s; }

    .title {
        font-size: 1.5em;
        font-weight: 900;
        text-align: center;
        margin: 0;
        color: white;
    }

    .flip-card-inner {
        position: relative;
        width: 100%;
        height: 100%;
        text-align: center;
        transition: transform 0.8s;
        transform-style: preserve-3d;
    }

    .flip-card:hover .flip-card-inner {
        transform: rotateY(180deg);
    }

    .flip-card-front, .flip-card-back {
        position: absolute;
        display: flex;
        flex-direction: column;
        justify-content: center;
        width: 100%;
        height: 100%;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        border-radius: 1rem;
        color: white;
        background: rgba(220, 38, 38, 0.85);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
    }

    .flip-card-front {
        background: linear-gradient(135deg,
            rgba(220, 38, 38, 0.85),
            rgba(239, 68, 68, 0.85)
        );
    }

    .flip-card-back {
        background: linear-gradient(135deg,
            rgba(239, 68, 68, 0.85),
            rgba(220, 38, 38, 0.85)
        );
        transform: rotateY(180deg);
    }

    /* Optional: Add hover effect */
    .flip-card:hover .flip-card-front,
    .flip-card:hover .flip-card-back {
        border-color: rgba(255, 255, 255, 0.3);
    }

        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            overflow-x: hidden;
            color: #fff;
            background-color: #0a0a0a;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        /* 3D Background Effect */
        #bg-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .bg-circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(200, 0, 0, 0.1);
            box-shadow: 0 0 20px rgba(200, 0, 0, 0.3);
            animation: float 15s infinite ease-in-out;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(5deg);
            }
        }

        /* Updated Navigation Styles */
        header {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 20px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 100;
            background: rgba(10, 10, 10, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(200, 0, 0, 0.3);
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo i {
            color: #ff0000;
            font-size: 2.5rem;
            margin-right: 10px;
        }

        .logo h1 {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(to right, #ff0000, #ff6b6b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 30px;
            align-items: center;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
            position: relative;
            font-size: 1rem;
        }

        nav ul li a:hover {
            color: #ff0000;
        }

        nav ul li a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background: #ff0000;
            bottom: -5px;
            left: 0;
            transition: width 0.3s;
        }

        nav ul li a:hover::after {
            width: 100%;
        }

        .cta-button {
            background: linear-gradient(45deg, #ff0000, #c70000);
            color: white;
            padding: 10px 25px;
            border-radius: 30px;
            font-weight: 600;
            transition: transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 4px 15px rgba(255, 0, 0, 0.3);
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255, 0, 0, 0.4);
            color: white;
            background: linear-gradient(45deg, #c70000, #ff0000);
        }

        @media (max-width: 768px) {
            nav ul {
                gap: 15px;
            }

            .logo h1 {
                font-size: 1.5rem;
            }

            .logo i {
                font-size: 2rem;
            }

            nav ul li a {
                font-size: 0.9rem;
            }
        }

        /* Hero Section Styles */
.hero {
    min-height: 100vh;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    padding: 6rem 10% 2rem 10%;
    position: relative;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(10px);
    margin: 0;
}

.hero-content {
    max-width: 600px;
    opacity: 1;
    z-index: 10;
    animation: fadeIn 1s ease-out;
}

.hero h2 {
    font-size: 4rem;
    font-weight: bold;
    margin-bottom: 1.5rem;
    line-height: 1.2;
    color: white;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

.hero h2 span {
    color: #ff0000;
    text-shadow: 2px 2px 4px rgba(255, 0, 0, 0.3);
}

.hero p {
    font-size: 1.25rem;
    margin-bottom: 2rem;
    line-height: 1.6;
    color: white;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero h2 {
        font-size: 2.5rem;
    }

    .hero-buttons {
        flex-direction: column;
        gap: 15px;
    }
}

/* Table Reveal Animation */
.reveal {
    position: relative;
    opacity: 0;
    transform: translateY(150px);
    transition: all 1s ease;
}

.reveal.active {
    opacity: 1;
    transform: translateY(0);
}

/* Optional: Add stagger effect to table rows */
.reveal tbody tr {
    opacity: 0;
    transform: translateX(-100px);
    transition: all 0.5s ease;
}

.reveal.active tbody tr {
    opacity: 1;
    transform: translateX(0);
}

.reveal.active tbody tr:nth-child(1) { transition-delay: 0.1s; }
.reveal.active tbody tr:nth-child(2) { transition-delay: 0.2s; }
.reveal.active tbody tr:nth-child(3) { transition-delay: 0.3s; }
.reveal.active tbody tr:nth-child(4) { transition-delay: 0.4s; }
.reveal.active tbody tr:nth-child(5) { transition-delay: 0.5s; }
.reveal.active tbody tr:nth-child(6) { transition-delay: 0.6s; }
.reveal.active tbody tr:nth-child(7) { transition-delay: 0.7s; }
.reveal.active tbody tr:nth-child(8) { transition-delay: 0.8s; }
    </style>    
</head>
<body>
<div id="bg-container"></div>
    <!-- Navigation Bar -->
    <nav class="fixed top-0 left-0 z-50 w-full bg-transparent border-b backdrop-blur-sm border-white/10">
        <div class="container flex items-center justify-between p-4 mx-auto">
            <a href="index.php" class="text-2xl font-bold text-white transition-colors hover:text-red-500">Hemova</a>
            <div class="flex items-center space-x-4">
                <?php if ($isLoggedIn): ?>
                    <a href="profile.php" class="transition text-white/90 hover:text-red-500">Profile</a>
                    <a href="check_blood_availability.php" class="transition text-white/90 hover:text-red-500">Check Blood</a>
                    <a href="view_camps.php" class="transition text-white/90 hover:text-red-500">View Camps</a>
                    <a href="about.php" class="transition text-white/90 hover:text-red-500">About</a>
                    <a href="logout.php" class="px-4 py-2 text-white transition rounded bg-red-600/80 hover:bg-red-700">Logout</a>
                <?php elseif ($isHospitalLoggedIn): ?>
                    <a href="managecamps.php" class="transition text-white/90 hover:text-red-500">Manage Camps</a>
                    <a href="logout.php" class="px-4 py-2 text-white transition rounded bg-red-600/80 hover:bg-red-700">Logout</a>
                <?php else: ?>
                    <a href="signin.php" class="transition text-white/90 hover:text-red-500">Sign In</a>
                    <a href="signup.php" class="transition text-white/90 hover:text-red-500">Sign Up</a>
                    <a href="hospitalLogin.php" class="transition text-white/90 hover:text-red-500">Hospital Login</a>
                    <a href="hospitalRegister.html" class="transition text-white/90 hover:text-red-500">Hospital Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>



    <section class="hero" id="home">
        <div class="hero-content">
            <h2>Give Blood, <span>Save Lives</span></h2>
            <p>Join Hemova's network of life-savers. Every donation can help up to 3 people in need. Your simple act of kindness can make a world of difference to someone in crisis.</p>
            <div class="flex gap-4 hero-buttons">
                <a href="#donate" class="px-6 py-3 text-white transition-all duration-300 rounded-full bg-gradient-to-r from-red-600 to-red-700 hover:shadow-lg hover:-translate-y-1">Donate Now</a>
                <a href="#learn" class="px-6 py-3 text-white transition-all duration-300 border-2 border-white rounded-full hover:bg-white hover:text-red-600">Learn More</a>
            </div>
        </div>
    </section>
<div class="flex flex-wrap justify-center gap-8 mt-8">
    <!-- Flip Card 1 -->
    <div class="flip-card">
        <div class="flip-card-inner">
            <div class="flip-card-front">
                <p class="title">Why Donate Blood?</p>
                <i class="mb-4 text-5xl fas fa-heart"></i>
                <p>One donation can save up to three lives</p>
                <p class="mt-4 text-sm">(Hover to learn more)</p>
            </div>
            <div class="flip-card-back">
                <p class="title">Benefits</p>
                <ul class="px-4 mt-4 text-left">
                    <li>• Free health screening</li>
                    <li>• Burns calories</li>
                    <li>• Reduces risk of heart disease</li>
                    <li>• Helps others in emergency</li>
                    <li>• Regular health updates</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Flip Card 2 -->
    <div class="flip-card">
        <div class="flip-card-inner">
            <div class="flip-card-front">
                <p class="title">Donation Process</p>
                <i class="mb-4 text-5xl fas fa-procedures"></i>
                <p>Simple 4-step process</p>
                <p class="mt-4 text-sm">(Hover to learn more)</p>
            </div>
            <div class="flip-card-back">
                <p class="title">Steps</p>
                <ul class="px-4 mt-4 text-left">
                    <li>1. Registration</li>
                    <li>2. Medical screening</li>
                    <li>3. Blood donation (15 min)</li>
                    <li>4. Refreshments & rest</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Flip Card 3 -->
    <div class="flip-card">
        <div class="flip-card-inner">
            <div class="flip-card-front">
                <p class="title">Blood Types Needed</p>
                <i class="mb-4 text-5xl fas fa-tint"></i>
                <p>All blood types welcome</p>
                <p class="mt-4 text-sm">(Hover to learn more)</p>
            </div>
            <div class="flip-card-back">
                <p class="title">Most Needed Types</p>
                <ul class="px-4 mt-4 text-left">
                    <li>• O Negative (Universal)</li>
                    <li>• O Positive</li>
                    <li>• A Negative</li>
                    <li>• B Negative</li>
                    <li>• Platelets from all types</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Flip Card 4 -->
    <div class="flip-card">
        <div class="flip-card-inner">
            <div class="flip-card-front">
                <p class="title">Next Steps</p>
                <i class="mb-4 text-5xl fas fa-clipboard-check"></i>
                <p>Ready to donate?</p>
                <p class="mt-4 text-sm">(Hover to learn more)</p>
            </div>
            <div class="flip-card-back">
                <p class="title">Get Started</p>
                <ul class="px-4 mt-4 text-left">
                    <li>• Sign up online</li>
                    <li>• Find nearest center</li>
                    <li>• Schedule appointment</li>
                    <li>• Complete pre-screening</li>
                    <li>• Bring valid ID</li>
                </ul>
            </div>
        </div>
    </div>
</div>

    <!-- Blood Group Compatibility Section -->
    <section id="eligibility" class="container px-4 py-12 mx-auto bg-transparent rounded-lg shadow-md reveal">
        <h2 class="mb-8 text-3xl font-bold text-center text-white">Blood Group Compatibility</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-white bg-red-600/80">
                        <th class="p-4">Blood Type</th>
                        <th class="p-4">Can Donate To</th>
                        <th class="p-4">Can Receive From</th>
                    </tr>
                </thead>
                <tbody class="text-white">
                    <tr class="border-b border-white/10 hover:bg-white/5">
                        <td class="p-4">A+</td>
                        <td class="p-4">A+, AB+</td>
                        <td class="p-4">A+, A-, O+, O-</td>
                    </tr>
                    <tr class="border-b border-white/10 hover:bg-white/5">
                        <td class="p-4">A-</td>
                        <td class="p-4">A+, A-, AB+, AB-</td>
                        <td class="p-4">A-, O-</td>
                    </tr>
                    <tr class="border-b border-white/10 hover:bg-white/5">
                        <td class="p-4">B+</td>
                        <td class="p-4">B+, AB+</td>
                        <td class="p-4">B+, B-, O+, O-</td>
                    </tr>
                    <tr class="border-b border-white/10 hover:bg-white/5">
                        <td class="p-4">B-</td>
                        <td class="p-4">B+, B-, AB+, AB-</td>
                        <td class="p-4">B-, O-</td>
                    </tr>
                    <tr class="border-b border-white/10 hover:bg-white/5">
                        <td class="p-4">AB+</td>
                        <td class="p-4">AB+</td>
                        <td class="p-4">All Blood Types</td>
                    </tr>
                    <tr class="border-b border-white/10 hover:bg-white/5">
                        <td class="p-4">AB-</td>
                        <td class="p-4">AB+, AB-</td>
                        <td class="p-4">AB-, A-, B-, O-</td>
                    </tr>
                    <tr class="border-b border-white/10 hover:bg-white/5">
                        <td class="p-4">O+</td>
                        <td class="p-4">O+, A+, B+, AB+</td>
                        <td class="p-4">O+, O-</td>
                    </tr>
                    <tr class="border-b border-white/10 hover:bg-white/5">
                        <td class="p-4">O-</td>
                        <td class="p-4">All Blood Types</td>
                        <td class="p-4">O-</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Eligibility Criteria Section -->
    <section class="container px-4 py-12 mx-auto">
        <h2 class="mb-8 text-3xl font-bold text-center text-gray-800">Who Can Donate?</h2>
        <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
            <div class="p-6 rounded-lg shadow-md bg-green-50">
                <h3 class="mb-4 text-xl font-semibold text-green-600">Eligible Donors</h3>
                <ul class="pl-5 space-y-2 text-gray-700 list-disc">
                    <li>Age: 17-65 (16 with parental consent in some regions)</li>
                    <li>Weight: At least 110 lbs (50 kg)</li>
                    <li>Good general health</li>
                    <li>No recent tattoos or piercings (within 6 months)</li>
                    <li>No cold, flu, or fever on donation day</li>
                </ul>
            </div>
            <div class="p-6 rounded-lg shadow-md bg-red-50">
                <h3 class="mb-4 text-xl font-semibold text-red-600">Cannot Donate</h3>
                <ul class="pl-5 space-y-2 text-gray-700 list-disc">
                    <li>Pregnant or breastfeeding women</li>
                    <li>Recent surgery or blood transfusion (within 6 months)</li>
                    <li>Chronic illnesses (e.g., diabetes, heart disease)</li>
                    <li>HIV/AIDS or hepatitis positive</li>
                    <li>Under medication for serious conditions</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Donation Facts Section -->
    <section class="container px-4 py-12 mx-auto bg-gray-200">
        <h2 class="mb-8 text-3xl font-bold text-center text-gray-800">Blood Donation Facts</h2>
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
            <div class="p-6 text-center bg-white rounded-lg shadow-md">
                <i class="mb-4 text-3xl text-red-600 fas fa-tint"></i>
                <p class="text-lg font-semibold">1 Donation = 3 Lives</p>
                <p class="text-gray-600">Each donation can help multiple patients.</p>
            </div>
            <div class="p-6 text-center bg-white rounded-lg shadow-md">
                <i class="mb-4 text-3xl text-red-600 fas fa-clock"></i>
                <p class="text-lg font-semibold">EveryCUL8 Every 8 Weeks</p>
                <p class="text-gray-600">You can donate every 56 days, up to 6 times a year.</p>
            </div>
            <div class="p-6 text-center bg-white rounded-lg shadow-md">
                <i class="mb-4 text-3xl text-red-600 fas fa-users"></i>
                <p class="text-lg font-semibold">High Demand</p>
                <p class="text-gray-600">Someone needs blood every 2 seconds.</p>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section id="signup" class="container px-4 py-12 mx-auto text-center">
        <h2 class="mb-4 text-3xl font-bold text-gray-800">Ready to Make a Difference?</h2>
        <p class="mb-6 text-gray-600">Join our community of donors and help save lives today!</p>
        <a href="signup.php" class="px-6 py-3 font-semibold text-white transition bg-red-600 rounded-full hover:bg-red-700">Sign Up Now</a>
    </section>

    <!-- Footer -->
    <footer class="py-6 text-white bg-gray-800">
        <div class="container px-4 mx-auto text-center">
            <p>&copy; 2025 Hemova. All rights reserved.</p>
            <div class="flex justify-center mt-4 space-x-4">
                <a href="#" class="hover:text-red-600"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="hover:text-red-600"><i class="fab fa-twitter"></i></a>
                <a href="#" class="hover:text-red-600"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bgContainer = document.getElementById('bg-container');
            const colors = ['rgba(200, 0, 0, 0.1)', 'rgba(150, 0, 0, 0.1)', 'rgba(255, 50, 50, 0.1)'];
            
            // Create floating circles
            for (let i = 0; i < 15; i++) {
                const circle = document.createElement('div');
                circle.classList.add('bg-circle');
                
                // Random properties
                const size = Math.random() * 200 + 50;
                const posX = Math.random() * 100;
                const posY = Math.random() * 100;
                const color = colors[Math.floor(Math.random() * colors.length)];
                const delay = Math.random() * 15;
                const duration = Math.random() * 10 + 10;
                
                // Apply styles
                circle.style.width = `${size}px`;
                circle.style.height = `${size}px`;
                circle.style.left = `${posX}%`;
                circle.style.top = `${posY}%`;
                circle.style.background = color;
                circle.style.animationDelay = `${delay}s`;
                circle.style.animationDuration = `${duration}s`;
                
                bgContainer.appendChild(circle);
            }

            // Reveal animation for table
            const revealElements = document.querySelectorAll('.reveal');
            const revealOnScroll = () => {
                revealElements.forEach(element => {
                    const rect = element.getBoundingClientRect();
                    if (rect.top < window.innerHeight && rect.bottom > 0) {
                        element.classList.add('active');
                    }
                });
            };

            window.addEventListener('scroll', revealOnScroll);
            revealOnScroll();
        });

        // Reveal animation on scroll
        function reveal() {
            const reveals = document.querySelectorAll('.reveal');
            
            reveals.forEach(element => {
                const windowHeight = window.innerHeight;
                const elementTop = element.getBoundingClientRect().top;
                const elementVisible = 150; // Adjust this value to change when the animation triggers
                
                if (elementTop < windowHeight - elementVisible) {
                    element.classList.add('active');
                }
            });
        }

        // Add scroll event listener
        window.addEventListener('scroll', reveal);
        // Trigger on initial load
        reveal();

        // Flip cards slide-in animation
        function animateFlipCards() {
            const cards = document.querySelectorAll('.flip-card');
            
            cards.forEach(card => {
                const cardTop = card.getBoundingClientRect().top;
                const cardBottom = card.getBoundingClientRect().bottom;
                const windowHeight = window.innerHeight;
                
                if (cardTop < windowHeight - 100 && cardBottom > 0) {
                    card.classList.add('slide-in');
                }
            });
        }

        // Add scroll event listener for flip cards
        window.addEventListener('scroll', animateFlipCards);
        // Trigger on initial load
        animateFlipCards();
    </script>
</body>
</html>