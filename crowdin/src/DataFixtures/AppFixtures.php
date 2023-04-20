<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Language;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{   

    private UserPasswordHasherInterface $hasher;

    //Pour hasher le mdp dans la base de données
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager)
    {
        $languages = [
            ['language' => 'English', 'code' => 'en'],
            ['language' => 'Spanish', 'code' => 'es'],
            ['language' => 'French', 'code' => 'fr'],
            ['language' => 'German', 'code' => 'de'],
            ['language' => 'Italian', 'code' => 'it'],
            ['language' => 'Arabic', 'code' => 'ar'],
        ];

        foreach ($languages as $languageData) {
            $language = new Language();
            $language->setLanguage($languageData['language']);
            $language->setCode($languageData['code']);
            $manager->persist($language);
        }

        $manager->flush();

         // Create some user entities
         $users = [
            [
                'username' => 'akli',
                'email' => 'akli@gmail.com',
                'password' => 'akli123',
                'description'=>'I am a web developer',
                'language' => $manager->getRepository(Language::class)->findOneBy(['code' => 'en']),
            ],
            [
                'username' => 'oumayma',
                'email' => 'oum@gmail.com',
                'password' => 'oum123',
                'description'=>'I am a web developer',
                'language' => $manager->getRepository(Language::class)->findOneBy(['code' => 'ar']),
            ],
            [
                'username' => 'anis',
                'email' => 'anis@gmail.com',
                'password' => 'anis123',
                'description'=>'I am a web developer',
                'language' => $manager->getRepository(Language::class)->findOneBy(['code' => 'fr']),
            ]
        ];

        foreach ($users as $userData) {
            $user = new User();
            $user->setUsername($userData['username']);
            $user->setEmail($userData['email']);
            $user->setPassword(
                $this->hasher->hashPassword($user, $userData["password"])
            );
            $user->setDescription($userData['description']);
            $user->addLanguage($userData['language']);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
