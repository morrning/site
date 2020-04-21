<?php

namespace App\Form;

use App\Entity\NewsCat;
use App\Entity\NewsContent;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminNewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class)
            ->add('body', CKEditorType::class)
            ->add('des',TextType::class)
            ->add('pictureBanner', TextType::class,['required'=>false])
            ->add('kywords',TextType::class,['required'=>false])
            ->add('url',TextType::class)
            ->add('cat',EntityType::class,
            [
                'class'=> NewsCat::class,
                'choice_label' => 'catName',
            ])
            ->add('submit',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NewsContent::class,
        ]);
    }
}
