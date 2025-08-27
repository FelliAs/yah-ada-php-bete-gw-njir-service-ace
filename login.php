<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DinginBro! - Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

  <div class="w-full max-w-5xl flex flex-col md:flex-row items-center justify-between px-6 py-12">
    
    <!-- Bagian kiri -->
    <div class="flex flex-col items-start space-y-6">
      <div class="flex justify-center mb-8">
        <img src="assets/logo.jpg" 
            class="w-40 h-16 object-cover rounded-lg" 
            alt="Logo">
      </div>

      <h1 class="text-5xl font-extrabold text-blue-900">Welcome!</h1>
      <hr class="w-16 border border-gray-500">
      <p class="text-gray-600 text-lg max-w-md">
        AC Terawat, Hidup Lebih Nikmat – Bareng DinginBro.
      </p>
    </div>

    <!-- Bagian kanan -->
    <div class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-3xl shadow-lg p-10 w-full max-w-md mt-10 md:mt-0">
      <h2 class="text-2xl font-bold text-blue-900 mb-6 text-center">Sign in</h2>
      
      <?php 
        if (isset($_GET['error'])) {
          echo "<p class='text-red-500 text-center mb-4'>".$_GET['error']."</p>";
        }
      ?>

      <form method="POST" action="proses_login.php" class="space-y-5">
        <input type="text" name="username" placeholder="Username" required
          class="w-full px-4 py-3 border rounded-full outline-none focus:ring-2 focus:ring-blue-400">

        <input type="password" name="password" placeholder="Password" required
          class="w-full px-4 py-3 border rounded-full outline-none focus:ring-2 focus:ring-blue-400">

        <button type="submit" 
          class="w-full py-3 rounded-full text-white font-semibold bg-gradient-to-r from-blue-400 to-gray-400 hover:opacity-90 transition">
          Submit
        </button>
      </form>
    </div>

  </div>
</body>
</html>
