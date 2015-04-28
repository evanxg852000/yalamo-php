Yalamo is a light, fast and easy to learn php framework that doesn't put any restriction on your application. in fact you can either use the built in mvc pattern or just include the framework to make use of the functionalities. Further you can extend as you need to suit your requirements. Yalamo is built with complex and simple applications development process in mind.
## Features ##
  * Mvc Mode
  * Classic Mode
  * Support Function Aliasing
  * Internal Debugger Called Inspector
  * Internal Profiler
  * Database Abstraction
  * Dataset Object
  * Support Cache
  * Support Uri routing
  * Powerful Table Class for creating records in one go
  * Support Extensions
  * Support Web Services SOAP, REST
  * Include a Javascript UI Library called Qj

## Quick Start Demo ##
> http://blip.tv/file/4330269/

## Installation ##
It's important to note that the above demo was made on the early days of the framework,
the architecture has changed since. wich makes the installation process different from the demo.

1- Download and extract the package in the root of your webserver or sub folder
> example: www/yfsite/
2- Open your browser and navigate to the directory where you installed yalamo
> you should see Not found page!
> It's working properly, it's just because you haven't configure yet
> example:
```
     http://localhost/yfsite/ 
```
3-copy the current url in the browser
> open the folder : 'yfsite/yalamo/configuration/'
> In the file Uri.php locate the config variable
```
    $URICONFIG["BASE"]="http://localhost/Framework/";
```
> replace the value by the url you copied from the browser
> this will make the yalamo to point to the right controller like
```
    $URICONFIG["BASE"]="http://localhost/yfsite/" 
```
> At this point the welcome page will load but the css file will not.
> In Application.php locate the config variable
```
   $APPCONFIG['CUSTOM']=array(
    "AdminEmail"=> "evanxg852000@yahoo.fr",
    "Title"=>"Yalamo Framework",
    "Copyright"=> "Evansofts 2010",
    "baseuri"=>"http://localhost/Framework/"
    //'key' => 'value'
);
```
> replace the entry
```
     "baseuri"=>"http://localhost/yfsite" 
```
> value with the value you    copied from the browser and add your custom value as you wish   to this array.

That's All !

## Requirement ##
Make sure mod\_rewrite is enabled on your server

## Contribution ##
Any Feature request or contribution is welcome