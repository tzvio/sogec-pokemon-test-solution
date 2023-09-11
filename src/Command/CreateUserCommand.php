<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create:user',
    description: 'Create a new user',
)]
class CreateUserCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            'Create a new user',
            '=================',
        ]);

        $userData = $this->getEmailAndPassword($input, $output);
        $this->saveUserInDb($userData['email'], $userData['password']);
        $io = new SymfonyStyle($input, $output);

        $io->success('User created successfully');

        return Command::SUCCESS;
    }

    /**
     * Retrieves the email and password from the user.
     *
     * @param mixed $input The input object.
     * @param mixed $output The output object.
     * @return array The email and password as an array.
     */
    private function getEmailAndPassword($input, $output) : array {
        $helper = $this->getHelper('question');
        $emailQuestion = new Question('Email: ');
        $passwordQuestion = new Question('Password: ');
        $passwordQuestion->setHidden(true);
        $passwordQuestion->setHiddenFallback(true);
        $email = $helper->ask($input, $output, $emailQuestion);
        $password = $helper->ask($input, $output, $passwordQuestion);
        return ['email' => $email, 'password' => $password];
    }

    /**
     * Saves a user in the database.
     *
     * @param string $email The user's email.
     * @param string $password The user's password.
     */
    private function saveUserInDb($email, $password) {
        $user = new User();
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $password
        );
        $user->setEmail($email);
        $user->setPassword($hashedPassword);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
