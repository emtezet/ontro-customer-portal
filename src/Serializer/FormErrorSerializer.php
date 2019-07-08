<?php

/*
 * This file was copied from the FOSRestBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file at https://github.com/FriendsOfSymfony/FOSRestBundle/blob/master/LICENSE
 *
 * Original @author Ener-Getick <egetick@gmail.com>
 */

namespace App\Serializer;



use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Serializes invalid Form instances.
 */
class FormErrorSerializer
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * FormErrorSerializer constructor.
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator) {
        $this->translator = $translator;
    }

    /**
     * @param FormInterface $data
     * @return array
     */
    public function getFormErrorMessages(FormInterface $data) {
        $errors = [];

        foreach($this->convertFormToArray($data)['children'] as $childName => $formChild) {
            if(array_key_exists('errors',$formChild)) {
                foreach($formChild['errors'] as $error) {
                    $errors[] = $error;
                }
            }
        }

        return $errors;
    }


    /**
     * @param FormInterface $data
     * @return array
     */
    private function convertFormToArray(FormInterface $data) {
        $form = $errors = [];

        foreach ($data->getErrors() as $error) {
            $errors[] = $this->getErrorMessage($error);
        }

        if ($errors) {
            $form['errors'] = $errors;
        }

        $children = [];
        foreach ($data->all() as $child) {
            if ($child instanceof FormInterface) {
                $children[$child->getName()] = $this->convertFormToArray($child);
            }
        }

        if ($children) {
            $form['children'] = $children;
        }

        return $form;
    }


    /**
     * @param FormError $error
     * @return string
     */
    private function getErrorMessage(FormError $error) {
        if (null !== $error->getMessagePluralization()) {
            return $this->translator->transChoice(
                $error->getMessageTemplate(),
                $error->getMessagePluralization(),
                $error->getMessageParameters(),
                'messages'
            );
        }

        return $this->translator->trans($error->getMessageTemplate(), $error->getMessageParameters(), 'messages');
    }
}