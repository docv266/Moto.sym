<?php

namespace doc\MotoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AnnonceEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->remove('password');
        $builder->remove('mail');
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'doc_motobundle_annonce_edit';
    }
	
	public function getParent()
	{
		return new AnnonceType();
	}
}
