<?php

namespace App\Form;

use App\Entity\Cotisation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Length;

class NewCotisationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('year', ChoiceType::class, [
                'help' => 'L\'année auquel vous souhaitez appliquer ces montants.',
                'choices' => array_combine(range(2000, 2050), range(2000, 2050)),
                'data' => date('Y'),
                'label' => 'Année',
                'constraints' => [
                    new Range([
                        'min' => 2000,
                        'max' => 2050
                    ]),
                    new Length([
                        'min' => 4,
                        'max' => 4
                    ])
                ]
            ])
            ->add('month', ChoiceType::class, [
                'help' => 'Le mois auquel vous souhaitez appliquer ces montants.',
                'choices' => array_combine(range(1, 12), range(1, 12)),
                'data' => date('n'),
                'label' => 'Mois',
                'constraints' => [
                    new Range([
                        'min' => 1,
                        'max' => 12
                    ]),
                    new Length([
                        'min' => 1,
                        'max' => 2
                    ])
                ]
            ])
            ->add('pmss_amount', MoneyType::class, [
                'help' => 'Le montant du PMSS à la date renseignée.',
                'label' => 'Montant du PMSS',
                'scale' => 2,
                'constraints' => new Range([
                    'min' => 1000,
                    'max' => 5000,
                    'notInRangeMessage' => 'Le montant du PMSS ({{ value }}) doit être compris entre {{ min }} et {{ max }}.'
                ])
            ])
            ->add('smic_amount', MoneyType::class, [
                'help' => 'Le montant du SMIC horaire à la date renseignée',
                'label' => 'Montant du SMIC',
                'scale' => 2,
                'constraints' => new Range([
                    'min' => 2,
                    'max' => 15,
                    'notInRangeMessage' => 'Le montant du SMIC ({{ value }}) doit être compris entre {{ min }} et {{ max }}.'
                ])
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cotisation::class,
        ]);
    }
}
