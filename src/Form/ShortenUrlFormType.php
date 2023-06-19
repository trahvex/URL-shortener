<?php

namespace App\Form;

use App\Entity\URL;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Url as validUrl;

class ShortenUrlFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('originalUrl', TextType::class, [
                'label' => 'URL',
                'constraints' => [
                    new validUrl([
                        'message' => 'The URL "{{ value }}" is not a valid URL.',
                    ]),
                ],
            ])
            ->add('customAlias', TextType::class, [
                'label' => 'Alias (opcional)',
                'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Acortar',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => URL::class,
        ]);
    }
}
