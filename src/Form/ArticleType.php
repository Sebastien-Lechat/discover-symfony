<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de votre article',
                'attr' => [
                    'placeholder' => 'Entrez un titre'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un titre.'
                    ]),
                ],
            ])
            ->add('subtitle', TextType::class, [
                'label' => 'Sous-titre de votre article',
                'attr' => [
                    'placeholder' => 'Entrez un sous-titre'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un sous-titre.'
                    ]),
                ],
            ])
            ->add('content', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Entrez le contenu de votre article'
                ],
            ])
            ->add('photo', FileType::class, [
                'label' => 'Photo de l\'article',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Créer l\'article',
                'attr' => [
                    'class' => 'd-block col-3 mx-auto btn btn-primary'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
