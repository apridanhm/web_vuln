<?php
if (!isset($_GET['auth']) || $_GET['auth'] !== 'rahasia123') {
    echo "<span style='color:red;'>Akses ditolak uweeeee coba cari cara lain wkwkkwkw 🫵🤡.</span>";
    
    // Sisipkan MD5 dalam elemen tersembunyi (hint buat yang jeli)
    echo "<span style='display:none;'>key=rahasia123</span>";
    echo "<span style='display:none;'>cara_pakai=file_inclusion.php?page=file5.php&auth=rahasia123</span>";
    
    return;
}
?>

<div class="terminal-output mt-4">
    <h4 style="color:#00ff99;">Kamu bisa akses file rahasia!</h4>
    <p>File ini tidak bisa diakses hanya dengan menebak namanya. harus pakai pass wkwkwk</p>
    <pre style="color:yellow;">FLAG{INCLUSION_WITH_EFFORT}</pre>
</div>
