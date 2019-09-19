<?php

namespace yidas\yii2BowerAsset;

/**
 * Installer of Yii2 Bower Asset
 *
 * @author  Nick Tsai <myintaer@gmail.com>
 * @version 2.0.12
 */

class Installer 
{
    
    /**
     * @var string $sourceBower Bower package path of yii2-bower-asset
     */
    private static $sourceBower = 'yidas' . DIRECTORY_SEPARATOR 
            . 'yii2-bower-asset' . DIRECTORY_SEPARATOR 
            . 'bower';

    /**
     * @var string $bowerVendor Bower vendor path name for Official Yii2
     */
    private static $bowerVendor = 'bower';

    /**
     * @var string $aliasFilePath Application class file with alias setting
     */
    private static $aliasFilePath = 'vendor' . DIRECTORY_SEPARATOR 
            . 'yiisoft' . DIRECTORY_SEPARATOR 
            . 'yii2' . DIRECTORY_SEPARATOR 
            . 'base' . DIRECTORY_SEPARATOR 
            . 'Application.php';

    /**
     * @var $aliasBowerString Original alias setting for Bower of Yii
     */
    private static $aliasBowerString = "Yii::setAlias('@bower', \$this->_vendorPath . DIRECTORY_SEPARATOR . 'bower');";

    /**
     * Alias of Clone()
     */
    public static function bower()
    {
        self::clone();
    }

    /**
     * Install via cloning package to Bower vendor
     */
    public static function clone()
    {
    	$bowerDir = 'vendor' . DIRECTORY_SEPARATOR . self::$sourceBower;

        $bowerYiiDir = 'vendor' . DIRECTORY_SEPARATOR . self::$bowerVendor;

    	try {
    		
    		self::deleteDir($bowerYiiDir);

        	self::copyDir($bowerDir, $bowerYiiDir);

        	echo "Clone bower process done\n";

    	} catch (Exception $e) {
    		
    		echo "Error on clone bower process\n";
    	}
    }

    /**
     * Install via setting alias of Bower
     */
    public static function setAlias()
    {
        $file = file_get_contents(self::$aliasFilePath);

        $newAliasString = str_replace(
            "'".self::$bowerVendor."'", 
            "'".self::$sourceBower."'", 
            self::$aliasBowerString
            );

        $file = str_replace(
            self::$aliasBowerString, 
            $newAliasString, 
            $file
            );

        $result = file_put_contents(self::$aliasFilePath, $file);

        if ($result) {
            
            echo "Install alias @bower done\n";
        }
    }

    /**
     * Uninstall via re-setting alias of Bower
     */
    public static function unsetAlias()
    {
        $file = file_get_contents(self::$aliasFilePath);

        $aliasString = str_replace(
            "'".self::$bowerVendor."'",  
            "'".self::$sourceBower."'",
            self::$aliasBowerString
            );

        $file = str_replace(
            $aliasString, 
            self::$aliasBowerString, 
            $file
            );

        $result = file_put_contents(self::$aliasFilePath, $file);

        if ($result) {
            
            echo "Uninstall alias @bower done\n";
        }
    }

    private static function deleteDir($dirPath) 
    {
        if (!is_dir($dirPath)) {

            return;
        }

        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {

            $dirPath .= '/';
        }

        $files = glob($dirPath . '{,.}[!.,!..]*',GLOB_BRACE);

        foreach ($files as $file) {

            if (is_dir($file)) {

                self::deleteDir($file);

            } else {

                unlink($file);
            }
        }

        rmdir($dirPath);
    }

    private static function copyDir($src, $dst)
    {
        $dir = opendir($src); 

        @mkdir($dst);

        while(false !== ( $file = readdir($dir)) ) { 

            if (( $file != '.' ) && ( $file != '..' )) { 

                if ( is_dir($src . '/' . $file) ) { 

                    self::copyDir($src . '/' . $file,$dst . '/' . $file); 

                } else { 

                    copy($src . '/' . $file,$dst . '/' . $file); 
                } 
            } 
        } 

        closedir($dir);     
    }
}
