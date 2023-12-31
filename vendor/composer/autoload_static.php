<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc15881939b779e979b02595c7853ad95
{
    public static $prefixLengthsPsr4 = array (
        'H' => 
        array (
            'Hoochicken\\ParameterBag\\' => 24,
            'Hoochicken\\Dbtable\\' => 19,
            'Hoochicken\\Datagrid\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Hoochicken\\ParameterBag\\' => 
        array (
            0 => __DIR__ . '/..' . '/hoochicken/parameter-bag/src',
        ),
        'Hoochicken\\Dbtable\\' => 
        array (
            0 => __DIR__ . '/..' . '/hoochicken/dbtable/src',
        ),
        'Hoochicken\\Datagrid\\' => 
        array (
            0 => __DIR__ . '/../..' . '/_lab/hoochicken/dbtable/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc15881939b779e979b02595c7853ad95::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc15881939b779e979b02595c7853ad95::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitc15881939b779e979b02595c7853ad95::$classMap;

        }, null, ClassLoader::class);
    }
}
