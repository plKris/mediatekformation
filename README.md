# MediatekFormation
## Application d'origine
L'application d'origine est disponible en suivant ce lien : https://github.com/CNED-SLAM/mediatekformation <br>
La documentation est disponible dans le readme du dépôt ci-dessus.
<br>
## Présentation
Ce site, développé avec Symfony 5.4, permet d'accéder aux vidéos d'auto-formation proposées par une chaîne de médiathèques et qui sont aussi accessibles sur YouTube. La partie back-office permet de gérer les formations proposées une fois connecté en tant qu'administrateur.
<br>Voici les fonctionnalités :
![image](https://github.com/Margaux-Lacheze/mediatekformation/assets/75217835/fe4165a4-c082-4670-b1a9-b225ab53283c)<br>
<br>
## Les différentes pages

### Page n°1: Les playlists - Front-office
![image](https://github.com/user-attachments/assets/0aa34cf8-c25b-4e4a-bbf7-45db409cda48)
)
)<br>
Cette page était déjà codée (cf: <a href="https://github.com/CNED-SLAM/mediatekformation">dépôt Github<a/>). Une colonne recensant le nombre de formations par playlist a été ajoutée ainsi que des boutons permettant de faire un tri par ordre croissant ou décroissant.<br>

### Page n°2: Page de connexion - Back-office
![image](![image](https://github.com/user-attachments/assets/97ddf6f1-17a6-4fec-b763-d8de7a72954d)
)<br>
Cette page permet à l'administrateur de se connecter à la partie gestion du site grâce à ses identifiants (nom d'utilisateur et mot de passe). Cette page est accessible en ajoutant /admin à l'URL du site<br>

### Page n°3: Page des formations - Back-office
![image](![image](https://github.com/user-attachments/assets/79851a46-0dbd-4ff8-a02e-498567d3b81c)
)<br>
Cette page s'affiche lorsque l'administrateur est connecté. Elle reprend le modèle de la page des formations du front office. Au niveau du header un bouton se déconnecter est ajouté pour pouvoir fermer la session
d'administration du site. Au dessus du tableau, juste sous le menu de navigation le titre de la page est affiché. Une colonne gestion contient deux boutons permettant soit d'éditer ou de supprimer une formation déjà présente. Tout en haut, un bouton permet d'ajouter une formation. Lors du clic sur le bouton supprimer, un pop-up apparait pour confirmer la suppression

### Page n°4: Ajouter une formation
![image](![image](https://github.com/user-attachments/assets/79824410-fd40-4391-814b-4c9d2f65b009)
)
Cette page s'affiche lorsque l'administrateur clique sur le bouton ajouter une formation. Elle contient le même header et le même footer que le reste du back-office, un titre a été ajouté. Il y a un formulaire vide avec à gauche le champ pour l'id de la vidéo Youtube de la formation et à droite les champs pour la date, le titre, la playlist, la catégorie et la description de la formation. Seules la description et la catégorie ne sont pas obligatoires. La date est sous forme de DateTimePicker et doit être antérieure à la date du jour. Un bouton enregistrer permet de soumettre le formulaire.

### Page n°5: Modifier une formation
![image](![image](https://github.com/user-attachments/assets/109380a4-7563-49d1-be6a-9db1671afcd4)
)
Cette page s'affiche lorsque l'administrateur clique sur le bouton éditer une formation. Elle est similaire à la page d'ajout d'une formation mais le formulaire est pré-rempli avec les informations de la formation que l'utilisateur a sélectionnée. Sous le titre, on retrouve la vidéo Youtube de la formation.

### Page n°6: Page des playlists - Back-office
![image](![image](https://github.com/user-attachments/assets/8f112a53-5716-4bf2-8270-1c85fef5ebba)
)
Cette page s'affiche lorsque l'administrateur clique sur "Playlists" dans le menu de navigation. Elle est similaire à la page des playlists du front-office et comme la page des formations du côté admin elle a une colonne de gestion permettant d'ajouter, d'éditer ou de supprimer une playlist. Là aussi le clic sur le bouton supprimer affiche un pop up pour confirmer la suppression. La suppression d'une playlist n'est possible que si cette dernière est vide. Si ce n'est pas le cas alors un message d'erreur apparaîtra en haut de l'écran.

### Page n°7: Ajout d'une playlist
![image](![image](https://github.com/user-attachments/assets/4e4b19f7-ebd1-4ace-a350-642d83db084d)
)
Cette page s'affiche lorsque l'administrateur clique sur "ajouter une playlist". Il s'agit d'un formulaire avec les champs nom et description. Seul le champ nom est obligatoire. Un bouton "enregistrer" permet de soumettre le formulaire.

### Page n°8: Modification d'une playlist
![image](![image](https://github.com/user-attachments/assets/31721c4c-7c3c-484f-a9c6-cfc7d8ba3a1a)
)
Cette page s'affiche lorsque l'administrateur clique sur "Editer" dans la colonne gestion des playlists. A gauche, on retrouve le même formulaire que celui présent sur la page d'ajout d'une playlist. Il est pré-rempli avec les informations de la playlist. A droite, il y a la liste des vidéos composant la playlist avec leur miniature et leur titre.

### Page n°9: Page des catégories
![image](![image](https://github.com/user-attachments/assets/1f773d2d-ea60-4df1-93be-0f23726c61ed)
)
Cette page s'affiche lorsque l'administrateur clique sur "catégories" dans le menu de navigation. Elle contient un titre et un formulaire permettant d'ajouter une catégorie. On ne peut ajouter une catégorie que si cette dernière n'existe pas encore. En dessous il y a un tableau composé de deux colonnes : une colonne contenant les noms des catégories et une colonne de gestion avec un bouton supprimer permettant la suppression de la catégorie sur la ligne du bouton. Le clic sur le bouton de suppression déclenche un pop up de confirmation.

## Installation de l'application en local
- Vérifier que Composer, Git et Wamserver (ou équivalent) sont installés sur l'ordinateur.
- Télécharger le code et le dézipper dans www de Wampserver (ou dossier équivalent) puis renommer le dossier en "mediatekformation".
- Ouvrir une fenêtre de commandes en mode admin, se positionner dans le dossier du projet et taper "composer install" pour reconstituer le dossier vendor.
- Récupérer le fichier mediatekformation.sql en racine du projet et l'utiliser pour créer la BDD MySQL "mediatekformation" en root sans pwd (si vous voulez mettre un login/pwd d'accès, il faut le préciser dans le fichier ".env" en racine du projet).
- De préférence, ouvrir l'application dans un IDE professionnel. L'adresse pour la lancer est : http://localhost/mediatekformation/public/index.php

## Tester l'application en ligne
L'application est disponible en ligne à cette adresse : http://pleselprojet.com/mediatekformation/public/ <br>
La page d'authentification est disponible en rajoutant admin à l'adresse : http://pleselprojet.com/mediatekformation/public/admin <br>
La documentation technique est disponible à cette adresse : https://mediatekformationlchz.go.yj.fr/mediatekformation_doc/
