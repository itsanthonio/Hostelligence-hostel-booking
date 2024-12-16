<?php
session_start();
include('includes/config.php');
date_default_timezone_set('Asia/Kolkata');
include('includes/checklogin.php');
check_login();
$aid = $_SESSION['id'];

// Handle profile update
if (isset($_POST['update'])) {
    $regno = $_POST['regno'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $contactno = $_POST['contact'];
    $udate = date('Y-m-d H:i:s', time());

    $query = "UPDATE userRegistration SET regNo=?, firstName=?, middleName=?, lastName=?, gender=?, contactNo=?, updationDate=? WHERE id=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('sssssssi', $regno, $fname, $mname, $lname, $gender, $contactno, $udate, $aid);
    $stmt->execute();
    echo "<script>alert('Profile updated successfully');</script>";
}

// Handle profile deletion
if (isset($_POST['delete'])) {
    // Delete from `registration` table
    $del_registration = "DELETE FROM registration WHERE regNo=(SELECT regNo FROM userRegistration WHERE id=?)";
    $stmt1 = $mysqli->prepare($del_registration);
    $stmt1->bind_param('i', $aid);
    $stmt1->execute();

    // Delete from `userRegistration` table
    $del_userRegistration = "DELETE FROM userRegistration WHERE id=?";
    $stmt2 = $mysqli->prepare($del_userRegistration);
    $stmt2->bind_param('i', $aid);
    $stmt2->execute();

    // Destroy session and redirect to home page
    session_destroy();
    echo "<script>
            alert('Profile deleted successfully. You will be logged out.');
            window.location.href = 'HostelManagement/index.php';
          </script>";
    exit();
}

// Fetch user profile
$ret = "SELECT * FROM userRegistration WHERE id=?";
$stmt = $mysqli->prepare($ret);
$stmt->bind_param('i', $aid);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_object();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Updation</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <script>
        function confirmDeletion() {
            return confirm("Are you sure you want to delete your profile? This will also book you out of the existing room.");
        }
    </script>
</head>
<body class="bg-gray-100 min-h-screen">
<nav class="bg-white shadow-lg fixed w-full top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            <div class="flex items-center">
                <h1 class="text-3xl font-serif font-bold text-gray-800">HOSTELLIGENCE</h1>
            </div>
            <div class="flex items-center space-x-4">
                <a href="dashboard.php" class="text-gray-600 hover:text-gray-800">Dashboard</a>
                <a href="my-profile.php" class="text-gray-600 hover:text-gray-800">My Account</a>
                <a href="actions/logout.php" class="text-gray-600 hover:text-red-600">Logout</a>
            </div>
        </div>
    </div>
</nav>
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-28 pb-12">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-4"><?php echo $row->firstName; ?>'s Profile</h2>
        <p class="text-sm text-gray-600 mb-6">Last updated on: <?php echo $row->updationDate; ?></p>

        <form method="post" action="" class="space-y-6">
            <!-- Profile Update Fields -->
            <div>
                <label for="regno" class="block text-sm font-medium text-gray-700">Registration No</label>
                <input type="text" name="regno" id="regno" value="<?php echo $row->regNo; ?>" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>

            <div>
                <label for="fname" class="block text-sm font-medium text-gray-700">First Name</label>
                <input type="text" name="fname" id="fname" value="<?php echo $row->firstName; ?>" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>

            <div>
                <label for="mname" class="block text-sm font-medium text-gray-700">Middle Name</label>
                <input type="text" name="mname" id="mname" value="<?php echo $row->middleName; ?>" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            <div>
                <label for="lname" class="block text-sm font-medium text-gray-700">Last Name</label>
                <input type="text" name="lname" id="lname" value="<?php echo $row->lastName; ?>" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>

            <div>
                <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                <select name="gender" id="gender" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    <option value="<?php echo $row->gender; ?>" selected><?php echo ucfirst($row->gender); ?></option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="others">Others</option>
                </select>
            </div>

            <div>
                <label for="contact" class="block text-sm font-medium text-gray-700">Contact No</label>
                <input type="text" name="contact" id="contact" value="<?php echo $row->contactNo; ?>" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" maxlength="10" required>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="<?php echo $row->email; ?>" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
            </div>
                        <!-- Change Password Link -->
            <div class="mt-4 text-center">
                <a href="actions/change-password.php" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                    Change Password
                </a>
            </div>

            <!-- Buttons -->
            <div class="flex justify-between items-center">
                <button type="submit" name="update" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Update Profile</button>
                <button type="submit" name="delete" class="bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2" onclick="return confirmDeletion()">Delete Profile</button>
            </div>
        </form>
    </div>
</main>
</body>
</html>
