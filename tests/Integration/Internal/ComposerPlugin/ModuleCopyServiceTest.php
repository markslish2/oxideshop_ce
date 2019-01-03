<?php declare(strict_types=1);
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Integration\Internal\ComposerPlugin;

use PHPUnit\Framework\TestCase;
use OxidEsales\EshopCommunity\Internal\Module\Setup\Installer\ModuleCopyService;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;

class ModuleCopyServiceTest extends TestCase
{
    /** @var vfsStreamDirectory */
    private $vfsStreamDirectory = null;

    public function setUp()
    {
        parent::setUp();
        $this->setupVfsStreamWrapper();
    }

    public function testCopy()
    {
        $this->createModuleStructure();
        $copyService = new ModuleCopyService();
        $pathToPackage = vfsStream::url('/vendor/testvendor/testmodule');
        $copyService->copyModuleFiles($pathToPackage);
    }


    private function setupVfsStreamWrapper()
    {
        if (!$this->vfsStreamDirectory) {
            $this->vfsStreamDirectory = vfsStream::setup();
        }
    }

    private function createModuleStructure()
    {
        $structure = [
            'vendor' => [
                'testvendor' => [
                    'testmodule' => [
                        'metadata.php' => ''
                    ]
                ]
            ],
            'source' => [
                'modules' => []
            ]
        ];
    }

}