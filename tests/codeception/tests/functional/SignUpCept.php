<?php

/**
 * @var $scenario
 */

$I = new FunctionalTester($scenario);
$I->wantTo('Test sign up page');
$I->amOnPage('/auth/signup');
$I->see('SignUp', 'h2');

