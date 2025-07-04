<?php  
header('Content-Type: text/html');  

// Fetch JSON using cURL  
$url = 'https://raw.githubusercontent.com/abusaeeidx/CricHd-playlists-Auto-Update-permanent/refs/heads/main/api.json';  
$ch = curl_init();  
curl_setopt($ch, CURLOPT_URL, $url);  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  
$response = curl_exec($ch);  

if(curl_errno($ch)) {  
    die('cURL Error: ' . curl_error($ch));  
}  
curl_close($ch);  

$data = json_decode($response, true);  
if (!is_array($data)) {  
    die('Failed to decode JSON or empty data.');  
}  

$output = '';  

foreach ($data as $item) {  
    $name = $item['name'] ?? 'Unnamed';  
    $logo = $item['logo'] ?? '';  
    $id = $item['id'] ?? '';  

    $output .= '<div class="col-6 col-md-3">';  
    $output .= '<div class="channel-card" onclick="window.location.href=\'player.php?id=' . urlencode($id) . '\'">';  
    $output .= '<img src="' . htmlspecialchars($logo) . '" onerror="this.src=\'https://via.placeholder.com/150x130?text=No+Logo\';" alt="Channel Logo">';  
    $output .= '<div class="channel-name">' . htmlspecialchars($name) . '</div>';  
    $output .= '</div></div>';  
}  
?>  
<!DOCTYPE html>  
<html lang="en">  
<head>  
  <meta charset="UTF-8" />  
  <meta name="viewport" content="width=device-width, initial-scale=1" />  
  <title>X Fire Flix - Sports TV</title>  
  <link rel="shortcut icon" href="https://i.postimg.cc/sxkGqfMT/x-fire-flix.png">  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">  
  <style>  
    body { font-family: 'Segoe UI', sans-serif; background-color: #121212; color: white; }  
    body.light-mode { background-color: #f0f0f0; color: black; }  
    .logo { text-align: center; padding: 20px; }  
    .channel-card { background: rgba(255,255,255,0.05); border: 1px solid red; border-radius: 10px; padding: 10px; transition: transform 0.2s ease-in-out; cursor: pointer; }  
    .channel-card:hover { transform: scale(1.03); }  
    .channel-card img { width: 100%; height: 130px; object-fit: contain; border-radius: 10px; background: white; }  
    .channel-name { text-align: center; margin-top: 10px; font-size: 14px; font-weight: bold; }  
    .toggle-btn { margin: 10px auto; display: block; }  
  </style>  
</head>  
<body>  
  <div class="logo text-center mb-4 border-bottom pb-3" style="border-color: #ff3c3c;">  
    <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEgn47Htl8rZkop10CXrSjkn7Y9zA07Zdh1athN4qyFMx7VQtvqTcaxYT6cEjUKytO-hOvJT3nbKuIJZsUAgbouV4CRSahlPAXnyFmolO3mhdZwXR0W0WlkXYXQIJn-X8pe0lUoVCUbA14neQbccB4yTO2zutHj1jSjt33Z7BylqbBQSU7e_vw2w1AK5pbvf/s600/logo.png" alt="X Fire Flix Logo" height="80" class="mb-2">  
    <h3 style="font-weight: bold; color: #ff3c3c;">CricHD <span style="color: white;">| by</span> X Fire Flix</h3>  
  </div>  
  
  <div class="container">  
    <input id="searchInput" type="text" class="form-control mb-3" placeholder="Search Channels...">  
    <button class="btn btn-danger toggle-btn" id="toggleMode">Switch to Light Mode</button>  
    <div id="channelList" class="row g-3">  
      <?php echo $output; ?>  
    </div>  
  </div>  
  
  <footer class="text-center mt-4 py-3 bg-danger text-white">  
    &copy; 2025 X Fire Flix. All rights reserved.  
  </footer>  
  
  <script>  
    // Light/Dark mode toggle  
    const toggleBtn = document.getElementById('toggleMode');  
    toggleBtn.addEventListener('click', () => {  
      document.body.classList.toggle('light-mode');  
      toggleBtn.textContent = document.body.classList.contains('light-mode') ? 'Switch to Dark Mode' : 'Switch to Light Mode';  
    });  
  
    // Channel search  
    document.getElementById('searchInput').addEventListener('input', function () {  
      const searchValue = this.value.toLowerCase();  
      document.querySelectorAll('.channel-card').forEach(card => {  
        const name = card.querySelector('.channel-name').textContent.toLowerCase();  
        card.parentElement.style.display = name.includes(searchValue) ? 'block' : 'none';  
      });  
    });  
  
    // Telegram Promotion Overlay  
    const telegramOverlay = document.createElement('div');  
    telegramOverlay.style.position = 'fixed';  
    telegramOverlay.style.bottom = '14px';  
    telegramOverlay.style.right = '13px';  
    telegramOverlay.style.zIndex = '9999';  
    telegramOverlay.style.background = '#0088cc';  
    telegramOverlay.style.padding = '8px 11px';  
    telegramOverlay.style.borderRadius = '26px';  
    telegramOverlay.style.display = 'flex';  
    telegramOverlay.style.alignItems = 'center';  
    telegramOverlay.style.boxShadow = '0 4px 8px rgba(0,0,0,0.3)';  
    telegramOverlay.style.transition = 'all 0.3s ease';  
    telegramOverlay.innerHTML = `  
      <a href="https://t.me/xfireflix" target="_blank" style="display: flex; align-items: center; text-decoration: none; color: white;">  
        <img src="https://upload.wikimedia.org/wikipedia/commons/8/82/Telegram_logo.svg" alt="Telegram" style="width: 20px; height: 20px; margin-right: 8px;">  
        <span style="font-weight: bold;">Join us on Telegram</span>  
      </a>  
    `;  
    document.body.appendChild(telegramOverlay);  
  </script>  
</body>  
</html>