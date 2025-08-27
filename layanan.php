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

// Ambil data layanan
$layanan = $conn->query("SELECT * FROM layanan ORDER BY id DESC");
?>

// Fungsi logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php?success=Berhasil logout!");
    exit;
}

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Layanan</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    function filterLayanan() {
      let input = document.getElementById("searchInput").value.toLowerCase();
      let cards = document.querySelectorAll(".layanan-card");
      cards.forEach(card => {
        let nama = card.querySelector(".nama-layanan").textContent.toLowerCase();
        card.style.display = nama.includes(input) ? "" : "none";
      });
    }
  </script>
</head>
<body class="flex bg-gray-100 min-h-screen">

  <!-- Sidebar -->
  <aside class="w-64 bg-gradient-to-b from-blue-50 to-gray-100 p-6 shadow-lg flex flex-col justify-between">
    <div>
      <div class="flex items-center space-x-2 mb-8">
        <img src="logo.png" class="w-10 h-10" alt="Logo">
        <span class="font-bold text-xl text-blue-900">DinginBro!</span>
      </div>
      <nav class="space-y-4">
        <a href="dashboard.php" class="flex items-center space-x-2 text-gray-700 hover:text-blue-700">📊 <span>Dashboard</span></a>
        <a href="manajemen_booking.php" class="flex items-center space-x-2 text-gray-700 hover:text-blue-700">📄 <span>Manajemen Booking</span></a>
        <a href="layanan.php" class="flex items-center space-x-2 text-blue-900 font-semibold">🛠️ <span>Layanan</span></a>
        <a href="ulasan.php" class="flex items-center space-x-2 text-gray-700 hover:text-blue-700">💬 <span>Ulasan</span></a>
        <a href="pengaturan.php" class="flex items-center space-x-2 text-gray-700 hover:text-blue-700">⚙️ <span>Pengaturan</span></a>
      </nav>
    </div>
    <div>
      <a href="logout.php" class="flex items-center space-x-2 text-red-600 hover:text-red-800">↩️ <span>Logout</span></a>
    </div>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 p-10">
    <h1 class="text-3xl font-bold text-blue-900 mb-2">Layanan</h1>
    <p class="text-gray-600 mb-6">Tambah, ubah, atau hapus layanan yang tersedia untuk pelanggan.</p>

    <!-- Search -->
    <div class="mb-8">
      <input id="searchInput" onkeyup="filterLayanan()" 
             type="text" placeholder="Search Jenis Layanan" 
             class="w-full md:w-1/2 px-4 py-2 border rounded-lg shadow-sm">
    </div>

    <!-- Grid Layanan -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php while($row = $layanan->fetch_assoc()): ?>
        <div class="layanan-card bg-white rounded-2xl shadow hover:shadow-lg transition p-3 flex flex-col">
          <!-- Gambar -->
          <img src="<?php echo $row['gambar']; ?>" 
              class="h-40 w-full object-cover rounded-xl mb-3">

          <!-- Nama & Status -->
          <div class="px-2 flex-1">
            <h3 class="nama-layanan font-semibold text-lg"><?php echo $row['nama']; ?></h3>
            <p class="text-sm flex items-center mt-1">
              <?php if ($row['status'] == "Aktif"): ?>
                <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                <span class="text-green-600">Aktif</span>
              <?php else: ?>
                <span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                <span class="text-red-600">Non Aktif</span>
              <?php endif; ?>
            </p>
          </div>

          <!-- Tombol Edit -->
          <div class="mt-3 px-2 flex justify-end">
            <a href="edit_layanan.php?id=<?php echo $row['id']; ?>" 
              class="px-4 py-1 text-sm rounded-lg border border-gray-400 hover:bg-gray-100">
              Edit
            </a>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </main>
</body>
</html>
