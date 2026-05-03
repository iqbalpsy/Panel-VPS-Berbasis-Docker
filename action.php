<?php
$do = $_GET['do'] ?? '';
$name = escapeshellarg($_GET['name'] ?? '');

if (!empty($do) && !empty($name)) {
    // Kita gunakan sudo dan path lengkap agar tidak gagal
    if ($do == 'start') {
        shell_exec("sudo /usr/bin/docker start $name");
    } elseif ($do == 'stop') {
        shell_exec("sudo /usr/bin/docker stop $name");
    } elseif ($do == 'restart') {
        shell_exec("sudo /usr/bin/docker restart $name");
    } elseif ($do == 'delete') {
        shell_exec("sudo /usr/bin/docker stop $name");
        shell_exec("sudo /usr/bin/docker rm $name");
    }
    echo "success";
} else {
    echo "error";
}
?>
