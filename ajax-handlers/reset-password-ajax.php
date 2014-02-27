<?php

$resetId = $_POST['resetId'];
$newPassword = $_POST['newPassword'];

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db-connect.php';

try {
    $request = $db->prepare("SELECT password_reset_time, reset_admin_password FROM frc_team_accounts WHERE password_reset_id=?");
    $request->execute(array($resetId));
    
    if($request->rowCount() < 1) {
        echo "Invalid ID.";
    }
    
    $data = $request->fetch(PDO::FETCH_ASSOC);
    
    if($data['reset_admin_password'] === "1") {
        $colName = "admin_password";
    } else {
        $colName = "team_password";
    }
    
    $resetRequest = $db->prepare("UPDATE frc_team_accounts SET $colName=?, password_reset_time=NULL, password_reset_id=NULL WHERE password_reset_id=?");
    $resetRequest->execute(array($newPassword, $resetId));
    
} catch (PDOException $ex) {

}

?>