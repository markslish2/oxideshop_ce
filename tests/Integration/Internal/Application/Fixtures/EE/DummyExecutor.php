<?php declare(strict_types=1);
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Integration\Internal\Application\Fixtures\EE;

class DummyExecutor
{
    public function execute()
    {
        return 'Service overwriting for EE!';
    }
}
