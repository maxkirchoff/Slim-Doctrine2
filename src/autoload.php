<?php
spl_autoload_register(
   function($class) {
      static $classes = null;
      if ($classes === null) {
         $classes = array(
            'drinkapp\\entity\\brewery' => '/entity/Brewery.php',
                'drinkapp\\entity\\distillery' => '/entity/Distillery.php',
                'drinkapp\\entity\\location' => '/entity/Location.php',
                'drinkapp\\entity\\winery' => '/entity/Winery.php',
                'slim\\environment' => '/vendor/slim/Slim/Environment.php',
                'slim\\exception\\pass' => '/vendor/slim/Slim/Exception/Pass.php',
                'slim\\exception\\stop' => '/vendor/slim/Slim/Exception/Stop.php',
                'slim\\http\\headers' => '/vendor/slim/Slim/Http/Headers.php',
                'slim\\http\\request' => '/vendor/slim/Slim/Http/Request.php',
                'slim\\http\\response' => '/vendor/slim/Slim/Http/Response.php',
                'slim\\http\\util' => '/vendor/slim/Slim/Http/Util.php',
                'slim\\log' => '/vendor/slim/Slim/Log.php',
                'slim\\logwriter' => '/vendor/slim/Slim/LogWriter.php',
                'slim\\middleware' => '/vendor/slim/Slim/Middleware.php',
                'slim\\middleware\\contenttypes' => '/vendor/slim/Slim/Middleware/ContentTypes.php',
                'slim\\middleware\\flash' => '/vendor/slim/Slim/Middleware/Flash.php',
                'slim\\middleware\\methodoverride' => '/vendor/slim/Slim/Middleware/MethodOverride.php',
                'slim\\middleware\\prettyexceptions' => '/vendor/slim/Slim/Middleware/PrettyExceptions.php',
                'slim\\middleware\\sessioncookie' => '/vendor/slim/Slim/Middleware/SessionCookie.php',
                'slim\\route' => '/vendor/slim/Slim/Route.php',
                'slim\\router' => '/vendor/slim/Slim/Router.php',
                'slim\\slim' => '/vendor/slim/Slim/Slim.php',
                'slim\\view' => '/vendor/slim/Slim/View.php'
          );
      }
      $cn = strtolower($class);
      if (isset($classes[$cn])) {
         require __DIR__ . $classes[$cn];
      }
   },
    true, // throw exception
    true  // prepend
);