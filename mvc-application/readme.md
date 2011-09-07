##mvc-application

This is an sandbox where I'm playing the the current ZF2 MVC prototype which is currently implemented as a Module within Matthew Weier O'Phinney's ZF2 tree on github: [github.com/weierophinney/zf2/tree/prototype/mvc-module/modules/Zf2Mvc/](github.com/weierophinney/zf2/tree/prototype/mvc-module/modules/Zf2Mvc/)


This implementation plays with the idea that the entire app is implemented as modules with the Application module holding the master bootstrap and config. 

The next step is to look at module loading so that the HelloWorld module can have its routes within its own config and that we don't need to register each module manually into the autoloader within public/index.php


**To get this code working:**

You need to symlink ZF2's library/Zend to mvc-application/library/Zend and ZF2's modules to mvc-application/modules/Zend for this to work.

Note also that modules/Application/configs/application.ini has a hardcoded path in it for routing.






