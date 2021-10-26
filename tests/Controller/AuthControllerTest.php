<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthControllerTest extends WebTestCase
{
    private const HOME_ROUTE = '/';

    /** @test */
    public function test_register(): void
    {
        $client = static::createClient();
        $client->request('GET', self::HOME_ROUTE);

        $client->clickLink('Register');
        self::assertSelectorTextContains('h1', 'Create your account.');


        $client->submitForm('Create your SensioTV account', [
            'user[firstname]' => '',
            'user[email]' => 'blub',
        ]);
        self::assertCount(5, $client->getCrawler()->filter('.form-error-icon'));

        $client->submitForm('Create your SensioTV account', [
            'user[firstname]' => 'Jane',
            'user[lastname]' => 'Doe',
            'user[email]' => 'test@test.com',
            'user[phone]' => '0123456789',
            'user[password][first]' => 'secretsecret',
            'user[password][second]' => 'secretsecret',
            'user[tos]' => true,
        ]);
//        var_dump($client->getResponse()->getContent());die;
        self::assertCount(0, $client->getCrawler()->filter('.form-error-icon'));

        /** @var User $user */
        $user = $client
            ->getContainer()
            ->get(UserRepository::class)
            ->findOneByEmail('test@test.com');

        self::assertNotNull($user);
        self::assertSame('Jane', $user->getFirstname());
    }
}
