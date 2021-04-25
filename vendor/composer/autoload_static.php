<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6cfa8c6d27d1f13b7f6f19ea3f0b7fd0
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'WilliamCosta\\DotEnv\\' => 20,
            'WilliamCosta\\DatabaseManager\\' => 29,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'WilliamCosta\\DotEnv\\' => 
        array (
            0 => __DIR__ . '/..' . '/william-costa/dot-env/src',
        ),
        'WilliamCosta\\DatabaseManager\\' => 
        array (
            0 => __DIR__ . '/..' . '/william-costa/database-manager/src',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6cfa8c6d27d1f13b7f6f19ea3f0b7fd0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6cfa8c6d27d1f13b7f6f19ea3f0b7fd0::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit6cfa8c6d27d1f13b7f6f19ea3f0b7fd0::$classMap;

        }, null, ClassLoader::class);
    }
}
