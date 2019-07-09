<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;
use App\Entity\Trip;
use App\Entity\Passenger;
use App\Form\Type\UserFormType;
use App\Serializer\FormErrorSerializer;

class CustomerController extends AbstractController
{
    /**
     * @var FormErrorSerializer
     */
    private $formErrorSerializer;


    /**
     * @param FormErrorSerializer $formErrorSerializer
     */
    public function __construct(FormErrorSerializer $formErrorSerializer) {
        $this->formErrorSerializer = $formErrorSerializer;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index() {
        $user = $this->getUser();
        $passengers = $this->getDoctrine()->getRepository(Passenger::class)->findAll();
        $trips = $this->getDoctrine()->getRepository(Trip::class)->findAll();

        $form = $this->createForm(UserFormType::class, $user, [
            'action' => $this->generateUrl('action_ajax_user_edit',[
                "user_id" => $user->getId()
            ]),
            'method' => 'POST',
            'attr' => [
                'class' => 'form-inline'
            ]
        ]);


        return $this->render('Customer/page_details.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
            'passengers' => $passengers,
            'trips' => $trips
        ]);
    }

    /**
     * @Route("/action_ajax/user/edit/{user_id}", name="action_ajax_user_edit", methods={"POST"})
     */
    public function actionAjaxUserEdit(Request $request) {

        $user = $this->getDoctrine()->getRepository(User::class)->find(intval($request->get('user_id')));

        $form = $this->createForm(UserFormType::class, $user, [
            'validation_groups' => ['edit']
        ]);

        $form->handleRequest($request);

        if ($request->isMethod("POST") && $form->isSubmitted() && $form->isValid() && $request->isXmlHttpRequest()) {
            $user = $form->getData();

            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse([
                'status' => 'success',
                'successMessage' => 'User edited!'
            ], JsonResponse::HTTP_CREATED);
        } else {
            return new JsonResponse([
                'status' => 'error',
                'errors' => $this->formErrorSerializer->getFormErrorMessages($form)
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

}
