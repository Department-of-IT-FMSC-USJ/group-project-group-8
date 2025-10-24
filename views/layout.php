<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $pageTitle ?? 'Debit Card Renewal System' ?></title>
    
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#359EFF",
                        "background-light": "#f5f7f8",
                        "background-dark": "#0f1923"
                    },
                    fontFamily: { display: ["Inter"] },
                    borderRadius: {
                        DEFAULT: "0.25rem",
                        lg: "0.5rem",
                        xl: "0.75rem",
                        full: "9999px"
                    }
                }
            }
        };
    </script>
    
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    
    <?php if (isset($customCSS)): ?>
        <link rel="stylesheet" href="public/css/<?= $customCSS ?>" />
    <?php endif; ?>
</head>
<body class="bg-background-light dark:bg-background-dark font-display">
    <?php if (isset($_SESSION['success'])): ?>
        <div class="fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
            <?= htmlspecialchars($_SESSION['success']) ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="fixed top-4 right-4 z-50 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
            <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    
    <div class="flex flex-col min-h-screen">
        <?= $content ?? '' ?>
    </div>
</body>
</html>
