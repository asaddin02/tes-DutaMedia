<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit022f086645fe2035f650a1aa04798539
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'Api\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Api\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit022f086645fe2035f650a1aa04798539::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit022f086645fe2035f650a1aa04798539::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit022f086645fe2035f650a1aa04798539::$classMap;

        }, null, ClassLoader::class);
    }
}