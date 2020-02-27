<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5a2dd1cd13ceffa258e048becaf36123
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
    );

    public static $prefixesPsr0 = array (
        'M' => 
        array (
            'Monolog' => 
            array (
                0 => __DIR__ . '/..' . '/monolog/monolog/src',
            ),
        ),
        'F' => 
        array (
            'Fuel\\Upload' => 
            array (
                0 => __DIR__ . '/..' . '/fuelphp/upload/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5a2dd1cd13ceffa258e048becaf36123::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5a2dd1cd13ceffa258e048becaf36123::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit5a2dd1cd13ceffa258e048becaf36123::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}