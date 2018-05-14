<?php

use Step\Acceptance\Start;
use OxidEsales\Codeception\Module\Translator;

class UserAccountCest
{
    /**
     * @group myAccount
     *
     * @param AcceptanceTester $I
     */
    public function userLoginInFrontend(AcceptanceTester $I)
    {
        $I->wantToTest('user login (popup in top of the page)');

        $startPage = $I->openShop();

        //login when username/pass are incorrect. error msg should be in place etc.
        $startPage->loginUser('non-existing-user@oxid-esales.dev', '');
        $I->see(Translator::translate('LOGIN'));
        $I->see(Translator::translate('ERROR_MESSAGE_USER_NOVALIDLOGIN'), $startPage::$badLoginError);

        //login with correct user name/pass
        $userData = $this->getExistingUserData();
        $startPage->loginUser($userData['userLoginName'], $userData['userPassword']);
        $I->dontSee(Translator::translate('LOGIN'));

        $accountPage = $startPage->openAccountPage();
        $breadCrumb = Translator::translate('YOU_ARE_HERE').':'.Translator::translate('MY_ACCOUNT').' - '.$userData['userLoginName'];
        $I->see($breadCrumb, $accountPage::$breadCrumb);
        $I->see(Translator::translate('LOGOUT'));
    }

    /**
     * @group myAccount
     *
     * @param AcceptanceTester $I
     */
    public function userAccountChangePassword(AcceptanceTester $I)
    {
        $I->wantTo('change user password in my account navigation');

        $userData = $this->getExistingUserData();
        $userName = $userData['userLoginName'];
        $userPassword = $userData['userPassword'];

        $startPage = $I->openShop()
            ->loginUser($userName, $userPassword);
        $I->dontSee(Translator::translate('LOGIN'));

        $accountPage = $startPage->openAccountPage();
        $breadCrumb = Translator::translate('YOU_ARE_HERE').':'.Translator::translate('MY_ACCOUNT').' - '.$userName;
        $I->see($breadCrumb, $accountPage::$breadCrumb);

        $changePasswordPage = $accountPage->openChangePasswordPage();

        //entered not matching new passwords
        $changePasswordPage->enterPasswords($userPassword, 'user1user', 'useruser');
        $I->see(Translator::translate('ERROR_MESSAGE_PASSWORD_DO_NOT_MATCH'));

        //new pass is too short
        $changePasswordPage->changePassword($userPassword, 'user', 'user');
        $I->see(Translator::translate('ERROR_MESSAGE_PASSWORD_TOO_SHORT'));

        //correct new pass
        $changePasswordPage->changePassword($userPassword, 'user1user', 'user1user');
        $I->see(Translator::translate('MESSAGE_PASSWORD_CHANGED'));

        $changePasswordPage->logoutUser();

        // try to login with old password
        $changePasswordPage->loginUser($userName, $userPassword);
        $I->see(Translator::translate('LOGIN'));
        $I->see(Translator::translate('ERROR_MESSAGE_USER_NOVALIDLOGIN'), $changePasswordPage::$badLoginError);

        // try to login with new password
        $changePasswordPage->loginUser($userName, 'user1user');
        $I->dontSee(Translator::translate('LOGIN'));

        //reset new pass to old one
        $changePasswordPage->changePassword('user1user', $userPassword, $userPassword);
        $I->see(Translator::translate('MESSAGE_PASSWORD_CHANGED'));
    }

    /**
     * @group myAccount
     *
     * @param AcceptanceTester $I
     */
    public function userPasswordReminder(AcceptanceTester $I)
    {
        $I->wantToTest('user password reminder in my account navigation');

        $userData = $this->getExistingUserData();

        $startPage = $I->openShop();

        //open password reminder page in account menu popup
        $passwordReminderPage = $startPage->openUserPasswordReminderPage();
        $I->see(Translator::translate('HAVE_YOU_FORGOTTEN_PASSWORD'));

        //enter not existing email
        $passwordReminderPage = $passwordReminderPage->resetPassword('not_existing_user@oxid-esales.dev');
        $I->see(Translator::translate('ERROR_MESSAGE_PASSWORD_EMAIL_INVALID'));

        //enter existing email
        $passwordReminderPage = $passwordReminderPage->resetPassword($userData['userLoginName']);
        $I->see(Translator::translate('PASSWORD_WAS_SEND_TO').' '.$userData['userLoginName']);

        //open password reminder page in main user account page
        $passwordReminderPage->openAccountPage()
            ->openUserPasswordReminderPage();
        $I->see(Translator::translate('HAVE_YOU_FORGOTTEN_PASSWORD'));
    }

