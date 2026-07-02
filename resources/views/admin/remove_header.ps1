$files = @("dashboard/index.blade.php", "students/index.blade.php", "attendances/index.blade.php", "leave_requests/index.blade.php", "tasks/index.blade.php", "daily_activities/index.blade.php")
foreach ($f in $files) {
    $content = Get-Content $f -Raw
    $newContent = $content -replace '(?s)<header.*?</header>\s*', ''
    Set-Content $f -Value $newContent
}
