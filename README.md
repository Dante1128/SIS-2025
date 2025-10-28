Antede seguir los siguientes comandos deben tener **laravel 11** y **xampp**
#Instalar las dependencias 
```bash
composer install
```
#Crear su entorno virtual
```bash
cp .env.example .env
```
#Generar la key
```bash
php artisan key:generate
```

#Recomendacion
ir donde tienen el xampp , dirigirse a la carpeta php y buscar el archivo php.ini ,dentro del archivo buscar ';extension=zip' y descomentar la linea eliminando el ';', deberia quedar de la siguiente manera 'extension=zip'

De su archivo env. editar la cadena de conexion de la siguiente manera
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sis-2025
DB_USERNAME=root
DB_PASSWORD=

```