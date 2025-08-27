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

// ambil data summary
$totalBooking   = $conn->query("SELECT COUNT(*) as jml FROM bookings")->fetch_assoc()['jml'];
$bookingProses  = $conn->query("SELECT COUNT(*) as jml FROM bookings WHERE status='Diproses'")->fetch_assoc()['jml'];
$bookingSelesai = $conn->query("SELECT COUNT(*) as jml FROM bookings WHERE status='Selesai'")->fetch_assoc()['jml'];
$totalUlasan    = $conn->query("SELECT COUNT(*) as jml FROM ulasan")->fetch_assoc()['jml'];

// ambil data booking detail
$bookings = $conn->query("SELECT * FROM bookings ORDER BY tanggal, jam");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>DinginBro! - Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex bg-gray-100 min-h-screen">

  <!-- Sidebar -->
  <aside class="w-64 bg-gradient-to-b from-blue-50 to-gray-100 p-6 shadow-lg flex flex-col justify-between">
    <div>
      <div class="flex items-center space-x-2 mb-8">
        <img src="/assets/logo.jpg" class="w-10 h-10" alt="Logo">
        <span class="font-bold text-xl text-blue-900">DinginBro!</span>
      </div>
      <nav class="space-y-4">
        <a href="dashboard.php" class="flex items-center space-x-2 text-blue-900 font-semibold">
          <span>📊</span><span>Dashboard</span>
        </a>
        <a href="manajemen_booking.php" class="flex items-center space-x-2 text-gray-700 hover:text-blue-700">
          <span>📄</span><span>Manajemen Booking</span>
        </a>
        <a href="layanan.php" class="flex items-center space-x-2 text-gray-700 hover:text-blue-700">
          <span>🛠️</span><span>Layanan</span>
        </a>
        <a href="ulasan.php" class="flex items-center space-x-2 text-gray-700 hover:text-blue-700">
          <span>💬</span><span>Ulasan</span>
        </a>
        <a href="pengaturan.php" class="flex items-center space-x-2 text-gray-700 hover:text-blue-700">
          <span>⚙️</span><span>Pengaturan</span>
        </a>
      </nav>
    </div>
    <div>
      <a href="logout.php" class="flex items-center space-x-2 text-red-600 hover:text-red-800">
        <span>↩️</span><span>Logout</span>
      </a>
    </div>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 p-10">
    <h1 class="text-3xl font-bold text-blue-900 mb-2">Dashboard</h1>
    <p class="text-gray-600 mb-8">Dapatkan gambaran umum tentang aktivitas dan kinerja sistem Anda.</p>

    <!-- Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
      <div class="bg-white p-6 rounded-xl shadow text-center">
        <p class="text-gray-600">Total booking</p>
        <h2 class="text-3xl font-bold"><?php echo $totalBooking; ?></h2>
      </div>
      <div class="bg-white p-6 rounded-xl shadow text-center">
        <p class="text-gray-600">Booking proses</p>
        <h2 class="text-3xl font-bold"><?php echo $bookingProses; ?></h2>
      </div>
      <div class="bg-white p-6 rounded-xl shadow text-center">
        <p class="text-gray-600">Booking selesai</p>
        <h2 class="text-3xl font-bold"><?php echo $bookingSelesai; ?></h2>
      </div>
      <div class="bg-white p-6 rounded-xl shadow text-center">
        <p class="text-gray-600">Ulasan masuk</p>
        <h2 class="text-3xl font-bold"><?php echo $totalUlasan; ?></h2>
      </div>
    </div>

    <!-- Table Booking -->
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Manajemen Booking</h2>
    <div class="bg-white shadow rounded-xl overflow-hidden">
      <table class="w-full text-left border-collapse">
        <thead class="bg-gray-100">
          <tr>
            <th class="p-3">Nama Pelanggan</th>
            <th class="p-3">Jenis Layanan</th>
            <th class="p-3">Tanggal & Jam</th>
            <th class="p-3">Alamat</th>
            <th class="p-3">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php while($row = $bookings->fetch_assoc()): ?>
            <tr class="border-b">
              <td class="p-3"><?php echo $row['nama_pelanggan']; ?></td>
              <td class="p-3"><?php echo $row['jenis_layanan']; ?></td>
              <td class="p-3"><?php echo $row['tanggal']." | ".substr($row['jam'],0,5); ?></td>
              <td class="p-3"><?php echo $row['alamat']; ?></td>
              <td class="p-3">
                <?php if($row['status']=="Diproses"): ?>
                  <span class="px-3 py-1 bg-yellow-400 text-white rounded-full text-sm">Diproses</span>
                <?php else: ?>
                  <span class="px-3 py-1 bg-blue-800 text-white rounded-full text-sm">Selesai</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </main>

</body>
</html>
