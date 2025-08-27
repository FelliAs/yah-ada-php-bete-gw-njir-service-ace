<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php?error=Silakan login dulu!");
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
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Layanan</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    function searchLayanan() {
      let input = document.getElementById("searchInput").value.toLowerCase();
      let cards = document.querySelectorAll(".layanan-card");

      cards.forEach(card => {
        let nama = card.querySelector(".nama-layanan").textContent.toLowerCase();
        if (nama.includes(input)) {
          card.style.display = "";
        } else {
          card.style.display = "none";
        }
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
    <p class="text-gray-600 mb-8">Tambah, ubah, atau hapus layanan yang tersedia untuk pelanggan.</p>

    <!-- Search -->
    <div class="mb-6">
      <input type="text" id="searchInput" onkeyup="searchLayanan()" 
             placeholder="Search Jenis Layanan"
             class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-300">
    </div>

    <!-- Grid Layanan -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php while($row = $layanan->fetch_assoc()): ?>
        <div class="layanan-card bg-white rounded-xl shadow p-4 flex flex-col">
          <img src="uploads/<?php echo $row['gambar']; ?>" alt="<?php echo $row['nama_layanan']; ?>" 
               class="w-full h-40 object-cover rounded-lg mb-3">
          <div class="flex-1">
            <h3 class="nama-layanan text-lg font-semibold"><?php echo $row['nama_layanan']; ?></h3>
            <p class="flex items-center mt-1">
              <span class="w-3 h-3 rounded-full mr-2 <?php echo $row['status']=='Aktif' ? 'bg-green-500':'bg-red-500'; ?>"></span>
              <span class="text-sm"><?php echo $row['status']; ?></span>
            </p>
          </div>
          <a href="edit_layanan.php?id=<?php echo $row['id']; ?>" 
             class="mt-3 inline-block px-4 py-2 text-sm border rounded-lg hover:bg-gray-100 text-center">Edit</a>
        </div>
      <?php endwhile; ?>
    </div>
  </main>
</body>
</html>
