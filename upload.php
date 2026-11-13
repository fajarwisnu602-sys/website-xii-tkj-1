<?php
/* HALAMAN UPLOAD FOTO — buka http://localhost/tkj-xii-1/upload.php */
const PASSWORD = 'tkj12345';   // ganti password ini jika website dipasang online
const MAX_MB = 15;

$src = @file_get_contents(__DIR__ . '/index.php');
preg_match_all('/\{name:"([^"]+)"/', $src, $m);
$students = $m[1] ?? [];
$msg = [];

function clean($s) { return trim(preg_replace('/[\\\\\/:*?"<>|]+/', '', $s)); }

function store($tmp, $base) {
    $info = @getimagesize($tmp);
    $map = [IMAGETYPE_JPEG => 'jpg', IMAGETYPE_PNG => 'png', IMAGETYPE_WEBP => 'webp', IMAGETYPE_GIF => 'gif'];
    if (!$info || !isset($map[$info[2]])) return false;
    $ext = $map[$info[2]];
    if ($ext !== 'gif' && function_exists('imagecreatefromstring')) {
        $im = @imagecreatefromstring(file_get_contents($tmp));
        if ($im) {
            if ($ext === 'jpg' && function_exists('exif_read_data')) {
                $e = @exif_read_data($tmp);
                $deg = [3 => 180, 6 => -90, 8 => 90][$e['Orientation'] ?? 1] ?? 0;
                if ($deg) $im = imagerotate($im, $deg, 0);
            }
            $w = imagesx($im); $h = imagesy($im); $s = min(1, 1600 / max($w, $h));
            if ($s < 1) $im = imagescale($im, (int)($w * $s));
            imagejpeg($im, "$base.jpg", 85);
            return "$base.jpg";
        }
    }
    return move_uploaded_file($tmp, "$base.$ext") ? "$base.$ext" : false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['jenis'] ?? '';
    if (!hash_equals(PASSWORD, $_POST['pw'] ?? '')) {
        $msg[] = ['err', 'Password salah.'];
    } elseif (!in_array($type, ['utama', 'siswa', 'galeri'], true)) {
        $msg[] = ['err', 'Pilih jenis foto dulu.'];
    } elseif (empty($_FILES['foto']['name'][0])) {
        $msg[] = ['err', 'Belum ada foto yang dipilih.'];
    } else {
        $dir = __DIR__ . '/assets/img/' . $type;
        if (!is_dir($dir)) mkdir($dir, 0777, true);
        $f = $_FILES['foto'];
        $count = $type === 'siswa' ? 1 : count($f['name']);
        for ($i = 0; $i < $count; $i++) {
            $nm = $f['name'][$i];
            if ($f['error'][$i] !== UPLOAD_ERR_OK) { $msg[] = ['err', "$nm: gagal diupload (kode {$f['error'][$i]})."]; continue; }
            if ($f['size'][$i] > MAX_MB * 1048576) { $msg[] = ['err', "$nm: lebih dari " . MAX_MB . " MB."]; continue; }
            if ($type === 'siswa') {
                $who = $_POST['siswa'] ?? '';
                if (!in_array($who, $students, true)) { $msg[] = ['err', 'Pilih nama siswa dulu.']; break; }
                foreach (glob("$dir/$who.*") ?: [] as $old) unlink($old);
                $base = "$dir/$who";
            } elseif ($type === 'galeri') {
                $kat = clean($_POST['kategori'] ?? 'Kebersamaan') ?: 'Kebersamaan';
                $judul = clean($_POST['judul'] ?? '') ?: 'Foto ' . date('d-m-Y');
                $base = "$dir/$kat - $judul"; $k = 1;
                while (glob("$base.*")) { $k++; $base = "$dir/$kat - $judul $k"; }
            } else {
                $base = "$dir/foto-" . date('Ymd-His') . "-$i";
            }
            $res = store($f['tmp_name'][$i], $base);
            $msg[] = $res ? ['ok', "$nm berhasil disimpan."] : ['err', "$nm: bukan file gambar (pakai jpg/png/webp)."];
        }
    }
}
$e = fn($s) => htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Upload Foto | XII TKJ 1</title>
<style>
body{margin:0;min-height:100vh;display:grid;place-items:center;background:radial-gradient(circle at 20% 0,#12104a,#05060f 60%);color:#dfe6ff;font:16px/1.6 Segoe UI,Arial,sans-serif;padding:20px}
form{width:min(480px,100%);background:rgba(255,255,255,.06);border:1px solid rgba(120,160,255,.25);border-radius:20px;padding:28px;box-shadow:0 0 40px rgba(45,107,255,.2)}
h1{margin:0 0 4px;font-size:1.4rem;background:linear-gradient(90deg,#00f0ff,#9b5cff);-webkit-background-clip:text;background-clip:text;color:transparent}
p.s{margin:0 0 18px;opacity:.7;font-size:.85rem}label{display:block;margin:14px 0 4px;font-size:.85rem;color:#00f0ff}
input,select{width:100%;padding:11px 14px;border-radius:12px;border:1px solid rgba(120,160,255,.3);background:rgba(5,6,15,.7);color:#fff;font:inherit;box-sizing:border-box}
button{width:100%;margin-top:22px;padding:13px;border:0;border-radius:30px;background:linear-gradient(90deg,#2d6bff,#9b5cff);color:#fff;font:600 1rem inherit;cursor:pointer}
.ok{color:#7dffb3}.err{color:#ff7d9a}.m{margin:2px 0;font-size:.88rem}a{color:#00f0ff;font-size:.85rem}.hide{display:none}
</style></head><body>
<form method="post" enctype="multipart/form-data">
  <h1>📷 Upload Foto XII TKJ 1</h1><p class="s">Pilih jenis, pilih foto, klik upload. Nama file diatur otomatis.</p>
  <?php foreach ($msg as [$c, $t]): ?><div class="m <?= $c ?>"><?= $c === 'ok' ? '✔' : '✖' ?> <?= $e($t) ?></div><?php endforeach; ?>
  <label>Jenis foto</label>
  <select name="jenis" id="j" onchange="sw()">
    <option value="utama">Tampilan utama (slideshow)</option>
    <option value="siswa">Foto siswa</option>
    <option value="galeri">Galeri kenangan</option>
  </select>
  <div id="fs" class="hide"><label>Nama siswa</label>
    <select name="siswa"><?php foreach ($students as $s): ?><option><?= $e($s) ?></option><?php endforeach; ?></select></div>
  <div id="fg" class="hide"><label>Kategori</label>
    <select name="kategori"><option>Praktik</option><option>Sekolah</option><option>Study Tour</option><option>Kebersamaan</option></select>
    <label>Judul foto</label><input name="judul" placeholder="contoh: Konfigurasi Mikrotik"></div>
  <label>Pilih foto (bisa lebih dari satu)</label>
  <input type="file" name="foto[]" id="ft" accept="image/*" multiple required>
  <label>Password</label><input type="password" name="pw" placeholder="tkj12345" required>
  <button>Upload</button>
  <p style="text-align:center;margin:16px 0 0"><a href="index.php">← Lihat website</a></p>
</form>
<script>
function sw(){var j=document.getElementById('j').value;
 document.getElementById('fs').classList.toggle('hide',j!=='siswa');
 document.getElementById('fg').classList.toggle('hide',j!=='galeri');
 document.getElementById('ft').multiple=j!=='siswa';}
sw();
</script></body></html>
