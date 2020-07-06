<?php

namespace App\Controller;

use App\Entity\Ubo;
use App\Form\UboFormType;
use App\Repository\UboRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UboController extends AbstractController
{
    private $manager;
    private $uboRepo;
    private $factory;

    public function __construct(EntityManagerInterface $manager, UboRepository $uboRepo, FormFactoryInterface $factory) {
        $this->manager = $manager;
        $this->uboRepo = $uboRepo;
        $this->factory = $factory;
    }

    // public function buildEditForms(Request $request) {
    //     $allUbos = $this->uboRepo->findAll();

    //     $allUbosForms = [];
    //     foreach($allUbos as $i => $ubo) {
    //         $form = $this->factory->createNamed('ubo_form_' . $i, UboFormType::class, $ubo, ['action' => $this->generateUrl('uboEdit', ['id' => $ubo->getId()])]);
    //         $form->handleRequest($request); 
    //         $allUbosForms[] = $form;
    //     }

    //     return $allUbosForms;
    // }

    /**
     * @Route("/ubo", name="ubo")
     */
    public function index()
    {
        $ubosList = $this->uboRepo->findAll();

        return $this->render('ubo/index.html.twig', [
            'ubos_list' => $ubosList
        ]);
    }

    /**
     * @Route("/ubo-add", name="uboAdd")
     */
    public function uboAddAction(Request $request)
    {
        $allUbos = $this->uboRepo->findAll();

        $ubo = new Ubo;
        $form = $this->factory->createNamed('ubo_add_form', UboFormType::class, $ubo, ['action' => $this->generateUrl('uboAdd')])
                              ->add('submit', SubmitType::class, [
                                  'attr' => [
                                      'class' => 'btn btn-primary btn-block'
                                  ],
                                  'label' => 'Ajouter'
                              ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($ubo);
            $this->manager->flush();

            $allUbos = $this->uboRepo->findAll();

            return new JsonResponse(
                [
                    'valid' => true,
                    'list' => $this->renderView('ubo/_ubos_list.html.twig', ['ubos_list' => $allUbos]),
                    'form' => $this->renderView('ubo/_ubo_form.html.twig', ['form' => $form->createView()])
                ]
            );
        }

        return new JsonResponse(
            [
                'valid' => false,
                'list' => $this->renderView('ubo/_ubos_list.html.twig', ['ubos_list' => $allUbos]),
                'form' => $this->renderView('ubo/_ubo_form.html.twig', ['form' => $form->createView()])
            ]
        );

    }

    /**
     * @Route("/ubo-edit/{id}", name="uboEdit")
     */
    public function uboEditAction(Request $request, Ubo $ubo)
    {
        $allUbos = $this->uboRepo->findAll();

        $form = $this->factory->createNamed('ubo_edit_form', UboFormType::class, $ubo, ['action' => $this->generateUrl('uboEdit', ['id' => $ubo->getId()])])
                              ->add('submit', SubmitType::class, [
                                  'attr' => [
                                      'class' => 'btn btn-primary btn-block'
                                  ],
                                  'label' => 'Modifier'
                              ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            return new JsonResponse(
                [
                    'valid' => true,
                    'list' => $this->renderView('ubo/_ubos_list.html.twig', ['ubos_list' => $allUbos]),
                    'form' => $this->renderView('ubo/_ubo_form.html.twig', ['form' => $form->createView()])
                ]
            );
        }

        return new JsonResponse(
            [
                'valid' => false,
                'list' => $this->renderView('ubo/_ubos_list.html.twig', ['ubos_list' => $allUbos]),
                'form' => $this->renderView('ubo/_ubo_form.html.twig', ['form' => $form->createView()])
            ]
        );
    }

    /**
     * @Route("/ubo-remove/{id}", name="uboRemove")
     */
    public function uboRemoveAction(Request $request, Ubo $ubo)
    {
        $this->manager->remove($ubo);
        $this->manager->flush();
        
        $allUbos = $this->uboRepo->findAll();

        return new JsonResponse(
            [
                'list' => $this->renderView('ubo/_ubos_list.html.twig', ['ubos_list' => $allUbos])
            ]
        );
    }
}
