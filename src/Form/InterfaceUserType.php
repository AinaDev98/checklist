<?php

namespace App\Form;

use App\Entity\Boutiques;
use App\Entity\Cloud;
use App\Entity\Connexion;
use App\Entity\InterfaceUser;
use App\Entity\Mail;
use App\Entity\QrCode;
use App\Entity\Telephone;
use App\Entity\Winparf;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InterfaceUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Boutique', EntityType::class, [
                'class' => Boutiques::class,
                'required' => true,
                'label' => 'Nom de la boutique :',
                'multiple' => false,
                'expanded' => false
            ])
            ->add('Winparf', EntityType::class, [
                'class' => Winparf::class,
                'required' => true,
                'label' => "L'état du Winparf :",
                'multiple' => false,
                'expanded' => true
            ])
            ->add('Mail', EntityType::class, [
                'class' => Mail::class,
                'required' => true,
                'label' => "L'état du Mail :",
                'multiple' => false,
                'expanded' => true
            ])
            ->add('Cloud', EntityType::class, [
                'class' => Cloud::class,
                'required' => true,
                'label' => "L'état du Cloud :",
                'multiple' => false,
                'expanded' => true
            ])
            ->add('Connexion', EntityType::class, [
                'class' => Connexion::class,
                'required' => true,
                'label' => "L'état du Connexion :",
                'multiple' => false,
                'expanded' => true
            ])
            ->add('Telephone', EntityType::class, [
                'class' => Telephone::class,
                'required' => true,
                'label' => "L'état du Télephone :",
                'multiple' => false,
                'expanded' => true
            ])
            ->add('QrCode', EntityType::class, [
                'class' => QrCode::class,
                'required' => true,
                'label' => "L'état du QR Code :",
                'multiple' => false,
                'expanded' => true
            ])
            ->add('Commentaire', CKEditorType::class, [
                'label' => 'Commentaire ou autre problème :',
                'required' => false,
            ])
            ->add('Submit', SubmitType::class, [
                'label' => 'Soumettre',
                'attr' => [
                    'class' => 'btn btn-primary btn-lg d-flex'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InterfaceUser::class,
        ]);
    }
}
