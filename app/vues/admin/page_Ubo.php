<main>

    <section class="ajout-admin">
        <h2>Ajouter un compte administrateur</h2>
        <?= $commande["inscription"] ?>
        <form action="./?action=ajout_admin" method="post" class="form-block">
            <input type="email" name="email" placeholder="Votre email" required>
            <input type="password" name="mot_de_passe" placeholder="Votre mot de passe" required>
            <button type="submit">Valider</button>
        </form>
    </section>

    <section class="admin-section">
        <h2>Liste des Administrateurs</h2>
        <?php foreach ($commande["liste_admin"] as $admin): ?>
            <div class="user-card">
                <p><strong>Email :</strong> <?= htmlspecialchars($admin["email"]) ?></p>
                <p><strong>ID commerce :</strong> <?= $admin["id_commerce"] ?? "Non défini" ?></p>
            </div>
        <?php endforeach; ?>

        <form action="./?action=suppression" method="post" class="form-inline">
            <input type="number" name="id_admin" placeholder="ID admin à supprimer" required>
            <button type="submit">Supprimer</button>
        </form>
    </section>

    <section class="user-section">
        <h2>Liste des Utilisateurs</h2>
        <?php foreach ($commande["liste_utilisateur"] as $user): ?>
            <div class="user-card">
                <p><strong>Email :</strong> <?= htmlspecialchars($user["email"]) ?></p>
                <p><strong>Nom :</strong> <?= $user["nom"] ?: "Non renseigné" ?></p>
                <p><strong>Prénom :</strong> <?= $user["prenom"] ?: "Non renseigné" ?></p>
                <p><strong>Adresse :</strong> <?= $user["adresse_livraison"] ?: "Non renseignée" ?></p>
                <p><strong>Ville :</strong> <?= $user["ville"] ?: "Non renseignée" ?></p>
                <p><strong>Code postal :</strong> <?= $user["code_postal"] ?: "—" ?></p>
                <p><strong>Pays :</strong> <?= $user["pays"] ?: "—" ?></p>
                <p><strong>Téléphone :</strong> <?= $user["telephone"] ?: "—" ?></p>
                <p><strong>Mode de paiement :</strong> <?= $user["mode_paiement"] ?: "—" ?></p>
            </div>
        <?php endforeach; ?>

        <form action="./?action=suppression" method="post" class="form-inline">
            <input type="number" name="id_utilisateur" placeholder="ID utilisateur à supprimer" required>
            <button type="submit">Supprimer</button>
        </form>
    </section>

</main>
