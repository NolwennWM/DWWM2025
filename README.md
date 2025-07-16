# Cours DWWM 2025

Actuellement des cours HTML, CSS, JS, SQL et PHP sont disponible.

## Cours Front

Ils peuvent être lancé avec un simple **live server** ou équivalent.

Pour les cours JS faites bien attention, certains peuvent inclures des bibliothèques installées avec NPM.

Dans ce cas il faudra lancer dans le terminal dans le même répertoir que le fichier `package.json` la commande suivante :

```shell
npm install
```

## Cours Back

Que ce soit les cours de BDD ou PHP, ils ont été prévu pour **docker**.

Pour les lancer il faudra utiliser dans les dossier "06-database" ou "07-php" la commande suivante :

```shell
docker compose up -d
```

Les cours PHP peuvent être accompagner de bibliothèques installées avec Composer.

Dans ce cas il faudra lancer dans le terminal dans le même répertoire que le fichier `composer.json` la commande suivante :

```shell
composer require
```
