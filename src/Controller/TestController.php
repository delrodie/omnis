<?php

namespace App\Controller;

use App\Entity\Test;
use App\Form\TestType;
use App\Repository\TestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backend/test")
 */
class TestController extends AbstractController
{
    /**
     * @Route("/", name="backend_test_index", methods={"GET","POST"})
     */
    public function index(Request $request, TestRepository $testRepository): Response
    {
        $test = new Test();
        $form = $this->createForm(TestType::class, $test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            // Reformattage des dates
            $debut = explode("/",$test->getDateDebut());
            $fin = explode("/",$test->getDateFin());
            $nouvelle_date_debut = $debut['2'].'-'.$debut['1'].'-'.$debut['0'];
            $nouvelle_date_fin = $fin['2'].'-'.$fin['1'].'-'.$fin['0'];
            $test->setDateDebut($nouvelle_date_debut);
            $test->setDateFin($nouvelle_date_fin);

            $verif = $testRepository->findOneBy(['annee'=>$test->getAnnee()]);
            if ($verif){
                $this->addFlash('error', "Le test de cette année accademique a deja été defini");

                return $this->redirectToRoute('backend_test_index');
            }
            $entityManager->persist($test);
            $entityManager->flush();

            return $this->redirectToRoute('backend_test_index');
        }

        return $this->render('test/index.html.twig', [
            'tests' => $testRepository->findBy([],['id'=>'DESC']),
            'test' => $test,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="backend_test_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $test = new Test();
        $form = $this->createForm(TestType::class, $test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($test);
            $entityManager->flush();

            return $this->redirectToRoute('backend_test_index');
        }

        return $this->render('test/new.html.twig', [
            'test' => $test,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="backend_test_show", methods={"GET"})
     */
    public function show(Test $test): Response
    {
        return $this->render('test/show.html.twig', [
            'test' => $test,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="backend_test_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Test $test, TestRepository $testRepository): Response
    {
        $form = $this->createForm(TestType::class, $test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_test_index');
        }

        return $this->render('test/edit.html.twig', [
            'tests' => $testRepository->findBy([],['id'=>'DESC']),
            'test' => $test,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="backend_test_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Test $test): Response
    {
        if ($this->isCsrfTokenValid('delete'.$test->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($test);
            $entityManager->flush();
        }

        return $this->redirectToRoute('backend_test_index');
    }
}
