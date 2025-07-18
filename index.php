<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Horroz.org Ana Sayfa</title>
    </head>
    <body>
        <h1>Ana sayfa</h1>
        <p>
            <b>Horroz.org son derece profesyonel projeleri ana sayfasına hoş geldiniz oğlum!</b><br>
            Burada dünyaca ünlü horroz.org'un bazı projelerine ulaşmak ile kalmayıp, bilmem ne. Neyse.
        </p>
        
        <h2>Projeler</h2>
        <ul>
            <li>Horrozpedi, <a href="https://wiki.horroz.org">wiki.horroz.org</a></li>
            <li>yemek.horroz.org (yeni!), <a href="https://yemek.horroz.org">yemek.horroz.org</a></li>
        </ul>

        <h2>İletişim</h2>
        <p>
            <a href="mailto:destek@horroz.org">destek@horroz.org</a> ile ulaşım gerçekleştirin.
            <br>
            Ayrıca Horrozpedi hesabı açtırttırmak için <a href="mailto:hesap@horroz.org">hesap@horroz.org</a>'a mesaj atabilir isiniz.
            <br><br>
            Hele ki, ben kod görecem diyorsanız, <a href="https://github.com/horroz-org">horroz-org</a> GitHub sayfasını takip edip oradan istediğinizi yapabilirsiniz.
        </p>

        <h2>Bağış</h2>
        <p>
            Bağış yapacam diyon sen he? Tamam hadi yap.<br>
            Horrozpedi'ye nasıl yapıyosan öyle yap. <a href="https://wiki.horroz.org/wiki/Horrozpedi:Bağış">Şuradan</a>.
        </p>

        <h2>Diğer</h2>
        <p>
            Sunucu hakkında (dkda bir güncelleniyo):<br>
            <div class="kod">
            <?php
                $komutlar = [
                    ["uptime"],
                    ["uptime -p"],
                    ["uptime -s"],
                    [null],
                    ["sunucu", "hostname"],
                    [null],
                    ["son giriş", "lastlog -u $(ls /home) | tail -n 1 | awk '{\$1=\"\"; \$2=\"\"; \$3=\"\"; print \$0 }'"]
                ];

                function komutlariYazdir($cmds){
                    $maxUzunluk = max(array_map(function($k) { return ($k[0] === null) ? 0 : mb_strlen($k[0]); }, $cmds));

                    $html = "";
                    foreach($cmds as $komut){
                        $bas = $komut[0];
                        $cmd = end($komut);
                        
                        if($cmd === null){
                            $html .= "<br>";
                            continue;
                        }
                        
                        $baslik = str_replace(" ", "&nbsp;", mb_str_pad($bas . ":", $maxUzunluk + 5));
                        
                        $out = [];
                        exec($cmd, $out);

                        $html .= "<b>" . $baslik . "</b><span class='italik monospace'>";
                        $i = 0;
                        foreach($out as $line){
                            if($i !== 0){
                                $html .= str_repeat("&nbsp;", $maxUzunluk + 5);
                            }
                            $html .= trim($line) . "<br>";
                            $i++;
                        }
                        $html .= "</span>";
                    }

                    return $html;
                }

                $cacheDosya = __DIR__ . "/cache.txt";
                $cacheZaman = 60; // saniye

                $lazim = true;

                if(file_exists($cacheDosya)){
                    if(time() - filemtime($cacheDosya) < $cacheZaman){
                        $lazim = false;
                    }
                }

                if($lazim){
                    $html = komutlariYazdir($komutlar);
                    file_put_contents($cacheDosya, $html);
                    echo $html;
                }
                else{
                    echo file_get_contents($cacheDosya);
                }
            ?>
            </div>
        </p>

        <br>
        <marquee><p class="italik">(c) 2025 horroz.org</p></marquee>

        <style>
            .italik {
                font-style: italic;
            }

            body {
                font-family: monospace;
            }

            .kod {
                overflow-x: auto;
                white-space: nowrap;
            }
        </style>
    </body>
</html>