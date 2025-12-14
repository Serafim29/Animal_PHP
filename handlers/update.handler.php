<?php
declare(strict_types=1);
session_start();

require_once '../controllers/veterinary.controller.php';
require_once '../models/appointment.model.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $current_photo = isset($_POST['current_photo']) ? $_POST['current_photo'] : '';

    if($id <= 0) {
        $_SESSION['errors'] = ['Invalid appointment ID'];
        header('Location: ../edit.php?id=' . $id);
        exit;
    }

    $pet_name = sanitizeInput($_POST['pet_name'] ?? '');
    $pet_species = sanitizeInput($_POST['pet_species'] ?? '');
    $pet_breed = sanitizeInput($_POST['pet_breed'] ?? '');
    $pet_age = sanitizeInput($_POST['pet_age'] ?? '');
    $pet_weight = sanitizeInput($_POST['pet_weight'] ?? '');
    $appointment_date = sanitizeInput($_POST['appointment_date'] ?? '');
    $owner_name = sanitizeInput($_POST['owner_name'] ?? '');
    $owner_email = sanitizeInput($_POST['owner_email'] ?? '');
    $problem_description = sanitizeInput($_POST['problem_description'] ?? '');
    $pet_photo = $_FILES['pet_photo'] ?? [];

    $errors = [];

    $errors = array_merge($errors, validatePetName($pet_name));
    $errors = array_merge($errors, validateSpecies($pet_species));
    $errors = array_merge($errors, validateAge($pet_age));
    $errors = array_merge($errors, validateWeight($pet_weight));
    $errors = array_merge($errors, validateAppointmentDate($appointment_date));
    $errors = array_merge($errors, validateOwnerName($owner_name));
    $errors = array_merge($errors, validateOwnerEmail($owner_email));
    $errors = array_merge($errors, validateProblemDescription($problem_description));
    
    $pet_photo_filename = $current_photo;
    
    if(isset($pet_photo['error']) && $pet_photo['error'] === UPLOAD_ERR_OK) {
        $photoValidation = validatePetPhoto($pet_photo, $pet_name);
        if(is_array($photoValidation)) {
            $errors = array_merge($errors, $photoValidation);
        } else {
            $pet_photo_filename = $photoValidation;
            if(!empty($current_photo) && file_exists('../uploads/' . $current_photo)) {
                unlink('../uploads/' . $current_photo);
            }
        }
    }

    if(empty($errors)) {
        $model = new AppointmentModel();
        $result = $model->updateAppointment($id, $owner_name, $owner_email, $pet_name, $pet_species, $pet_breed, $pet_age, $pet_weight, $appointment_date, $problem_description, $pet_photo_filename);
        
        if($result > 0) {
            $_SESSION['success'] = "Appointment updated successfully for " . $pet_name . "!";
            header('Location: ../appointments.php');
            exit;
        } else {
            $_SESSION['errors'] = ['Failed to update appointment'];
            header('Location: ../edit.php?id=' . $id);
            exit;
        }
    } else {
        $_SESSION['errors'] = $errors;
        header('Location: ../edit.php?id=' . $id);
        exit;
    }
} else {
    header('Location: ../appointments.php');
    exit;
}


