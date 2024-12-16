<?php
session_start();
include('includes/config.php');

// PHP Validation Function
function validateInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if(isset($_POST['submit']))
{
    $errors = array();
    
    // Validate Registration Number
    $regno = validateInput($_POST['regno']);
    if (!preg_match("/^[A-Z0-9]{6,10}$/", $regno)) {
        $errors[] = "Invalid registration number format";
    }
    
    // Validate Names
    $fname = validateInput($_POST['fname']);
    $mname = validateInput($_POST['mname']);
    $lname = validateInput($_POST['lname']);
    if (!preg_match("/^[a-zA-Z]{2,30}$/", $fname) || !preg_match("/^[a-zA-Z]{2,30}$/", $lname)) {
        $errors[] = "Names should only contain letters and be between 2-30 characters";
    }
    if (!empty($mname) && !preg_match("/^[a-zA-Z]{2,30}$/", $mname)) {
        $errors[] = "Middle name should only contain letters and be between 2-30 characters";
    }
    
    // Validate Gender
    $gender = validateInput($_POST['gender']);
    if (!in_array($gender, ['male', 'female', 'others'])) {
        $errors[] = "Invalid gender selection";
    }
    
    // Validate Contact Number
    $contactno = validateInput($_POST['contact']);
    if (!preg_match("/^[0-9]{10}$/", $contactno)) {
        $errors[] = "Contact number should be 10 digits";
    }
    
    // Validate Email
    $emailid = validateInput($_POST['email']);
    if (!filter_var($emailid, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    // Validate Password
    $password = validateInput($_POST['password']);
    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password)) {
        $errors[] = "Password must be at least 8 characters and contain uppercase, lowercase, number, and special character";
    }

    if(empty($errors)) {
        $password = password_hash($password, PASSWORD_DEFAULT); // Hash password
        $regDate = date('Y-m-d H:i:s', time());
        
        // Check if email already exists
        $stmt = $mysqli->prepare("SELECT email FROM userRegistration WHERE email = ?");
        $stmt->bind_param('s', $emailid);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows > 0) {
            echo "<script>alert('Email already registered!');</script>";
        } else {
            $query = "INSERT INTO userRegistration(regNo,firstName,middleName,lastName,gender,contactNo,email,password,regDate) VALUES (?,?,?,?,?,?,?,?,?)";
            $stmt = $mysqli->prepare($query);
            $rc = $stmt->bind_param('sssssisss',$regno,$fname,$mname,$lname,$gender,$contactno,$emailid,$password,$regDate);
            
            if($stmt->execute()) {
                echo "<script>
                    alert('Student Successfully registered');
                    window.location.href = 'actions/login.php';
                </script>";
                exit;
            } else {
                echo "<script>alert('Something went wrong. Please try again');</script>";
            }
        }
    } else {
        echo "<script>alert('".implode("\\n", $errors)."');</script>";
    }
}
?>


