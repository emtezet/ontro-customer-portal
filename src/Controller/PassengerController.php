<?php

namespace App\Controller;

use App\Entity\Passenger;
use App\Serializer\FormErrorSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Type\PassengerFormType;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PassengerController extends AbstractController
{
    /**
     * @var FormErrorSerializer
     */
    private $formErrorSerializer;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var ValidatorInterface
     */
    private $validator;


    /**
     * @param FormErrorSerializer $formErrorSerializer
     */
    public function __construct(FormErrorSerializer $formErrorSerializer, TranslatorInterface $translator, ValidatorInterface $validator) {
        $this->formErrorSerializer = $formErrorSerializer;
        $this->translator = $translator;
        $this->validator = $validator;
    }

    /**
     * @Route("/passenger/page/add", name="passenger_page_add", options={"expose"=true})
     */
    public function pageAdd()
    {
        $form = $this->createForm(PassengerFormType::class, null, [
            'action' => $this->generateUrl('passenger_action_ajax_add'),
            'method' => 'POST',
            'attr' => [
                'class' => 'form-inline'
            ]
        ]);

        return $this->render('Passenger/page_add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/passenger/action_ajax/add", name="passenger_action_ajax_add")
     */
    public function actionAjaxPassengerAdd(Request $request) {

        $form = $this->createForm(PassengerFormType::class, null, [
            'validation_groups' => ['new']
        ]);

        $form->handleRequest($request);

        if ($request->isMethod("POST") && $form->isSubmitted() && $form->isValid() && $request->isXmlHttpRequest()) {
            $passenger = $form->getData();

            $this->getDoctrine()->getManager()->persist($passenger);
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse([
                'status' => 'success',
                'successMessage' => 'Passenger created!'
            ], JsonResponse::HTTP_CREATED);
        } else {
            return new JsonResponse([
                'status' => 'error',
                'errors' => $this->formErrorSerializer->getFormErrorMessages($form)
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/passenger/action_ajax/remove", name="passenger_action_ajax_remove", options={"expose"=true}, methods={"POST"})
     *
     * @param Request $request
     * @return Response
     */
    public function actionAjaxPassengerRemove(Request $request) {
        $passengerId = intval($request->request->get('passenger_id'));
        $passengerToRemove = $this->getDoctrine()->getRepository(Passenger::class)->find($passengerId);
        $violations = $this->validator->validate($passengerToRemove, null, 'remove');

        if ($request->isMethod("POST") && $request->isXmlHttpRequest() && !count($violations)) {

            $this->getDoctrine()->getManager()->remove($this->getDoctrine()->getManager()->merge($passengerToRemove));
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse([
                'status' => 'success',
                'successMessage' => 'Passenger removed!'
            ], JsonResponse::HTTP_CREATED);
        } else {
            $errors = [];
            foreach($violations as $violation) {
                $errors[] = $this->translator->trans($violation->getMessageTemplate(), $violation->getParameters(), 'messages');
            }

            return new JsonResponse([
                'status' => 'error',
                'errors' => $errors
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}
