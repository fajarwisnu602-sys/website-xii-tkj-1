<?php
// Baca foto otomatis dari folder assets/img/{utama,siswa,galeri}
function scan($d){$o=[];$f=glob(__DIR__."/assets/img/$d/*.{jpg,jpeg,png,webp,gif,JPG,JPEG,PNG,WEBP,GIF}",GLOB_BRACE)?:[];
  foreach($f as $p)$o[]="assets/img/$d/".rawurlencode(basename($p));sort($o);return $o;}
$AUTO=['hero'=>scan('utama'),'siswa'=>scan('siswa'),'galeri'=>scan('galeri')];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>XII TKJ 1 | One Class, One Network, One Family</title>
<link rel="icon" href="assets/img/logo.jpeg">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600;800&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<style>
:root{--bg:#05060f;--blue:#2d6bff;--cyan:#00f0ff;--purple:#9b5cff;--txt:#dfe6ff;--glass:rgba(255,255,255,.05);--bd:rgba(120,160,255,.2)}
*{margin:0;padding:0;box-sizing:border-box;cursor:none}
html{scroll-behavior:smooth;scroll-padding-top:70px}
body{background:radial-gradient(circle at 20% 0,#12104a 0,transparent 40%),radial-gradient(circle at 90% 60%,#2a0f55 0,transparent 40%),var(--bg);color:var(--txt);font:300 16px/1.7 Poppins,sans-serif;overflow-x:hidden}
.mono{font-family:Consolas,monospace}
#bg-video{position:fixed;inset:0;width:100%;height:100%;object-fit:cover;z-index:-2;pointer-events:none}
#bg-overlay{position:fixed;inset:0;z-index:-1;pointer-events:none;background:linear-gradient(180deg,rgba(5,6,15,.55),rgba(10,8,40,.62) 50%,rgba(5,6,15,.78))}
a{color:inherit;text-decoration:none}
.glass{background:var(--glass);backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px);border:1px solid var(--bd);border-radius:18px;box-shadow:0 0 30px rgba(45,107,255,.08)}
.pad{padding:26px}
section{padding:90px 6vw;max-width:1250px;margin:auto}
.title{font:800 clamp(1.6rem,4vw,2.6rem) Orbitron;text-align:center;margin-bottom:40px}
.title span{background:linear-gradient(90deg,var(--cyan),var(--purple));-webkit-background-clip:text;background-clip:text;color:transparent}
h3{font:600 1.05rem Orbitron;color:var(--cyan);margin-bottom:8px}
.center{text-align:center}
#loader{position:fixed;inset:0;background:var(--bg);z-index:999;display:grid;place-content:center;justify-items:center;gap:20px;transition:.6s}
#loader.off{opacity:0;visibility:hidden}
.ring{width:70px;height:70px;border-radius:50%;border:3px solid transparent;border-top-color:var(--cyan);border-bottom-color:var(--purple);animation:spin 1s linear infinite;box-shadow:0 0 25px var(--blue)}
@keyframes spin{to{transform:rotate(360deg)}}
#cur-dot,#cur-ring{position:fixed;top:0;left:0;pointer-events:none;z-index:1000;border-radius:50%}
#cur-dot{width:7px;height:7px;background:var(--cyan);box-shadow:0 0 12px var(--cyan);margin:-3px}
#cur-ring{width:34px;height:34px;border:1px solid var(--purple);margin:-17px;transition:width .2s,height .2s,margin .2s,border-color .2s}
#cur-ring.hov{width:54px;height:54px;margin:-27px;border-color:var(--cyan)}
@media(hover:none){*{cursor:auto}#cur-dot,#cur-ring{display:none}}
.nav{position:fixed;top:12px;left:50%;transform:translateX(-50%);width:min(1200px,94vw);display:flex;align-items:center;justify-content:space-between;padding:10px 22px;z-index:50;border-radius:50px}
.logo{font:800 1.2rem Orbitron}.logo span{color:var(--cyan);text-shadow:0 0 12px var(--cyan)}
#menu{display:flex;gap:22px;font-size:.9rem}
#menu a{opacity:.75;transition:.3s}#menu a:hover,#menu a.act{opacity:1;color:var(--cyan);text-shadow:0 0 10px var(--cyan)}
.clock{text-align:right;line-height:1.2;font-size:.95rem;color:var(--cyan)}.clock small{display:block;font-size:.65rem;opacity:.7;color:var(--txt)}
#burger{display:none;background:none;border:0;color:var(--cyan);font-size:1.6rem}
.hero{min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;gap:18px;max-width:none}
.chip{border:1px solid var(--bd);padding:6px 16px;border-radius:30px;font-size:.8rem;color:var(--cyan);background:var(--glass)}
.glitch{font:800 clamp(2.2rem,8vw,5.6rem)/1.1 Orbitron;background:linear-gradient(90deg,var(--cyan),var(--blue),var(--purple),var(--cyan));background-size:300%;-webkit-background-clip:text;background-clip:text;color:transparent;animation:flow 6s linear infinite;filter:drop-shadow(0 0 22px rgba(0,240,255,.45))}
@keyframes flow{to{background-position:300%}}
.tag{font-size:clamp(1rem,2.5vw,1.5rem);letter-spacing:2px}
.typed{color:#7dffb3;min-height:1.6em}.typed i{animation:blink 1s infinite}@keyframes blink{50%{opacity:0}}
.btn{margin-top:14px;padding:14px 34px;border-radius:40px;font-weight:600;background:linear-gradient(90deg,var(--blue),var(--purple));box-shadow:0 0 25px rgba(90,100,255,.6);transition:.3s}
.btn:hover{transform:translateY(-4px) scale(1.04);box-shadow:0 0 45px var(--cyan)}
.grid2{display:grid;grid-template-columns:1fr 1fr;gap:22px}.stack{display:grid;gap:22px}
.pad p{margin-bottom:14px}.pad ul{padding-left:20px}
.stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:20px;margin-top:26px}
.stat{padding:26px;text-align:center}.stat b{display:block;font:800 2.6rem Orbitron;color:var(--cyan);text-shadow:0 0 18px var(--cyan)}
.search{display:block;width:min(500px,100%);margin:0 auto 34px;padding:14px 22px;color:var(--txt);font:inherit;outline:0;border-radius:40px}
.search:focus{border-color:var(--cyan);box-shadow:0 0 22px rgba(0,240,255,.3)}
.cards{display:grid;grid-template-columns:repeat(auto-fill,minmax(190px,1fr));gap:20px}
.card{padding:18px;text-align:center;transition:.35s;position:relative;overflow:hidden}
.card::before{content:"";position:absolute;inset:0;background:linear-gradient(135deg,transparent 40%,rgba(0,240,255,.18));opacity:0;transition:.35s}
.card:hover{transform:translateY(-10px);border-color:var(--cyan);box-shadow:0 12px 40px rgba(0,240,255,.25)}.card:hover::before{opacity:1}
.card img{width:110px;height:110px;border-radius:50%;object-fit:cover;border:2px solid var(--purple);box-shadow:0 0 20px var(--purple);margin-bottom:12px}
.card h4{font-weight:600;font-size:.95rem}.card span{font-size:.78rem;color:var(--cyan)}
.org{display:flex;flex-direction:column;align-items:center}
.row{display:flex;flex-wrap:wrap;justify-content:center;gap:16px;position:relative;padding-top:30px}
.row::before{content:"";position:absolute;top:0;left:50%;height:30px;border-left:2px solid var(--cyan);box-shadow:0 0 8px var(--cyan)}
.row:first-child{padding-top:0}.row:first-child::before{display:none}
.node{padding:14px 24px;text-align:center;min-width:170px;transition:.3s}.node:hover{border-color:var(--cyan);transform:scale(1.06)}
.node small{display:block;color:var(--cyan);font-size:.72rem;letter-spacing:1px;text-transform:uppercase}.node b{font-weight:600}
.node.top{border-color:var(--purple);box-shadow:0 0 28px rgba(155,92,255,.4)}
.filters{display:flex;flex-wrap:wrap;justify-content:center;gap:10px;margin-bottom:28px}
.filters button{background:var(--glass);color:var(--txt);border:1px solid var(--bd);padding:8px 20px;border-radius:30px;font:inherit;font-size:.85rem;transition:.3s}
.filters button.on,.filters button:hover{background:linear-gradient(90deg,var(--blue),var(--purple));border-color:transparent}
.gallery{display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:18px}
.ph{aspect-ratio:4/3;border-radius:16px;overflow:hidden;position:relative;border:1px solid var(--bd);transition:.35s}
.ph:hover{transform:scale(1.03);box-shadow:0 0 30px rgba(155,92,255,.5)}
.ph img,.ph .art{width:100%;height:100%;object-fit:cover;display:grid;place-content:center;font-size:3rem}
.ph .cap{position:absolute;inset:auto 0 0;padding:30px 14px 12px;background:linear-gradient(transparent,rgba(0,0,0,.85));font-size:.85rem}
.ph .cap small{color:var(--cyan);display:block;font-size:.7rem}
.acts{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:22px}
.act{padding:28px;transition:.35s}.act:hover{transform:translateY(-8px);border-color:var(--purple);box-shadow:0 0 35px rgba(155,92,255,.35)}
.act .ic{font-size:2.4rem;display:inline-grid;place-content:center;width:64px;height:64px;border-radius:16px;background:linear-gradient(135deg,rgba(45,107,255,.35),rgba(155,92,255,.35));margin-bottom:14px}
footer{max-width:900px;margin:40px auto 30px;padding:30px;text-align:center;width:92%}
footer p{font:600 1.1rem Orbitron;margin-bottom:14px}
.socials{display:flex;justify-content:center;flex-wrap:wrap;gap:12px;margin-bottom:14px}
.socials a{padding:8px 18px;border:1px solid var(--bd);border-radius:30px;transition:.3s;font-size:.85rem}.socials a:hover{border-color:var(--cyan);box-shadow:0 0 18px var(--cyan);transform:translateY(-3px)}
footer small{opacity:.6}
#lb{position:fixed;inset:0;background:rgba(2,3,10,.92);z-index:200;display:flex;align-items:center;justify-content:center;gap:10px}
#lb[hidden]{display:none}
#lb figure{width:min(820px,80vw);text-align:center}
#lbimg{aspect-ratio:4/3;border-radius:16px;overflow:hidden;display:grid;place-content:center;font-size:6rem;box-shadow:0 0 50px rgba(0,240,255,.3)}
#lbimg img{width:100%;height:100%;object-fit:contain}
#lbimg .art{width:100%;height:100%;display:grid;place-content:center}
#lbcap{margin-top:12px}
#lb button{background:var(--glass);color:#fff;border:1px solid var(--bd);width:46px;height:46px;border-radius:50%;font-size:1.4rem}
#lb .x{position:absolute;top:20px;right:20px}
.fab{position:fixed;right:20px;width:48px;height:48px;border-radius:50%;color:var(--cyan);font-size:1.2rem;z-index:60;border-color:var(--cyan)}
#music{bottom:20px}#top{bottom:78px;opacity:0;pointer-events:none;transition:.3s}#top.show{opacity:1;pointer-events:auto}
.reveal{opacity:0;transform:translateY(30px);transition:opacity .8s,transform .8s}.reveal.in{opacity:1;transform:none}
@media(max-width:860px){
  .grid2{grid-template-columns:1fr}.clock{display:none}#burger{display:block}
  #menu{position:absolute;top:64px;left:0;right:0;flex-direction:column;padding:20px;gap:14px;background:rgba(5,6,15,.95);border:1px solid var(--bd);border-radius:18px;display:none}
  #menu.open{display:flex}
  section{padding:70px 5vw}#lb figure{width:70vw}
}
@media(prefers-reduced-motion:reduce){*{animation:none!important;transition:none!important}}

/* foto tampilan utama */
.hero-photo{position:relative;width:min(520px,88vw);aspect-ratio:4/3;margin-top:10px;border-radius:22px;padding:4px;background:linear-gradient(135deg,var(--cyan),var(--blue),var(--purple));box-shadow:0 0 45px rgba(0,240,255,.35),0 0 90px rgba(155,92,255,.25);animation:float 5s ease-in-out infinite}
.hero-photo .in-box{position:relative;width:100%;height:100%;border-radius:18px;overflow:hidden;background:#0a0c20}
.hero-photo img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center 40%;opacity:0;transition:opacity 1s}
.hero-photo img.on{opacity:1}
.hero-photo .ph-empty{display:grid;place-content:center;height:100%;font-size:.95rem;color:var(--cyan);gap:6px;background:repeating-linear-gradient(45deg,rgba(0,240,255,.06) 0 12px,transparent 12px 24px)}
.hero-photo .ph-empty b{font-size:2.4rem}
.hero-photo .dots{position:absolute;bottom:10px;left:0;right:0;display:flex;justify-content:center;gap:7px;z-index:2}
.hero-photo .dots i{width:8px;height:8px;border-radius:50%;background:rgba(255,255,255,.4);cursor:pointer}
.hero-photo .dots i.on{background:var(--cyan);box-shadow:0 0 8px var(--cyan)}
@keyframes float{50%{transform:translateY(-10px)}}

.logo{display:flex;align-items:center;gap:8px}.logo img{height:34px;mix-blend-mode:lighten}
.school-logo{width:84px;mix-blend-mode:lighten;filter:drop-shadow(0 0 16px rgba(0,240,255,.5));animation:float 5s ease-in-out infinite}
.socials a{display:inline-flex;align-items:center;gap:8px}.socials svg{width:18px;height:18px;flex:none}
.socials a:first-child:hover{background:linear-gradient(45deg,rgba(253,89,73,.25),rgba(214,36,159,.25),rgba(40,90,235,.25))}
.ph img{object-position:center 30%}
#lbimg{aspect-ratio:auto}#lbimg img{width:auto;height:auto;max-width:100%;max-height:74vh;margin:auto}#lbimg .art{aspect-ratio:4/3}
</style>
</head>
<body>
<div id="loader"><div class="ring"></div><p class="mono">BOOTING XII-TKJ1 NETWORK<span id="pct">0</span>%</p></div>
<div id="cur-dot"></div><div id="cur-ring"></div>
<video id="bg-video" autoplay muted loop playsinline preload="auto" disablepictureinpicture><source src="assets/video/background.mp4" type="video/mp4"></video>
<div id="bg-overlay"></div>

<header class="nav glass">
  <a href="#home" class="logo"><img src="assets/img/logo.jpeg" alt="Logo SMKN 1 Kras" onerror="this.remove()">XII<span>TKJ1</span></a>
  <nav id="menu">
    <a href="#home">Home</a><a href="#about">About</a><a href="#members">Members</a>
    <a href="#org">Struktur</a><a href="#memories">Memories</a><a href="#activities">Activities</a>
  </nav>
  <div class="clock mono"><b id="time">00:00:00</b><small id="date"></small></div>
  <button id="burger" aria-label="Menu">☰</button>
</header>

<section id="home" class="hero">
  <img class="school-logo" src="assets/img/logo.jpeg" alt="Logo SMK Negeri 1 Kras" onerror="this.remove()">
  <p class="mono chip" id="school"></p>
  <h1 class="glitch" data-t="WELCOME TO XII TKJ 1">WELCOME TO XII TKJ 1</h1>
  <p class="tag">One Class, One Network, One Family.</p>
  <div class="hero-photo" id="heroPhoto"></div>
  <p class="mono typed">$ <span id="typed"></span><i>▌</i></p>
  <a href="#about" class="btn">Explore Our Class →</a>
</section>

<section id="about">
  <h2 class="title">About <span>Us</span></h2>
  <div class="grid2">
    <div class="glass pad"><h3>Cerita Kami</h3><p id="story"></p>
      <h3>Filosofi</h3><p id="philo"></p></div>
    <div class="stack">
      <div class="glass pad"><h3>🎯 Visi</h3><p id="visi"></p></div>
      <div class="glass pad"><h3>🚀 Misi</h3><ul id="misi"></ul></div>
    </div>
  </div>
  <div class="stats" id="stats"></div>
</section>

<section id="members">
  <h2 class="title">Our <span>Members</span></h2>
  <input id="search" class="glass search" placeholder="🔍 Cari nama siswa atau jabatan...">
  <div class="cards" id="cards"></div>
  <p id="empty" class="mono center" hidden>// 404: siswa tidak ditemukan</p>
</section>

<section id="org">
  <h2 class="title">Struktur <span>Organisasi</span></h2>
  <div class="org" id="orgbox"></div>
</section>

<section id="memories">
  <h2 class="title">Memories <span>Gallery</span></h2>
  <div class="filters" id="filters"></div>
  <div class="gallery" id="gallery"></div>
</section>

<section id="activities">
  <h2 class="title">Class <span>Activities</span></h2>
  <div class="acts" id="acts"></div>
</section>

<footer class="glass">
  <p>Made with ❤️ by XII TKJ 1</p>
  <div class="socials" id="socials"></div>
  <small class="mono" id="copy"></small>
  <br><a href="upload.php" class="mono" style="font-size:.7rem;opacity:.45">⚙ kelola foto</a>
</footer>

<div id="lb" hidden><button class="x" id="lbx">✕</button><button class="pv" id="lbp">‹</button>
  <figure><div id="lbimg"></div><figcaption id="lbcap"></figcaption></figure><button class="nx" id="lbn">›</button></div>
<button id="music" class="fab glass" title="Musik ON/OFF">🔇</button>
<button id="top" class="fab glass" title="Kembali ke atas">↑</button>
<script>
/* ===== GANTI DATA DI SINI SAJA ===== */
const CLASS_DATA = {
  school: "SMK Negeri 1 Kras — Angkatan 2026/2027",
  year: 2025,
  // Foto tampilan utama (slideshow). Taruh file di assets/img/ lalu isi daftar di bawah.
  // Contoh: heroPhotos: ["assets/img/kelas1.jpg", "assets/img/kelas2.jpg"]
  // Kosong = tampil placeholder bertuliskan "Tambahkan Foto Kelas"
  heroPhotos: [],
  musicFile: "",   // isi "assets/music.mp3" jika punya file musik sendiri
  story: "XII TKJ 1 adalah rumah bagi para calon network engineer yang berawal dari kabel UTP yang belum rapi dan kini menjadi tim kompak. Dari praktik pertama hingga ujian kompetensi, kami tumbuh bersama.",
  philo: "Seperti jaringan, kekuatan kami ada pada koneksi. Satu node boleh jatuh, tapi tidak ada yang dibiarkan offline.",
  visi: "Menjadi kelas TKJ yang unggul, kompak, kreatif, dan siap menghadapi dunia industri teknologi.",
  misi: ["Menguasai jaringan, server, dan keamanan siber","Saling membantu dan tidak ada yang tertinggal","Menjaga disiplin, etika, dan integritas","Berkarya lewat proyek dan kompetisi"],
  homeroom: "Yanuar Dwianta, S.Pd",
  // Isi USERNAME akun kelas (tanpa @). Contoh: instagram: "futureengineering_"
  instagram: "12one.tkje_",
  tiktok: "futureengineering_",
  // role: jabatan, g: L/P, photo: "assets/img/nama.jpg" (kosongkan = avatar otomatis)
  members: [
    {name:"Fajar Wisnu Ghaisandi",role:"Ketua Kelas",g:"L"},
    {name:"Yunita Mira Agustin",role:"Wakil Ketua",g:"P"},
    {name:"Cinta Aprilia Nanda Putri",role:"Bendahara",g:"P"},
    {name:"Zunifia Cahya Kirani",role:"Wakil Bendahara",g:"P"},
    {name:"Syaharani Alna Vianda",role:"Sekretaris",g:"P"},
    {name:"Dyah Ayu Reztyani",role:"Wakil Sekretaris",g:"P"},
    {name:"Adam Rodick",role:"Anggota",g:"L"},
    {name:"Al Vina Laila Safitri",role:"Anggota",g:"P"},
    {name:"Alfina Zulfa Sari",role:"Anggota",g:"P"},
    {name:"Andini Ma'rifatul Hasanah",role:"Anggota",g:"P"},
    {name:"Arjun Fraska Saifulloh",role:"Anggota",g:"L"},
    {name:"Christianti Leviyana Putri Purnama",role:"Anggota",g:"P"},
    {name:"Desfita Maharani Alambhia",role:"Anggota",g:"P"},
    {name:"Dewi Fatimah",role:"Anggota",g:"P"},
    {name:"Dista Rahma Dina",role:"Anggota",g:"P"},
    {name:"Elya Khanifatu Arvina",role:"Anggota",g:"P"},
    {name:"Firda Melarisma Handayani",role:"Anggota",g:"P"},
    {name:"Imro'atus Salamah",role:"Anggota",g:"P"},
    {name:"Kaila Nur Aura Jayanti",role:"Anggota",g:"P"},
    {name:"Laili Miftakhul Nisfa",role:"Anggota",g:"P"},
    {name:"Marcella Nimas Sari",role:"Anggota",g:"P"},
    {name:"Melody Citra",role:"Anggota",g:"P"},
    {name:"Moh. Wahyu Nugroho",role:"Anggota",g:"L"},
    {name:"Muhammad Akbar Apriano",role:"Anggota",g:"L"},
    {name:"Muhammad Fahri Maulana",role:"Anggota",g:"L"},
    {name:"Naila Hasna Yulia Putri",role:"Anggota",g:"P"},
    {name:"Nayla Aulia Putri Shafira",role:"Anggota",g:"P"},
    {name:"Niken Dwi Novita",role:"Anggota",g:"P"},
    {name:"Oektaviana Putri Haryuni",role:"Anggota",g:"P"},
    {name:"Revan Wibisono",role:"Anggota",g:"L"},
    {name:"Rifa Pandu Setyawan",role:"Anggota",g:"L"},
    {name:"Safira Anjana Putri",role:"Anggota",g:"P"},
    {name:"Salsabila Rawa Gutama",role:"Anggota",g:"P"},
    {name:"Sheril Natasya Aurelia",role:"Anggota",g:"P"},
    {name:"Trista Anastya Wulandari",role:"Anggota",g:"P"},
    {name:"Wahyu Suci",role:"Anggota",g:"P"},
    {name:"Wulan Selviana Sari",role:"Anggota",g:"P"}
  ],
  // type: Praktik / Sekolah / Study Tour / Kebersamaan ; src: "assets/img/xx.jpg" (kosong = placeholder)
  memories: [
    {cap:"Praktik Konfigurasi Mikrotik",type:"Praktik",src:""},{cap:"Crimping Kabel LAN",type:"Praktik",src:""},
    {cap:"Upacara & Kegiatan Sekolah",type:"Sekolah",src:""},{cap:"Study Tour Yogyakarta",type:"Study Tour",src:""},
    {cap:"Foto Bersama Satu Kelas",type:"Kebersamaan",src:""},{cap:"Instalasi Debian Server",type:"Praktik",src:""},
    {cap:"Class Meeting",type:"Sekolah",src:""},{cap:"Makan Bareng Kelas",type:"Kebersamaan",src:""},
    {cap:"Kunjungan Industri",type:"Study Tour",src:""}
  ],
  activities: [
    {i:"📡",t:"Praktik Jaringan Komputer",d:"Membangun topologi LAN, subnetting, dan troubleshooting di lab."},
    {i:"🛜",t:"Konfigurasi Router & MikroTik",d:"DHCP, NAT, firewall, hotspot, dan manajemen bandwidth."},
    {i:"🔌",t:"Crimping Kabel LAN",d:"Straight & crossover, uji kabel dengan LAN tester."},
    {i:"💿",t:"Instalasi Sistem Operasi",d:"Windows, Linux Debian, hingga server virtualisasi."},
    {i:"🏆",t:"Ekstrakurikuler",d:"Pramuka, futsal, robotik, dan komunitas coding."},
    {i:"🎉",t:"Acara Kelas",d:"Class meeting, bukber, ulang tahun, dan perpisahan."}
  ]
};

</script>
<script>
/* FOTO OTOMATIS dari folder (diisi PHP) */
const AUTO = <?= json_encode($AUTO, JSON_UNESCAPED_SLASHES) ?>;
const fname = p => decodeURIComponent(p.split('/').pop()).replace(/\.[^.]+$/, '');
if (AUTO.hero.length) CLASS_DATA.heroPhotos = AUTO.hero;
CLASS_DATA.members.forEach(m => { const f = AUTO.siswa.find(p => fname(p).toLowerCase().trim() === m.name.toLowerCase()); if (f) m.photo = f; });
if (AUTO.galeri.length) CLASS_DATA.memories = AUTO.galeri.map(p => { const n = fname(p).split(' - ');
  return n.length > 1 ? {type: n[0].trim(), cap: n.slice(1).join(' - ').trim(), src: p} : {type: 'Kenangan', cap: n[0], src: p}; });
</script>
<script>
const D = CLASS_DATA, $ = s => document.querySelector(s);
const hue = s => [...s].reduce((a, c) => a + c.charCodeAt(0), 0) * 7 % 360;
const avatar = m => m.photo || 'data:image/svg+xml,' + encodeURIComponent(
  `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><linearGradient id="g" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="hsl(${hue(m.name)},80%,40%)"/><stop offset="1" stop-color="hsl(${hue(m.name)+70},80%,30%)"/></linearGradient></defs><rect width="100" height="100" fill="url(#g)"/><text x="50" y="62" font-size="38" text-anchor="middle" fill="#fff" font-family="Arial" font-weight="700">${m.name.split(' ').map(w=>w[0]).slice(0,2).join('')}</text></svg>`);

$('#school').textContent = D.school;
$('#story').textContent = D.story; $('#philo').textContent = D.philo; $('#visi').textContent = D.visi;
$('#misi').innerHTML = D.misi.map(x => `<li>${x}</li>`).join('');
$('#copy').textContent = `© ${D.year} XII TKJ 1 — ${D.school}`;
const user = v => (v || '').trim().replace(/^@/, '');
const socials = [
  {n: 'Instagram', i: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg>', u: 'https://instagram.com/' + user(D.instagram), at: user(D.instagram)},
  {n: 'TikTok', i: '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>', u: 'https://tiktok.com/' + (user(D.tiktok) ? '@' + user(D.tiktok) : ''), at: user(D.tiktok)}];
$('#socials').innerHTML = socials.map(s => `<a href="${s.u}" target="_blank" rel="noopener">${s.i} ${s.n}${s.at ? ' · @' + s.at : ''}</a>`).join('');

const L = D.members.filter(m => m.g === 'L').length, P = D.members.length - L;
$('#stats').innerHTML = [['Total Siswa', D.members.length], ['Laki-laki', L], ['Perempuan', P], ['Kegiatan', D.activities.length]]
  .map(([k, v]) => `<div class="glass stat reveal"><b data-n="${v}">0</b>${k}</div>`).join('');

function renderMembers(q = '') {
  const list = D.members.filter(m => (m.name + m.role).toLowerCase().includes(q.toLowerCase()));
  $('#cards').innerHTML = list.map(m => `<div class="glass card in reveal"><img src="${avatar(m)}" alt="${m.name}" loading="lazy"><h4>${m.name}</h4><span>${m.role}</span></div>`).join('');
  $('#empty').hidden = list.length > 0;
  hoverBind();
}
$('#search').addEventListener('input', e => renderMembers(e.target.value));

const by = r => D.members.filter(m => m.role === r);
const nm = r => (by(r)[0] || {}).name || '-';
const nd = (r, n, c = '') => `<div class="glass node ${c}"><small>${r}</small><b>${n}</b></div>`;
const pair = (r1, r2) => `<div class="row">${nd(r1, nm(r1))}${nd(r2, nm(r2))}</div>`;
const sies = D.members.filter(m => m.role.startsWith('Sie'));
$('#orgbox').innerHTML =
  `<div class="row">${nd('Wali Kelas', D.homeroom, 'top')}</div>` +
  pair('Ketua Kelas', 'Wakil Ketua') + pair('Sekretaris', 'Wakil Sekretaris') + pair('Bendahara', 'Wakil Bendahara') +
  (sies.length ? `<div class="row">${sies.map(m => nd(m.role, m.name)).join('')}</div>` : '');

const icons = {Praktik:'💻', Sekolah:'🏫', 'Study Tour':'🚌', Kebersamaan:'🤝'};
let shown = [], idx = 0;
const art = m => m.src ? `<img src="${m.src}" alt="${m.cap}" loading="lazy">`
  : `<div class="art" style="background:linear-gradient(135deg,hsl(${hue(m.cap)},80%,35%),hsl(${hue(m.cap)+80},80%,22%))">${icons[m.type] || '📷'}</div>`;
function renderGallery(t = 'Semua') {
  shown = D.memories.filter(m => t === 'Semua' || m.type === t);
  $('#gallery').innerHTML = shown.map((m, i) => `<div class="ph" data-i="${i}">${art(m)}<div class="cap"><small>${m.type}</small>${m.cap}</div></div>`).join('');
  document.querySelectorAll('.ph').forEach(p => p.onclick = () => openLB(+p.dataset.i));
  hoverBind();
}
const types = ['Semua', ...new Set(D.memories.map(m => m.type))];
$('#filters').innerHTML = types.map((t, i) => `<button class="${i ? '' : 'on'}">${t}</button>`).join('');
$('#filters').onclick = e => { if (e.target.tagName !== 'BUTTON') return;
  document.querySelectorAll('#filters button').forEach(b => b.classList.remove('on')); e.target.classList.add('on'); renderGallery(e.target.textContent); };
function openLB(i) { idx = (i + shown.length) % shown.length; const m = shown[idx];
  $('#lbimg').innerHTML = art(m); $('#lbcap').textContent = `${m.cap} (${idx + 1}/${shown.length})`; $('#lb').hidden = false; }
$('#lbx').onclick = () => $('#lb').hidden = true;
$('#lbp').onclick = () => openLB(idx - 1); $('#lbn').onclick = () => openLB(idx + 1);
$('#lb').onclick = e => { if (e.target.id === 'lb') $('#lb').hidden = true; };
addEventListener('keydown', e => { if ($('#lb').hidden) return;
  if (e.key === 'Escape') $('#lb').hidden = true; if (e.key === 'ArrowLeft') openLB(idx - 1); if (e.key === 'ArrowRight') openLB(idx + 1); });

$('#acts').innerHTML = D.activities.map(a => `<div class="glass act reveal"><div class="ic">${a.i}</div><h3>${a.t}</h3><p>${a.d}</p></div>`).join('');

function tick() { const n = new Date();
  $('#time').textContent = n.toLocaleTimeString('id-ID', {hour12: false}).replace(/\./g, ':');
  $('#date').textContent = n.toLocaleDateString('id-ID', {weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'}); }
tick(); setInterval(tick, 1000);

const lines = ['ping xii-tkj1.local ... reply: 1ms', 'ssh admin@kelas --connect', 'Welcome, future network engineer.'];
let li = 0, ci = 0, del = false;
(function type() { const s = lines[li];
  if (!del) ci++; else ci--;
  $('#typed').textContent = s.slice(0, ci);
  if (!del && ci === s.length) { del = true; return setTimeout(type, 1500); }
  if (del && ci === 0) { del = false; li = (li + 1) % lines.length; }
  setTimeout(type, del ? 25 : 60); })();

const io = new IntersectionObserver(es => es.forEach(e => { if (!e.isIntersecting) return;
  e.target.classList.add('in'); const b = e.target.querySelector('[data-n]');
  if (b) { let c = 0, t = +b.dataset.n; const s = setInterval(() => { b.textContent = ++c; if (c >= t) clearInterval(s); }, 900 / t); }
  io.unobserve(e.target); }), {threshold: .15});
document.querySelectorAll('.reveal,.title').forEach(e => { e.classList.add('reveal'); io.observe(e); });
renderMembers(); renderGallery();
const links = document.querySelectorAll('#menu a');
addEventListener('scroll', () => {
  $('#top').classList.toggle('show', scrollY > 500);
  let cur = ''; document.querySelectorAll('section').forEach(s => { if (scrollY >= s.offsetTop - 200) cur = s.id; });
  links.forEach(a => a.classList.toggle('act', a.hash === '#' + cur)); });
$('#top').onclick = () => scrollTo({top: 0, behavior: 'smooth'});
$('#burger').onclick = () => $('#menu').classList.toggle('open');
links.forEach(a => a.onclick = () => $('#menu').classList.remove('open'));

const dot = $('#cur-dot'), ring = $('#cur-ring'); let mx = 0, my = 0, rx = 0, ry = 0;
addEventListener('mousemove', e => { mx = e.clientX; my = e.clientY; dot.style.transform = `translate(${mx}px,${my}px)`; });
(function f() { rx += (mx - rx) * .15; ry += (my - ry) * .15; ring.style.transform = `translate(${rx}px,${ry}px)`; requestAnimationFrame(f); })();
function hoverBind() { document.querySelectorAll('a,button,.card,.ph,input').forEach(e => {
  e.onmouseenter = () => ring.classList.add('hov'); e.onmouseleave = () => ring.classList.remove('hov'); }); }
hoverBind();

let on = false, ac, nodes = [], audio;
$('#music').onclick = () => { on = !on; $('#music').textContent = on ? '🔊' : '🔇';
  if (D.musicFile) { audio = audio || Object.assign(new Audio(D.musicFile), {loop: true, volume: .4}); on ? audio.play() : audio.pause(); return; }
  if (on) { ac = ac || new (window.AudioContext || window.webkitAudioContext)(); ac.resume();
    const g = ac.createGain(); g.gain.value = .05; g.connect(ac.destination);
    [110, 164.8, 220, 277.2, 329.6].forEach((f, i) => { const o = ac.createOscillator(); o.type = i % 2 ? 'sine' : 'triangle'; o.frequency.value = f;
      const l = ac.createOscillator(), lg = ac.createGain(); l.frequency.value = .1 + i * .07; lg.gain.value = 3; l.connect(lg); lg.connect(o.frequency); l.start();
      o.connect(g); o.start(); nodes.push(o, l); });
  } else { nodes.forEach(n => n.stop()); nodes = []; } };

const bv = $('#bg-video'); bv.muted = true; bv.play().catch(() => addEventListener('click', () => bv.play(), {once: true}));
let pc = 0; const ld = setInterval(() => { pc += Math.ceil(Math.random() * 12); if (pc >= 100) { pc = 100; clearInterval(ld); setTimeout(() => $('#loader').classList.add('off'), 300); } $('#pct').textContent = ' ' + pc; }, 90);

/* foto tampilan utama: slideshow otomatis */
(function heroSlider() {
  const box = $('#heroPhoto'), ph = D.heroPhotos || [];
  if (!ph.length) { box.innerHTML = '<div class="in-box"><div class="ph-empty mono"><b>📷</b>Tambahkan Foto Kelas<small>js/data.js → heroPhotos</small></div></div>'; return; }
  box.innerHTML = '<div class="in-box">' + ph.map((s, i) => `<img src="${s}" alt="Foto XII TKJ 1 ${i + 1}" class="${i ? '' : 'on'}">`).join('') +
    (ph.length > 1 ? '<div class="dots">' + ph.map((_, i) => `<i class="${i ? '' : 'on'}"></i>`).join('') + '</div>' : '') + '</div>';
  const imgs = box.querySelectorAll('img'), dots = box.querySelectorAll('.dots i'); let n = 0, t;
  const go = i => { imgs[n].classList.remove('on'); dots[n] && dots[n].classList.remove('on'); n = i; imgs[n].classList.add('on'); dots[n] && dots[n].classList.add('on'); };
  const auto = () => { clearInterval(t); if (ph.length > 1) t = setInterval(() => go((n + 1) % ph.length), 4000); };
  dots.forEach((d, i) => d.onclick = () => { go(i); auto(); }); auto();
})();

</script>
</body>
</html>
