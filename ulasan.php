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

$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_dinginbro";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

// Ambil data ulasan
$ulasan = $conn->query("SELECT * FROM ulasan ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Ulasan</title>
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
        <a href="ulasan.php" class="flex items-center space-x-2 text-blue-900 font-semibold">💬 <span>Ulasan</span></a>
        <a href="pengaturan.php" class="flex items-center space-x-2 text-gray-700 hover:text-blue-700">⚙️ <span>Pengaturan</span></a>
      </nav>
    </div>
    <div>
      <a href="ulasan.php?logout=true" class="flex items-center space-x-2 text-red-600 hover:text-red-800">↩️ <span>Logout</span></a>
    </div>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 p-10">
    <h1 class="text-3xl font-bold text-blue-900 mb-2">Ulasan</h1>
    <p class="text-gray-600 mb-8">Baca dan kelola ulasan dari pelanggan untuk meningkatkan kualitas layanan.</p>

    <!-- Grid Ulasan -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php while($row = $ulasan->fetch_assoc()): ?>
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-2xl shadow">
          <!-- Header -->
          <div class="flex items-center space-x-3 mb-3">
            <img src="<?php echo $row['avatar']; ?>" alt="Avatar" class="w-10 h-10 rounded-full bg-white border">
            <div>
              <h3 class="font-bold"><?php echo $row['nama']; ?></h3>
              <p class="text-xs text-gray-500"><?php echo $row['waktu']; ?></p>
            </div>
          </div>
          <!-- Rating -->
          <div class="flex text-yellow-500 mb-2">
            <?php for($i=0;$i<$row['rating'];$i++): ?>
              ★
            <?php endfor; ?>
          </div>
          <!-- Komentar -->
          <p class="text-gray-700 text-sm leading-relaxed">
            <?php echo $row['komentar']; ?>
          </p>
        </div>
      <?php endwhile; ?>
    </div>
  </main>
</body>
</html>
