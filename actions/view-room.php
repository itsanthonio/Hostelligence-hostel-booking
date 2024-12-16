<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

// Fetch room details from the database
if (!isset($_GET['room_id'])) {
    header('Location: new_booking.php');
    exit;
}

$room_id = (int)$_GET['room_id'];

// Fetch room details
$room_query = "
    SELECT * FROM rooms WHERE id = ?
";
$stmt = $mysqli->prepare($room_query);
$stmt->bind_param("i", $room_id);
$stmt->execute();
$room_result = $stmt->get_result();
$room = $room_result->fetch_assoc();

if (!$room) {
    header('Location: new_booking.php');
    exit;
}

// Fetch room images
$image_query = "SELECT image_url FROM room_images WHERE room_id = ?";
$stmt = $mysqli->prepare($image_query);
$stmt->bind_param("i", $room_id);
$stmt->execute();
$image_result = $stmt->get_result();
$images = [];
while ($row = $image_result->fetch_assoc()) {
    $images[] = $row['image_url'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room <?= htmlspecialchars($room['room_no']) ?> - Hostel Management</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    .image-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); /* Adjusted min width for larger frames */
        gap: 1.5rem; /* Increased spacing between images */
    }

    .image-gallery img {
        object-fit: cover;
        height: 250px; /* Increased height */
        width: 100%;   /* Ensures responsiveness */
        border-radius: 12px; /* Retains the rounded corners */
    }
</style>

</head>

<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <h1 class="text-2xl font-serif font-bold text-gray-800">HOSTELLIGENCE</h1>
                <button onclick="window.history.back()" class="text-gray-600 hover:text-gray-800">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </button>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-12">
        <!-- Room Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-serif font-bold text-gray-900 mb-2">
                Room <?= htmlspecialchars($room['room_no']) ?>
            </h1>
        </div>

             <!-- Room Image Gallery -->
             <div class="mb-8">
            <h2 class="text-2xl font-bold mb-4">Room Facilities</h2>
            <div class="image-gallery">
                <?php if (!empty($images)): ?>
                    <?php foreach ($images as $image): ?>
                        <img src="<?= htmlspecialchars($image) ?>" alt="Room Image" class="shadow-md">
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-500">No images available for this room.</p>
                <?php endif; ?>
            </div>
        </div>

   

        <!-- Room Details -->
        <section class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <h2 class="text-2xl font-bold mb-4">Room Information</h2>
            <p class="text-gray-600 leading-relaxed">
                This is a <?= htmlspecialchars($room['seater']) ?>-seater room. It has a monthly fee of GHS <?= htmlspecialchars($room['fees']) ?>.
            </p>
        </section>

        <!-- Booking Button -->
        <section class="bg-white rounded-lg shadow-lg p-8">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold">Ready to Book?</h2>
                                            <!-- Book Now Button -->
                <a href="actions/book-hostel.php?room_id=<?= htmlspecialchars($room['id']) ?>" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-full">Book Now</a>

            </div>
        </section>
    </main>
</body>

</html>


