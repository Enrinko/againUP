<?php

namespace App\Form;

use App\Entity\Questions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('question', TextType::class, [
                'label' => 'Вопрос',
                'attr' => [
                    'placeholder' => 'Вопрос'
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('answers', CollectionType::class, [
                'entry_type' => AnswersFormType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'attr' => [
                    'class' => 'answers'
                ]
            ])
            ->add('addNewAnswer', ButtonType::class, [
                'attr' => [
                    'class' => 'add_item_link_answer btn-secondary',
                    'mapped' => 'false',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Questions::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'THEREQuestiON',
        ]);
    }
}