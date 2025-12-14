<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../database/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$pdo = (new Database())->getPDO();
$user = User::getUserById($_SESSION['user_id'], $pdo);
if (!$user) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Profile - Pet Veterinary Appointment</title>
</head>
<body class="bg-[#1c1c1c]">
    <div class="container mx-auto mt-8 px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-4xl font-bold text-white">Profile</h2>
                <a href="../handlers/handle_logout.php" class="px-4 py-2 rounded-md bg-red-600 text-white font-bold hover:bg-red-700 transition-colors duration-200">
                    Logout
                </a>
            </div>
            <div class="bg-[#2c2c2c] rounded-lg p-6 space-y-4">
                <div>
                    <label class="text-white/70 block mb-2">Username</label>
                    <p class="text-white text-lg"><?php echo htmlspecialchars($user['username']); ?></p>
                </div>
                <div>
                    <label class="text-white/70 block mb-2">Email</label>
                    <p class="text-white text-lg"><?php echo htmlspecialchars($user['email']); ?></p>
                </div>
            </div>
            <div class="mt-6 flex gap-4">
                <a href="../index.php" class="flex-1 px-4 py-3 rounded-md bg-[#00ddff] text-[#1c1c1c] font-bold hover:bg-[#00ccee] transition-colors duration-200 text-center">
                    Create Appointment
                </a>
                <a href="../appointments.php" class="flex-1 px-4 py-3 rounded-md bg-blue-600 text-white font-bold hover:bg-blue-700 transition-colors duration-200 text-center">
                    View Appointments
                </a>
            </div>
        </div>
    </div>
</body>
</html>

