<?php

namespace doc\MotoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use doc\MotoBundle\Entity\Moto;

class MotoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
		
			->add('moto', 'entity', array(
				'class'    => 'docMotoBundle:Moto',
				'property' => 'modele',
				'multiple' => false
			  ))			
        ;
					
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'doc\MotoBundle\Entity\Moto'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'doc_motobundle_moto';
    }
}
