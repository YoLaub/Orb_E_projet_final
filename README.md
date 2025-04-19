# Orb'E - Site Web & Mini-Jeu

## Description
Orb'E est un assistant personnel intelligent sous forme de sphère. Ce projet de site web vise à promouvoir Orb'E en intégrant un mini-jeu interactif permettant aux utilisateurs de gagner des réductions en fonction de leurs scores.

## Fonctionnalités Principales
- **Site vitrine** pour présenter Orb'E et ses caractéristiques.
- **Mini-jeu** :
  - Contrôlez Orb'E et évitez les obstacles.
  - Score cumulatif avec bonus et récompenses.
  - Classement des meilleurs joueurs.
- **E-commerce** :
  - Page produit et système de commande.
  - Réductions basées sur les performances du jeu.
- **Back-office** pour la gestion des utilisateurs, commandes et stocks.

## Technologies Utilisées
### Frontend
- `HTML`, `CSS`, `JavaScript`
- `SaSS` pour les styles

### Backend
- `PHP (MVC)`
- `MySQL` pour la base de données
- `API REST` (Open Météo pour la météo dynamique du jeu)

### Outils
- `Git/GitLab`
- `XAMPP` (Environnement de développement PHP/MySQL)
- `Wireshark` pour la surveillance réseau
- `Figma` pour la conception UI/UX

## Installation
1. **Cloner le dépôt**
   ```bash
   git clone https://github.com/utilisateur/OrbE-Site.git
   ```
2. **Configurer la base de données**
   - Importer dans phpmyadmin le fichier SQL fourni dans le dossier app/BDD
   - Creer un fichier .env avec vos paramètres de connexion
  
  - DB_HOST=
  - DB_NAME= 
  - USERNAME=
  - PASSWORD=


3. **Installer Composer***
   -npm init
   -composer install
   
4. **Lancer le serveur local**
   - Utiliser XAMPP ou un autre serveur PHP

5. **Schema E/A**
![schema E/A](./publique/images/divers/modeleBDD_E-A.jpg "E/A") 

