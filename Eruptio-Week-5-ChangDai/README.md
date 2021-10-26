# Erupt.io
This script showcases volcanic mountains from the [Mondial database](https://www.dbis.informatik.uni-goettingen.de/Mondial/#SQL). It also uses Mapbox to show satellite images of the area. Explore the code comments to help build understanding. 

# PHP and MySQL with Bootstrap Navigation
This script demonstrates how we can access data from a MySQL database using PDO (PHP Data Objects). It integrates a [Bootstrap](https://getbootstrap.com/) Navigation menu to allow filtering by Continent and Sorting by Various Columns. The code makes use of PHP Classes to keep functionality organized. It it loosely follows the Model-View-Controller (MVC) pattern. It assumes you already have a hosted copy of the [Mondial database](https://www.dbis.informatik.uni-goettingen.de/Mondial/#SQL). 

### Environment Variables

In order to connect to the database the script needs to know where it is hosted, and what your username and password are. In Replit, you can use "Secrets" (Environment Variables) to input your credentials. The PHP script makes use of the following environment variables:

* DBNAME
* HOST 
* PASSWORD 
* USERNAME

### Mapbox

If you want the map images to work, you'll need to get a mapbox token. [Sign up](https://www.mapbox.com/) for the free tier, and then store your access token in the Environment. This script assumes that you'll use the following Environment Variable.

* MAPBOX_TOKEN

You can use my token if you want but if everyone does this I'll probably run out of free hits. Here is my token for reference.

* pk.eyJ1IjoibnNpdHUiLCJhIjoiOGFZRVYtayJ9.5S6MT1zMMsPcKcrIWw1zIA 

###  Files and Folders
In this demo, the PHP webserver exposes the `public/` folder to the world. The entrypoint is `public/index.php`. Other files and folders are not directly accessible in the browser, but are included by `index.php` as needed. For example `views/countries.php` is included by `index.php` in order to display countries.

# Beyond Replit 
If deploying elsewhere (e.g. on LAMP Server):
* Use PHP8 or higher
* Point all URLs to index.php (e.g. via .htaccess )
* Set environment variables (e.g. via .htaccess )
* Deploy to the root folder

###  About
For more information contact [harold.sikkema@sheridancollege.ca](mailto:harold.sikkema@sheridancollege.ca)