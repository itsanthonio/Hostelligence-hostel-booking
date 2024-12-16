<?php
session_start();
include('includes/config.php');

// Verify token is valid and not expired
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $stmt = $mysqli->prepare("SELECT email, expires_at, used FROM password_resets 
                             WHERE token = ? AND used = 0 
                             AND expires_at > CURRENT_TIMESTAMP");
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        die("This reset link is invalid or has expired.");
    }
    
    $reset = $result->fetch_assoc();
    $email = $reset['email'];
}

if (isset($_POST['update'])) {
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];
    $token = $_POST['token'];
    
    if ($password !== $confirm) {
        $error = "Passwords do not match";
    } else {
        // Hash the new password
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        
        // Update the password
        $update = $mysqli->prepare("UPDATE userregistration SET password = ? WHERE email = ?");
        $update->bind_param('ss', $hashed, $email);
        
        if ($update->execute()) {
            // Mark token as used
            $mark = $mysqli->prepare("UPDATE password_resets SET used = 1 WHERE token = ?");
            $mark->bind_param('s', $token);
            $mark->execute();
            
            $success = "Password has been updated successfully. You can now login with your new password.";
        } else {
            $error = "Error updating password. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set New Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap');
        .playfair { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 bg-blue-50">
    <div class="bg-white rounded-lg w-full max-w-md p-8 shadow-lg">
        <h1 class="text-3xl font-bold mb-8 playfair text-blue-700 text-center">Set New Password</h1>
        
        <?php if (isset($success)): ?>
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded">
                <?php echo $success; ?>
                <div class="mt-4">
                    <a href="login.php" class="text-blue-600 hover:underline">Go to Login</a>
                </div>
            </div>
        <?php else: ?>
            <?php if (isset($error)): ?>
                <div class="mb-6 p-4 bg-red-100 text-red-700 rounded">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <form method="post" class="space-y-6">
                <input type="hidden" name="token" value="<?php echo $token; ?>">
                
                <div>
                    <label class="block text-sm text-gray-600 mb-2">New Password</label>
                    <input type="password" name="password" required 
                           class="w-full px-4 py-2 rounded border focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm text-gray-600 mb-2">Confirm New Password</label>
                    <input type="password" name="confirm_password" required 
                           class="w-full px-4 py-2 rounded border focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                </div>
                
                <button type="submit" name="update" 
                        class="w-full py-2 px-4 bg-blue-600 text-white rounded hover:bg-blue-700 transition duration-200">
                    Update Password
                </button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>