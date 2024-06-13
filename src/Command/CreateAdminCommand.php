<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateAdminCommand extends Command
{
    protected static $defaultName = 'make:admin';

    private UserPasswordHasherInterface $passwordHasher;
    private EntityManagerInterface $entityManager;
    private ValidatorInterface $validator;

    public function __construct(UserPasswordHasherInterface $passwordHasher,
                                EntityManagerInterface      $entityManager,
                                ValidatorInterface          $validator,
    )
    {
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
        $this->validator = $validator;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Create a new admin user')
            ->setHelp('This command allows you to create a new admin user');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Welcome to the admin user creation wizard.');

        $helper = $this->getHelper('question');

        $username = $helper->ask($input, $output, new Question('Please enter the username: '));
        $email = $helper->ask($input, $output, new Question('Please enter the email: '));
        $password = $helper->ask($input, $output, new Question('Please enter the password: '));

        if (empty($username)) {
            $output->writeln('<error>Username cannot be empty!</error>');

            return Command::FAILURE;
        }

        if (empty($email)) {
            $output->writeln('<error>Email cannot be empty!</error>');

            return Command::FAILURE;
        }
        $userRepository = $this->entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => $email]);
        if ($user instanceof User) {
            $output->writeln('<error>User with this email already exists!</error>');

            return Command::FAILURE;
        }
        if (empty($password)) {
            $output->writeln('<error>Password cannot be empty!</error>');

            return Command::FAILURE;
        }

        $roles = ['ROLE_USER', 'ROLE_ADMIN'];
        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);
        $user->setRoles($roles);

        $errors = $this->validator->validate($user);
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $output->writeln('<error>' . $error->getMessage() . '</error>');
            }

            return Command::FAILURE;
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $output->writeln('Success created admin user with username "' . $username . '" and password "' . $password . '"!');

        return Command::SUCCESS;
    }
}
