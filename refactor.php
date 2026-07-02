<?php
// Smart extractor
$files = [
    'resources/views/admin/students/index.blade.php',
    'resources/views/admin/students/create.blade.php',
    'resources/views/admin/students/edit.blade.php',
    'resources/views/admin/attendance_qrs/index.blade.php',
    'resources/views/admin/attendances/index.blade.php',
    'resources/views/admin/daily_activities/index.blade.php',
    'resources/views/admin/leave_requests/index.blade.php'
];

foreach ($files as $file) {
    if (!file_exists($file)) continue;
    $content = file_get_contents($file);
    if (strpos($content, "@extends('layouts.admin')") !== false) continue; // Already refactored

    // Search for a main wrapper container div like <div class="p-8 ..."> or <div class="mb-10 ...">
    // Often it comes right after </header>
    $pattern = '/(?:<\/header>\s*)(<div[^>]*>.*)/is';
    if (!preg_match($pattern, $content, $matches)) {
        // Try another pattern if no header exists but <main> exists
        $pattern = '/(?:<main[^>]*>\s*)(<div[^>]*>.*)/is';
        if (!preg_match($pattern, $content, $matches)) {
            // Match specific div
            $pattern = '/(<!--\s*(?:Page Header|Content Canvas|Main Content|Dashboard Content).*?-->\s*<div[^>]*>.*)/is';
            if (!preg_match($pattern, $content, $matches)) {
                 echo "Could not find content block in $file\n";
                 continue;
            }
        }
    }
    
    $extracted = $matches[1];
    
    // Strip trailing layout elements (</main>, </div>, </body>, </html>, floating action buttons)
    $extracted = preg_replace('/<\/main>\s*<\/div>\s*(?:<!--.*?-->\s*<button.*?<\/button>\s*)?<\/body>\s*<\/html>\s*$/is', '', $extracted);
    $extracted = preg_replace('/<\/main>\s*<\/body>\s*<\/html>\s*$/is', '', $extracted);
    $extracted = preg_replace('/<\/main>.*$/is', '', $extracted); // Catch all
    
    // Specific cleanup
    $extracted = preg_replace('/<!-- Floating Action Button -->\s*<button.*?<\/button>$/is', '', $extracted);

    $newContent = "@extends('layouts.admin')\n\n@section('content')\n" . $extracted . "\n@endsection\n";
    file_put_contents($file, $newContent);
    echo "Refactored $file\n";
}
