// $line = readline("INPUT THE URL: ");
// readline_add_history($line);
// dump history
// print_r(readline_list_history());
// dump variables
// print_r(readline_info());

// print("INPUT THE M3U8 URL:\n");
// $m3u8_url = trim(fgets(STDIN));

// preg_match_all("/(<(title)[^>]*>)(.*?)(<\/\\2>)/", $html, $matches, PREG_SET_ORDER);
// preg_match_all("/<title>(.*?)<\/title>/", $html, $matches, PREG_SET_ORDER);
// preg_match_all('/<meta\s+property="og:title"\s+content="(.*?)"\s+\/>/', $html, $matches, PREG_SET_ORDER);
// $title = html_entity_decode($matches[0][1]);

// Remote image URL
$url = 'http://www.example.com/remote-image.png';

// Image path
$img = 'images/codexworld.png';

// Save image
$ch = curl_init($url);
$fp = fopen($img, 'wb');
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);
fclose($fp);

$str = <<<EOD
Ejemplo de una cadena
expandida en varias líneas
empleando la sintaxis heredoc.
EOD;

sudo apt install php7.4-cli
sudo apt install php7.4-curl
sudo apt install php7.4-bcmath
