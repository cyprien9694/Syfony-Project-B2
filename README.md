# 🌌 Symfony Project B2 – Projet Web sur les Étoiles

## 📌 Présentation

**Syfony-Project-B2** est un projet web développé en **B2**, basé sur le framework **Symfony**.

Le projet porte sur l’univers des **étoiles et de l’astronomie**, avec une interface moderne permettant la consultation de contenu, la gestion d’utilisateurs et un système d’interaction (commentaires).

Il a pour objectif de mettre en pratique le développement d’une application web complète en architecture MVC.

---

## 🎯 Objectifs pédagogiques

* Maîtriser le framework **Symfony**
* Comprendre l’architecture **MVC (Model – View – Controller)**
* Manipuler une base de données avec **Doctrine & Migrations**
* Implémenter un système d’authentification
* Développer une interface dynamique avec **Twig, CSS et JavaScript**
* Structurer proprement un projet professionnel

---

## 🧱 Technologies utilisées

* **PHP (Symfony)**
* **Twig** (moteur de templates)
* **Doctrine ORM**
* **MySQL / Base de données relationnelle**
* **CSS** (style personnalisé)
* **JavaScript** (interactions légères)
* **Docker Compose** (configuration environnement)
* **Composer** (gestion des dépendances)

---

## 📂 Structure du projet

* `/src` → Contrôleurs, entités et logique métier
* `/templates` → Fichiers Twig (vues)
* `/config` → Configuration Symfony
* `/migrations` → Fichiers de migration base de données
* `/public` → Assets publics (CSS, JS, images et audio)
* `/bin` → Fichiers exécutables Symfony
* `composer.json` → Dépendances du projet
* `compose.yaml` → Configuration Docker

---

## ⚙️ Fonctionnalités principales

* 🪐 Affichage de contenu sur les étoiles
* 👤 Système d’authentification (login)
* 💬 Système de commentaires
* 🎨 Interface stylisée (CSS personnalisé)
* 🔄 Gestion des migrations de base de données

---

## 🚀 Installation du projet

### 1️⃣ Cloner le dépôt

```bash
git clone https://github.com/cyprien9694/Syfony-Project-B2.git
cd Syfony-Project-B2
```

### 2️⃣ Installer les dépendances

```bash
composer install
```

### 3️⃣ Configurer l’environnement

Configurer le fichier `.env` ou `.env.dev` avec vos paramètres de base de données.

### 4️⃣ Lancer les migrations

```bash
php bin/console doctrine:migrations:migrate
```

### 5️⃣ Démarrer le serveur

```bash
symfony server:start
```

ou via Docker si configuré :

```bash
docker compose up
```

---

## 📈 Compétences développées

* Développement backend en PHP
* Utilisation avancée de Symfony
* Gestion base de données & migrations
* Organisation d’un projet web complet
* Structuration Git d’un projet professionnel

---

## 👨‍💻 Auteur

Projet réalisé par **Cyprien**
Étudiant – B2

---

## 📄 Licence

Projet pédagogique – Usage académique.
