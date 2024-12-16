<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

$user_id = $_SESSION['id'];

// Check if user already has a booking
$query = "SELECT COUNT(*) as booking_count FROM registration WHERE regno = (SELECT regNo FROM userRegistration WHERE id = ?)";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if($row['booking_count'] > 0) {
    echo "<script>
        alert('You already have an active booking. Redirecting to your bookings.');
        window.location.href = 'view/room-details.php';
    </script>";
    exit;
} 

// Fetch the room details from the rooms table based on the room_id passed in the URL
if (isset($_GET['room_id'])) {
    $room_id = (int)$_GET['room_id'];

    // Query to fetch the room details
    $query = "SELECT room_no, seater, fees FROM rooms WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $room_id);
    $stmt->execute();
    $stmt->bind_result($roomNo, $seater, $feespm);
    $stmt->fetch();
    $stmt->close();
} else {
    // Redirect if room_id is not set
    header('Location: new_booking.php');
    exit;
}

// Fetch the Registration Number for the user from the userRegistration table
$query = "SELECT regNo FROM userRegistration WHERE id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($regNo);
$stmt->fetch();
$stmt->close();

// If the form is submitted, insert the data into the registration table
if (isset($_POST['submit'])) {
    $roomno = $_POST['roomno'];
    $seater = $_POST['seater'];
    $feespm = $_POST['feespm'];
    $stayfrom = date('Y-m-d H:i:s', time());
    $duration = $_POST['duration'];
    // Convert course to proper format
    $course = ucwords(str_replace('_', ' ', $_POST['course']));
    $regno = $_POST['regno'];
    $firstName = $_POST['fname'];
    $middleName = $_POST['mname'];
    $lastName = $_POST['lname'];
    $gender = $_POST['gender'];
    $contactno = $_POST['contact'];
    $emailid = $_POST['email'];
    // Properly handle guardian information
    $guardianName = isset($_POST['guardianName']) ? trim($_POST['guardianName']) : '';
    $guardianRelation = isset($_POST['guardianRelation']) ? trim($_POST['guardianRelation']) : '';
    $guardianContactno = isset($_POST['guardianContactno']) ? trim($_POST['guardianContactno']) : '';

    // Check if email already exists
    $query = "SELECT * FROM registration WHERE emailid = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $emailid);
    $stmt->execute();
    $stmt->store_result();
    
    if($stmt->num_rows > 0) {
        echo "<script>alert('Email already exists!');</script>";
    } else {
        // If email is available, proceed with registration
        $query = "INSERT INTO registration 
        (roomno, seater, feespm, stayfrom, duration, course, regno, 
         firstName, middleName, lastName, gender, contactno, emailid, 
         guardianName, guardianRelation, guardianContactno, 
         postingDate, updationDate) 
        VALUES 
        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
        CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
    
        $stmt = $mysqli->prepare($query);

        $contactno = strval($contactno);
        $guardianContactno = strval($guardianContactno);
        $regno = strval($regno);

        $stmt->bind_param(
            "iiisisssssssssss",  
            $roomno, $seater, $feespm, $stayfrom, $duration, $course,
            $regno, $firstName, $middleName, $lastName, $gender,
            $contactno, $emailid, $guardianName, $guardianRelation,
            $guardianContactno
        );
        
        $stmt->execute();
        
        if($stmt->affected_rows > 0) {
            echo "<script>
                alert('Student Successfully Registered');
                window.location.href = 'view/bookings.php';
            </script>";
        } else {
            echo "<script>
                alert('Error in registration. Please try again.');
            </script>";
        }
    }
}
?>

