<?php

namespace App\Command;

use App\Entity\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Repository\UserRepository;

class CreateAdminCommand extends Command
{
    protected static $defaultName = 'make:admin';

    private UserPasswordHasherInterface $passwordHasher;
    private UserRepository $userRepository;

    public function __construct(UserPasswordHasherInterface $passwordHasher,
                                EntityManagerInterface      $entityManager,
                                ValidatorInterface          $validator,
                                UserRepository              $userRepository
    )
    {
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->userRepository = $userRepository;

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

        if (empty($username)) {
            $output->writeln('<error>Username cannot be empty!</error>');
            return Command::FAILURE;
        }

        if (empty($email)) {
            $output->writeln('<error>Email cannot be empty!</error>');
            return Command::FAILURE;
        }
        if ($this->userRepository->findByEmail($email)) {
            $output->writeln('<error>User with this email already exists!</error>');
            return Command::FAILURE;
        }
        if (empty($password)) {
            $output->writeln('<error>Password cannot be empty!</error>');
            return Command::FAILURE;
        }

        $roles = ['USER', 'ADMIN'];
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
