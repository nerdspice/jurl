<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitad521ba37129492476b8d8f1d06c34a9
{
    public static $prefixesPsr0 = array (
        'V' => 
        array (
            'Viocon' => 
            array (
                0 => __DIR__ . '/..' . '/usmanhalalit/viocon/src',
            ),
        ),
        'P' => 
        array (
            'Pixie' => 
            array (
                0 => __DIR__ . '/..' . '/usmanhalalit/pixie/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInitad521ba37129492476b8d8f1d06c34a9::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
