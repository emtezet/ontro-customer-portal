<?php

namespace App\Controller;

use App\Entity\Trip;
use App\Serializer\FormErrorSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Type\TripFormType;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TripController extends AbstractController
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
     * @Route("/trip/page/add", name="trip_page_add", options={"expose"=true})
     */
    public function pageAdd()
    {
        $form = $this->createForm(TripFormType::class, null, [
            'action' => $this->generateUrl('trip_action_ajax_add'),
            'method' => 'POST',
            'attr' => [
                'class' => 'form-inline'
            ]
        ]);

        return $this->render('Trip/page_add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/trip/action_ajax/add", name="trip_action_ajax_add")
     */
    public function actionAjaxTrip(Request $request) {

        $form = $this->createForm(TripFormType::class, null, [
            'validation_groups' => ['new']
        ]);

        $form->handleRequest($request);

        if ($request->isMethod("POST") && $form->isSubmitted() && $form->isValid() && $request->isXmlHttpRequest()) {
            $passenger = $form->getData();

            $this->getDoctrine()->getManager()->persist($passenger);
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse([
                'status' => 'success',
                'successMessage' => 'Trip created!'
            ], JsonResponse::HTTP_CREATED);
        } else {
            return new JsonResponse([
                'status' => 'error',
                'errors' => $this->formErrorSerializer->getFormErrorMessages($form)
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/trip/action_ajax/remove", name="trip_action_ajax_remove", options={"expose"=true}, methods={"POST"})
     *
     * @param Request $request
     * @return Response
     */
    public function actionAjaxTripRemove(Request $request) {
        $tripId = intval($request->request->get('trip_id'));
        $tripToRemove = $this->getDoctrine()->getRepository(Trip::class)->find($tripId);
        $violations = $this->validator->validate($tripToRemove, null, 'remove');

        if ($request->isMethod("POST") && $request->isXmlHttpRequest() && !count($violations)) {

            $this->getDoctrine()->getManager()->remove($this->getDoctrine()->getManager()->merge($tripToRemove));
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse([
                'status' => 'success',
                'successMessage' => 'Trip removed!'
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
