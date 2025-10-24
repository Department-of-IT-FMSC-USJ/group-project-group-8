<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Officer Registration - Debit Card Renewal System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-gray-900 via-blue-900 to-gray-900 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full">
        <!-- Logo/Header -->
        <div class="text-center mb-8">
            <div class="inline-block p-4 bg-blue-600 rounded-full mb-4">
                <span class="material-icons text-white text-5xl">admin_panel_settings</span>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">Bank Officer Registration</h1>
            <p class="text-gray-400">Internal Use Only</p>
        </div>

        <!-- Registration Card -->
        <div class="bg-gray-800 rounded-2xl shadow-2xl p-8 border border-gray-700">
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="bg-red-500/10 border border-red-500 text-red-500 px-4 py-3 rounded-lg mb-6 flex items-center">
                    <span class="material-icons mr-2">error</span>
                    <span><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></span>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="bg-green-500/10 border border-green-500 text-green-500 px-4 py-3 rounded-lg mb-6 flex items-center">
                    <span class="material-icons mr-2">check_circle</span>
                    <span><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></span>
                </div>
            <?php endif; ?>

            <form action="index.php?action=register_officer" method="POST">
                
                <!-- Full Name -->
                <div class="mb-4">
                    <label for="full_name" class="block text-gray-300 mb-2 flex items-center">
                        <span class="material-icons text-sm mr-1">person</span>
                        Full Name
                    </label>
                    <input 
                        type="text" 
                        id="full_name" 
                        name="full_name" 
                        required 
                        class="w-full px-4 py-3 rounded-lg bg-gray-700 border border-gray-600 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                        placeholder="Enter full name"
                    >
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-300 mb-2 flex items-center">
                        <span class="material-icons text-sm mr-1">email</span>
                        Email Address
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        required 
                        class="w-full px-4 py-3 rounded-lg bg-gray-700 border border-gray-600 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                        placeholder="officer@bank.com"
                    >
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-gray-300 mb-2 flex items-center">
                        <span class="material-icons text-sm mr-1">lock</span>
                        Password
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required 
                        minlength="8"
                        class="w-full px-4 py-3 rounded-lg bg-gray-700 border border-gray-600 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                        placeholder="Minimum 8 characters"
                    >
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <label for="confirm_password" class="block text-gray-300 mb-2 flex items-center">
                        <span class="material-icons text-sm mr-1">lock_outline</span>
                        Confirm Password
                    </label>
                    <input 
                        type="password" 
                        id="confirm_password" 
                        name="confirm_password" 
                        required 
                        minlength="8"
                        class="w-full px-4 py-3 rounded-lg bg-gray-700 border border-gray-600 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                        placeholder="Re-enter password"
                    >
                </div>

                <!-- Branch -->
                <div class="mb-4">
                    <label for="branch" class="block text-gray-300 mb-2 flex items-center">
                        <span class="material-icons text-sm mr-1">business</span>
                        Branch
                    </label>
                    <select 
                        id="branch" 
                        name="branch" 
                        required 
                        class="w-full px-4 py-3 rounded-lg bg-gray-700 border border-gray-600 text-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                    >
                        <option value="">Select Branch</option>
                        <option value="Colombo">Colombo</option>
                        <option value="Kandy">Kandy</option>
                        <option value="Galle">Galle</option>
                        <option value="Jaffna">Jaffna</option>
                        <option value="Negombo">Negombo</option>
                        <option value="Anuradhapura">Anuradhapura</option>
                        <option value="Matara">Matara</option>
                        <option value="Batticaloa">Batticaloa</option>
                    </select>
                </div>

                <!-- Phone -->
                <div class="mb-6">
                    <label for="phone" class="block text-gray-300 mb-2 flex items-center">
                        <span class="material-icons text-sm mr-1">phone</span>
                        Phone Number
                    </label>
                    <input 
                        type="tel" 
                        id="phone" 
                        name="phone" 
                        class="w-full px-4 py-3 rounded-lg bg-gray-700 border border-gray-600 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                        placeholder="555-0000"
                    >
                </div>

                <!-- Secret Access Code -->
                <div class="mb-6">
                    <label for="access_code" class="block text-gray-300 mb-2 flex items-center">
                        <span class="material-icons text-sm mr-1">vpn_key</span>
                        Access Code
                    </label>
                    <input 
                        type="password" 
                        id="access_code" 
                        name="access_code" 
                        required 
                        class="w-full px-4 py-3 rounded-lg bg-gray-700 border border-gray-600 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                        placeholder="Enter secret access code"
                    >
                    <p class="text-xs text-gray-500 mt-1">Contact system administrator for access code</p>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors flex items-center justify-center"
                >
                    <span class="material-icons mr-2">how_to_reg</span>
                    Register Officer Account
                </button>
            </form>

            <!-- Back to Login -->
            <div class="mt-6 text-center">
                <a href="index.php?action=officer_login" class="text-gray-400 hover:text-blue-400 transition-colors text-sm flex items-center justify-center">
                    <span class="material-icons text-sm mr-1">arrow_back</span>
                    Back to Officer Login
                </a>
            </div>
        </div>

        <!-- Security Notice -->
        <div class="mt-6 text-center text-xs text-gray-500">
            <p class="flex items-center justify-center">
                <span class="material-icons text-sm mr-1">security</span>
                This page is for authorized personnel only
            </p>
        </div>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match!');
                return false;
            }
        });
    </script>
</body>
</html>
