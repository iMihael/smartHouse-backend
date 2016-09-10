<?php 
$I = new AcceptanceTester($scenario);


$I->amOnPage('/auth/signup');

$I->see('SignUp', 'h2');
$I->see('First Name', 'label');
$I->see('Last Name', 'label');
$I->see('Email', 'label');
$I->see('Password', 'label');
$I->see('Confirm Password', 'label');

$I->click('input[type=submit]');

$I->see('Field First Name is required');
$I->see('Field Last Name is required');
$I->see('Field Email is required');
$I->see('Field Email must be an email address');
$I->see('Field Password is required');
$I->see('Field Confirm Password is required');

