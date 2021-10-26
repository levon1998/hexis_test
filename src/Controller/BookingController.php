<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Vehicle;
use App\Entity\Vendor;
use App\Repository\VehicleRepository;
use App\Repository\VendorRepository;
use DateInterval;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/booking")
 */
class BookingController extends AbstractController
{
    /**
     * @var \App\Repository\VendorRepository
     */
    private VendorRepository $vendorRepository;

    /**
     * @var \App\Repository\VehicleRepository
     */
    private VehicleRepository $vehicleRepository;

    /**
     * @param \App\Repository\VendorRepository  $vendorRepository
     * @param \App\Repository\VehicleRepository $vehicleRepository
     */
    public function __construct(VendorRepository $vendorRepository, VehicleRepository $vehicleRepository)
    {
        $this->vendorRepository = $vendorRepository;
        $this->vehicleRepository = $vehicleRepository;
    }

    /**
     * @Route("/", name="booking_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('booking/index.html.twig', [
            'vendors' => $this->vendorRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{vendor}", name="booking_in_vendor", methods={"GET"})
     */
    public function bookingInVendor(Vendor $vendor) : Response
    {
        return $this->render('booking/select_vehicle.html.twig', [
            'vendor' => $vendor,
        ]);
    }

    /**
     * @Route("/book/{vehicle}", name="book_vehicle", methods={"GET"})
     */
    public function bookVehicles(Vehicle $vehicle) : Response
    {
        return $this->render('booking/book_vehicle.html.twig', [
            'vehicle' => $vehicle,
        ]);
    }

    /**
     * @Route("/book", name="book_now", methods={"POST"})
     */
    public function bookNow(Request $request, ValidatorInterface $validator)
    {
        $vehicle = $this->vehicleRepository->find($request->get('vehicleId'));
        $quantity = $request->get('quantity');

        if ($quantity > $vehicle->getQuantity()) {
            return new Response('Now available only '. $vehicle->getQuantity() . 'vehicles.');
        }

        $booking = new Booking();
        $booking->setIsActive(true);
        $booking->setStartDate(new \DateTime($request->get('date')));
        $booking->setEndDate(new \DateTime($request->get('date').' +1 day'));
        $booking->setQuantity($quantity);
        $booking->setVehicle($vehicle);

        $errors = $validator->validate($booking);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;

            return new Response($errorsString);
        }

        $entityManager = $this->getDoctrine()->getManager();

        $vehicle->setQuantity($vehicle->getQuantity()-$quantity);

        $entityManager->persist($booking);
        $entityManager->persist($vehicle);
        $entityManager->flush();

        return $this->render('booking/index.html.twig', [
            'vendors' => $this->vendorRepository->findAll(),
        ]);
    }
}
