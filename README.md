## Prerequisites
<ul>
<li>After cloning this repository, go to the root folder, run the following command/s,
<pre>
    composer install
    composer update
    npm install</pre>
</li>
<li>Rename .env.example to .env and provide your database details there.</li>
<li>Find and import the sql file located at <code>/resources/developer_test.sql</code>.</li>
<li>Run <pre>php artisan key:generate</pre> </li>
<li>Run <pre>php artisan serve</pre> </li>
</ul>

## Working Demo
You can see the demo of the project <a href="http://demos.justlaravel.com/vue-js-crud-laravel/">here</a>