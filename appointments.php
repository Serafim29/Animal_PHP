<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: public/login.php');
    exit;
}

require_once __DIR__ . "/models/appointment.model.php";

$model = new AppointmentModel();
$appointments = $model->getAppointments();

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
    <title>All Appointments</title>
</head>
<body class="bg-[#1c1c1c]">
    <div class="container mx-auto mt-8 px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-4xl font-bold text-white">All Appointments</h1>
            <div class="flex gap-2">
                <a href="index.php" class="px-4 py-2 rounded-md bg-[#00ddff] text-[#1c1c1c] font-bold hover:bg-[#00ccee] transition-colors duration-200">
                    Create New Appointment
                </a>
                <a href="public/profile.php" class="px-4 py-2 rounded-md bg-blue-600 text-white font-bold hover:bg-blue-700 transition-colors duration-200">
                    Profile
                </a>
                <a href="handlers/handle_logout.php" class="px-4 py-2 rounded-md bg-red-600 text-white font-bold hover:bg-red-700 transition-colors duration-200">
                    Logout
                </a>
            </div>
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

        <?php if(empty($appointments)): ?>
            <div class="text-center py-12">
                <p class="text-white/70 text-xl">No appointments found. <a href="index.php" class="text-[#00ddff] hover:underline">Create your first appointment</a></p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full bg-[#2c2c2c] rounded-lg overflow-hidden">
                    <thead class="bg-[#3c3c3c]">
                        <tr>
                            <th class="px-6 py-4 text-left text-white font-semibold">Pet Photo</th>
                            <th class="px-6 py-4 text-left text-white font-semibold">Pet Name</th>
                            <th class="px-6 py-4 text-left text-white font-semibold">Species</th>
                            <th class="px-6 py-4 text-left text-white font-semibold">Owner Name</th>
                            <th class="px-6 py-4 text-left text-white font-semibold">Owner Email</th>
                            <th class="px-6 py-4 text-left text-white font-semibold">Appointment Date</th>
                            <th class="px-6 py-4 text-left text-white font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($appointments as $appointment): ?>
                            <tr class="border-t border-gray-700 hover:bg-[#3c3c3c] transition-colors">
                                <td class="px-6 py-4">
                                    <?php if(!empty($appointment['pet_photo'])): ?>
                                        <img src="uploads/<?php echo htmlspecialchars($appointment['pet_photo']); ?>" 
                                             alt="Pet photo" 
                                             class="w-16 h-16 object-cover rounded-lg">
                                    <?php else: ?>
                                        <span class="text-white/50">No photo</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-white"><?php echo htmlspecialchars($appointment['pet_name']); ?></td>
                                <td class="px-6 py-4 text-white/70"><?php echo htmlspecialchars(ucfirst($appointment['pet_species'])); ?></td>
                                <td class="px-6 py-4 text-white/70"><?php echo htmlspecialchars($appointment['owner_name']); ?></td>
                                <td class="px-6 py-4 text-white/70"><?php echo htmlspecialchars($appointment['owner_email']); ?></td>
                                <td class="px-6 py-4 text-white/70"><?php echo htmlspecialchars(date('Y-m-d', strtotime($appointment['appointment_date']))); ?></td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        <a href="edit.php?id=<?php echo $appointment['id']; ?>" 
                                           class="px-3 py-1 rounded-md bg-blue-600 text-white hover:bg-blue-700 transition-colors text-sm">
                                            Edit
                                        </a>
                                        <form action="handlers/delete.handler.php" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this appointment?');">
                                            <input type="hidden" name="id" value="<?php echo $appointment['id']; ?>">
                                            <button type="submit" class="px-3 py-1 rounded-md bg-red-600 text-white hover:bg-red-700 transition-colors text-sm">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>


