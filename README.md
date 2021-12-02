# TEST

## Installation des dépendances
### Avec Composer
* sensio/framework-extra-bundle
* symfony/twig-bundle
* doctrine/annotations
* doctrine/orm
* doctrine/doctrine-bundle
* symfony/webpack-encore-bundle
* --dev orm-fixtures
* --dev symfony/debug-bundle
* --dev symfony/maker-bundle

### Avec Yarn
* yarn install
* Changement de l’extension de assets/styles/app.css en scss
* Modification de assets/styles/app.js en mettant à jour l’extension
* Activation du Sass loader en décommentant webpack.config.js:59 ".enableSassLoader()"
* yarn add sass-loader
* yarn add sass --dev
* yarn add bootstrap
* yarn add --dev @fortawesome/fontawesome-free