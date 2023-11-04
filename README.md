# consort 
Exercice de fin de module Technologie du Web 2 PHP Licence 2.

## Contenu de l'exercice ....


```Année : 2022-2023
Classe et spécialité : Licence 2 IGL
Module : Langage du Web
Mini Projet Web
Le but de ce travail est d’ammener l’étudiant à être capable de réaliser une site
web depuis la conception jusqu’à la réalisation. L’objectif est de mettre en
œuvre, un ensemble reliant les différents TPs vus en cours pour aboutir à
un module complet.
Les paramètres d’ergonomie, d’interface homme machine et de design seront
des qualités complémentaires qui seront prises en compte.
Pré requis
(x)Html/CSS, Javascript, Php, MySql, SQL
Enoncé
L’entreprise CONSORT est spécialisée dans la promotion de médicaments
pharmaceutiques. En partenariat avec plusieurs firmes nationales et
internationales du domaine, elle importe des produits pharmaceutiques et fait la
promotion auprès de médecins et de pharmaciens par le biais de délégués
médicaux. Vu la densité et la complexité de ses activités, CONSORT aimerait
mettre en place système informatique, lui permettant un certain nombre de
traitement tels :
✓ Avoir la liste de tous ses partenaires, les gammes de produits qu’ils
proposent ainsi que les différents produits chaque gamme
✓ Avoir une base de ses délégués médicaux, les zones auxquelles ils sont
affectés et les produits dont ils sont en charge
✓ Gérer le stock des médicaments
✓ Gérer l’activité des délégués
Votre travail consistera à réaliser une application web qui satisfait les différents
besoins de l’entreprise CONSORT
Travail demandé
Le système devra comporter :
Les modules suivants :
1Année : 2022-2023
➢ Une page d’accueil avec:
• Un menu contenant les liens (Accueil, Laboratoires partenaires,
Nous connaître, Contact)
• Des (news, liens sociaux, liens utiles, bannières publicitaires)
• un formulaire de connexion pour accéder à l'espace délégué ou
administrateur)
• une zone Recherche
➢ Le lien laboratoires partenaires affiche dans un menu déroulant tous les
labos ; et un labo propose une gamme de produits et les produits associés
à la gamme (afficher dans un menu déroulant)
➢ La page espace délégué permettra à un délégué d’accéder à ses
informations personnelles (en consultation uniquement) et de voir son
ses zones d’affectation ainsi que ses produits en charge
➢ L’espace administrateur permettra :
✓ Enregistrer les différentes tables de la base (créer labo-
produits, créer délégué ; zones)
✓ Affecter un délégué médical à une zone et à des produits
✓ Voir l’état de tous les labos ou délégués un moment donné
✓ Apporter des modifications sur toutes les tables
➢ Une variable session sera créée afin d’identifier sur chaque page protégée
l’utilisateur connecté.
➢ Une mesure de sécurité empêchera l’accès aux pages protégées à toute
personne n’ayant pas le droit. Ceci inclus un lien de connexion et de
déconnexion
La Base de données peut contenir les tables suivantes( à titre indicatif) :
✓ Une table delegue (numMat, nom, prenom, adresse, email,photo*
telephone, fonction, sate_entree, date_depart)
✓ Une table zone (id_zone, district)
✓ Une table laboratoire(id, pays)
✓ Une table gammeProduit (id_gamme, catégorie)
✓ Une table produit (id_produit, gamme)
Relations entre tables : Un délégué peut être affecté à 0 ou plusieurs zones et
avoir plusieurs produits en charge, et une zone peut avoir plusieurs délégués. Un
labo a au moins une gamme de produits qui contient au moins un produit.
2Année : 2022-2023
NB : Travail réalisé au plus en binôme qui devra remettre un rapport
technique, l’application et le script de la base de données au plus tard le
Vendredi 24 2023
Bon courage !```

## Ceci est ma solution.
