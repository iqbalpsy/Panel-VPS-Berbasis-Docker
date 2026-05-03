<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = escapeshellarg($_POST['vps_name']);
    $image = escapeshellarg($_POST['os_image']);

    // Perintah untuk membuat container baru berdasarkan input user
    shell_exec("sudo docker run -d --name $name $image sleep infinity");

    header("Location: index.php");
    exit;
}
?>
