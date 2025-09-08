<head>
    <meta charset="utf-8">
    <title>TCC</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&family=Playfair+Display:wght@400;500;600&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="icon" href="<?= BASE_URL ?>assets/img/logo.svg"/>

    <link href="<?= BASE_URL ?>assets/lib/animate/animate.min.css" rel="stylesheet">

    <link href="<?= BASE_URL ?>assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>assets/css/style.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>assets/css/process.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>assets/css/values.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>assets/css/contact-warehouse.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>assets/css/terms.css" rel="stylesheet">
    <?php

    // Fonction pour récupérer la langue principale du navigateur
    function getBrowserLanguage()
    {
        if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            return 'fr'; // fallback
        }
        // Exemple: "fr-FR,fr;q=0.9,en-US;q=0.8,en;q=0.7"
        $langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        if (count($langs) > 0) {
            // Prendre la première langue (ex: fr-FR)
            $lang = substr($langs[0], 0, 2);
            // On accepte uniquement 'fr' ou 'en' ici
            if (in_array($lang, ['fr', 'en'])) {
                return $lang;
            }
        }
        return 'fr'; // fallback si autre langue
    }

    // Si l'utilisateur a choisi via GET, on stocke en session
    if (isset($_GET['lang'])) {
        $lang = $_GET['lang'];
        $_SESSION['lang'] = $lang;
    } elseif (isset($_SESSION['lang'])) {
        $lang = $_SESSION['lang'];
    } else {
        // Sinon on détecte la langue navigateur
        $lang = getBrowserLanguage();
        $_SESSION['lang'] = $lang; // On peut aussi la stocker pour garder cette valeur
    }

    // Chargement fichier traduction
    $langFile = __DIR__ . "/../../lang/{$lang}.php";
    if (file_exists($langFile)) {
        $translations = include $langFile;
    } else {
        $translations = include __DIR__ . "/../../lang/{$lang}.php";
    }

    function t($key)
    {
        global $translations;
        return $translations[$key] ?? $key;
    }

    // Préparation de la requête (sans erreur de syntaxe)
    
    function getBlockContent(PDO $bdd, string $code, string $lang = 'fr'): string
    {
        // Préparer la requête
        $stmt = $bdd->prepare("SELECT content_fr, content_en FROM block WHERE code = :code");
        $stmt->bindParam(':code', $code, PDO::PARAM_STR);
        $stmt->execute();

        $block = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$block) {
            return ''; // Aucun bloc trouvé
        }

        // Retourner selon la langue demandée
        if ($lang === 'en' && !empty($block['content_en'])) {
            return $block['content_en'];
        }

        return $block['content_fr'] ?? '';
    }

    ?>
</head>