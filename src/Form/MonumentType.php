<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\Monument;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class MonumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('location_new', LocationType::class, [
                'required' => false,
                'mapped' => false
            ])
            ->add('location_list', EntityType::class, [
                'property_path' => 'location',
                'class' => Location::class,
                'expanded' => false,
                'multiple' => false
            ])
            ->add('image', MediaType::class)

            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) use($builder) {
                $data = $event->getData();
                $form = $event->getForm();


               // dd($data, $form);
                if($data['location_new']["country"] !== "") {
                    $form->remove("location_list");
                    $form->add('location_new',LocationType::class, [
                        'allow_extra_fields' => true,
                        'property_path' => 'location',
                        'required' => true,
                        'mapped' => true
                    ]) ;
                }
            });
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Monument::class,
            "allow_extra_field" => true
        ]);
    }
}