<!doctype html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">
    <title>Student Registration</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">
    <script type="text/javascript" src="js/jquery-1.11.3-jquery.min.js"></script>
    <script type="text/javascript" src="js/validation.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
    <script type="text/javascript">
    function valid() {
        if(document.registration.password.value != document.registration.cpassword.value) {
            alert("Password and Re-Type Password Field do not match!!");
            document.registration.cpassword.focus();
            return false;
        }
        return true;
    }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Blue theme styling */
        .input-field {
            background-color: #f1faff;
            border: 1px solid #cbd5e0;
            transition: all 0.3s ease;
        }
        .input-field:focus {
            border-color: #3b82f6; /* Blue focus border */
            box-shadow: none;
            outline: none;
        }
        .btn-blue {
            background-color: #3b82f6; /* Blue button */
            color: white;
            transition: all 0.3s ease;
        }
        .btn-blue:hover {
            background-color: #2563eb; /* Darker blue on hover */
        }
        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #3b82f6 #f1faff;
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1faff;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #3b82f6;
            border-radius: 3px;
        }
        .playfair {
            font-family: 'Playfair Display', serif;
        }
    </style>
    <script type="text/javascript">
    function valid() {
        var isValid = true;
        var errorMessage = "";

        // Registration Number Validation
        var regno = document.registration.regno.value;
        if(!/^[A-Z0-9]{6,10}$/.test(regno)) {
            errorMessage += "Registration number must be 6-10 characters of uppercase letters and numbers only\n";
            isValid = false;
        }

        // Name Validations
        var fname = document.registration.fname.value;
        var mname = document.registration.mname.value;
        var lname = document.registration.lname.value;
        
        if(!/^[a-zA-Z]{2,30}$/.test(fname)) {
            errorMessage += "First name must be 2-30 letters only\n";
            isValid = false;
        }
        
        if(mname && !/^[a-zA-Z]{2,30}$/.test(mname)) {
            errorMessage += "Middle name must be 2-30 letters only\n";
            isValid = false;
        }
        
        if(!/^[a-zA-Z]{2,30}$/.test(lname)) {
            errorMessage += "Last name must be 2-30 letters only\n";
            isValid = false;
        }

        // Contact Number Validation
        var contact = document.registration.contact.value;
        if(!/^[0-9]{10}$/.test(contact)) {
            errorMessage += "Contact number must be 10 digits\n";
            isValid = false;
        }

        // Email Validation
        var email = document.registration.email.value;
        if(!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
            errorMessage += "Please enter a valid email address\n";
            isValid = false;
        }

        // Password Validation
        var password = document.registration.password.value;
        var cpassword = document.registration.cpassword.value;
        
        if(!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(password)) {
            errorMessage += "Password must be at least 8 characters and contain uppercase, lowercase, number, and special character\n";
            isValid = false;
        }
        
        if(password !== cpassword) {
            errorMessage += "Password and Confirm Password do not match\n";
            isValid = false;
        }

        if(!isValid) {
            alert(errorMessage);
            return false;
        }
        return true;
    }

    // Real-time validation
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="password"]');
        
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });
        });
    });

    function validateField(field) {
        let isValid = true;
        const fieldName = field.name;
        const value = field.value;
        
        switch(fieldName) {
            case 'regno':
                isValid = /^[A-Z0-9]{6,10}$/.test(value);
                break;
            case 'fname':
            case 'lname':
                isValid = /^[a-zA-Z]{2,30}$/.test(value);
                break;
            case 'mname':
                isValid = value === '' || /^[a-zA-Z]{2,30}$/.test(value);
                break;
            case 'contact':
                isValid = /^[0-9]{10}$/.test(value);
                break;
            case 'email':
                isValid = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(value);
                break;
            case 'password':
                isValid = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(value);
                break;
        }
        
        if(!isValid && value !== '') {
            field.style.borderColor = '#ff0000';
        } else {
            field.style.borderColor = '#cbd5e0';
        }
    }
    </script>
</head>

<body class="h-screen bg-gray-50">
    <div class="h-screen flex">
        <!-- Form Section - Scrollable -->
        <div class="w-full md:w-1/2 overflow-y-auto custom-scrollbar p-6 md:p-12 bg-white">
            <div class="max-w-lg mx-auto">
                <h2 class="text-3xl font-bold mb-8 playfair text-blue-600">Student Registration</h2>
                <form method="post" action="" name="registration" class="space-y-6 form-horizontal" onSubmit="return valid();">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="regno">Registration No</label>
                        <input type="text" name="regno" id="regno" class="input-field w-full px-4 py-3 rounded-md" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="fname">First Name</label>
                        <input type="text" name="fname" id="fname" class="input-field w-full px-4 py-3 rounded-md" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="mname">Middle Name</label>
                        <input type="text" name="mname" id="mname" class="input-field w-full px-4 py-3 rounded-md">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="lname">Last Name</label>
                        <input type="text" name="lname" id="lname" class="input-field w-full px-4 py-3 rounded-md" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="gender">Gender</label>
                        <select name="gender" class="input-field w-full px-4 py-3 rounded-md" required>
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="others">Others</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="contact">Contact No</label>
                        <input type="text" name="contact" id="contact" class="input-field w-full px-4 py-3 rounded-md" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="email">Email</label>
                        <input type="email" name="email" id="email" class="input-field w-full px-4 py-3 rounded-md" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="password">Password</label>
                        <input type="password" name="password" id="password" class="input-field w-full px-4 py-3 rounded-md" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="cpassword">Confirm Password</label>
                        <input type="password" name="cpassword" id="cpassword" class="input-field w-full px-4 py-3 rounded-md" required>
                    </div>

                    <div class="flex justify-center mt-6">
                        <input type="submit" name="submit" Value="Register" class="w-full btn-blue py-3 rounded-md hover:bg-gray-800 transition duration-300 ml-4">
                    </div>
					<div class="text-center text-sm text-gray-600">
                        Already have an account?
                        <a href="actions/login.php" class="text-black font-medium hover:underline">Login</a>
                    </div>
                </form>
            </div>
        </div>

          <!-- Image Section - Hidden on mobile -->
          <div class="hidden md:block md:w-1/2 relative bg-blue-50">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-blue-700">
                <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                    <div class="text-white text-center p-8">
                        <h2 class="text-4xl font-bold mb-4 playfair">Join the Hostel Community</h2>
                        <p class="text-xl">A comfortable stay awaits you</p>
                    </div>
                </div>
            </div>
        </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <script src="js/fileinput.js"></script>
    <script src="js/chartData.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