    /**
     * @group myAccount
     *
     * @param AcceptanceTester $I
     */
    public function userChangeEmailInBillingAddress(AcceptanceTester $I)
    {
        $I->wantTo('change user email in my account');

        $userData = $this->getExistingUserData();

        $userAddressPage = $I->openShop()
            ->loginUser($userData['userLoginName'], $userData['userPassword'])
            ->openAccountPage()
            ->openUserAddressPage()
            ->openUserBillingAddressForm();
        $I->see('Germany', $userAddressPage::$billCountryId);
        $I->see(Translator::translate('PLEASE_SELECT_STATE'), $userAddressPage::$billStateId);

        //change user password
        $userAddressPage = $userAddressPage->changeEmail("example01@oxid-esales.dev", $userData['userPassword'])
            ->logoutUser();

        //try to login with old and new email address
        $userAddressPage->loginUser($userData['userLoginName'], $userData['userPassword']);
        $I->see(Translator::translate('LOGIN'));
        $I->see(Translator::translate('ERROR_MESSAGE_USER_NOVALIDLOGIN'), $userAddressPage::$badLoginError);
        //login with new email address
        $userAddressPage->loginUser('example01@oxid-esales.dev', $userData['userPassword']);
        $I->dontSee(Translator::translate('LOGIN'));

        //change password back to original
        $userAddressPage->openUserBillingAddressForm()
            ->changeEmail("example_test@oxid-esales.dev", $userData['userPassword'])
            ->logoutUser();
    }

    /**
     * @group myAccount
     *
     * @param Start $I
     */
    public function newsletterSubscriptionInUserAccount(Start $I)
    {
        $I->wantToTest('newsletter subscription in my account navigation');

        $userData = $this->getExistingUserData();

        $newsletterSettingsPage = $I->loginOnStartPage($userData['userLoginName'], $userData['userPassword'])
            ->openAccountPage()
            ->openNewsletterSettingsPage();
        $I->see(Translator::translate('MESSAGE_NEWSLETTER_SUBSCRIPTION'));
        $newsletterSettingsPage->seeNewsletterUnSubscribed();

        //subscribe for a newsletter
        $newsletterSettingsPage->subscribeNewsletter()
            ->seeNewsletterSubscribed();

        //unsubscribe a newsletter
        $newsletterSettingsPage->unSubscribeNewsletter()
            ->seeNewsletterUnSubscribed();
    }

    /**
     * @group myAccount
     *
     * @after cleanUpUserData
     *
     * @param Start $I
     */
    public function userBillingAddress(Start $I)
    {
        $I->wantToTest('user billing address in my account');

        /** Change Germany and Belgium to non EU country to skip online VAT validation. */
        $I->updateInDatabase('oxcountry', ["oxvatstatus" => 0], ["OXID" => 'a7c40f632e04633c9.47194042']);
        $I->updateInDatabase('oxcountry', ["oxvatstatus" => 0], ["OXID" => 'a7c40f631fc920687.20179984']);

        $existingUserData = $this->getExistingUserData();

        $userAddressPage = $I->loginOnStartPage($existingUserData['userLoginName'], $existingUserData['userPassword'])
            ->openAccountPage()
            ->openUserAddressPage()
            ->openUserBillingAddressForm();
        $I->see('Germany', $userAddressPage::$billCountryId);
        $I->see(Translator::translate('PLEASE_SELECT_STATE'), $userAddressPage::$billStateId);

        $userLoginData['userLoginNameField'] = $existingUserData['userLoginName'];
        $addressData = $this->getUserAddressData('1', 'Belgium');
        $userData = $this->getUserData('1');
        $userData['userUstIDField'] = 'BE0410521222';
        $userAddressPage = $userAddressPage
            ->enterUserData($userData)
            ->enterAddressData($addressData)
            ->saveAddress()
            ->validateUserBillingAddress(array_merge($addressData, $userData, $userLoginData));

        $userData['userUstIDField'] = '';
        $addressData['UserFirstName'] = $existingUserData['userName'];
        $addressData['UserLastName'] = $existingUserData['userLastName'];
        $userAddressPage = $userAddressPage->openUserBillingAddressForm()
            ->enterUserData($userData)
            ->enterAddressData($addressData)
            ->selectBillingCountry('Germany')
            ->saveAddress();
        $I->see('Germany', $userAddressPage::$billingAddress);

    }

