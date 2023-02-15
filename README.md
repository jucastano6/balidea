# Instalación del sitio
Se recomienda utilizar **ddev**.

1. Clonar repositorio.
2. cd carpetarepositorio && 'composer install' o 'ddev composer install'.
3. Proceder a realizar la instalación de drupal.
4. Instalar módulo "Balidea Form (balidea_form)" (pedirá instalar módulos de multilenguaje, aceptar).
5. Instalar tema "Balidea" (balidea_theme).

Y finalizamos, ya esta el sitio con el módulo,theme custom instalados y listos para usar.

# Herramientas utilizadas para calidad

Se utilizó codesniffer, phpstan con nivel por defecto de 5 y upgrade status para asegurar funcionamiento en drupal 10.

1. Codesniffer
Para ejecutar las pruebas de codesniffer se utilizó un container en docker (https://hub.docker.com/r/willhallonline/drupal-phpcs). Una vez instalado el contenedor se puede ejecutar: docker run -it --rm -v $(pwd):/app willhallonline/drupal-phpcs phpcs web/modules/custom/balidea_form

2. Phpstan
Phpstan está en el archivo composer de este repositorio, para ejecutar las pruebas se debe ejecutar:
'ddev php vendor/bin/phpstan analyze web/modules/custom/balidea_form' o 'php vendor/bin/phpstan analyze web/modules/custom/balidea_form'

3. Upgrade status
Para usar esta herramienta se debe instalar el módulo vía backoffice o drush ('ddev drush en upgrade_status' || 'drush en upgrade_status'). Después usar el comando: 'ddev drush upgrade_status:analyze balidea_form' || 'drush upgrade_status:analyze balidea_form'

# Particularidades del desarrollo realizado (Module && Theme)

1. Incorpora un archivo propio de permisos para la configuración del formulario.
2. Incorpora un tab para la traducción del formulario.
3. Incorpora un tab para la visualización del formulario (la vista del usuario autenticado).
4. Incorpora un enlace a la configuración del formulario en la barra de administración de Drupal.
5. Al instalar genera un enlace en el menú principal de navegación (la vista del usuario autenticado).
6. Se reemplazó el submit del formulario por uno con Ajax en donde se hizo una validación sencilla (esto solo con el fin de ampliar el funcionamiento del formulario, como un plus).
7. Se utilizó el hook page_attachments_alter para pasarle a drupalSettings el nombre del sitio y así poderlo usar en JS.
8. Se utilizó un Drupal Behavior para el manejo del JS que se requiere para la funcionalidad solicitada del botón.
9. Incorpora traducciones a español en su correspondiente archivo es.po
10. Se utilizó npm para instalar sass (para compilar utilizar: npm run scss)

**Muchas gracias**