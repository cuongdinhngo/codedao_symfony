<?php

namespace App\Controller;

use App\Entity\Category;
use App\EventDispatchers\Events\CategoryEvent;
use App\EventDispatchers\Events\CategoryIsUpdatedEvent;
use App\EventDispatchers\Listeners\CategoryListener;
use App\EventDispatchers\Subscribers\CategorySubscriber;
// use App\EventDispatchers\Subscribers\CategorySubscriber;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CategoryController extends AbstractController
{
    public $em;

    public $categoryRepository;

    public $dispatcher;

    public function __construct(EntityManagerInterface $em, CategoryRepository $categoryRepository, EventDispatcherInterface $dispatcher)
    {
        $this->em = $em;
        $this->categoryRepository = $categoryRepository;
        $this->dispatcher = $dispatcher;   
    }

    #[Route('/category/create', name: 'category.create')]
    public function create(Request $request): Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($category);
            $this->em->flush();

            // register listener for the 'category.created' event
            $listener = new CategoryListener();
            $this->dispatcher->addListener('category.created', array($listener, 'onCategoryIsCreatedEvent'));
 
            // dispatch
            $this->dispatcher->dispatch(new CategoryEvent($category), CategoryEvent::NAME);

            return $this->json(['id' => $category->getId(), 'name' => $category->getName()]);
        }

        return $this->render('category/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/category', name: "category.index", methods:["GET"])]
    public function index(Request $request): Response
    {
        $categories = $this->categoryRepository->getAllCategories();

        return $this->render('category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    #[Route('/category/{id}', name: "category.show", methods:["GET"])]
    public function show(Request $request)
    {
        $id = $request->get('id');
        $category = $this->categoryRepository->findOneById($id);

        return $this->render('category/show.html.twig', [
            'category' => $category
        ]);
    }

    #[Route('/category/update/{id}', name:"category.update")]
    public function update(Request $request)
    {
        $category = $this->categoryRepository->findOneById($request->get('id'));

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($category);
            $this->em->flush();

            // register subscriber
            $subscriber = new CategorySubscriber();
            $this->dispatcher->addSubscriber($subscriber);
 
            // dispatch
            $this->dispatcher->dispatch(new CategoryIsUpdatedEvent($category), CategoryIsUpdatedEvent::NAME);

            return $this->json([
                'id' => $category->getId(),
                'name' => $category->getName(),
                'description' => $category->getDescription()
            ]);
        }

        return $this->render('category/update.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('category/delete/{id}', name:'category.delete')]
    public function delete(Request $request)
    {
        $id = $request->get('id');
        $category = $this->em->find(Category::class, $id);
        $this->em->remove($category);
        $this->em->flush();
        return $this->redirectToRoute('category.index');
    }

}
