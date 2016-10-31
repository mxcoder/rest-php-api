<?php
require_once dirname(dirname(__DIR__)).'/vendor/autoload.php';
$file = __DIR__.'/index.html';

try {
    $builder = new \Crada\Apidoc\Builder(['GOG\Controllers\Products','GOG\Controllers\Carts'], dirname($file), 'GOG PHP API', basename($file));
    $builder->generate();
    $tweak = <<< TWEAK_HTML
    <script>
    document.getElementById('apiUrl').value='/api/v1';
    document.querySelector('.navbar-form.navbar-right').className += ' hidden';
    </script>
TWEAK_HTML;
    $fo = fopen($file, 'a+');
    fwrite($fo, $tweak, strlen($tweak));
    fclose($fo);
} catch (\Crada\Apidoc\Exception $e) {
    echo 'There was an error generating the documentation: ', $e->getMessage();
}
