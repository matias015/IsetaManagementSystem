Como empezar de cero la app

descargar git: https://git-scm.com/download/win

descargar xampp

descargar composer: https://getcomposer.org/Composer-Setup.exe

si lees algo de añadir php al path pone que si!!!!!!!!!

0. abrir xampp y arrancar mysql y apache.
<br><br>
En apache, ir a config, httpd.conf y buscar la seccion <documentRoot> y a las rutas agregar al final /[CarpetaDelProyecto]/public.
<br>
si no se hace esto, para poder acceder al sitio se debe usar el path /[CarpetaDelProyecto]/public para acceder a la aplicación
<br>
Deberia quedar asi:
<br>
```
DocumentRoot "C:/xampp/htdocs/[nombreCarpeta]/public"
<Directory "C:/xampp/htdocs/[nombreCarpeta]/public">
```
<br>
2. descargar de github la carpeta del proyecto
<br>
3. importar la base dump2.sql a phpmyadmin
<br>
4. abrir en visual la carpeta de la app de la raiz (donde esta el archivo sql, carpetas app,public,resources etc)
<br>
5. abris consola en visual con ctrl+ñ o en el menu de arriba terminal -> nueva terminal
<br>
6. pones en consola "composer install", si da error, entras en xampp, en la parte de apache, pones config, php.ini y buscas la linea que diga ";extension=zip" y le borras el ";" de adelante y cerras y guardas.
<br>
7. al archivo .env.example en la raiz, cambiale el nombre a solo .env y modifica la config de la db, tiene que quedar asi:
<br>
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306 <br>
DB_DATABASE=movedb
DB_USERNAME=root
DB_PASSWORD=    
```
<br>
El username y password son de tu phpmyadmin, pero si los dejaste default, el username es root y el password queda vacio 
<br>
7. lo del mail tiene que quedar asi, pero con las credenciales de tu mailtrap, si no haces esto te da error cuando
tenga que enviar mail:
<br>
 ```
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=af5abb26f9dc63   // aca va lo que te diga la app de mailtrap
MAIL_PASSWORD=fa016bcca8a71c   // aca va lo que te diga la app de mailtrap
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"<br>  
```
<br>
9. ahora deberias poder abrir la pag con:
```
php artisan serve
```
<br>
si te pide algo de un key, apreta el boton de generar y recarga
<br>
10. si la pag anda pone en consola lo siguiente en orden

```
    php artisan migrate
    php artisan db:seed
```
<br>
11. paso 10, disfruta deaa
