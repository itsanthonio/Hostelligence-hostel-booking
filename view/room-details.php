<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Room</title>
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
                    <a href="dashboard.php" class="text-gray-600 hover:text-gray-800">Dashboard</a>
                    <a href="my-profile.php" class="text-gray-600 hover:text-gray-800">My Account</a>
                    <a href="actions/logout.php" class="text-gray-600 hover:text-red-600">Logout</a>
                </div>
            </div>
        </div>
    </nav>


  
        <div class="flex-1 p-6">
            <h2 class="text-3xl font-semibold text-gray-800 mb-6">My Room Details</h2>
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Room Related Info</h4>
                <table class="min-w-full table-auto text-left">
                    <tbody>
                        <?php
                        $aid = $_SESSION['login'];
                        $ret = "SELECT * FROM registration WHERE emailid=?";
                        $stmt = $mysqli->prepare($ret);
                        $stmt->bind_param('s', $aid);
                        $stmt->execute();
                        $res = $stmt->get_result();
                        while ($row = $res->fetch_object()) {
                        ?>
                            <tr>
                                <td class="px-4 py-2 font-medium text-gray-700">Room No:</td>
                                <td class="px-4 py-2"><?php echo $row->roomno; ?></td>
                                <td class="px-4 py-2 font-medium text-gray-700">Seater:</td>
                                <td class="px-4 py-2"><?php echo $row->seater; ?></td>
                                <td class="px-4 py-2 font-medium text-gray-700">Fees/Month (GHS):</td>
                                <td class="px-4 py-2"><?php echo $row->feespm; ?></td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-medium text-gray-700">Stay From:</td>
                                <td class="px-4 py-2"><?php echo $row->stayfrom; ?></td>
                                <td class="px-4 py-2 font-medium text-gray-700">Duration:</td>
                                <td class="px-4 py-2"><?php echo $dr = $row->duration; ?> Months</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-medium text-gray-700" colspan="6">Total Fee (GHS): <?php echo $dr * $row->feespm; ?></td>
                            </tr>
                            <tr>
                                <td colspan="6" class="text-lg font-semibold text-gray-800 py-4">Personal Info</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-medium text-gray-700">Reg No:</td>
                                <td class="px-4 py-2"><?php echo $row->regno; ?></td>
                                <td class="px-4 py-2 font-medium text-gray-700">Full Name:</td>
                                <td class="px-4 py-2"><?php echo $row->firstName . " " . $row->middleName . " " . $row->lastName; ?></td>
                                <td class="px-4 py-2 font-medium text-gray-700">Email:</td>
                                <td class="px-4 py-2"><?php echo $row->emailid; ?></td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-medium text-gray-700">Contact No:</td>
                                <td class="px-4 py-2"><?php echo $row->contactno; ?></td>
                                <td class="px-4 py-2 font-medium text-gray-700">Gender:</td>
                                <td class="px-4 py-2"><?php echo $row->gender; ?></td>
                                <td class="px-4 py-2 font-medium text-gray-700">Course:</td>
                                <td class="px-4 py-2"><?php echo $row->course; ?></td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-medium text-gray-700">Guardian Name:</td>
                                <td class="px-4 py-2"><?php echo $row->guardianName; ?></td>
                                <td class="px-4 py-2 font-medium text-gray-700">Guardian Relation:</td>
                                <td class="px-4 py-2"><?php echo $row->guardianRelation; ?></td>
                                <td class="px-4 py-2 font-medium text-gray-700">Guardian Contact No:</td>
                                <td class="px-4 py-2"><?php echo $row->guardianContactno; ?></td>
                            </tr>

                            <!-- Display Roommates -->
                            <tr>
                                <td colspan="6" class="text-lg font-semibold text-gray-800 py-4">Roommates</td>
                            </tr>
                            <?php
                                $roommates_query = "SELECT firstName, middleName, lastName, emailid FROM registration WHERE roomno=? AND emailid != ?";
                                $stmt = $mysqli->prepare($roommates_query);
                                $stmt->bind_param('is', $row->roomno, $row->emailid);
                                $stmt->execute();
                                $roommates_res = $stmt->get_result();
                                while ($roommate = $roommates_res->fetch_object()) {
                            ?>
                            <tr>
                                <td class="px-4 py-2 font-medium text-gray-700">Roommate Name:</td>
                                <td class="px-4 py-2"><?php echo $roommate->firstName . " " . $roommate->middleName . " " . $roommate->lastName; ?></td>
                                <td class="px-4 py-2 font-medium text-gray-700">Email:</td>
                                <td class="px-4 py-2"><?php echo $roommate->emailid; ?></td>
                            </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="mt-6 flex justify-end">
                    <button onclick="confirmCancellation()" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-times-circle mr-2"></i>Cancel Booking
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
    function confirmCancellation() {
        if (confirm("Are you sure you want to cancel your booking? This action cannot be undone.")) {
            // Make AJAX call to cancel-booking.php
            fetch('actions/cancel-booking.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Booking cancelled successfully!");
                    window.location.href = 'view/dashboard.php'; // Redirect to dashboard
                } else {
                    alert("Error cancelling booking: " + data.message);
                }
            })
            .catch(error => {
                alert("An error occurred while cancelling the booking.");
                console.error('Error:', error);
            });
        }
    }
</script>
</body>

</html>
