<?php

namespace Command;

use App\Entity\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\EntityManagerInterface;


class CreateAdminCommand extends Command
{
    protected static $defaultName = 'make:admin';

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager)
    {
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Create a new admin user')
            ->setHelp('This command allows you to create a new admin user');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Welcome to the admin user creation wizard.');

        $helper = $this->getHelper('question');

        $username = $helper->ask($input, $output, new Question('Please enter the username: '));
        $email = $helper->ask($input, $output, new Question('Please enter the email: '));
        $password = $helper->ask($input, $output, new Question('Please enter the password: '));


        $hashedPassword = $this->passwordHasher->hashPassword(null, $password);

        $roles = ['USER', 'ADMIN'];
        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($hashedPassword);
        $user->setRoles($roles);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $output->writeln('Success created admin user with username "'.$username.'" and password "'.$password.'"!' );

        return Command::SUCCESS;
    }
}
