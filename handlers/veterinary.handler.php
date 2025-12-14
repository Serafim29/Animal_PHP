<?php
declare(strict_types=1);
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../public/login.php');
    exit;
}

require_once '../controllers/veterinary.controller.php';
require_once '../models/appointment.model.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {

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
    

    $photoValidation = validatePetPhoto($pet_photo, $pet_name);
    $pet_photo_filename = "";
    if(is_array($photoValidation)) {
        $errors = array_merge($errors, $photoValidation);
    } else {
        $pet_photo_filename = $photoValidation;
    }

    if(empty($errors)) {
        $model = new AppointmentModel();
        $model->createAppointment($owner_name, $owner_email, $pet_name, $pet_species, $pet_breed, $pet_age, $pet_weight, $appointment_date, $problem_description, $pet_photo_filename);
        
        $_SESSION['success'] = "Appointment scheduled successfully for " . $pet_name . "! We will contact you at " . $owner_email . " to confirm.";
        header('Location: ../index.php');
        exit;
    } else {
        $_SESSION['errors'] = $errors;
        header('Location: ../index.php');
        exit;
    }
}