<?php
session_start();
include('includes/config.php');

function generateToken() {
    return bin2hex(random_bytes(32)); // Generate a secure random token
}

if (isset($_POST['reset'])) {
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    
    // Verify email and contact exist
    $stmt = $mysqli->prepare("SELECT id FROM userregistration WHERE email=? AND contactNo=?");
    $stmt->bind_param('ss', $email, $contact);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Generate token and expiration
        $token = generateToken();
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        // Delete any existing reset tokens for this email
        $delete = $mysqli->prepare("DELETE FROM password_resets WHERE email = ?");
        $delete->bind_param('s', $email);
        $delete->execute();
        
        // Insert new reset token
        $insert = $mysqli->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
        $insert->bind_param('sss', $email, $token, $expires);
        $insert->execute();
        
        // Create reset link
        $resetLink = "http://" . $_SERVER['HTTP_HOST'] . 
                    dirname($_SERVER['PHP_SELF']) . 
                    "/reset-password.php?token=" . $token;
        
        // In a production environment, you would send this via email
        // For demonstration, we'll show it on screen
        $message = "Password reset link has been generated. Click the link below to reset your password:<br>";
        $message .= "<a href='" . $resetLink . "'>" . $resetLink . "</a>";
        $message .= "<br>This link will expire in 1 hour.";
    } else {
        $error = "No account found with that email and contact number.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap');
        .playfair { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 bg-blue-50">
    <div class="bg-white rounded-lg w-full max-w-md p-8 shadow-lg">
        <h1 class="text-3xl font-bold mb-8 playfair text-blue-700 text-center">Reset Password</h1>
        
        <?php if (isset($message)): ?>
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <form method="post" class="space-y-6">
            <div>
                <label class="block text-sm text-gray-600 mb-2">Email Address</label>
                <input type="email" name="email" required 
                       class="w-full px-4 py-2 rounded border focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
            </div>
            
            <div>
                <label class="block text-sm text-gray-600 mb-2">Contact Number</label>
                <input type="text" name="contact" required 
                       class="w-full px-4 py-2 rounded border focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
            </div>
            
            <button type="submit" name="reset" 
                    class="w-full py-2 px-4 bg-blue-600 text-white rounded hover:bg-blue-700 transition duration-200">
                Send Reset Link
            </button>
        </form>
        
        <div class="mt-6 text-center">
            <a href="index.php" class="text-blue-600 hover:underline">Back to Login</a>
        </div>
    </div>
</body>
</html>
