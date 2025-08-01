<?php
session_start();
if (isset($_SESSION['my_doc_online'])) {
    session_unset();
    session_destroy();
}


// Inclusion des fonctions et paramètres

include_once("php/function.php");
include("param.php");

global $bdd;


$nid_client = $email = $pin_secret = "";
$errors = [];

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['btn_valider'])) {

    // Validation et nettoyage des entrées utilisateur
    $nid_client = !empty($_POST['nid_client']) ? trim($_POST['nid_client']) : "";
    $email = !empty($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL) : "";
    $pin_secret = !empty($_POST['pin_secret']) ? trim($_POST['pin_secret']) : "";

    if (empty($nid_client)) {
        $errors['nid_client'] = "NID est obligatoire.";
    }
    if (empty($email)) {
        $errors['email'] = "Email est obligatoire.";
    }
    if (empty($pin_secret)) {
        $errors['pin_secret'] = "PIN SECRET est obligatoire.";
    }

    // Si aucune erreur, traitement de l'authentification
    if (empty($errors)) {
        try {
            $stmt = $bdd->prepare("SELECT idt_dossier FROM t_dossier
                                   WHERE (nid_pp = :nid OR ndel = :nid OR email = :email)
                                   AND pin_secret = :pin
                                   AND (statut_dossier IS NULL OR statut_dossier NOT IN ('Clos_reussi','Clos_echec','Clos_Abandon','Paiement_incomplet'))
                                   LIMIT 1");
            $stmt->execute([
                'nid' => $nid_client,
                'email' => $email,
                'pin' => $pin_secret
            ]);
            $dossier = $stmt->fetch();

            if ($dossier) {
                $_SESSION['my_doc_online'] = $dossier['idt_dossier'];
                $_SESSION['username_online'] = "online_user";
                $_SESSION['sessionstarttime_online'] = date('H:i:s d/m/Y');

                add_notification("t_dossier", $nid_client ?: $email, "Connexion", "Connexion réussie", $nid_client ?: $email, "Connexion à MyPASS Online");

                header("Location: modification-dossier.php?msg=Vous êtes connecté à votre compte&success=ok");
                exit;

            } else {
                $errors['auth'] = "Nom d'utilisateur ou PIN incorrect.";
            }
        } catch (Exception $e) {
            $errors['auth'] = "Une erreur est survenue : " . $e->getMessage();
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">


<?php
include_once("candidate/layouts/head.php");
?>

<body class="service-details-page">

<?php
include_once("candidate/layouts/header.php");
?>


<main class="main">

    <!-- Page Title -->
    <div class="page-title">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">
                        <h2 class="heading-title">Consultez Votre Dossier en Toute Confiance</h2>

                    </div>
                </div>
            </div>
        </div>
        <nav class="breadcrumbs">
            <div class="container">
                <ol>
                    <li><a href="candidate.php">Accueil</a></li>
                    <li class="current">Conditions Générales d’Utilisation</li>
                </ol>
            </div>
        </nav>
    </div><!-- End Page Title -->

    <!-- Service Details Section -->
    <section id="service-details" class="service-details section payment">

        <div class="container">

            <div class="row gy-4">
                <div class="row justify-content-center">
                    <div class="col-lg-12 py-5 py-xl-5 py-xxl-7 col-payment section-title puce-condidate">
                        <h2>Conditions Générales d’Utilisation <br></h2>
                        <div class="pt-5 p-4">
                            <?php if (!empty($errors['auth']) || !empty($errors['stripe'])): ?>
                                <div class="alert alert-danger">
                                    <?= htmlspecialchars($errors['auth'] ?? $errors['stripe']) ?>
                                </div>
                            <?php endif; ?>


                                <ol type="I">
                                    <li>
                                        <p>L’agence prendra avec ses partenaires toutes les dispositions nécessaires facilitant le voyage du client ; l’agence étant liée par l’obligation de moyen;</p>
                                    </li>
                                    <li>
                                        <p>Endéans 10 jours après l’arrivée d’une admission dont le client aura été informé, ce dernier est sensé avoir réuni tous les documents nécessaires pour le dépôt du dossier à l’ambassade conformément à la fiche sur la deuxième étape qui lui aura déjà été remise et expliquée minimum une semaine avant l’arrivée de cette admission ; L’explication de ladite fiche se fera au cours d’une réunion dont la présence des clients invités sera constatée par leur identité et leur signature dans une liste de présence ;</p>
                                    </li>
                                    <li>
                                        <p>Pour une raison dépendant du client lui-même (par exemple si le client n’a pas payé à temps les frais de la deuxième tranche ou n’a pas fourni à temps les documents de la deuxième étape des démarches ou autre raison ayant retardé l’avancement du dossier), le report de l’admission est sanctionné des frais de pénalités que ce client devra payer, allant de 250 USD à 550 USD selon les cas et les universités ;</p>
                                    </li>
                                    <li>
                                        <p>L’agence exécutera sa mission qu’une fois qu’un paiement total sera effectué par le client. Néanmoins, en cas de versement par le client d’une tranche comme paiement partiel exigé, celui – ci devra régler, dans un délai de 10 jours précédant la finition de premiers services rendus, la tranche suivante, selon les services à rendre, sous peine de mettre la société en droit de se déresponsabiliser de premiers services rendus au nom du client et l’acompte versé sera ainsi perdu ;
                                        </p>
                                    </li>
                                    <li>
                                        <p>La responsabilité de l’agence est dégagée en cas d’annulation de voyages, des modifications de trajet, des retards ou de changement de quelle que nature que ce soit relatif aux services de voyage et sous l’influence du client ou des circonstances de force majeure ;
                                        </p>
                                    </li>
                                    <li>
                                        <p>La responsabilité de l’agence est dégagée si le client n’a pas fourni dans le délai les éléments exigés pour le voyage ou s’il a fourni d’éléments considérés de non authentiques et ayant conduit à l’échec de ses démarches de voyage ;
                                    </li>
                                    </p>
                                    </li>
                                    <p>En cas d’échec de la première tentative de délivrance d’un visa d’études, l’agence se réserve le droit de relancer, uniquement pour une seconde fois, les démarches à cet effet, sans que le client n’ait encore à débourser les frais de base (première et deuxième tranches) ayant déjà été payés aux démarches précédentes. Après deux refus de visas, l’unique option restante est celle de choisir une autre destination parmi celles qui seront proposées par l’agence ;
                                    </p>
                                    </li>
                                    <li>
                                        <p>L’obtention d’un remboursement n’est pas possible pour un voyage ou pour des services non consommés ou ceux déjà en cours ;
                                        </p>
                                    </li>
                                    <li>
                                        <p>Après paiement, PASSPORT SARL attribue à chaque client un Numéro d’Identification du Dossier (NID), lequel contient les informations et mises à jour relatives à son dossier. Le client est tenu de consulter régulièrement le site internet de PASSPORT afin de prendre connaissance, grâce à son NID, de l’évolution de son dossier et pouvoir faire le suivi lui-même. De ce fait, PASSPORT SARL ne saurait engager sa responsabilité pour tout préjudice découlant du fait que le CLIENT n’a pas consulté les informations pourtant disponibles dans son NID ;
                                        </p>
                                    </li>
                                    <li>
                                        <p>A l’obtention d’un visa d’études ou autre visa, il est d’obligation au client de participer à la prise des photos souvenirs avec l’équipe PASSPORT Sarl dans les locaux de l’Agence ou à son voisinage ou encore à tout autre endroit où l’agence aura choisi d’organiser une cérémonie de remise des visas et de prise des photos, et autorise, à cet effet, l’agence à utiliser, si bon lui semble, ces photos pour des raisons publicitaires saines ;
                                        </p>
                                    </li>
                                    <li>
                                        <p>A l’obtention du visa, le client ramène le passeport à l’agence pour la clôture du dossier, sans quoi le dossier ne peut être clôturé. La date du voyage est fixée par l’agence en vue de permettre au client de s’accorder au processus de clôture du dossier qui doit être finalisé par l’agence. Le tout sans préjudicier le client par rapport à la date de rentrée des cours à son université ;
                                        </p>
                                    </li>
                                    <li>
                                        <p>A la signature de ce contrat, le client et tout membre de sa famille ou ses amis l’ayant accompagné et se retrouvant dans les photos prises par l’agence, autorise celle-ci à utiliser ces photos pour des raisons publicitaires conformément au point (X) précédent ;
                                        </p>
                                    </li>
                                    <li>
                                        <p>Pour des raisons politiques sur le plan national, régional ou mondial ou bien pour des raisons climatiques qui ne constituent pas une menace grave pour le déroulement du voyage, aucun montant ne sera remboursé ;
                                        </p>
                                    </li>
                                    <li>
                                        <p>Ce contrat s’applique à tout client l’ayant signé, que ses démarches de voyage aient commencé à l’agence PASSPORT SARL ou ailleurs ;
                                        </p>
                                    </li>
                                    <li>
                                        <p>Les présents termes s’appliquent également au mandant dont le mandataire a signé ce formulaire ;
                                        </p>
                                    </li>
                                    <li>
                                        <p>Le masculin est utilisé dans ce document pour représenter le genre humain sans restriction.
                                        </p>
                                    </li>
                                </ol>

                        </div>
                    </div>
                </div>


            </div>

        </div>

    </section><!-- /Service Details Section -->

</main>

<?php
include_once("candidate/layouts/footer.php");
?>

</body>

</html>