<?php

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Behat\Testwork\Hook\Scope\AfterSuiteScope;
use Behat\Testwork\Hook\Scope\BeforeSuiteScope;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;

class DataManagementContext implements Context
{
    private static ?Filesystem $filesystem = null;
    private const DATABASE_LOCATION = __DIR__ . '/../../data/database_test.sqlite'; // for test
    private const DATABASE_LOCATION_COPY = __DIR__ . '/../../data/database_test.sqlite.original'; // for test

    public function __construct(
        private KernelInterface $kernel
    )
    {}

//    /**
//     * @BeforeSuite
//     */
    public static function saveTestDatabase(BeforeSuiteScope $scope): void
    {
        $filesystem = self::getFilesystem();
        $filesystem->copy(
            self::DATABASE_LOCATION,
            self::DATABASE_LOCATION_COPY
        );
    }

//    /**
//     * @AfterSuite
//     */
    public static function removeCopiedDatabase(AfterSuiteScope $scope): void
    {
        $filesystem = self::getFilesystem();
        $filesystem->copy(
            self::DATABASE_LOCATION,
            self::DATABASE_LOCATION_COPY
        );
    }

//    /**
//     * @AfterScenario @database
//     */
    public function resetDatabase(): void
    {
        $filesystem = self::getFilesystem();
        $filesystem->remove(self::DATABASE_LOCATION);
        $filesystem->copy(
            self::DATABASE_LOCATION_COPY,
            self::DATABASE_LOCATION
        );
    }

    private static function getFilesystem(): Filesystem
    {
        if (self::$filesystem !== null) {
            return self::$filesystem;
        }

        return self::$filesystem = new Filesystem();
    }
}
