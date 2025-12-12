# Projet PHP – Projet d’apprentissage

## Présentation

Ce dépôt contient un **projet PHP avec MySQL** réalisé dans un cadre **d’apprentissage**. L’objectif principal était de pratiquer les bases du développement backend, notamment :

* La programmation en **PHP**
* La conception et l’utilisation d’une base de données **MySQL**
* Les opérations CRUD (Create, Read, Update, Delete)
* L’organisation d’un petit projet web

Ce projet ne contient **aucune donnée réelle ou sensible**. Toutes les données présentes sont uniquement des données de test.

---

## Technologies utilisées

* **Backend :** PHP
* **Base de données :** MySQL / MariaDB
* **Frontend :** HTML, CSS, JavaScript
* **Serveur web :** Apache (compatible avec un hébergement mutualisé)

---

## Structure du projet

```
project-root/
├── database/
│   └── db.sql            # Structure de la base de données + données de test
├── connection/
│   └── connect.php       # Connexion à la base de données
├── public/               # Fichiers accessibles publiquement
├── assets/               # Fichiers statiques (CSS, JS, images)
├── index.php             # Point d’entrée de l’application
├── .gitignore
└── README.md
```

---

## Base de données

### Création et import

Le fichier SQL nécessaire au projet se trouve dans :

```
database/db.sql
```

Pour importer la base de données :

```bash
mysql -u utilisateur -p nom_de_la_base < database/db.sql
```

Ou via **phpMyAdmin** :

1. Sélectionner la base de données
2. Cliquer sur **Importer**
3. Importer le fichier `db.sql`

---

## Configuration

Les paramètres de connexion à la base de données se trouvent dans le fichier :

```
connection/connect.php
```

Exemple :

```php
$host = "localhost";
$db   = "nom_de_la_base";
$user = "utilisateur";
$pass = "mot_de_passe";
```


---

## Lancer le projet en local

1. Installer un serveur local (XAMPP, WAMP, Laragon, etc.)
2. Placer le projet dans le dossier `htdocs`
3. Démarrer Apache et MySQL
4. Importer la base de données
5. Accéder au projet via le navigateur :

```
http://localhost/nom-du-projet
```

---

## Mise en ligne (hébergement)

Ce projet est compatible avec des hébergements PHP + MySQL comme :

* alwaysdata.com
* InfinityFree
* AwardSpace

Étapes générales :

1. Envoyer les fichiers sur le serveur
2. Créer une base de données
3. Importer le fichier `db.sql`
4. Mettre à jour les identifiants de connexion

---

## Remarques

* Projet réalisé dans un but **pédagogique**
* Données de test uniquement
* Le projet peut être amélioré et étendu

---
