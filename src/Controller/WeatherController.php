<?php

namespace App\Controller;

use App\Repository\LocationRepository;
use App\Repository\MeasurementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WeatherController extends AbstractController
{
    #[Route(
        '/weather/{city}/{country}',
        name: 'app_weather',
        requirements: ['country' => '[A-Za-z]{2}'],
        defaults: ['country' => null]
    )]
    public function city(
        string $city,
        ?string $country,
        LocationRepository $locationRepository,
        MeasurementRepository $repository
    ): Response
    {
        $query = $locationRepository->createQueryBuilder('location')
            ->where('LOWER(location.city) = LOWER(:city)')
            ->setParameter('city', $city);

        if ($country !== null) {
            $query->andWhere('UPPER(location.country) = :country')
                ->setParameter('country', strtoupper($country));
        }

        $locations = $query->getQuery()->getResult();

        $location = $locations[0] ?? null;

        $measurements = $repository->findByLocation($location);

        return $this->render('weather/city.html.twig', [
            'controller_name' => 'WeatherController',
            'location' => $location,
            'measurements' => $measurements,
        ]);
    }
}
