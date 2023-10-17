Como empezar de cero la app

descargar git: https://git-scm.com/download/win

descargar xampp

descargar composer: https://getcomposer.org/Composer-Setup.exe

si lees algo de añadir php al path pone que si!!!!!!!!!

0. abrir xampp y arrancar mysql y apache.

En apache, ir a config, httpd.conf y buscar la seccion "documentRoot" y a las rutas agregar al final /[CarpetaDelProyecto]/public.

si no se hace esto, para poder acceder al sitio se debe usar el path /[CarpetaDelProyecto]/public para acceder a la aplicación

Deberia quedar asi:

```
DocumentRoot "C:/xampp/htdocs/[nombreCarpeta]/public"
<Directory "C:/xampp/htdocs/[nombreCarpeta]/public">
```

2. descargar de github la carpeta del proyecto

3. importar la base dump2.sql a phpmyadmin

4. abrir en visual la carpeta de la app de la raiz (donde esta el archivo sql, carpetas app,public,resources etc)

5. abris consola en visual con ctrl+ñ o en el menu de arriba terminal -> nueva terminal

6. pones en consola "composer install", si da error, entras en xampp, en la parte de apache, pones config, php.ini y buscas la linea que diga ";extension=zip" y le borras el ";" de adelante y cerras y guardas.

7. al archivo .env.example en la raiz, cambiale el nombre a solo .env y modifica la config de la db, tiene que quedar asi:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306 <br>
DB_DATABASE=movedb
DB_USERNAME=root
DB_PASSWORD=    
```

El username y password son de tu phpmyadmin, pero si los dejaste default, el username es root y el password queda vacio 

7. lo del mail tiene que quedar asi, pero con las credenciales de tu mailtrap, si no haces esto te da error cuando
tenga que enviar mail:

 ```
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=username?   // aca va lo que te diga la app de mailtrap
MAIL_PASSWORD=contraseña?   // aca va lo que te diga la app de mailtrap
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"<br>  
```

9. ahora deberias poder abrir la pag con:
```
php artisan serve
```

si te pide algo de un key, apreta el boton de generar y recarga


Antes del paso 10, puedes cambiar la contraseña o usuario de administrador en ./database/seeders/AdminSeeder.php en la linea 18.

```
Admin::create([
            'username' => 'usuario',
            'password' => bcrypt('contraseña')
        ]);
```

10. si la pagina funciona pon en consola lo siguiente en orden
    
```
    php artisan migrate
    php artisan db:seed
```

11. paso 10, disfruta deaa
