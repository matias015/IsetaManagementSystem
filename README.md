Como empezar de cero la app

descargar git: https://git-scm.com/download/win

descargar xampp

descargar composer: https://getcomposer.org/Composer-Setup.exe

si lees algo de añadir php al path pone que si!!!!!!!!!

0. abrir xampp y arrancar mysql y apache
1. descargar de github la carpeta del proyecto
2. importar la base dump2.sql a phpmyadmin
3. abrir en visual la carpeta de la app de la raiz (donde esta el archivo sql, carpetas app,public,resources etc)
4. abris consola en visual con ctrl+ñ o en el menu de arriba terminal -> nueva terminal
5. pones en consola "composer install", si da error, entras en xampp, en la parte de apache, pones config, php.ini y buscas la linea que diga ";extension=zip" y le borras el ";" de adelante y cerras y guardas.
6. al archivo .env.example en la raiz, cambiale el nombre a solo .env y modifica la config de la db, tiene que quedar asi:
    
    DB_CONNECTION=mysql<br>  
    DB_HOST=127.0.0.1<br>  
    DB_PORT=3306<br>  
    DB_DATABASE=movedb<br>  
    DB_USERNAME=root<br>  
    DB_PASSWORD=       <br>  
    
El username y password son de tu phpmyadmin, pero si los dejaste default, el username es root y el password queda vacio 

7. lo del mail tiene que quedar asi, pero con las credenciales de tu mailtrap, si no haces esto te da error cuando
tenga que enviar mail:
 
    MAIL_MAILER=smtp
   <br>  
    MAIL_HOST=sandbox.smtp.mailtrap.io
   <br>  
    MAIL_PORT=2525
   <br>  
    MAIL_USERNAME=af5abb26f9dc63   // aca va lo que te diga la app de mailtrap
   <br>  
    MAIL_PASSWORD=fa016bcca8a71c   // aca va lo que te diga la app de mailtrap
   <br>  
    MAIL_FROM_ADDRESS="hello@example.com"
   <br>  
    MAIL_FROM_NAME="${APP_NAME}"<br>  

9. ahora deberias poder abrir la pag con "php artisan serve", si te pide algo de un key, apreta el boton de generar y recarga

10. si la pag anda pone en consola lo siguiente en orden
    "php artisan migrate" y "php artisan db:seed"

11. paso 10, disfruta deaa
