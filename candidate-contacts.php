<?php
session_start();

include_once("php/function.php");
include("param.php");

global $bdd;

$errors = [];
$name = $email = $subject = $message = "";
$ref_dossier = $_SESSION['my_doc_online'] ?? null;

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_add_contact'])) {

    // Récupération et nettoyage des données
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');


    if (empty($name)) {
        $errors['name'] = 'Le nom est obligatoire.';
    }
    if (empty($email)) {
        $errors['email'] = "L'adresse email est obligatoire.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "L'adresse email n'est pas valide.";
    }

    if (empty($subject)) {
        $errors['subject'] = 'Le sujet est obligatoire.';
    }
    if (empty($message)) {
        $errors['message'] = 'Le message est obligatoire.';
    }

    if (empty($errors)) {

        // Préparation de la requête
        $add_conntacts = add_contact($name, $email, $subject, $message, $ref_dossier);

        // Exécution
        if ($add_conntacts) {
            $success = "Votre message a été envoyé avec succès !";
            $name = $email = $subject = $message = "";
            if (!empty($email)) {
                $text_message = $message;
                $to_destination = $email;
                $sujet = $subject;
                include("candidate_sendmail_contact.php");
            }
        } else {
            $errors[] = "Erreur lors de l'envoi du message.";
        }
    }
}

?>
<div class="container section-title">
    <h2>Contact</h2>
    <p>Bienvenu à notre site web. Nous sommes heureux de votre visite.</p>
</div>

<div class="mb-5" data-aos="fade-up" data-aos-delay="200">
    <iframe style="border:0; width: 100%; height: 370px;" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d48389.78314118045!2d-74.006138!3d40.710059!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a22a3bda30d%3A0xb89d1fe6bc499443!2sDowntown%20Conference%20Center!5e0!3m2!1sen!2sus!4v1676961268712!5m2!1sen!2sus" frameborder="0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div><!-- End Google Maps -->

<div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="row gy-4">
        <div class="col-lg-6 ">
            <div class="row gy-4">

                <div class="col-lg-12">
                    <div class="info-item d-flex flex-column justify-content-center align-items-center">
                        <i class="bi bi-telephone"></i>
                        <h3>Téléphone</h3>
                        <p>+243 82 7000 755 | +243 85 0050 755</p>
                        <p>+243 82 6999 755 (Clients de Lubumbashi uniquement)</p>
                    </div>
                </div><!-- End Info Item -->

                <div class="col-lg-12">
                    <div class="info-item d-flex flex-column justify-content-center align-items-center">
                        <i class="bi bi-geo-alt"></i>
                        <h3>Adresse</h3>
                        <p ><strong>Siège National à Kinshasa :</strong></p>
                        <p> 14, Avenue Sergent Moke, Commune de Ngaliema, Kinshasa</p>
                        <p> A l'intérieur de la concession SAFRICAS,</p>
                        <p>   proche du Rond-point Haute Cour Militaire/GB.
                            +243 82 7000 755 </p>
                        <p><strong>Bureau de Lubumbashi :</strong></p>
                        <p>  Bâtiment Hypnose 2ème Niveau 826,</p>
                        <p>   Avenue Mama Yemo, Ville de Lubumbashi</p>
                        +243 82 6999 755 / +243 97 0639 702 </p>
                        <p></p>
                    </div>
                </div><!-- End Info Item -->

                <div class="col-lg-12">
                    <div class="info-item d-flex flex-column justify-content-center align-items-center">
                        <i class="bi bi-envelope"></i>
                        <h3>Email</h3>
                        <p>admin@passportsarl.voyage</p>
                    </div>
                </div><!-- End Info Item -->

            </div>
        </div>

        <div class="col-lg-6">
            <?php if (!empty($success)): ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="contact-form">
                <h3 class="text-center"><strong>Envoyer un message</strong></h3>
                <p>Votre adresse email ne sera pas publiée. Les champs obligatoires sont marqués.</p>

                <div class="form-group row mb-3 align-items-center">
                    <label for="name" class="col-12 col-sm-6 col-form-label">Nom <span class="text-danger">*</span></label>
                    <div class="col-12 col-sm-6">
                        <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($name) ?>">
                        <?php if (!empty($errors['name'])): ?>
                            <small class="text-danger"><?= htmlspecialchars($errors['name']) ?></small>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group row mb-3 align-items-center">
                    <label for="email" class="col-12 col-sm-6 col-form-label">Email <span class="text-danger">*</span></label>
                    <div class="col-12 col-sm-6">
                        <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>">
                        <?php if (!empty($errors['email'])): ?>
                            <small class="text-danger"><?= htmlspecialchars($errors['email']) ?></small>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group row mb-3 align-items-center">
                    <label for="subject" class="col-12 col-sm-6 col-form-label">Sujet <span class="text-danger">*</span></label>
                    <div class="col-12 col-sm-6">
                        <input type="text" id="subject" name="subject" class="form-control" value="<?= htmlspecialchars($subject) ?>">
                        <?php if (!empty($errors['subject'])): ?>
                            <small class="text-danger"><?= htmlspecialchars($errors['subject']) ?></small>
                        <?php endif; ?>
                    </div>
                </div>



                <div class="form-group row mb-3 align-items-center">
                    <label for="message" class="col-12 col-sm-6 col-form-label">Message <span class="text-danger">*</span></label>
                    <div class="col-12 col-sm-6">
                        <textarea id="message" name="message" class="form-control" rows="4"><?= htmlspecialchars($message) ?></textarea>
                        <?php if (!empty($errors['message'])): ?>
                            <small class="text-danger"><?= htmlspecialchars($errors['message']) ?></small>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <button name="submit_add_contact" type="submit">Envoyer</button>
                </div>
            </form>
        </div><!-- End Contact Form -->

    </div>

</div>
