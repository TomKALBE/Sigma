# Sigma

Sigma est une application de cours en ligne a but non lucratif.


## Installation

Une fois le projet téléchargé faire `composer install`


Créez une base de données et ajoutez la dans votre .env ensuite utilisez la commande : `php artisan migrate --seed`

Configurez aussi un serveur mail avec la configuration suivante :

MAIL_MAILER=smtp  
MAIL_HOST=smtp.mailtrap.io  
MAIL_PORT=2525  
MAIL_USERNAME=USERNAME  
MAIL_PASSWORD=PASSWORD  
MAIL_ENCRYPTION=tls  
MAIL_FROM_ADDRESS=null  
MAIL_FROM_NAME="${APP_NAME}"  

Executez ensuite la commande `php artisan storage:link`

Enfin vous pouvez lancer le serveur avec la commande `php artisan serve`

## Présentation de l'application 

### Partie utilisateur

- Un utilisateur peut consulter un cours.
- Il peut aussi se connecter s'il est formateur dans l'onglet `Login`.
- S'il n'est pas formateur il peut faire une demande dans l'onglet `Start now !`.

### Partie formateur

- Un formateur se connecte pour la première fois avec les identifiants qu'il a reçu par mail lorsque l'administrateur l'a accepté.
- Il peut modifier son profil dans l'onglet `profile` dans le menu déroulant en cliquant sur son nom
- Il peut créer une formation dans l'onglet `My courses`
- Il peut modifier les informations de la formation
- Il peut ajouter du contenu a la formation en cliquant sur l'image de la formation
    - Il peut y ajouter un chapitre (titre)
    - Il peut modifier l'ordre des chapitres grâce à une fonction de drag and drop
    - Il peut modifier le nom d'un chapitre ou le supprimer
    - Il peut ajouter des étapes (Chapitre,titre,contenu) a ce chapitre avec du contenu avec un éditeur html
    - Il peut modifier l'ordre des étapes grâce à une fonction de drag and drop
    - Il peut modifier une étape ou la supprimer
-Il peut se déconnecter

### Partie administrateur

- Il peut faire tout ce qu'un formateur peut faire créer du contenu etc
- Il peut dans l'onglet `Admin/Courses` modifier tous les cours
- Il peut dans l'onglet `Admin/Manage`
    - Créer/Modifier/Supprimer des categories
    - Accepter/Refuser par mail des utilisateurs qui souhaitent devenir formateur
    - Accepter/Refuser des utilisateurs directement dans cette vulnerabilities
    - Modifier supprimer les informations d'un utilisateur
    
## Information pratique


- Le mot de passe par défaut des utilisateurs est `password`.
- Les identidiants administrateur sont : `admin@admin.com` `admin`
- Si la modification d'image ne fonctionne pas du premier coup supprimer dans le dossier `storage` dans `public/storage` et faire la commande `php artisan storage:link` à la racine du projet
