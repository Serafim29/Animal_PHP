<?php
session_start();

require_once __DIR__ . "/models/appointment.model.php";

$success = isset($_SESSION['success']) ? $_SESSION['success'] : null;
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : null;

unset($_SESSION['success']);
unset($_SESSION['errors']);

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if($id <= 0) {
    $_SESSION['errors'] = ['Invalid appointment ID'];
    header('Location: appointments.php');
    exit;
}

$model = new AppointmentModel();
$appointment = $model->getAppointmentById($id);

if(!$appointment || is_string($appointment)) {
    $_SESSION['errors'] = ['Appointment not found'];
    header('Location: appointments.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Edit Appointment</title>
</head>
<body class="bg-[#1c1c1c]">
    <div class="container mx-auto mt-8 px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-4xl font-bold text-white">Edit Appointment</h1>
            <a href="appointments.php" class="px-4 py-2 rounded-md bg-gray-600 text-white font-bold hover:bg-gray-700 transition-colors duration-200">
                Back to Appointments
            </a>
        </div>
        
        <?php if($success): ?>
            <div class="mb-6 p-4 rounded-md bg-green-900 text-green-300"><?php echo $success; ?></div>
        <?php endif; ?>
    
        <?php if($errors): ?>
            <div class="mb-6 p-4 rounded-md bg-red-900 text-red-300">
                <?php foreach($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="flex flex-col lg:flex-row justify-between items-start gap-8">
            <div class="w-full lg:w-1/2">
                <?php if(!empty($appointment['pet_photo'])): ?>
                    <img src="uploads/<?php echo htmlspecialchars($appointment['pet_photo']); ?>" 
                         alt="Pet photo" 
                         class="w-full h-64 lg:h-96 object-cover rounded-lg mb-4">
                <?php else: ?>
                    <div class="w-full h-64 lg:h-96 bg-[#2c2c2c] rounded-lg flex items-center justify-center mb-4">
                        <p class="text-white/50">No photo uploaded</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="w-full lg:w-1/2">
                <form action="handlers/update.handler.php" method="post" class="space-y-6" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($appointment['id']); ?>">
                    <input type="hidden" name="current_photo" value="<?php echo htmlspecialchars($appointment['pet_photo'] ?? ''); ?>">
                    
                    <div class="space-y-2">
                        <label for="owner_name" class="text-white/70 block">Owner Name *</label>
                        <input type="text" name="owner_name" id="owner_name" 
                               value="<?php echo htmlspecialchars($appointment['owner_name']); ?>"
                               class="w-full p-3 rounded-md bg-[#2c2c2c] text-white border border-gray-600 focus:border-[#00ddff] focus:outline-none">
                    </div>
                    
                    <div class="space-y-2">
                        <label for="owner_email" class="text-white/70 block">Owner Email *</label>
                        <input type="email" name="owner_email" id="owner_email" 
                               value="<?php echo htmlspecialchars($appointment['owner_email']); ?>"
                               class="w-full p-3 rounded-md bg-[#2c2c2c] text-white border border-gray-600 focus:border-[#00ddff] focus:outline-none">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="pet_name" class="text-white/70 block">Pet Name *</label>
                            <input type="text" name="pet_name" id="pet_name" 
                                   value="<?php echo htmlspecialchars($appointment['pet_name']); ?>"
                                   class="w-full p-3 rounded-md bg-[#2c2c2c] text-white border border-gray-600 focus:border-[#00ddff] focus:outline-none">
                        </div>
                        
                        <div class="space-y-2">
                            <label for="pet_species" class="text-white/70 block">Species *</label>
                            <select name="pet_species" id="pet_species" class="w-full p-3 rounded-md bg-[#2c2c2c] text-white border border-gray-600 focus:border-[#00ddff] focus:outline-none">
                                <option value="">Select species</option>
                                <option value="dog" <?php echo $appointment['pet_species'] === 'dog' ? 'selected' : ''; ?>>Dog</option>
                                <option value="cat" <?php echo $appointment['pet_species'] === 'cat' ? 'selected' : ''; ?>>Cat</option>
                                <option value="bird" <?php echo $appointment['pet_species'] === 'bird' ? 'selected' : ''; ?>>Bird</option>
                                <option value="rabbit" <?php echo $appointment['pet_species'] === 'rabbit' ? 'selected' : ''; ?>>Rabbit</option>
                                <option value="other" <?php echo $appointment['pet_species'] === 'other' ? 'selected' : ''; ?>>Other</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="pet_breed" class="text-white/70 block">Breed</label>
                            <input type="text" name="pet_breed" id="pet_breed" 
                                   value="<?php echo htmlspecialchars($appointment['pet_breed'] ?? ''); ?>"
                                   class="w-full p-3 rounded-md bg-[#2c2c2c] text-white border border-gray-600 focus:border-[#00ddff] focus:outline-none">
                        </div>
                        
                        <div class="space-y-2">
                            <label for="pet_age" class="text-white/70 block">Age *</label>
                            <input type="number" name="pet_age" id="pet_age" min="0" max="50" 
                                   value="<?php echo htmlspecialchars($appointment['pet_age']); ?>"
                                   class="w-full p-3 rounded-md bg-[#2c2c2c] text-white border border-gray-600 focus:border-[#00ddff] focus:outline-none">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="pet_weight" class="text-white/70 block">Weight (kg) *</label>
                            <input type="number" name="pet_weight" id="pet_weight" step="0.1" min="0" 
                                   value="<?php echo htmlspecialchars($appointment['pet_weight']); ?>"
                                   class="w-full p-3 rounded-md bg-[#2c2c2c] text-white border border-gray-600 focus:border-[#00ddff] focus:outline-none">
                        </div>
                        
                        <div class="space-y-2">
                            <label for="appointment_date" class="text-white/70 block">Preferred Date *</label>
                            <input type="date" name="appointment_date" id="appointment_date" 
                                   value="<?php echo htmlspecialchars($appointment['appointment_date']); ?>"
                                   class="w-full p-3 rounded-md bg-[#2c2c2c] text-white border border-gray-600 focus:border-[#00ddff] focus:outline-none">
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <label for="problem_description" class="text-white/70 block">Problem Description *</label>
                        <textarea name="problem_description" id="problem_description" rows="4" 
                                  class="w-full p-3 rounded-md bg-[#2c2c2c] text-white border border-gray-600 focus:border-[#00ddff] focus:outline-none" 
                                  placeholder="Please describe your pet's symptoms or concerns..."><?php echo htmlspecialchars($appointment['problem_description']); ?></textarea>
                    </div>
                    
                    <div class="space-y-2">
                        <label for="pet_photo" class="text-white/70 block">Upload New Pet Photo</label>
                        <input type="file" name="pet_photo" id="pet_photo" class="w-full p-2 rounded-md bg-[#2c2c2c] text-white" accept="image/*">
                        <p class="text-white/50 text-sm">Leave empty to keep current photo</p>
                    </div>
                    
                    <div class="flex gap-4">
                        <button type="submit" class="flex-1 p-4 rounded-md bg-[#00ddff] text-[#1c1c1c] font-bold hover:bg-[#00ccee] transition-colors duration-200">
                            Update Appointment
                        </button>
                        <a href="appointments.php" class="flex-1 p-4 rounded-md bg-gray-600 text-white font-bold hover:bg-gray-700 transition-colors duration-200 text-center">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>


