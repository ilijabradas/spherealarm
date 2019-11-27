# Wordpress Webpack
 This project gives you the ability to have hot module replacement provided by Webpack to allow you to develop javascript rich themes that without having to constantly reload the page. Additionally you can import any npm module and have it available on the front-end. This project also allows you to write your styling using SASS and use ES2015.

# Getting Started
To start using the project simply run:
```
git clone
npm install
```
The next step requires you to download Wordpress and add it into a wordpress folder in the root folder. If you have WP CLI installed you can simply run.
```
npm run setup
```
This will download the latest version of Wordpress and add it to a wordpress folder. To view your project you will need a tool like WAMP, XAMMP, Vagrant to this wordpress folder. You should now see the Wordpress wp-config creation page. Create a new database in PhpMyAdmin or MySQL WorkBench and link up wordpress to it. Once completed return to your terminal and run.
```
npm run watch
```
Once run a browser will load the home page of your site at localhost:3000. This is where all your development will take place.


