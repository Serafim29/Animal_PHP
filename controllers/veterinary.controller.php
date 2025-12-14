<?php
declare(strict_types=1);

function sanitizeInput(string $input): string {
    return htmlspecialchars(trim($input));
}

function validateOwnerName(string $name): array {
    $errors = [];
    if(empty($name)) {
        $errors[] = "Owner name is required";
    } elseif(!preg_match('/^[a-zA-Z\s\-]+$/', $name)) {
        $errors[] = "Owner name must contain only letters, spaces and hyphens";
    }
    return $errors;
}

function validateOwnerEmail(string $email): array {
    $errors = [];
    if(empty($email)) {
        $errors[] = "Owner email is required";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    return $errors;
}

function validatePetName(string $name): array {
    $errors = [];
    if(empty($name)) {
        $errors[] = "Pet name is required";
    } elseif(!preg_match('/^[a-zA-Z\s\-]+$/', $name)) {
        $errors[] = "Pet name must contain only letters, spaces and hyphens";
    }
    return $errors;
}

function validateSpecies(string $species): array {
    $errors = [];
    if(empty($species)) {
        $errors[] = "Pet species is required";
    }
    return $errors;
}

function validateAge(string $age): array {
    $errors = [];
    if(empty($age)) {
        $errors[] = "Pet age is required";
    } elseif(!is_numeric($age) || $age < 0 || $age > 50) {
        $errors[] = "Age must be a valid number between 0 and 50";
    }
    return $errors;
}

function validateWeight(string $weight): array {
    $errors = [];
    if(empty($weight)) {
        $errors[] = "Pet weight is required";
    } elseif(!is_numeric($weight) || $weight <= 0) {
        $errors[] = "Weight must be a valid positive number";
    }
    return $errors;
}

function validateAppointmentDate(string $date): array {
    $errors = [];
    if(empty($date)) {
        $errors[] = "Appointment date is required";
    } else {
        $selectedDate = strtotime($date);
        $today = strtotime('today');
        if($selectedDate < $today) {
            $errors[] = "Appointment date cannot be in the past";
        }
    }
    return $errors;
}


function validateProblemDescription(string $description): array {
    $errors = [];
    if(empty($description)) {
        $errors[] = "Problem description is required";
    } elseif(strlen($description) < 10) {
        $errors[] = "Problem description must be at least 10 characters long";
    }
    return $errors;
}

function validatePetPhoto(array $pet_photo, string $pet_name): array | string {
    $errors = [];
    
    if($pet_photo['error'] === UPLOAD_ERR_NO_FILE) {
        return "";
    }
    
    if($pet_photo['error'] === UPLOAD_ERR_OK) {
        $tmpName = $pet_photo['tmp_name'];
        $originalName = $pet_photo['name'];
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        if(in_array($ext, $allowedExts)) {

            $sanitizedPetName = preg_replace('/[^a-zA-Z0-9]/', '_', $pet_name);
            $newName = $sanitizedPetName . '_' . uniqid() . '.' . $ext;
            $destination = '../uploads/' . $newName;
            
            if(!is_dir('../uploads')) {
                mkdir('../uploads', 0755, true);
            }
            
            if(move_uploaded_file($tmpName, $destination)) {
                return $newName;
            } else {
                $errors[] = "Failed to move uploaded file";
            }
        } else {
            $errors[] = "Invalid image format. Allowed: JPG, JPEG, PNG, GIF, WEBP";
        }
    } else {
        $errors[] = "Failed to upload image. Error code: " . $pet_photo['error'];
    }
    
    return $errors;
}