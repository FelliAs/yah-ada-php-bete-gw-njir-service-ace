<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
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

// handle aksi update status
if (isset($_POST['aksi'])) {
    $id = intval($_POST['id']);
    if ($_POST['aksi'] === 'Diproses' || $_POST['aksi'] === 'Selesai') {
        $stmt = $conn->prepare("UPDATE bookings SET status=? WHERE id=?");
        $stmt->bind_param("si", $_POST['aksi'], $id);
        $stmt->execute();
    }
    if ($_POST['aksi'] === 'Hapus') {
        // pindahkan ke tabel bookings_deleted
        $conn->query("INSERT INTO bookings_deleted 
                      (nama_pelanggan, jenis_layanan, tanggal, jam, alamat, status)
                      SELECT nama_pelanggan, jenis_layanan, tanggal, jam, alamat, status 
                      FROM bookings WHERE id=$id");
        // hapus dari bookings
        $conn->query("DELETE FROM bookings WHERE id=$id");
    }
    header("Location: manajemen_booking.php");
    exit;
}

// ambil data booking
$bookings = $conn->query("SELECT * FROM bookings ORDER BY tanggal, jam");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Manajemen Booking</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    function toggleMenu(id) {
      document.querySelectorAll('.menu-popup').forEach(el => {
        if (el.id !== 'menu-'+id) el.classList.add('hidden');
      });
      document.getElementById('menu-'+id).classList.toggle('hidden');
    }

    // fungsi filter tabel
    function filterTable() {
      let searchInput = document.getElementById("searchInput").value.toLowerCase();
      let statusFilter = document.getElementById("statusFilter").value;
      let dateFilter = document.getElementById("dateFilter").value;

      let rows = document.querySelectorAll("#bookingTable tbody tr");

      rows.forEach(row => {
        let nama = row.querySelector(".nama").textContent.toLowerCase();
        let status = row.querySelector(".status-btn").textContent.trim();
        let tanggal = row.querySelector(".tanggal").textContent.split("|")[0].trim();

        let matchSearch = nama.includes(searchInput);
        let matchStatus = (statusFilter === "" || status === statusFilter);
        let matchDate = (dateFilter === "" || tanggal === dateFilter);

        if (matchSearch && matchStatus && matchDate) {
          row.style.display = "";
        } else {
          row.style.display = "none";
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
        <a href="dashboard.php" class="flex items-center space-x-2 text-gray-700 hover:text-blue-700">
          <span>📊</span><span>Dashboard</span>
        </a>
        <a href="manajemen_booking.php" class="flex items-center space-x-2 text-blue-900 font-semibold">
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
    <h1 class="text-3xl font-bold text-blue-900 mb-2">Manajemen Booking</h1>
    <p class="text-gray-600 mb-8">Kelola dan lacak semua pemesanan layanan Anda dengan mudah dalam satu tempat.</p>

    <!-- Search & Filter -->
    <div class="flex flex-wrap gap-4 mb-6 p-4 bg-green-300 rounded-lg shadow">
      <!-- Search nama -->
      <input type="text" id="searchInput" 
            onkeyup="filterTable()" 
            placeholder="Cari nama pelanggan..." 
            class="px-3 py-2 border rounded-lg w-60">

      <!-- Filter status -->
      <select id="statusFilter" onchange="filterTable()" class="px-3 py-2 border rounded-lg">
        <option value="">Semua Status</option>
        <option value="Diproses">Diproses</option>
        <option value="Selesai">Selesai</option>
      </select>

      <!-- Filter tanggal -->
      <input type="date" id="dateFilter" onchange="filterTable()" class="px-3 py-2 border rounded-lg">
    </div>


    <!-- Tabel Booking -->
    <div class="bg-white shadow rounded-xl overflow-hidden">
      <table id="bookingTable" class="w-full text-left border-collapse">
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
              <td class="p-3 nama"><?php echo $row['nama_pelanggan']; ?></td>
              <td class="p-3"><?php echo $row['jenis_layanan']; ?></td>
              <td class="p-3 tanggal"><?php echo $row['tanggal']." | ".substr($row['jam'],0,5); ?></td>
              <td class="p-3"><?php echo $row['alamat']; ?></td>
              <td class="p-3 relative">
                <button onclick="toggleMenu(<?php echo $row['id']; ?>)"
                        class="status-btn px-3 py-1 rounded-full text-white text-sm
                               <?php echo $row['status']=="Diproses" ? 'bg-yellow-400' : 'bg-blue-800'; ?>">
                  <?php echo $row['status']; ?>
                </button>
                <div id="menu-<?php echo $row['id']; ?>" 
                     class="menu-popup hidden absolute right-0 mt-2 w-28 bg-white shadow rounded-lg z-10">
                  <form method="post">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button name="aksi" value="Diproses" class="block w-full px-3 py-2 text-left text-yellow-600 hover:bg-gray-100">Diproses</button>
                    <button name="aksi" value="Selesai" class="block w-full px-3 py-2 text-left text-blue-600 hover:bg-gray-100">Selesai</button>
                    <?php if($row['status']=="Selesai"): ?>
                      <button name="aksi" value="Hapus" class="block w-full px-3 py-2 text-left text-red-600 hover:bg-gray-100">Hapus</button>
                    <?php endif; ?>
                  </form>
                </div>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </main>
</body>
</html>
