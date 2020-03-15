<?php

namespace App\Form;

use App\Entity\Card;
use App\Entity\Faction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CardFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('health')
            ->add('damage')
            ->add('cost')
            ->add('faction', EntityType::class, [
                'class' => Faction::class,
                'choice_label' => function (Faction $faction) {
                    return $faction->getTitle();
                }
            ])
            ->add('image', FileType::class,[
                'mapped' => false,
                'required' => false,
                ])
            ->add('add', SubmitType::class, [
                'label' => 'Create Card',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Card::class,
        ]);
    }
}
