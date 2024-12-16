<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

// Get the logged-in user's gender
$aid = $_SESSION['id'];
$query_user = "SELECT gender FROM userregistration WHERE id=?";
$stmt_user = $mysqli->prepare($query_user);
$stmt_user->bind_param('i', $aid);
$stmt_user->execute();
$stmt_user->bind_result($user_gender);
$stmt_user->fetch();
$stmt_user->close();

// Base query to fetch rooms
$query = "SELECT * FROM rooms WHERE rgender='Both'";
if ($user_gender == 'male') {
    $query = "SELECT * FROM rooms WHERE rgender='Both' OR rgender='Male'";
} elseif ($user_gender == 'female') {
    $query = "SELECT * FROM rooms WHERE rgender='Both' OR rgender='Female'";
}

// Check for search input
$search_query = '';
if (isset($_GET['search'])) {
    $search_query = trim($_GET['search']);
    if (!empty($search_query)) {
        $query .= " AND (room_no LIKE ? OR seater LIKE ? OR fees LIKE ?)";
    }
}

// Prepare and execute the query
$stmt = $mysqli->prepare($query);
if (!empty($search_query)) {
    $search_param = '%' . $search_query . '%';
    $stmt->bind_param('sss', $search_param, $search_param, $search_param);
}
$stmt->execute();
$result = $stmt->get_result();

// Hardcoded room images array
$room_images = [
    '101' => 'room_101.jpg',
    '200' => 'room_200.jpg',
    '201' => 'room_201.jpg',
    '100' => 'room_100.jpg',
    '112' => 'room_112.jpg',
    '132' => 'room_132.jpg',
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Hostel</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                    <a href="view/dashboard.php" class="text-gray-600 hover:text-gray-800">Dashboard</a>
                    <a href="my-profile.php" class="text-gray-600 hover:text-gray-800">My Account</a>
                    <a href="actions/logout.php" class="text-gray-600 hover:text-red-600">Logout</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container mx-auto mt-20">
        <main class="container mx-auto px-4 py-6">

    
        <!-- Search Bar -->
            <form method="GET" action="" class="mb-6">
                <input 
                    type="text" 
                    name="search" 
                    value="<?= htmlspecialchars($search_query) ?>" 
                    placeholder="Search for rooms..." 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                <button 
                    type="submit" 
                    class="mt-2 w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">
                    Search
                </button>
            </form>
    </div>
        <!-- Room Listings -->
        <?php if ($result->num_rows > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <?php
                    // Assign an image based on room number
                    $room_image = isset($room_images[$row['room_no']]) ? $room_images[$row['room_no']] : 'placeholder.jpg';
                    ?>
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="p-4">
                            <!-- Room Image (Hardcoded) -->
                            <img src="images/<?= $room_image ?>" alt="Room <?= htmlspecialchars($row['room_no']) ?>" class="h-48 w-full object-cover mb-4">
                            <h2 class="text-lg font-bold mb-2">Room <?= htmlspecialchars($row['room_no']) ?></h2>
                            <p class="text-gray-600 mb-4">Seater: <?= htmlspecialchars($row['seater']) ?> | Price: <?= htmlspecialchars($row['fees']) ?>GHS per month</p>
                            <a href="actions/book-hostel.php?room_id=<?= $row['id'] ?>" class="block text-center bg-blue-500 text-white mt-4 py-2 rounded hover:bg-blue-600">Book Now</a>
                            <a href="actions/view-room.php?room_id=<?= $row['id'] ?>" class="block text-center bg-green-500 text-white mt-2 py-2 rounded hover:bg-green-600">View</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="text-center text-gray-600">No rooms available matching your search criteria. Please try again.</p>
        <?php endif; ?>
    </main>
</body>

</html>
