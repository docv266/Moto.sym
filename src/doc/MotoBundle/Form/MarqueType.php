<?php

namespace doc\MotoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MarqueType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('marque', 'entity', array(
				'class'    => 'docMotoBundle:Marque',
				'property' => 'nom',
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
            'data_class' => 'doc\MotoBundle\Entity\Marque'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'doc_motobundle_marque';
    }
}
