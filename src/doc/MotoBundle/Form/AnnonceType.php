<?php

namespace doc\MotoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use doc\MotoBundle\Entity\MotoRepository;

class AnnonceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',      		'text')
            ->add('annee',      		'text')
            ->add('kilometrage',      	'text')
            ->add('description',      	'textarea')
            ->add('anneeMini',      	'text', array('required' => false))
            ->add('kilometrageMaxi',    'text', array('required' => false))
            ->add('pseudo',      		'text')
            ->add('mail',      			'email')
            ->add('telephone',      	'text', array('required' => false))
            ->add('password', 'repeated', array(
				'type' => 'password',
				'invalid_message' => 'Les mots de passe doivent correspondre',
				'options' => array('required' => true)
			  ))
			
			->add('departement', 'entity', array(
				'class'    => 'docMotoBundle:Departement',
				'property' => 'getAffichage',
				'multiple' => false
			  ))
			  
            ->add('marques_voulues', 'entity', array(
				'class'    => 'docMotoBundle:Marque',
				'property' => 'nom',
				'multiple' => true,
				'required' => false,
				'attr' => array('class' => 'chzn-select')
			  ))
			  
            ->add('genres_voulus', 'entity', array(
				'class'    => 'docMotoBundle:Genre',
				'property' => 'nom',
				'multiple' => true,
				'required' => false,
				'attr' => array('class' => 'chzn-select')
			  ))
			  
			->add('moto', 'entity', array(
				'class'    => 'docMotoBundle:Moto',
				'property' => 'getAffichage',
				'multiple' => false,
				'attr' => array('class' => 'chzn-select')
			  ))
			
            ->add('motos_voulues', 'entity', array(
				'class'    => 'docMotoBundle:Moto',
				'property' => 'modele',
				'multiple' => true,
				'group_by' => 'getNomMarque',
				'required' => false,
				'attr' => array('class' => 'chzn-select')
			  ))
            
            ->add('photo1', 			new PhotoType(), array('required' => false))
            ->add('photo2', 			new PhotoType(), array('required' => false))
            ->add('photo3', 			new PhotoType(), array('required' => false))
			->add('save',      			'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'doc\MotoBundle\Entity\Annonce'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'doc_motobundle_annonce';
    }
}
