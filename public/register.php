<?php
session_start();
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Register - Pet Veterinary Appointment</title>
</head>
<body class="bg-[#1c1c1c]">
    <div class="container mx-auto mt-8 px-4 py-8">
        <div class="max-w-md mx-auto">
            <h2 class="text-4xl font-bold text-white mb-8 text-center">Register</h2>
            <form action="../handlers/handle_register.php" method="post" class="space-y-6">
                <div class="space-y-2">
                    <label for="username" class="text-white/70 block">Username</label>
                    <input type="text" name="username" id="username" required
                           class="w-full p-3 rounded-md bg-[#2c2c2c] text-white border border-gray-600 focus:border-[#00ddff] focus:outline-none">
                </div>
                <div class="space-y-2">
                    <label for="email" class="text-white/70 block">Email</label>
                    <input type="email" name="email" id="email" required
                           class="w-full p-3 rounded-md bg-[#2c2c2c] text-white border border-gray-600 focus:border-[#00ddff] focus:outline-none">
                </div>
                <div class="space-y-2">
                    <label for="password" class="text-white/70 block">Password</label>
                    <input type="password" name="password" id="password" required
                           class="w-full p-3 rounded-md bg-[#2c2c2c] text-white border border-gray-600 focus:border-[#00ddff] focus:outline-none">
                </div>
                <button type="submit" class="w-full p-4 rounded-md bg-[#00ddff] text-[#1c1c1c] font-bold hover:bg-[#00ccee] transition-colors duration-200">
                    Register
                </button>
                <p class="text-white/70 text-center">
                    Already have an account? <a href="login.php" class="text-[#00ddff] hover:underline">Login</a>
                </p>
            </form>
            <?php if (!empty($errors)) : ?>
                <div class="mt-6 p-4 rounded-md bg-red-900 text-red-300">
                    <ul>
                        <?php foreach ($errors as $error) : ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

