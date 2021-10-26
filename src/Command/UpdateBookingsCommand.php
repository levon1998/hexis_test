<?php

namespace App\Command;

use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UpdateBookingsCommand extends Command
{
    protected static $defaultName = 'app:update-bookings';
    protected static $defaultDescription = 'Add a short description for your command';

    /**
     * @var \App\Repository\BookingRepository
     */
    private BookingRepository $bookingRepository;

    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @param \App\Repository\BookingRepository    $bookingRepository
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     */
    public function __construct(BookingRepository $bookingRepository, EntityManagerInterface $entityManager)
    {
        $this->bookingRepository = $bookingRepository;
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $bookings = $this->bookingRepository->getExpiredBookings();

        foreach ($bookings as $booking) {

            $entityManager = $this->entityManager;

            $vehicle = $booking->getVehicle();
            $vehicle->setQuantity($vehicle->getQuantity()+$booking->getQuantity());
            $booking->setIsActive(false);

            $entityManager->persist($booking);
            $entityManager->persist($vehicle);
            $entityManager->flush();
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
