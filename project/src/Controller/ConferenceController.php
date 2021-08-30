<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface;
use App\Entity\Conference;
use App\Form\ConferenceType;
use App\Repository\ConferenceRepository;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\Logging\DebugStack;
use Doctrine\ORM\EntityManagerInterface;

class ConferenceController extends AbstractController
{
    public $logger;

    public $doctrine;

    public $entityManager;

    public $doctrineConnection;

    public $stack;

    public function __construct(EntityManagerInterface $entityManager, Connection $connection ,LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->entityManager = $entityManager;
        /**Get Doctrine queries */
        $this->doctrineConnection = $connection;
        $this->stack = new DebugStack();
        $this->doctrineConnection->getConfiguration()->setSQLLogger($this->stack);
    }

    #[Route('/conference/', name: 'conference.index', methods:["GET"])]
    public function index(Request $request): mixed
    {
        $this->logger->info(__METHOD__);
        return $this->render('conference/index.html.twig', [
            'controller_name' => 'ConferenceController',
        ]);
    }

    /**
     * @Route("conference/store", name="conference.store", methods={"POST"})
     */
    public function store(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $conference = new Conference();
        $conference->setCity($request->request->get('city'));
        $conference->setYear($request->request->get('year'));
        $conference->setIsInternational($request->request->get('isInternational'));

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($conference);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$conference->getId());
    }

    #[Route('/conference/{id}', name: 'conference.show', methods:["GET"])]
    public function show(Request $request, ConferenceRepository $repository)
    {
        $id = $request->get('id');
        // $conference = $this->entityManager->find(Conference::class, $id);

        $conference = $repository->findOneById($id);
        // var_dump($this->stack);

        return $this->json(['conference_id' => $conference->getId(), 'city' => $conference->getCity()]);
    }

    #[Route('/conference/{id}', name: 'conference.update', methods:["PUT"])]
    public function update(Request $request)
    {
        $content = $request->getContent();
        var_dump($content);
        die();
        $id = $request->get('id');
        $conference = $this->entityManager->find(Conference::class, $id);

        if (!$conference) {
            throw $this->createNotFoundException(
                'No Conference found for id '.$id
            );
        }


        $form = $this->createForm(ConferenceType::class, $conference);
        $form->handleRequest($request);

        $this->entityManager->persist($conference);

        $this->entityManager->flush();

        return $this->json(['conference_id' => $conference->getId(), 'city' => $conference->getCity()]);
    }
}
