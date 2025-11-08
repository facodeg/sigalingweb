<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Link Tidak Dapat Diakses</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body{font-family:system-ui,-apple-system,"Segoe UI",Roboto,Arial,sans-serif;
      margin:0;display:flex;flex-direction:column;align-items:center;justify-content:center;
      min-height:100vh;background:linear-gradient(135deg,#f43f5e,#be123c);color:#fff;text-align:center;}
    h1{font-size:2rem;margin-bottom:.5rem}
    p{max-width:420px;margin:0 auto 1.5rem;color:#fee2e2}
    .badge{display:inline-block;padding:6px 10px;border-radius:999px;background:#fee2e2;color:#991b1b;
      font-weight:700;margin-bottom:1rem}
    button{background:#fff;color:#991b1b;border:0;padding:10px 20px;border-radius:8px;
      font-weight:600;cursor:pointer}
    button:hover{background:#fef2f2}
  </style>
</head>
<body>
  @php
      $msg = $exception->getMessage();
      $text = str_contains($msg, 'kedaluwarsa')
          ? 'Tautan ini sudah melewati masa berlakunya. Silakan minta tautan baru ke admin.'
          : 'Tautan ini sudah digunakan sebelumnya dan tidak dapat dibuka lagi.';
  @endphp

  <div class="badge">410 • {{ $msg }}</div>
  <h1>🚫 {{ $msg }}</h1>
  <p>{{ $text }}</p>

  <button onclick="window.close()">Tutup Halaman</button>
</body>
</html>
