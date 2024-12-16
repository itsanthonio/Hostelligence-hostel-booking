<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

header('Content-Type: application/json');

try {
    $aid = $_SESSION['login'];
    
    // Begin transaction
    $mysqli->begin_transaction();

    // Delete the booking
    $del_booking = "DELETE FROM registration WHERE emailid=?";
    $stmt = $mysqli->prepare($del_booking);
    $stmt->bind_param('s', $aid);
    
    if ($stmt->execute()) {
        $mysqli->commit();
        echo json_encode(['success' => true]);
    } else {
        throw new Exception("Error deleting booking");
    }
} catch (Exception $e) {
    $mysqli->rollback();
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

$mysqli->close();
?>