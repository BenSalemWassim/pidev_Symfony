<?php

namespace ForumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class QuestionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre',TextType::class ,['required' => true])->add('contenu',TextareaType::class ,['required' => true])->add('categorie',ChoiceType::class ,array(
            'choices' => [
                'Developpement Web'=> 'Developpement Web',
                'Developpement Mobile'=> 'Developpement Mobile',
                'Design'=> 'Design',
                'Marketing'=> 'Marketing',

                 'Réseaux'=> 'Reseaux',
                 'Systèmes d\'exploitation' =>'Systèmes dexploitation',
                 'Matériel & logiciels'=>'Matériel & logiciels',
                'Jeux vidéo' => 'Jeux vidéo',

            ],
            'required'=> true,
        ))
        ->add('Ajouter',SubmitType::class);;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ForumBundle\Entity\Question'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'forumbundle_question';
    }


}
