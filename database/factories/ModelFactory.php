<?php

use App\SalesActivity;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'id' => App\User::count() + 1,
        'fname' => $faker->firstName,
        'lname' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => Str::random(10),
    ];
});

$factory->define(App\JobTitleCategory::class, function (Faker $faker) {
    return [
        'name' => $faker->jobTitle
    ];
});

$factory->define(App\CompanyStatus::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'color' => $faker->hexColor,
        'reason' => $faker->sentence
    ];
});

$factory->define(App\JobTitle::class, function (Faker $faker) {
    return [
        'name' => $faker->jobTitle,
    ];
});

$factory->define(App\Operation::class, function (Faker $faker) {
    return [
        'name' => $faker->jobTitle,
    ];
});

$factory->define(App\SubOperation::class, function (Faker $faker) {
    return [
        'name' => $faker->jobTitle,
    ];
});

$factory->define(App\Organization::class, function (Faker $faker) {
    return [
        'id' => App\Organization::count() + 1,
        'name' => $faker->company,
        'address' => $faker->address,
        'phone' => $faker->phoneNumber,
        'email' => $faker->companyEmail,
        'reg' => $faker->swiftBicNumber,
        'vat' => $faker->word,
    ];
});

$factory->define(App\Role::class, function (Faker $faker) {
    return [
        'name' => 'manager',
        'display_name' => 'Manager',
        'updated_at' => $faker->dateTime,
        'created_at' => $faker->dateTime,
    ];
});

$factory->define(App\Country::class, function (Faker $faker) {
    return [
        'name' => $faker->jobTitle,
        'code' => $faker->jobTitle,
    ];
});

$factory->define(App\Company::class, function (Faker $faker) {
    return [
        'name' => $faker->jobTitle,
        'reg' => $faker->jobTitle,
        'vat' => $faker->jobTitle,
        'legal_address' => $faker->jobTitle,
        'address' => $faker->jobTitle,
        'source' => $faker->jobTitle
    ];
});

$factory->define(App\CompanyBranch::class, function (Faker $faker) {
    return [
        'name' => $faker->jobTitle,
        'address' => $faker->jobTitle,
        'phone' => $faker->jobTitle,
        'color' => $faker->jobTitle,
        'email' => $faker->jobTitle,
    ];
});

$factory->define(App\Workforce::class, function (Faker $faker) {
    return [
        'fname' => $faker->firstName,
        'lname' => $faker->lastName,
        'gender' => rand(0, 1),
        'idcode' => $faker->jobTitle,
        'dob' => now(),
        'is_personnel' => rand(0, 1),
        'phone' => $faker->jobTitle,
        'email' => $faker->companyEmail,
        'address' => $faker->jobTitle,
        'bank_acc' => $faker->jobTitle,
        'source' => $faker->jobTitle
    ];
});

$factory->define(App\CompanyContact::class, function (Faker $faker) {
    return [
        'fname' => $faker->jobTitle,
        'lname' => $faker->jobTitle,
        'phone' => $faker->jobTitle,
        'job_title' => $faker->jobTitle,
        'email' => $faker->jobTitle,
    ];
});

$factory->define(App\Permission::class, function (Faker $faker) {
    return [
        'name' => Str::slug($faker->jobTitle, '_'),
        'display_name' => $faker->jobTitle,
    ];
});

$factory->define(App\WorkSchedule::class, function (Faker $faker) {
    return [
        'name' => $faker->jobTitle,
    ];
});

$factory->define(App\Workday::class, function (Faker $faker) {
    return [
        'start_date' => $faker->dateTime,
        'end_date' => $faker->dateTime,
    ];
});

$factory->define(App\DocFolder::class, function (Faker $faker) {
    return [
        'name' => $faker->jobTitle,
    ];
});

$factory->define(App\Doc::class, function (Faker $faker) {
    return [
        'name' => $faker->jobTitle,
    ];
});

$factory->define(App\SalesActivityType::class, function (Faker $faker) {
    return [
        'name'         => $faker->jobTitle,
        'show_address' => 1,
    ];
});

$factory->define(App\UserSettings::class, function (Faker $faker) {
    return [
        'zero_sales_act_companies' => rand(1, 15)
    ];
});

$factory->define(SalesActivity::class, function (Faker $faker) {
    return [
        'start_date' => $faker->dateTime->format('Y-m-d H:i:s'),
        'end_date' => $faker->dateTime->format('Y-m-d H:i:s'),
        'address' => $faker->address,
        'info' => $faker->text,
        'result' => $faker->text,
        'outcome' => $faker->randomDigit
    ];
});


$factory->define(App\OrgSettings::class, function (Faker $faker) {
    return [
        'status_length_days' => $faker->randomDigit
    ];
});