<!doctype html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">
    <title>User Registration</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full bg-gray-100">
  
    <div class="min-h-screen">
       
        <div class="lg:pl-64">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="py-6">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Room Registration</h2>
                    <div class="bg-white rounded-lg shadow">
                        <div class="bg-blue-600 text-white px-6 py-4 rounded-t-lg">
                            <h3 class="text-lg font-medium">Fill all Info</h3>
                        </div>
                        <div class="p-6">
                            <form method="post" action="" name="registration" class="space-y-6" onSubmit="return valid();">
                                
                                <!-- Registration Number -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                                    <label class="block text-sm font-medium text-gray-700">Registration No:</label>
                                    <div class="md:col-span-2">
                                        <input type="text" name="regno" id="regno" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="<?php echo $regNo; ?>" readonly required>
                                    </div>
                                </div>

                                <!-- Room Number -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                                    <label class="block text-sm font-medium text-gray-700">Room No:</label>
                                    <div class="md:col-span-2">
                                        <input type="text" name="roomno" id="roomno" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="<?php echo $roomNo; ?>" readonly required>
                                    </div>
                                </div>

                                <!-- Seater -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                                    <label class="block text-sm font-medium text-gray-700">Seater:</label>
                                    <div class="md:col-span-2">
                                        <input type="text" name="seater" id="seater" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="<?php echo $seater; ?>" readonly required>
                                    </div>
                                </div>

                                <!-- Fees per Month -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                                    <label class="block text-sm font-medium text-gray-700">Fees per Month:</label>
                                    <div class="md:col-span-2">
                                        <input type="text" name="feespm" id="feespm" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="<?php echo $feespm; ?>" readonly required>
                                    </div>
                                </div>

                                <!-- Stay From -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                                    <label class="block text-sm font-medium text-gray-700">Stay From:</label>
                                    <div class="md:col-span-2">
                                        <input type="datetime-local" name="stayfrom" id="stayfrom" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    </div>
                                </div>

                                <!-- Duration -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                                    <label class="block text-sm font-medium text-gray-700">Duration(Months):</label>
                                    <div class="md:col-span-2">
                                        <input type="number" name="duration" id="duration" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    </div>
                                </div>

                                <!-- Course -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                                    <label class="block text-sm font-medium text-gray-700">Course:</label>
                                    <div class="md:col-span-2">
                                        <select name="course" id="course" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                            <option value="">Select Course</option>
                                            <option value="computer_science">Computer Science</option>
                                            <option value="business_administration">Business Administration</option>
                                            <option value="engineering">Engineering</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Personal Information Section -->
                                <div class="border-t border-gray-200 pt-6">
                                    <h4 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h4>
                                    
                                    <!-- Name Fields -->
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">First Name</label>
                                            <input type="text" name="fname" id="fname" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Middle Name</label>
                                            <input type="text" name="mname" id="mname" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Last Name</label>
                                            <input type="text" name="lname" id="lname" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                        </div>
                                    </div>

                                    <!-- Gender -->
                                    <div class="mt-6">
                                        <label class="block text-sm font-medium text-gray-700">Gender</label>
                                        <select name="gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                            <option value="">Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="others">Others</option>
                                        </select>
                                    </div>

                                    <!-- Contact Details -->
                                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Contact No</label>
                                            <input type="text" name="contact" id="contact" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Email</label>
                                            <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" onBlur="checkAvailability()" required>
                                            <span id="user-availability-status" class="text-sm"></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Guardian Information Section -->
                                <div class="border-t border-gray-200 pt-6">
                                    <h4 class="text-lg font-medium text-gray-900 mb-4">Guardian Information</h4>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Guardian Name</label>
                                            <input type="text" name="guardianName" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Guardian Relation</label>
                                            <input type="text" name="guardianRelation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Guardian Contact</label>
                                            <input type="text" name="guardianContactno" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="pt-6">
                                    <button type="submit" name="submit" class="w-full md:w-auto px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Register
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>const REGEX = {
    name: /^[a-zA-Z\s]{2,30}$/,
    contact: /^\d{10}$/,
    email: /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/,
    guardianContact: /^\d{10}$/
};

