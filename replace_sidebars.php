<?php

$dir = new RecursiveDirectoryIterator('resources/views/admin');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/^.+\.blade\.php$/i', RecursiveRegexIterator::GET_MATCH);

$count = 0;
foreach ($files as $file) {
    if (strpos($file[0], 'sidebar.blade.php') !== false) continue;
    $content = file_get_contents($file[0]);
    // Try to replace <aside> ... </aside>
    $pattern = '/<aside[^>]*>.*?<\/aside>/s';
    if (preg_match($pattern, $content)) {
        $replaced = preg_replace($pattern, "@include('admin.partials.sidebar')", $content);
        file_put_contents($file[0], $replaced);
        echo "Replaced in " . $file[0] . "\n";
        $count++;
    }
}
echo "Total processed: $count\n";
