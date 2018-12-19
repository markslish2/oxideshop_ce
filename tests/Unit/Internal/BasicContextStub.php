<?php
declare(strict_types=1);

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal;

use OxidEsales\EshopCommunity\Internal\Application\Utility\BasicContext;
use OxidEsales\EshopCommunity\Internal\Application\Utility\BasicContextInterface;
use OxidEsales\Facts\Facts;
use Webmozart\PathUtil\Path;

/**
 * @internal
 */
class BasicContextStub implements BasicContextInterface
{

    private $communityEditionSourcePath;
    private $containerCacheFilePath;
    private $edition;
    private $enterpriseEditionRootPath;
    private $generatedProjectFilePath;
    private $professionalEditionRootPath;
    private $sourcePath;
    
    public function __construct()
    {
        $basicContext = new BasicContext();
        $this->communityEditionSourcePath = $basicContext->getCommunityEditionSourcePath();
        $this->containerCacheFilePath = $basicContext->getContainerCacheFilePath();
        $this->edition = $basicContext->getEdition();
        $this->enterpriseEditionRootPath = $basicContext->getEnterpriseEditionRootPath();
        $this->generatedProjectFilePath = $basicContext->getGeneratedProjectFilePath();
        $this->professionalEditionRootPath = $basicContext->getProfessionalEditionRootPath();
        $this->sourcePath = $basicContext->getSourcePath();
    }

    public function getCommunityEditionSourcePath(): string
    {
        return $this->communityEditionSourcePath;
    }

    public function setCommunityEditionSourcePath(string $path): string
    {
        $this->communityEditionSourcePath = $path;
    }

    public function getContainerCacheFilePath(): string
    {
        return $this->containerCacheFilePath;
    }

    public function setContainerCacheFilePath(string $path): string
    {
        $this->containerCacheFilePath = $path;
    }

    public function getEdition(): string
    {
        return $this->edition;
    }

    public function setEdition(string $path)
    {
        $this->edition = $path;
    }

    public function getEnterpriseEditionRootPath(): string
    {
        return $this->enterpriseEditionRootPath;
    }

    public function setEnterpriseEditionRootPath(string $path)
    {
        $this->enterpriseEditionRootPath = $path;
    }

    public function getGeneratedProjectFilePath(): string
    {
        return $this->generatedProjectFilePath;
    }

    public function setGeneratedProjectFilePath(string $path)
    {
        $this->generatedProjectFilePath = $path;
    }

    public function getProfessionalEditionRootPath(): string
    {
        return $this->professionalEditionRootPath;
    }

    public function setProfessionalEditionRootPath(string $path)
    {
        $this->professionalEditionRootPath = $path;
    }

    public function getSourcePath(): string
    {
        return $this->sourcePath;
    }

    public function setSourcePath(string $path)
    {
        $this->sourcePath = $path;
    }
}
