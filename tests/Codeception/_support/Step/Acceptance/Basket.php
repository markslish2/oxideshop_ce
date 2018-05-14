<?php
namespace Step\Acceptance;

use OxidEsales\Codeception\Page\UserCheckout;
use OxidEsales\Codeception\Page\Basket as BasketPage;
use OxidEsales\Codeception\Module\Translator;

class Basket extends \AcceptanceTester
{
    /**
     * @param $productId
     * @param $amount
     */
    public function addProductToBasket($productId, $amount)
    {
        $I = $this;
        //add Product to basket
        // $params['cl'] = $controller;
        $params['fnc'] = 'tobasket';
        $params['aid'] = $productId;
        $params['am'] = $amount;
        $params['anid'] = $productId;
        $I->amOnPage('/index.php?'.http_build_query($params));
    }
    /**
     * @param $productId
     * @param $amount
     * @param $controller
     *
     * @return mixed
     */
    public function addProductToBasketAndOpen($productId, $amount, $controller)
    {
        $I = $this;
        //add Product to basket
       // $params['cl'] = $controller;
        $params['fnc'] = 'tobasket';
        $params['aid'] = $productId;
        $params['am'] = $amount;
        $params['anid'] = $productId;
        $I->amOnPage(BasketPage::route($params));
        if ($controller === 'user') {
            $breadCrumbName = Translator::translate("YOU_ARE_HERE") . ':' . Translator::translate("ADDRESS");
            $I->see($breadCrumbName, UserCheckout::$breadCrumb);
            return new UserCheckout($I);
        } else {
            $breadCrumbName = Translator::translate("YOU_ARE_HERE") . ':' . Translator::translate("CART");
            $I->see($breadCrumbName, BasketPage::$breadCrumb);
            return new BasketPage($I);
        }
    }
}