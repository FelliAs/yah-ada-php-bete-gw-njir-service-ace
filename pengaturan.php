<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php?error=Silakan login dulu!");
    exit;
}

// Fungsi logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php?success=Berhasil logout!");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pengaturan</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex bg-gray-100 min-h-screen">

  <!-- Sidebar -->
  <aside class="w-64 bg-gradient-to-b from-blue-50 to-gray-100 p-6 shadow-lg flex flex-col justify-between">
    <div>
      <div class="flex justify-center mb-8">
        <img src="assets/logo.jpg" 
            class="w-40 h-16 object-cover rounded-lg" 
            alt="Logo">
      </div>
      <nav class="space-y-4">
        <a href="dashboard.php" class="flex items-center space-x-2 text-gray-700 hover:text-blue-700">📊 <span>Dashboard</span></a>
        <a href="manajemen_booking.php" class="flex items-center space-x-2 text-gray-700 hover:text-blue-700">📄 <span>Manajemen Booking</span></a>
        <a href="layanan.php" class="flex items-center space-x-2 text-gray-700 hover:text-blue-700">🛠️ <span>Layanan</span></a>
        <a href="ulasan.php" class="flex items-center space-x-2 text-gray-700 hover:text-blue-700">💬 <span>Ulasan</span></a>
        <a href="pengaturan.php" class="flex items-center space-x-2 text-blue-900 font-semibold">⚙️ <span>Pengaturan</span></a>
      </nav>
    </div>
    <div>
      <a href="pengaturan.php?logout=true" class="flex items-center space-x-2 text-red-600 hover:text-red-800">↩️ <span>Logout</span></a>
    </div>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 p-10">
    <h1 class="text-3xl font-bold text-blue-900 mb-2">Pengaturan</h1>
    <p class="text-gray-600 mb-8">Kelola pengaturan dan preferensi akun Anda.</p>

    <!-- Pengaturan Akun -->
    <div class="bg-white rounded-2xl shadow p-6 mb-6 flex justify-between items-center">
      <div>
        <h2 class="font-semibold text-lg mb-3">Pengaturan Akun</h2>
        <div class="space-y-2 text-gray-700">
          <button class="block w-full text-left hover:text-blue-600">Ganti Kata Sandi</button>
          <button class="block w-full text-left hover:text-blue-600">Ganti Username / Email</button>
          <p>Hak Akses: <span class="font-semibold">Admin</span></p>
        </div>
      </div>
      <div class="text-center">
        <img src="assets/profile.jpg" class="w-16 h-16 rounded-full mb-2 border" alt="Foto Profil">
        <button class="text-sm text-blue-600 hover:underline">Ganti foto profil</button>
      </div>
    </div>

    <!-- Pengaturan Sistem -->
    <div class="bg-white rounded-2xl shadow p-6 mb-6 flex justify-between items-center">
      <div>
        <h2 class="font-semibold text-lg mb-3">Pengaturan Sistem</h2>
        <div class="space-y-2 text-gray-700">
          <p>Nama Aplikasi: <span class="font-semibold">DinginBro!</span></p>
          <p>Logo Aplikasi: <span class="text-blue-600 hover:underline cursor-pointer">Ganti Logo</span></p>
          <!-- Warna tema skip -->
          <p>Info Kontak: <span class="font-semibold">+62 852-8291-7804</span></p>
        </div>
      </div>
      <div class="text-center">
        <img src="logo.png" class="w-16 h-16 rounded-full mb-2 border" alt="Logo Aplikasi">
      </div>
    </div>

    <!-- Pengaturan Notifikasi -->
    <div class="bg-white rounded-2xl shadow p-6">
      <h2 class="font-semibold text-lg mb-3">Pengaturan Notifikasi</h2>
      <div class="space-y-3 text-gray-700">
        <label class="flex items-center justify-between">
          <span>Notifikasi Email</span>
          <input type="checkbox" checked class="w-6 h-6 accent-green-500">
        </label>
        <label class="flex items-center justify-between">
          <span>Notifikasi WhatsApp</span>
          <input type="checkbox" checked class="w-6 h-6 accent-green-500">
        </label>
        <label class="flex items-center justify-between">
          <span>Reminder Otomatis</span>
          <input type="checkbox" checked class="w-6 h-6 accent-green-500">
        </label>
      </div>
    </div>
  </main>
</body>
</html>
