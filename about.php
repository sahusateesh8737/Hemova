<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Hemova</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background-color: #050505;
            color: white;
            position: relative;
            overflow-x: hidden;
        }

        .gradient-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            overflow: hidden;
        }

        .gradient-sphere {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
        }

        .sphere-1 {
            width: 40vw;
            height: 40vw;
            background: linear-gradient(40deg, rgba(255, 0, 128, 0.8), rgba(255, 102, 0, 0.4));
            top: -10%;
            left: -10%;
            animation: float-1 15s ease-in-out infinite alternate;
        }

        .sphere-2 {
            width: 45vw;
            height: 45vw;
            background: linear-gradient(240deg, rgba(72, 0, 255, 0.8), rgba(0, 183, 255, 0.4));
            bottom: -20%;
            right: -10%;
            animation: float-2 18s ease-in-out infinite alternate;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1) !important;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }

        @keyframes float-1 {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(10%, 10%) scale(1.1); }
        }

        @keyframes float-2 {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(-10%, -5%) scale(1.15); }
        }

        /* Animation Keyframes */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Animation Classes */
        .animate-fade-up {
            opacity: 0;
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .animate-fade-left {
            opacity: 0;
            animation: fadeInLeft 0.6s ease-out forwards;
        }

        .animate-fade-right {
            opacity: 0;
            animation: fadeInRight 0.6s ease-out forwards;
        }

        /* Animation Delays */
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
        .delay-500 { animation-delay: 0.5s; }
    </style>
</head>
<body>
    <div class="gradient-background">
        <div class="gradient-sphere sphere-1"></div>
        <div class="gradient-sphere sphere-2"></div>
    </div>

    <!-- Navigation Bar -->
    <nav class="fixed top-0 left-0 z-50 w-full bg-transparent border-b backdrop-blur-sm border-white/10">
        <div class="container flex items-center justify-between p-4 mx-auto">
            <a href="index.php" class="text-2xl font-bold text-white transition-colors hover:text-red-500">Hemova</a>
            <div class="flex items-center space-x-4">
                <a href="profile.php" class="transition text-white/90 hover:text-red-500">Profile</a>
                <a href="check_blood_availability.php" class="transition text-white/90 hover:text-red-500">Check Blood</a>
                <a href="about.php" class="text-red-500">About</a>
                <a href="logout.php" class="px-4 py-2 text-white transition rounded bg-red-600/80 hover:bg-red-700">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative z-10 pt-32 pb-16">
        <div class="container px-4 mx-auto text-center">
            <h1 class="mb-4 text-4xl font-bold text-white animate-fade-up">About Hemova</h1>
            <p class="text-lg delay-200 text-white/70 animate-fade-up">Saving lives, one drop at a time. Join us in making a difference.</p>
        </div>
    </section>

    <!-- Mission Section -->
    <section class="relative z-10 py-16">
        <div class="container px-4 mx-auto">
            <div class="p-8 delay-300 glass-effect rounded-xl animate-fade-left">
                <h2 class="mb-6 text-3xl font-bold text-center text-white">Our Mission</h2>
                <p class="max-w-3xl mx-auto text-lg text-center text-white/70">
                    At Hemova, our mission is to connect blood donors with those in need, ensuring that no life is lost due to a lack of blood. We strive to create a community of compassionate individuals who are committed to saving lives.
                </p>
            </div>
        </div>
    </section>

    <!-- Vision Section -->
    <section class="relative z-10 py-16">
        <div class="container px-4 mx-auto">
            <div class="p-8 glass-effect rounded-xl animate-fade-right delay-400">
                <h2 class="mb-6 text-3xl font-bold text-center text-white">Our Vision</h2>
                <p class="max-w-3xl mx-auto text-lg text-center text-white/70">
                    We envision a world where every patient has access to safe and sufficient blood whenever and wherever it is needed. Together, we can make this vision a reality.
                </p>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="relative z-10 py-16">
        <div class="container px-4 mx-auto">
            <h2 class="mb-10 text-3xl font-bold text-center text-white">Why Donate Blood?</h2>
            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                <div class="p-6 text-center transition-transform duration-300 delay-300 glass-effect rounded-xl hover:-translate-y-2 animate-fade-up">
                    <div class="mb-4 text-3xl text-red-500">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3 class="mb-4 text-xl font-bold text-white">Save Lives</h3>
                    <p class="text-white/70">Your blood donation can save up to three lives. Be a hero today!</p>
                </div>
                <div class="p-6 text-center transition-transform duration-300 glass-effect rounded-xl hover:-translate-y-2 animate-fade-up delay-400">
                    <div class="mb-4 text-3xl text-red-500">
                        <i class="fas fa-hand-holding-medical"></i>
                    </div>
                    <h3 class="mb-4 text-xl font-bold text-white">Health Benefits</h3>
                    <p class="text-white/70">Donating blood can improve your cardiovascular health and reduce harmful iron stores.</p>
                </div>
                <div class="p-6 text-center transition-transform duration-300 delay-500 glass-effect rounded-xl hover:-translate-y-2 animate-fade-up">
                    <div class="mb-4 text-3xl text-red-500">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="mb-4 text-xl font-bold text-white">Community Impact</h3>
                    <p class="text-white/70">Join a community of donors and make a lasting impact on the lives of others.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="relative z-10 py-16">
        <div class="container px-4 mx-auto text-center">
            <div class="p-8 delay-300 glass-effect rounded-xl animate-fade-up">
                <h2 class="mb-6 text-3xl font-bold text-white">Ready to Make a Difference?</h2>
                <p class="mb-8 text-lg text-white/70">Join our community of blood donors and help save lives today.</p>
                <a href="check_blood_availability.php" 
                   class="px-6 py-3 text-white transition duration-200 transform rounded-lg bg-gradient-to-r from-red-600 to-red-700 hover:shadow-lg hover:-translate-y-0.5">
                    Check Blood Availability
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="relative z-10 py-6 mt-8 text-center border-t border-white/10">
        <div class="container px-4 mx-auto">
            <p class="text-white/50">&copy; 2025 Hemova. All rights reserved.</p>
        </div>
    </footer>

    <!-- Add JavaScript for scroll animations -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '50px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.animate-fade-up, .animate-fade-left, .animate-fade-right').forEach(el => {
            el.style.animationPlayState = 'paused';
            observer.observe(el);
        });
    });
    </script>
</body>
</html>