<?php

declare(strict_types=1);

namespace K911\Swoole\Reflection;

use K911\Swoole\Bridge\Symfony\Bundle\DependencyInjection\ContainerConstants;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use ZEngine\Core;
use ZEngine\Reflection\ReflectionClass;
use ZEngine\Reflection\ReflectionMethod;

final class FinalClassModifier
{
    private static FilesystemAdapter $cache;

    private static string $cacheDir = '';

    private static array $originalFinalClasses = [];

    public static function initialize(string $cacheDir): void
    {
        Core::init();
        self::initializeCache($cacheDir);
        self::modifyStoredClasses();
    }

    public static function removeFinalFlagsFromClass(string $className): void
    {
        $reflClass = new ReflectionClass($className);

        if (self::hasNativeParents($reflClass)) {
            // native classes should not be final and z-engine has problems with them
            return;
        }

        $finalMethods = $reflClass->getMethods(ReflectionMethod::IS_PUBLIC | ReflectionMethod::IS_FINAL);

        if (!$reflClass->isFinal() && 0 === count($finalMethods)) {
            return;
        }

        self::$originalFinalClasses[$className] = $className;
        $reflClass->setFinal(false);

        foreach ($finalMethods as $reflMethod) {
            $reflMethod->setFinal(false);
        }
    }

    public static function dumpCache(string $cacheDir = null): void
    {
        $cache = self::getCache($cacheDir);
        $item = $cache->getItem('class_list');
        $item->set(self::$originalFinalClasses);
        $cache->save($item);
    }

    private static function modifyStoredClasses(): void
    {
        $finalClasses = self::getCachedFinalClasses();

        if (null === $finalClasses) {
            return;
        }

        foreach ($finalClasses as $className) {
            self::removeFinalFlagsFromClass($className);
        }
    }

    private static function getCachedFinalClasses(): ?array
    {
        $item = self::$cache->getItem('class_list');

        if (!$item->isHit()) {
            return null;
        }

        return $item->get();
    }

    private static function initializeCache(string $cacheDir): void
    {
        self::getCache($cacheDir);
    }

    private static function getCache(string $cacheDir = null): FilesystemAdapter
    {
        if (self::$cacheDir === $cacheDir || null === $cacheDir) {
            return self::$cache;
        }

        return self::$cache = new FilesystemAdapter(
            '',
            0,
            $cacheDir.DIRECTORY_SEPARATOR.ContainerConstants::PARAM_CACHE_FOLDER
                .DIRECTORY_SEPARATOR.'final_classes'
        );
    }

    private static function hasNativeParents(ReflectionClass $class): bool
    {
        do {
            if ($class->isInternal()) {
                return true;
            }

            $class = $class->getParentClass();
        } while ($class instanceof ReflectionClass);

        return false;
    }
}
