<?php
// Cleanup script to remove inner <header> and extraneous <main> wrapping
$files = [
    'resources/views/admin/students/index.blade.php',
    'resources/views/admin/students/create.blade.php',
    'resources/views/admin/students/edit.blade.php',
    'resources/views/admin/attendance_qrs/index.blade.php',
    'resources/views/admin/attendances/index.blade.php',
    'resources/views/admin/daily_activities/index.blade.php',
    'resources/views/admin/leave_requests/index.blade.php',
    'resources/views/admin/dashboard/index.blade.php'
];

foreach ($files as $file) {
    if (!file_exists($file)) continue;
    $content = file_get_contents($file);

    // Remove any <header> block entirely
    $content = preg_replace('/<header[^>]*>.*?<\/header>/is', '', $content);
    
    // Remove opening <main> tags (since layout already provides main)
    $content = preg_replace('/<main[^>]*>/i', '', $content);
    
    // Remove standalone closing </main> or closing </div> that wrapped main. Wait, removing </div> might break layout if not careful.
    // Instead of regexing </main>, since we removed <main>, we should remove </main>.
    $content = str_ireplace('</main>', '', $content);
    
    file_put_contents($file, $content);
    echo "Cleaned $file\n";
}
