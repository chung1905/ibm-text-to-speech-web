<?php
$voices = [
    'en-AU_CraigVoice',
    'en-AU_MadisonVoice',
    'en-GB_CharlotteV3Voice',
    'en-GB_JamesV3Voice',
    'en-GB_KateVoice',
    'en-GB_KateV3Voice',
    'en-US_AllisonVoice',
    'en-US_AllisonV3Voice',
    'en-US_EmilyV3Voice',
    'en-US_HenryV3Voice',
    'en-US_KevinV3Voice',
    'en-US_LisaVoice',
    'en-US_LisaV3Voice',
    'en-US_MichaelVoice',
    'en-US_MichaelV3Voice',
    'en-US_OliviaV3Voice',
];
$defaultVoice = 'en-US_MichaelV3Voice';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['text'])) {
    $env = include_once 'config.php';
    function genFileName(string $content): string
    {
        $content = preg_replace('/\W+/', ' ', $content);
        $words = explode(' ', $content);
        $words = array_slice($words, 0, 3);

        return implode('-', $words) . '-' . time();
    }

    $voice = $defaultVoice;
    if (isset($_POST['voice'])) {
        if (in_array($_POST['voice'], $voices, true)) {
            $voice = $_POST['voice'];
        }
    }

    $outDir = './out/';
    if (!is_dir($outDir)) {
        mkdir($outDir);
    }
    $text = $_POST['text'];
    $text = preg_replace("/\r\n+|\r+|\n+/", '. ', trim($text));
    $text = str_replace('"', '\"', $text);
    $fileName = genFileName($text);
    $output = $outDir . $fileName . '.wav';
    $logFile = $outDir . $fileName . '.log';
    $curl = <<<CURL
curl -X POST -u "apikey:${env['API_KEY']}" \
--header "Content-Type: application/json" \
--header "Accept: audio/wav" \
--data "{\"text\":\"$text\"}" \
--output $output "${env['API_URL']}/v1/synthesize?voice=$voice"

CURL;
    file_put_contents($logFile, $curl);
    exec($curl);
    if (headers_sent()) {
        die("<script type=\"text/javascript\">window.location='$output';</script>");
    } else {
        header('Location: ' . $output);
        die();
    }
}
?>
<html lang="en">
<head>
    <title>TTS</title>
    <link rel="icon" href="data:image/png;base64,iVBORw0KGgo=">
</head>
<body>
<main>
    <form action="" name="tts" method="post">
        <div style="width: 80%; margin: 2% 10%;">
            <div style="margin-bottom: 10px;">
                <textarea name="text" style="width: 100%" rows="10"></textarea>
            </div>
            <select name="voice">
                <option value="<?= $defaultVoice ?>" selected>Default: <?= $defaultVoice ?></option>
                <?php foreach ($voices as $v) { ?>
                    <option value="<?= $v ?>"><?= $v ?></option>
                <?php } ?>
            </select>
            <button type="submit">Submit</button>
        </div>
    </form>
</main>
</body>
</html>