    /**
     * @group myAccount
     *
     * @param Start $I
     */
    public function userShippingAddress(Start $I)
    {
        $I->wantToTest('user shipping address in my account');

        $userData = $this->getExistingUserData();

        $userAddressPage = $I->loginOnStartPage($userData['userLoginName'], $userData['userPassword'])
            ->openAccountPage()
            ->openUserAddressPage()
            ->openUserBillingAddressForm();
        $I->see('Germany', $userAddressPage::$billCountryId);
        $I->see(Translator::translate('PLEASE_SELECT_STATE'), $userAddressPage::$billStateId);

        //create first new delivery address
        $deliveryAddressData = $this->getUserAddressData('1_2');

        $userAddressPage = $userAddressPage
            ->openShippingAddressForm()
            ->enterShippingAddressData($deliveryAddressData)
            ->saveAddress()
            ->validateUserDeliveryAddress($deliveryAddressData);

        //create second new delivery address
        $deliveryAddressData = $this->getUserAddressData('1_3');
        $userAddressPage = $userAddressPage
            ->selectNewShippingAddress()
            ->enterShippingAddressData($deliveryAddressData)
            ->saveAddress();
        $I->seeElement(sprintf($userAddressPage::$shippingAddress, 3));

        //change existing delivery address
        $deliveryAddressData = $this->getUserAddressData('1_4');

        $userAddressPage->selectShippingAddress(1)
            ->enterShippingAddressData($deliveryAddressData)
            ->saveAddress()
            ->validateUserDeliveryAddress($deliveryAddressData, 1);

        //TODO: delete existing delivery address
    }

    private function getExistingUserData()
    {
        return \Codeception\Util\Fixtures::get('existingUser');
    }

    private function getUserData($userId)
    {
        $userData = [
            "userUstIDField" => "",
            "userMobFonField" => "111-111111-$userId",  //still needed?
            "userPrivateFonField" => "11111111$userId",
            "userBirthDateDayField" => rand(10, 28),
            "userBirthDateMonthField" => rand(10, 12),
            "userBirthDateYearField" => rand(1960, 2000),
        ];
        return $userData;
    }

    private function getUserAddressData($userId, $userCountry = 'Germany')
    {
        $addressData = [
            "UserSalutation" => 'Mrs',
            "UserFirstName" => "user$userId name_šÄßüл",
            "UserLastName" => "user$userId last name_šÄßüл",
            "CompanyName" => "user$userId company_šÄßüл",
            "Street" => "user$userId street_šÄßüл",
            "StreetNr" => "$userId-$userId",
            "ZIP" => "1234$userId",
            "City" => "user$userId city_šÄßüл",
            "AdditionalInfo" => "user$userId additional info_šÄßüл",
            "FonNr" => "111-111-$userId",
            "FaxNr" => "111-111-111-$userId",
            "CountryId" => $userCountry,
        ];
        if ( $userCountry == 'Germany' ) {
            $addressData["StateId"] = "BE";
        }
        return $addressData;
    }

    public function _failed(\AcceptanceTester $I)
    {
        $this->cleanUpUserData($I);
    }

    protected function cleanUpUserData(\AcceptanceTester $I)
    {
        /** Change Germany and Belgium data to original. */
        $I->updateInDatabase('oxcountry', ["oxvatstatus" => 1], ["OXID" => 'a7c40f632e04633c9.47194042']);
        $I->updateInDatabase('oxcountry', ["oxvatstatus" => 1], ["OXID" => 'a7c40f631fc920687.20179984']);
    }
}