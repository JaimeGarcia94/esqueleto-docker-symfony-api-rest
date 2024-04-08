Este repositorio contiene una API-REST de usuarios que pueden realizar fichajes de entrada y de salida. Puedes crear, actualizar o borrar usuarios y sus respectivos fichajes de horas mediante varios endpoints que te proporciona la API.

<h1>Infraestructura usada</h1>
<ul>
  <li>Symfony 6.4</li>
  <li>Docker</li>
  <ul>
    <li>PHP 8.2</li>
    <li>NGINX</li>
    <li>MySQL 8</li>
  </ul>
</ul>

<h3>Librerías instaladas</h3>
<ul>
  <li><strong>doctrine/doctrine-bundle: </strong>Conjuntos predefinidos de datos que se utilizan para probar o rellenar una base de datos con datos iniciales.</li>
  <li><strong>doctrine/orm: </strong>Simplifica las interacciones con la base de datos mediante la asignación de tablas de la base de datos a objetos PHP.</li>
  <li><strong>symfony/flex: </strong>Symfony Flex es un sistema de gestión de paquetes para Symfony. Está diseñado para simplificar la instalación y configuración de los paquetes necesarios para una aplicación web de Symfony.</li>
  <li><strong>symfony/validator: </strong>Herramientas de validación de datos según normas predefinidas.</li>
  <li><strong>symfony/http-client: </strong>Cliente HTTP para realizar peticiones HTTP e interactuar con servicios web.</li>
  <li><strong>phpunit/phpunit: </strong>Framework de test para PHP.</li>
</ul>

<h1>Instalación</h1>
Para ejecutar el proyecto en local con docker tendrá que lanzar los siguientes comandos:
<ul>
  <li>Usar <code>docker-compose</code></li>
  <ul>
    <li>Añadir el parametro <code>-d</code> para que el proceso corra en segundo plano</li>
    <li>Añadir el parametro <code>--build</code> la <strong>primera vez</strong> para construir las imágenes</li>
    <li>Añadir la clave <code>down</code> para detener los contenedores</li>
  </ul>
</ul>

<code># Build & up. Ejecutar el comando desde la carpeta raíz del proyecto
docker-compose up -d --build
</code>

Para acceder al contenedor habría que usar el siguiente comando (el nombre del contenedor está definido en el fichero <strong>docker-compose.yml</strong>)
<code>docker exec -it $container_name bash</code>

<h1>¿Cómo funciona?</h1>
Tienes hasta 3 contenedores ejecutandose: PHP, NGINX y MySQL. Para comprobar que los contenedores están corriendo puedes usar el siguiente comando:
<code>docker ps</code>
<p><a href="http://localhost/v1/user/test">Página de bienvenida de la aplicación</a></p>

<h3>API</h3>
<p>Utiliza Postman u otro CLI para realizar acciones en cada endpoint.</p>
<p>La lista de endpoints se puede ver mediante el siguiente comando (dentro del contenedor <code>sf6_php</code>)</p>
<p><code>docker exec -it sf6_php bash</code></p>
<p><code>bin/console debug:router</code></p>

<p>Ejemplo:</p>

<table>
  <tr>
    <th>Name</th>
    <th>Method</th>
    <th>Scheme</th>
    <th>Host</th>
    <th>Path</th>
  </tr>
  <tr>
    <td>app_v1_user_test</td>
    <td>GET</td>
    <td>ANY</td>
    <td>ANY</td>
    <td>/v1/user/test</td>
  </tr>
  <tr>
    <td>app_v1_users</td>
    <td>GET</td>
    <td>ANY</td>
    <td>ANY</td>
    <td>/v1/users</td>
  </tr>
  <tr>
    <td>app_v1_user</td>
    <td>GET</td>
    <td>ANY</td>
    <td>ANY</td>
    <td>/v1/user/{id}</td>
  </tr>
  <tr>
    <td>app_v1_user_create</td>
    <td>POST</td>
    <td>ANY</td>
    <td>ANY</td>
    <td>/v1/user/create</td>
  </tr>
  <tr>
    <td>app_v1_user_update</td>
    <td>PUT</td>
    <td>ANY</td>
    <td>ANY</td>
    <td>/v1/user/update/{id}</td>
  </tr>
  <tr>
    <td>app_v1_user_delete</td>
    <td>DELETE</td>
    <td>ANY</td>
    <td>ANY</td>
    <td>/v1/user/delete/{id}</td>
  </tr>
  <tr>
    <td>app_v1_works_entries</td>
    <td>GET</td>
    <td>ANY</td>
    <td>ANY</td>
    <td>/v1/works-entries</td>
  </tr>
  <tr>
    <td>app_v1_work_entry</td>
    <td>GET</td>
    <td>ANY</td>
    <td>ANY</td>
    <td>/v1/work-entry/{id}</td>
  </tr>
  <tr>
    <td>app_v1_work_entry_create</td>
    <td>POST</td>
    <td>ANY</td>
    <td>ANY</td>
    <td>/v1/work-entry/create</td>
  </tr>
  <tr>
    <td>app_v1_work_entry_update</td>
    <td>PUT</td>
    <td>ANY</td>
    <td>ANY</td>
    <td>/v1/work-entry/update/{id}</td>
  </tr>
  <tr>
    <td>app_v1_work_entry_delete</td>
    <td>DELETE</td>
    <td>ANY</td>
    <td>ANY</td>
    <td>/v1/work-entry/delete/{id}</td>
  </tr>
</table>

<h3>Test PHPUnit</h3>
<p>Los tests se pueden lanzar desde dentro del contenedor <code>sf6_php</code> de la siguiente manera:</p>
<p><code>docker exec -it sf6_php bash</code></p>
<p><code>php bin/phpunit</code></p>
