CMS
Структура:<br>
Index.php - будущий сайт. <br> 
- На данный момент это рабочая модель в которой можно посмотреть на результат добавления блоков, их удаления и редактирования, блоки можно менять местами. <br><br>

Папка includes - в ней содержится файл connection.php для подключения к БД и файл blocks.php - класс для блоков и функции.<br>
Папка assets - в ней находится один файл со стилями к админ панели. <br><br>
Папка  admin - ключевая папка админпанели. В ней находятся все файлы для работы в админпанели.<br><br>

- Точка входа - admin.php <br> <br>
- В админпанель можно зайти через форму регестрации. Пароль занесен в БД и проверка осуществляется из БД. <br>
- Через админпанель можно добавить новый блок, удалить или редактировать блок. А так же есть поле ввода для добаления в <head> мета тегов. 

- Добавление нового блока - add.php <br> 
- Удаление блока - delete.php <br>
- Редактирование блока - edit.php <br>
- и logout.php(уничтожает сессию).<br>