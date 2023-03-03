<?php

namespace App\Form;

use App\Entity\Lectures;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LectureFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Назовите лекцию',
                'attr' => [
                    'placeholder' => 'Название лекции',
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Данные',
                'attr' => [
                    'placeholder' => 'Данные'
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Сохранить'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lectures::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'this-Time_LectUre',
        ]);
    }
}