<section>

    <h1>Gestion utilisateur</h1>

    <article class="utilisateur">
        <h2>Liste des Utilisateurs</h2>
        <input type="text" id="rechercheUtilisateur" placeholder="Rechercher un utilisateur...">
        <div id="resultatsRecherche"> </div>


    </article>

    <article class="admin">

        <div class="ajout_admin">
            <h2>Ajouter un compte administrateur</h2>
            <?= $commande["inscription"] ?>
        </div>

        <div class="admin_section">
            <h2>Liste des Administrateurs</h2>
            <?php foreach ($commande["liste_admin"] as $admin): ?>

                <div class="user-card">
                    <p><strong>Email :</strong> <?= htmlspecialchars($admin["email"]) ?></p>
                    <p><strong>ID Admin :</strong> <?= $admin["id_utilisateur"] ?? "Non défini" ?></p>
                    <form action="./?action=suppression" method="post" class="form-inline">
                        <input type="hidden" name="id_admin" value="<?= $admin["id_utilisateur"] ?>">
                        <button type="submit">Supprimer</button>
                    </form>
                </div>
            <?php endforeach; ?>


        </div>
    </article>

</section>