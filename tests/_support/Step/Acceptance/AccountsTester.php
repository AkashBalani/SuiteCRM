<?php

namespace Step\Acceptance;

use InvalidArgumentException;

class AccountsTester extends \AcceptanceTester
{
    /**
     * Navigate to accounts module
     */
    public function gotoAccounts()
    {
        $I = new NavigationBarTester($this->getScenario());
        $I->clickAllMenuItem('Accounts');
    }

    /**
     * Create an account
     *
     * @param $name
     */
    public function createAccount($name, $fullFill = true, $useFaker = true)
    {
        if (!$fullFill && $useFaker) {
            throw new InvalidArgumentException('Using Faker option is possible only for full-fill.');
        }
        
        $I = new EditView($this->getScenario());
        $DetailView = new DetailView($this->getScenario());
        $Sidebar = new SideBar($this->getScenario());

        $I->see('Create Account', '.actionmenulink');
        $Sidebar->clickSideBarAction('Create');
        $I->waitForEditViewVisible();
        $I->fillField('#name', $name);
        
        if ($fullFill) {
            if ($useFaker) {
                $faker = $this->getFaker();
                $I->fillField('#phone_office', $faker->phoneNumber());
                $I->fillField('#website', $faker->url());
                $I->fillField('#phone_fax', $faker->phoneNumber());
                $I->fillField('#Accounts0emailAddress0', $faker->email());
                $I->fillField('#billing_address_street', $faker->streetAddress());
                $I->fillField('#billing_address_city', $faker->city());
                $I->fillField('#billing_address_state', $faker->city());
                $I->fillField('#billing_address_postalcode', $faker->postcode());
                $I->fillField('#billing_address_country', $faker->country());
                $I->fillField('#description', $faker->text());
                $I->fillField('#annual_revenue', $faker->randomDigit());
                $I->fillField('#employees', $faker->randomDigit());
            }

            $I->checkOption('#shipping_checkbox');
            $I->selectOption('#account_type', 'Analyst');
            $I->selectOption('#industry', 'Apparel');
        }

        $I->seeElement('#assigned_user_name');
        $I->seeElement('#parent_name');
        $I->seeElement('#campaign_name');

        $I->clickSaveButton();
        $DetailView->waitForDetailViewVisible();
    }
    
    /**
     * 
     * @return Scenario
     */
    public function getPublicScenario() {
        return $this->getScenario();
    }
}
