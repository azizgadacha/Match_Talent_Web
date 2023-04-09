<?php

namespace App\Form;

use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('question', null, [
                'label' => 'Question',
            ])
            ->add('propositiona', null, [
                'label' => 'Proposition A',
            ])
            ->add('propositionb', null, [
                'label' => 'Proposition B',
            ])
            ->add('propositionc', null, [
                'label' => 'Proposition C',
            ])
            ->add('idBonnereponse', ChoiceType::class, [
                'label' => 'Bonne réponse',
                'choices' => [
                    'Proposition A' => 'A',
                    'Proposition B' => 'B',
                    'Proposition C' => 'C',
                ],
            ])
            ->add('QuizAssocier', null, [
                'label' => 'Quiz associé',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}

