<?php
// Remove all emojis from blade files
$emojiMap = [
    // Form labels and headers
    '➕' => '',
    '✏️' => '',
    '📚' => '',
    '💰' => '',
    '📊' => '',
    '📌' => '',
    '⏰' => '',
    '🧠' => '',
    '🏆' => '',
    '💼' => '',
    '🌐' => '',
    '🏙️' => '',
    '📅' => '',
    '⏱️' => '',
    '🎥' => '',
    '📝' => '',
    '📄' => '',
    '🎓' => '',
    '🏢' => '',
    '🗑️' => '',
    '✅' => '',
    '🔗' => '',
    '👤' => '',
    '🗺️' => '',
    '🛣️' => '',
    '📱' => '',
    '🖼️' => '',
    '📭' => '',
    '🎯' => '',
    '📈' => '',
    '🚀' => '',
    '⏳' => '',
    '📦' => '',
    '🔒' => '',
    '⚠️' => '',
    '⚙️' => '',
    '👁️' => '',
    '💼' => '',
];

$basePath = __DIR__ . '/resources/views';

$files = [
    'instructor/edit-profile.blade.php',
    'instructor/skills/create.blade.php',
    'instructor/skills/edit.blade.php',
    'instructor/certifications/create.blade.php',
    'instructor/certifications/edit.blade.php',
    'instructor/projects/create.blade.php',
    'instructor/projects/edit.blade.php',
    'instructor/projects/index.blade.php',
    'instructor/availabilities/create.blade.php',
    'instructor/availabilities/edit.blade.php',
    'instructor/skills/index.blade.php',
    'instructor/certifications/index.blade.php',
    'instructor/availabilities/index.blade.php',
    'instructor/profile.blade.php',
    'admin/instructors/index.blade.php',
    'admin/instructors/show.blade.php',
    'admin/layout.blade.php',
];

foreach ($files as $file) {
    $filePath = $basePath . '/' . $file;
    if (file_exists($filePath)) {
        $content = file_get_contents($filePath);
        $newContent = strtr($content, $emojiMap);
        file_put_contents($filePath, $newContent);
        echo "Processed: $file\n";
    } else {
        echo "Not found: $file\n";
    }
}

echo "\nAll emojis removed!\n";
?>
