<?php
declare(strict_types=1);
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../public/login.php');
    exit;
}

require_once '../models/appointment.model.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if($id <= 0) {
        $_SESSION['errors'] = ['Invalid appointment ID'];
        header('Location: ../appointments.php');
        exit;
    }

    $model = new AppointmentModel();
    
    $appointment = $model->getAppointmentById($id);
    if($appointment && !is_string($appointment) && !empty($appointment['pet_photo'])) {
        $photo_path = '../uploads/' . $appointment['pet_photo'];
        if(file_exists($photo_path)) {
            unlink($photo_path);
        }
    }
    
    $result = $model->deleteAppointment($id);
    
    if($result > 0) {
        $_SESSION['success'] = "Appointment deleted successfully!";
    } else {
        $_SESSION['errors'] = ['Failed to delete appointment'];
    }
    
    header('Location: ../appointments.php');
    exit;
} else {
    header('Location: ../appointments.php');
    exit;
}