// Create duration spinner
document.addEventListener('DOMContentLoaded', function() {
    const durationInput = document.getElementById('duration');
    const wrapper = durationInput.parentElement;
    
    // Create spinner container
    const spinnerContainer = document.createElement('div');
    spinnerContainer.className = 'relative flex items-center';
    
    // Wrap input in container
    durationInput.parentNode.insertBefore(spinnerContainer, durationInput);
    spinnerContainer.appendChild(durationInput);
    
    // Create spinner buttons
    const spinnerButtons = document.createElement('div');
    spinnerButtons.className = 'absolute right-0 h-full flex flex-col border-l';
    spinnerButtons.innerHTML = `
        <button type="button" class="flex-1 px-2 bg-gray-50 hover:bg-gray-100 border-b">▲</button>
        <button type="button" class="flex-1 px-2 bg-gray-50 hover:bg-gray-100">▼</button>
    `;
    
    spinnerContainer.appendChild(spinnerButtons);
    
    // Add spinner functionality
    durationInput.value = '1'; // Default value
    
    spinnerButtons.querySelector('button:first-child').addEventListener('click', () => {
        let value = parseInt(durationInput.value) || 0;
        durationInput.value = value + 1;
    });
    
    spinnerButtons.querySelector('button:last-child').addEventListener('click', () => {
        let value = parseInt(durationInput.value) || 0;
        if (value > 1) {
            durationInput.value = value - 1;
        }
    });
    
    // Prevent manual input of negative numbers
    durationInput.addEventListener('input', function() {
        let value = parseInt(this.value) || 0;
        if (value < 1) {
            this.value = 1;
        }
    });
});

// Form validation
$(document).ready(function() {
    $.validator.addMethod("regex", function(value, element, regexp) {
        return regexp.test(value);
    });

    $("form[name='registration']").validate({
        rules: {
            fname: {
                required: true,
                regex: REGEX.name
            },
            mname: {
                regex: REGEX.name
            },
            lname: {
                required: true,
                regex: REGEX.name
            },
            contact: {
                required: true,
                regex: REGEX.contact
            },
            email: {
                required: true,
                regex: REGEX.email
            },
            guardianName: {
                required: true,
                regex: REGEX.name
            },
            guardianRelation: {
                required: true,
                regex: REGEX.name
            },
            guardianContactno: {
                required: true,
                regex: REGEX.guardianContact
            },
            duration: {
                required: true,
                min: 1
            }
        },
        messages: {
            fname: {
                required: "Please enter your first name",
                regex: "Please enter a valid name (2-30 letters only)"
            },
            mname: {
                regex: "Please enter a valid name (2-30 letters only)"
            },
            lname: {
                required: "Please enter your last name",
                regex: "Please enter a valid name (2-30 letters only)"
            },
            contact: {
                required: "Please enter your contact number",
                regex: "Please enter a valid 10-digit contact number"
            },
            email: {
                required: "Please enter your email",
                regex: "Please enter a valid email address"
            },
            guardianName: {
                required: "Please enter guardian name",
                regex: "Please enter a valid name (2-30 letters only)"
            },
            guardianRelation: {
                required: "Please enter guardian relation",
                regex: "Please enter a valid relation (2-30 letters only)"
            },
            guardianContactno: {
                required: "Please enter guardian contact number",
                regex: "Please enter a valid 10-digit contact number"
            },
            duration: {
                required: "Please enter duration",
                min: "Duration must be at least 1"
            }
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element).addClass('text-red-500 text-sm mt-1');
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});

// Email availability check
function checkAvailability() {
    const emailInput = $("#email");
    const statusSpan = $("#user-availability-status");
    
    jQuery.ajax({
        url: "HostelManagement/check_availability.php",
        data: 'email='+emailInput.val(),
        type: "POST",
        success: function(data) {
            statusSpan.html(data);
        },
        error: function() {
            statusSpan.html("Error checking availability");
        }
    });
}</script>
</body>
</html>