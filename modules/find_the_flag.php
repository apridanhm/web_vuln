<?php
session_start();
$page_title = "Temukan Flag";

include '../includes/header.php';
?>

<div class="text-center mb-4">
    <h2><i class="fas fa-flag me-2"></i>Find the Hidden Flag</h2>
    <p>Coba temukan dan masukkan salah satu flag tersembunyi dalam halaman ini.</p>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <form method="get">
            <input type="text" name="flag" class="form-control mb-2" placeholder="Masukkan FLAG{...}" required>
            <div class="d-grid">
                <button type="submit" class="btn btn-hack">Submit</button>
            </div>
        </form>

        <?php
        $flag_easy = "FLAG{INI_YANG_GAMPANG_CARI_LAGI_SANA_WKWKWKW}";
        $flag_hard = "FLAG{AGAK_SEDIKIT_SULIT_LAH_KLO_INI}";
        if (isset($_GET['flag'])) {
            $input = $_GET['flag'];
            if ($input === $flag_easy || $input === $flag_hard) {
                echo "<div class='alert alert-success mt-3 text-center' style='background-color:#00ff99; color:#000; font-weight:bold; border: 1px solid #00ff99; box-shadow: 0 0 10px #00ff99;'>Benar! Kamu menemukan flagnya!</div>";
            } else {
                echo "<div class='alert alert-danger mt-3'>Salah! Coba lagi.</div>";
            }
        }
        ?>
    </div>
</div>

<div style="display:none;" 91br4n_454m5ulf4t="RkxBR3tJTklfWUFOR19HQU1QQU5HX0NBUklfTEFHSV9TQU5BX1dLV0tXS1d9"></div>

<script>

(function(){
    let M4K4N = "RkxBR3tBR0FLX1NFRElLSVRfU1VMSVRfTEFIX0tMT19JTkl9";
})();
</script>

<div class="mt-4">
    <a href="../index.php" class="btn btn-outline-hack">Kembali ke Home Page</a>
</div>

<?php include '../includes/footer.php'; ?>
