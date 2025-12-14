<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: public/login.php');
    exit;
}

$success = isset($_SESSION['success']) ? $_SESSION['success'] : null;
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : null;

unset($_SESSION['success']);
unset($_SESSION['errors']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Pet Veterinary Appointment</title>
</head>
<body class="bg-[#1c1c1c]">
    <div class="container mx-auto mt-8 px-4 py-8">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-4xl font-bold text-white">Pet Veterinary Appointment</h1>
            <div class="flex gap-2">
                <a href="appointments.php" class="px-4 py-2 rounded-md bg-[#00ddff] text-[#1c1c1c] font-bold hover:bg-[#00ccee] transition-colors duration-200">
                    View All Appointments
                </a>
                <a href="public/profile.php" class="px-4 py-2 rounded-md bg-blue-600 text-white font-bold hover:bg-blue-700 transition-colors duration-200">
                    Profile
                </a>
                <a href="handlers/handle_logout.php" class="px-4 py-2 rounded-md bg-red-600 text-white font-bold hover:bg-red-700 transition-colors duration-200">
                    Logout
                </a>
            </div>
        </div>
        <p class="text-white/70 text-center mb-8">Schedule an appointment for your pet</p>
        
        <div class="flex flex-col lg:flex-row justify-between items-center gap-8">
            <div class="w-full lg:w-1/2 ">
                <img src="https://images.unsplash.com/photo-1450778869180-41d0601e046e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                    alt="Pet and veterinarian" class="w-full h-64 lg:h-96 object-cover rounded-lg">
            </div>
            
            <div class="w-full lg:w-1/2">
                <form action="handlers/veterinary.handler.php" method="post" class="space-y-6" enctype="multipart/form-data">
                    
                <div class="space-y-2">
                        <label for="owner_name" class="text-white/70 block">Owner Name *</label>
                        <input type="text" name="owner_name" id="owner_name" class="w-full p-3 rounded-md bg-[#2c2c2c] text-white border border-gray-600 focus:border-[#00ddff] focus:outline-none">
                    </div>
                    
                    <div class="space-y-2">
                        <label for="owner_email" class="text-white/70 block">Owner Email *</label>
                        <input type="email" name="owner_email" id="owner_email" class="w-full p-3 rounded-md bg-[#2c2c2c] text-white border border-gray-600 focus:border-[#00ddff] focus:outline-none">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="pet_name" class="text-white/70 block">Pet Name *</label>
                            <input type="text" name="pet_name" id="pet_name" class="w-full p-3 rounded-md bg-[#2c2c2c] text-white border border-gray-600 focus:border-[#00ddff] focus:outline-none">
                        </div>
                        
                        <div class="space-y-2">
                            <label for="pet_species" class="text-white/70 block">Species *</label>
                            <select name="pet_species" id="pet_species" class="w-full p-3 rounded-md bg-[#2c2c2c] text-white border border-gray-600 focus:border-[#00ddff] focus:outline-none">
                                <option value="">Select species</option>
                                <option value="dog">Dog</option>
                                <option value="cat">Cat</option>
                                <option value="bird">Bird</option>
                                <option value="rabbit">Rabbit</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="pet_breed" class="text-white/70 block">Breed</label>
                            <input type="text" name="pet_breed" id="pet_breed" class="w-full p-3 rounded-md bg-[#2c2c2c] text-white border border-gray-600 focus:border-[#00ddff] focus:outline-none">
                        </div>
                        
                        <div class="space-y-2">
                            <label for="pet_age" class="text-white/70 block">Age *</label>
                            <input type="number" name="pet_age" id="pet_age" min="0" max="50" class="w-full p-3 rounded-md bg-[#2c2c2c] text-white border border-gray-600 focus:border-[#00ddff] focus:outline-none">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="pet_weight" class="text-white/70 block">Weight (kg) *</label>
                            <input type="number" name="pet_weight" id="pet_weight" step="0.1" min="0" class="w-full p-3 rounded-md bg-[#2c2c2c] text-white border border-gray-600 focus:border-[#00ddff] focus:outline-none">
                        </div>
                        
                        <div class="space-y-2">
                            <label for="appointment_date" class="text-white/70 block">Preferred Date *</label>
                            <input type="date" name="appointment_date" id="appointment_date" class="w-full p-3 rounded-md bg-[#2c2c2c] text-white border border-gray-600 focus:border-[#00ddff] focus:outline-none">
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <label for="problem_description" class="text-white/70 block">Problem Description *</label>
                        <textarea name="problem_description" id="problem_description" rows="4" class="w-full p-3 rounded-md bg-[#2c2c2c] text-white border border-gray-600 focus:border-[#00ddff] focus:outline-none" placeholder="Please describe your pet's symptoms or concerns..."></textarea>
                    </div>
                    
                    <div class="space-y-2">
                        <label for="pet_photo" class="text-white/70 block">Upload Pet Photo</label>
                        <input type="file" name="pet_photo" id="pet_photo" class="w-full p-2 rounded-md bg-[#2c2c2c] text-white" accept="image/*">
                        <p class="text-white/50 text-sm">Upload a clear photo of your pet (optional but recommended)</p>
                    </div>
                    
                    <button type="submit" class="w-full p-4 rounded-md bg-[#00ddff] text-[#1c1c1c] font-bold hover:bg-[#00ccee] transition-colors duration-200">Schedule Appointment</button>
                </form>
            </div>
        </div>
        
        <?php if($success): ?>
            <div class="mt-6 p-4 rounded-md bg-green-900 text-green-300"><?php echo $success; ?></div>
        <?php endif; ?>
    
        <?php if($errors): ?>
            <div class="mt-6 p-4 rounded-md bg-red-900 text-red-300">
                <?php foreach($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>