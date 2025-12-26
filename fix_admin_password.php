<?php
// Script untuk memperbaiki password admin
// Jalankan melalui browser: http://localhost/Sawit_Digital/fix_admin_password.php

// Database configuration
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'sawit';

// Connect to database
$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$email = 'admin@gmail.com';
$plain_password = 'admin123';
$hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);

// Check if user exists
$check = $conn->query("SELECT id_user, email, role, password FROM users WHERE email = '$email'");
if ($check && $check->num_rows > 0) {
    $user = $check->fetch_assoc();

    // Update password
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $hashed_password, $email);

    if ($stmt->execute()) {
        $affected = $conn->affected_rows;

        echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Fix Admin Password</title>";
        echo "<style>body{font-family:Arial,sans-serif;padding:2rem;max-width:700px;margin:0 auto;background:#f5f5f5;}";
        echo "h2{color:#1B5E20;border-bottom:2px solid #1B5E20;padding-bottom:10px;}";
        echo ".success{color:#2e7d32;background:#e8f5e9;padding:1.5rem;border-radius:8px;margin:1rem 0;border-left:4px solid #2e7d32;}";
        echo ".info{color:#1976d2;background:#e3f2fd;padding:1.5rem;border-radius:8px;margin:1rem 0;border-left:4px solid #1976d2;}";
        echo ".warning{color:#f57c00;background:#fff3e0;padding:1.5rem;border-radius:8px;margin:1rem 0;border-left:4px solid #f57c00;}";
        echo ".btn{display:inline-block;padding:12px 24px;background:#1B5E20;color:white;text-decoration:none;border-radius:5px;margin-top:1rem;font-weight:bold;}";
        echo ".btn:hover{background:#0D4A12;}</style></head><body>";
        echo "<h2>✅ Password Admin Berhasil Diperbaiki!</h2>";

        echo "<div class='success'>";
        echo "<h3>Informasi Login:</h3>";
        echo "<p><strong>Email:</strong> " . htmlspecialchars($user['email']) . "</p>";
        echo "<p><strong>Password:</strong> " . htmlspecialchars($plain_password) . "</p>";
        echo "<p><strong>Role:</strong> " . htmlspecialchars($user['role']) . "</p>";
        echo "<p><strong>Status:</strong> Password telah di-hash dan disimpan ke database</p>";
        echo "<p><strong>Baris yang diupdate:</strong> " . $affected . "</p>";
        echo "</div>";

        // Verify the hash
        $verify = $conn->query("SELECT password FROM users WHERE email = '$email'");
        if ($verify && $row = $verify->fetch_assoc()) {
            $verify_result = password_verify($plain_password, $row['password']);
            echo "<div class='info'>";
            echo "<h3>Verifikasi Hash:</h3>";
            echo "<p>Panjang Hash: " . strlen($row['password']) . " karakter</p>";
            echo "<p>Verifikasi Password: " . ($verify_result ? "✅ Berhasil" : "❌ Gagal") . "</p>";
            echo "</div>";
        }

        echo "<div class='warning'>";
        echo "<h3>⚠️ PENTING!</h3>";
        echo "<p><strong>HAPUS FILE INI SETELAH MENGGUNAKANNYA!</strong></p>";
        echo "<p>File ini berisi informasi sensitif dan tidak boleh diakses publik.</p>";
        echo "</div>";

        echo "<hr>";
        echo "<p><a href='http://localhost/Sawit_Digital/admin/login' class='btn'>🔐 Klik di sini untuk Login Admin</a></p>";
        echo "</body></html>";
    } else {
        echo "Error updating password: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Error</title></head><body>";
    echo "<h2 style='color:red;'>❌ User tidak ditemukan!</h2>";
    echo "<p>Email <strong>$email</strong> tidak ditemukan di database.</p>";
    echo "<p>Pastikan user dengan email tersebut sudah ada di tabel <code>users</code>.</p>";
    echo "</body></html>";
}

$conn->close();
?>