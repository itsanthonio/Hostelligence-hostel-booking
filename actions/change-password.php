<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();
date_default_timezone_set('Asia/Kolkata');
$ai = $_SESSION['id'];

// Code for change password
if (isset($_POST['changepwd'])) {
    $op = $_POST['oldpassword'];
    $np = $_POST['newpassword'];
    $udate = date('Y-m-d H:i:s', time());
    $sql = "SELECT password FROM userregistration WHERE password=?";
    $chngpwd = $mysqli->prepare($sql);
    $chngpwd->bind_param('s', $op);
    $chngpwd->execute();
    $chngpwd->store_result();
    $row_cnt = $chngpwd->num_rows;
    if ($row_cnt > 0) {
        $con = "UPDATE userregistration SET password=?, passUdateDate=? WHERE id=?";
        $chngpwd1 = $mysqli->prepare($con);
        $chngpwd1->bind_param('ssi', $np, $udate, $ai);
        $chngpwd1->execute();
        $_SESSION['msg'] = "Password Changed Successfully!!";
    } else {
        $_SESSION['msg'] = "Old Password does not match!!";
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
    <title>Change Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script type="text/javascript">
        function valid() {
            if (document.changepwd.newpassword.value != document.changepwd.cpassword.value) {
                alert("Password and Re-Type Password Field do not match!!");
                document.changepwd.cpassword.focus();
                return false;
            }
            return true;
        }
    </script>
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
					<a href="view/my-profile.php" class="text-gray-600 hover:text-gray-800">
						My Account
					</a>
				   <a href="actions/logout.php" class="text-gray-600 hover:text-red-600">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    

        <div class="flex-grow p-6">
            <h2 class="text-2xl font-bold mb-6">Change Password</h2>
            <div class="bg-white shadow rounded-lg p-6">
                <div class="mb-4 text-sm text-gray-600">
                    <?php
                    $result = "SELECT passUdateDate FROM userregistration WHERE id=?";
                    $stmt = $mysqli->prepare($result);
                    $stmt->bind_param('i', $ai);
                    $stmt->execute();
                    $stmt->bind_result($result);
                    $stmt->fetch();
                    ?>
                    Last Update Date: <span class="font-medium"><?php echo $result; ?></span>
                </div>
                <?php if (isset($_POST['changepwd'])) { ?>
                    <p class="text-red-500"><?php echo htmlentities($_SESSION['msg']); ?><?php echo htmlentities($_SESSION['msg'] = ""); ?></p>
                <?php } ?>
                <form method="post" class="space-y-4" name="changepwd" id="change-pwd" onSubmit="return valid();">
                    <div>
                        <label class="block font-medium text-gray-700">Old Password</label>
                        <input type="password" name="oldpassword" id="oldpassword" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                        <span id="password-availability-status" class="text-xs text-gray-500"></span>
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700">New Password</label>
                        <input type="password" name="newpassword" id="newpassword" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700">Confirm Password</label>
                        <input type="password" name="cpassword" id="cpassword" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    </div>
                    <div class="flex space-x-4">
                        <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded-md">Cancel</button>
                        <input type="submit" name="changepwd" value="Change Password" class="px-4 py-2 bg-indigo-500 text-white rounded-md cursor-pointer">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script>
        function checkpass() {
            $("#loaderIcon").show();
            jQuery.ajax({
                url: "check_availability.php",
                data: 'oldpassword=' + $("#oldpassword").val(),
                type: "POST",
                success: function(data) {
                    $("#password-availability-status").html(data);
                    $("#loaderIcon").hide();
                },
                error: function() {}
            });
        }
    </script>
</body>

</html>
