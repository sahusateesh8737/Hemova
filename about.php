<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Hemova</title>
    <link rel="stylesheet" href="./src/output.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="bg-white shadow-md fixed top-0 left-0 w-full z-50">
        <div class="container mx-auto p-4 flex justify-between items-center">
            <a href="index.php" class="text-2xl font-bold">Hemova</a>
            <div>
                <a href="profile.php" class="text-gray-700 hover:text-gray-900 mx-2">Profile</a>
                <a href="check_blood_availability.php" class="text-gray-700 hover:text-gray-900 mx-2">Check Blood Availability</a>
                <a href="about.php" class="text-gray-700 hover:text-gray-900 mx-2">About</a>
                <a href="logout.php" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-red-500 text-white py-20 mt-16">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-bold mb-4">About Hemova</h1>
            <p class="text-lg">Saving lives, one drop at a time. Join us in making a difference.</p>
        </div>
    </section>

    <!-- Mission Section -->
    <section class="py-16 bg-gray-100">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Our Mission</h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                At Hemova, our mission is to connect blood donors with those in need, ensuring that no life is lost due to a lack of blood. We strive to create a community of compassionate individuals who are committed to saving lives.
            </p>
        </div>
    </section>

    <!-- Vision Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Our Vision</h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                We envision a world where every patient has access to safe and sufficient blood whenever and wherever it is needed. Together, we can make this vision a reality.
            </p>
        </div>
    </section>

    <!-- Benefits of Blood Donation -->
    <section class="py-16 bg-gray-100">
        <div class="container mx-auto">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">Why Donate Blood?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white shadow-md rounded-lg p-6 text-center">
                    <h3 class="text-xl font-bold text-red-500 mb-4">Save Lives</h3>
                    <p class="text-gray-600">Your blood donation can save up to three lives. Be a hero today!</p>
                </div>
                <div class="bg-white shadow-md rounded-lg p-6 text-center">
                    <h3 class="text-xl font-bold text-red-500 mb-4">Health Benefits</h3>
                    <p class="text-gray-600">Donating blood can improve your cardiovascular health and reduce harmful iron stores.</p>
                </div>
                <div class="bg-white shadow-md rounded-lg p-6 text-center">
                    <h3 class="text-xl font-bold text-red-500 mb-4">Community Impact</h3>
                    <p class="text-gray-600">Join a community of donors and make a lasting impact on the lives of others.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-16 bg-red-500 text-white">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold mb-6">Ready to Make a Difference?</h2>
            <p class="text-lg mb-8">Join our community of blood donors and help save lives today.</p>
            <a href="check_blood_availability.php" class="bg-white text-red-500 px-6 py-3 rounded-lg font-bold hover:bg-gray-100">Check Blood Availability</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2025 Hemova. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>