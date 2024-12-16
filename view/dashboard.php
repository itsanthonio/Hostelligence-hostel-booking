<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hostel Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center">
                    <h1 class="text-3xl font-serif font-bold text-gray-800">HOSTELLIGENCE</h1>
                </div>
					<div class="flex items-center space-x-4">
					<a href="my-profile.php" class="text-gray-600 hover:text-gray-800">
						My Account
					</a>
				   <a href="actions/logout.php" class="text-gray-600 hover:text-red-600">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-28 pb-12">
        <div class="mb-8">
            <h2 class="text-3xl font-serif font-bold text-gray-900">Hostel Dashboard</h2>
            <p class="text-gray-600">Access your profile, room details, and more.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Profile Section -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h3 class="text-xl font-semibold text-gray-700">My Profile</h3>
                <p class="mt-2 text-gray-500">View and update your personal details.</p>
                <a href="my-profile.php" class="block mt-4 text-blue-600 hover:text-blue-800">
                    View Details <i class="fa fa-arrow-right ml-2"></i>
                </a>
            </div>

            <!-- Room Details Section -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h3 class="text-xl font-semibold text-gray-700">My Room</h3>
                <p class="mt-2 text-gray-500">See details of your allocated room.</p>
                <a href="room-details.php" class="block mt-4 text-blue-600 hover:text-blue-800">
                    See All <i class="fa fa-arrow-right ml-2"></i>
                </a>
            </div>

            <!-- Book a Hostel Section -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h3 class="text-xl font-semibold text-gray-700">Book a Hostel</h3>
                <p class="mt-2 text-gray-500">Reserve your spot in the hostel of your choice.</p>
                <a href="bookings.php" class="block mt-4 text-blue-600 hover:text-blue-800">
                    Book Now <i class="fa fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </main>


    </footer>

    <script>
        document.getElementById('profileBtn').addEventListener('click', function () {
            alert('Profile button clicked.');
        });
    </script>
</body>

</html>
