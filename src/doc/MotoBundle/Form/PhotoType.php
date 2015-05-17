<?php

namespace doc\MotoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PhotoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file')
        ;
    }
    
	/*
	class="file" 
	accept="image/*" 
	data-browse-label="Parcourir" 
	data-show-upload="false" 
	data-preview-file-type="image" 
	data-max-file-size="3072" 
	data-msg-size-too-large="Le fichier ne doit pas dépasser 3Mo."
	*/
	
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'doc\MotoBundle\Entity\Photo'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'doc_motobundle_photo';
    }
}
