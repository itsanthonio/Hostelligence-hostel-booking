<?php
session_start();
include('includes/config.php');
if(isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password']; // Plain text password from form
    
    // First get the hashed password from database
    $stmt = $mysqli->prepare("SELECT email, password, id FROM userregistration WHERE email=?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->bind_result($email, $hashed_password, $id);
    $rs = $stmt->fetch();
    $stmt->close();
    
    // Verify the password against the hash
    if($rs && password_verify($password, $hashed_password)) {
        $_SESSION['id'] = $id;
        $_SESSION['login'] = $email;
        $uip = $_SERVER['REMOTE_ADDR'];
        $ldate = date('Y-m-d H:i:s', time());
        
        $uid = $_SESSION['id'];
        $uemail = $_SESSION['login'];
        $ip = $_SERVER['REMOTE_ADDR'];
        
        // Using prepared statement for log entry to prevent SQL injection
        $log = $mysqli->prepare("INSERT INTO userLog(userId, userEmail, userIp, loginTime) VALUES (?, ?, ?, ?)");
        $log->bind_param('ssss', $uid, $uemail, $ip, $ldate);
        $log->execute();
        
        if($log) {
            header("location:view/dashboard.php");
            exit(); // Always exit after redirect
        }
    } else {
        echo "<script>alert('Invalid Username/Email or password');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Hostel Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap');

        .playfair {
            font-family: 'Playfair Display', serif;
        }

        .login-container {
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.1);
            border: 1px solid #cbd5e1;
        }

        .input-field {
            background-color: #e0f2fe;
            border: 1px solid #7dd3fc;
            transition: all 0.3s ease;
        }

        .input-field:focus {
            border-color: #0284c7;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.4);
            outline: none;
        }

        .login-btn {
            background-color: #0284c7;
            transition: all 0.3s ease;
        }

        .login-btn:hover {
            background-color: #0369a1;
        }

        body {
            background-color: #e0f2fe;
			color: black; 
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4">
    <div class="login-container bg-white rounded-lg w-full max-w-md md:max-w-6xl flex overflow-hidden">
        <!-- Login Form Section -->
        <div class="w-full md:w-1/2 p-8 md:p-12">
            <h1 class="text-3xl md:text-4xl font-bold mb-12 playfair text-blue-700">Welcome back!</h1>

            <form action="" method="post" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm text-blue-600 mb-2">Email</label>
                    <input type="text" name="email" id="email" class="input-field w-full px-4 py-3 rounded-md" placeholder="Enter your email address" required>
                </div>

                <div>
                    <label for="password" class="block text-sm text-blue-600 mb-2">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" class="input-field w-full px-4 py-3 rounded-md" placeholder="Enter your password" required>
                        <button type="button" id="togglePasswordBtn" class="absolute right-3 top-1/2 -translate-y-1/2 text-blue-400 hover:text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" name="login" class="login-btn w-full py-3 text-white font-medium rounded-md">Login</button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-sm text-blue-600">
                    <a href="forgot-password.php" class="font-medium hover:underline">Forgot password?</a>
                </p>
                <p class="text-sm text-blue-600">
                    Don't have an account?
                    <a href="registration.php" class="font-medium hover:underline">Create account</a>
                </p>
            </div>
        </div>

        <!-- Image Section -->
        <div class="hidden md:block md:w-1/2 relative">
            <img src="images/login.jpg" alt="Hostel Management" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-blue-700 bg-opacity-50 flex items-center justify-center">
                <div class="text-white text-center p-8">
                    <h2 class="text-4xl font-bold mb-4 playfair">Experience Comfort</h2>
                    <p class="text-xl">Manage your stay with ease</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
