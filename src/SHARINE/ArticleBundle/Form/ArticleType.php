<?php

namespace SHARINE\ArticleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', 'text')
            ->add('resume' , 'text')
            ->add('categorie', 'entity', array(
                'class' => 'SHARINECategorieBundle:Categorie',
                'property' => 'nom',
            ))
            ->add('image',new ImageType())
            ->add('mainArticle', "textarea" , array(
                'attr' => array(
                    'class' => 'ckeditor',
                )))
            ->add('save', 'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SHARINE\ArticleBundle\Entity\Article'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sharine_articlebundle_article';
    }
}
