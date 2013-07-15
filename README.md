dice
====

*Dice : a toy php orm/active record, for teaching purposes*

Dice is a small orm/active record component written in php for teaching purposes only.
You should not us it in a real project.

It is intended to illustrate a course on data management in a web app, and particularly how can be implemented a ORM 
and an active record.

Dice implement an active record implemented using a "table data gateway" (DAO) pattern.

Installation
------------

Dice is a library. You should just git clone the dice tree in your project and then : 

 * install it using composer : just run composer install, and then include the generated autoloder (vendor/autoload.php)
 * include the file "dice/src/conf/DiceConfigure.php" in your app,  and then execute DiceConfigure::auloadRegister() in your code
