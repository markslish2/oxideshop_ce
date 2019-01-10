<?php declare(strict_types=1);
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Module\Configuration\DataObject;

use OxidEsales\EshopCommunity\Internal\Module\Configuration\DataObject\Chain;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class ChainTest extends TestCase
{
    public function testAddExtensionToChainIfItIsFirstExtension()
    {
        $chain = new Chain();
        $chain->addExtensionToChain('extendedClass', 'firstExtension');

        $this->assertEquals(
            [
                'extendedClass' => [
                    'firstExtension'
                ],
            ],
            $chain->getChain()
        );
    }

    public function testAddExtensionToChainIfAnotherExtensionsAlreadyExist()
    {
        $chain = new Chain();
        $chain->addExtensionToChain('extendedClass', 'firstExtension');
        $chain->addExtensionToChain('anotherExtendedClass', 'someExtension');

        $chain->addExtensionToChain('extendedClass', 'secondExtension');

        $this->assertEquals(
            [
                'extendedClass' => [
                    'firstExtension',
                    'secondExtension',
                ],
                'anotherExtendedClass' => [
                    'someExtension',
                ]
            ],
            $chain->getChain()
        );
    }
}
