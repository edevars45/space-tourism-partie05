# Space Tourism — Partie 05

Implémentation du challenge “Space Tourism” (inspiré de Frontend Mentor) avec **Laravel**, **Blade** et **Tailwind CSS**.
Cette partie met l’accent sur la conformité à la maquette, l’internationalisation (FR/EN) et l’accessibilité.

## Objectifs fonctionnels
- Header conforme maquette : logo, ligne (≥ lg), nav translucide, header fixe, burger mobile, état actif.
- Pages publiques :
  - Home : fond noir, contenu rapproché du header, CTA “Explorer”
  - Destinations : Lune, Mars, Europe, Titan (onglet actif correct)
  - Crew : fallback i18n si la BDD est vide
  - Technology : Lanceur, Spaceport, Capsule (slider 1–2–3, accessible, images visibles en mobile)
- i18n FR/EN : textes dans `lang/fr` et `lang/en`, route `/lang/{locale}`
- Accessibilité : ARIA, focus visibles
- Responsive : mobile, tablette, desktop

## Démonstrations (captures à ajouter)
- `public/screenshots/home.png`
- `public/screenshots/destinations.png`
- `public/screenshots/technology.png`
- `public/screenshots/crew.png`

## Prérequis
- PHP 8.2+, Composer, Node 18+ / npm
- BDD non obligatoire pour cette partie

## Installation
```bash
git clone https://github.com/edevars45/space-tourism-partie05.git
cd space-tourism-partie05

composer install
cp .env.example .env
php artisan key:generate

npm install
npm run dev     # ou npm run build pour la prod

php artisan serve   # http://127.0.0.1:8000

Internationalisation

Fichiers : lang/fr/*.php, lang/en/*.php

Commutateur : GET /lang/{locale} (fr, en)

Routage
GET /                       -> pages.home (home)
GET /destinations           -> redirection /destinations/moon
GET /destinations/{planet}  -> DestinationsController@show
GET /crew                   -> PublicCrewController@index
GET /technology             -> pages.technology
GET /lang/{locale}          -> FR/EN

Structure utile
resources/
  views/
    components/{header.blade.php, nav-link.blade.php}
    layouts/app.blade.php
    pages/{home,destinations,crew,technology}.blade.php
lang/{fr,en}/*.php
public/images/{logo,crew,technology,destinations}
routes/web.php

Scripts utiles
php artisan route:clear && php artisan config:clear && php artisan cache:clear && php artisan view:clear
npm run dev         # watcher
npm run build       # build prod

Crédits

Maquette inspirée de Frontend Mentor — Space Tourism

Stack : Laravel, Blade, Tailwind CSS

Licence

Projet pédagogique. Voir composer.json et package.json.

Sauvegarde.

Commit + push :

git add README.md
git commit -m "docs: README partie 05"
git push


Si GitHub n’affiche pas le nouveau README, fais un Ctrl+F5 sur la page du dépôt.

2) Réglages VS Code pour les “erreurs” Tailwind

Ces messages (Unknown at rule @tailwind, @apply) sont des alertes de l’éditeur, pas du build. Pour les faire disparaître proprement :

a) Crée/édite .vscode/settings.json

Chemin : créer un dossier .vscode à la racine si besoin, puis le fichier settings.json.

Contenu :

{
  "tailwindCSS.experimental.configFile": "tailwind.config.js",
  "css.lint.unknownAtRules": "ignore",
  "scss.lint.unknownAtRules": "ignore",
  "less.lint.unknownAtRules": "ignore",
  "files.associations": {
    "*.css": "postcss"
  }
}

b) Installe l’extension “Tailwind CSS IntelliSense”

Dans VS Code, marketplace → Tailwind CSS IntelliSense (Microsoft).

c) Recharge VS Code

Ctrl+Shift+P → Developer: Reload Window.

3) Vérifie les bons fichiers aux bons endroits

CSS Tailwind : resources/css/app.css doit contenir :

@tailwind base;
@tailwind components;
@tailwind utilities;

@layer base {
  html { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }
  body { @apply bg-black text-white; }
}

@layer utilities {
  .font-bellefair { font-family: 'Bellefair', serif; }
  .font-barlow { font-family: 'Barlow', sans-serif; }
  .font-barlow-condensed { font-family: 'Barlow Condensed', sans-serif; }
}


Import CSS côté JS : resources/js/app.js doit avoir :

import '../css/app.css';


Layout : dans resources/views/layouts/app.blade.php :

@vite(['resources/css/app.css', 'resources/js/app.js'])


Config : à la racine, tu dois avoir tailwind.config.js et postcss.config.js (c’est le cas sur ta capture).

4) Nettoyage d’arborescence

Sur ta capture, je vois deux dossiers bizarres à la racine : 'fr' et ["fr".
Ils ne doivent pas exister là. Les langues doivent être dans lang/fr et lang/en.

Si ces dossiers sont vides ou des erreurs de manipulation : supprime-les.

S’ils contiennent des fichiers de langue, déplace le contenu dans lang/fr puis supprime les dossiers parasites.

Commandes (si c’est bien à supprimer) :

git rm -r --cached "'fr" "['fr"
# puis côté disque, supprime-les aussi si Windows t’a créé ces dossiers par erreur
git add -A
git commit -m "chore(repo): nettoyage dossiers racine incorrects"
git push

5) Relance le front
php artisan view:clear
npm run dev


Vite prendra 5174 si 5173 est occupé, c’est normal.
Teste http://127.0.0.1:8000.
