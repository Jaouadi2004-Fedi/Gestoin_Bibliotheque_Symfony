<?php

namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Author;
use App\Entity\Book;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Book1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title', TextType::class, [
            'label' => 'Book Title',
            'attr' => ['class' => 'form-control'],
        ])
      ->add('authors', EntityType::class, [
    'class' => Author::class,
    'choice_label' => function(Author $author) {
        return $author->getName() . ' ' . $author->getSurname();
    },
    'multiple' => true,       // permet de sélectionner plusieurs auteurs
    'expanded' => false,      // false = select, true = checkbox
    'placeholder' => 'Choose one or more authors',
    'label' => 'Author(s)',
    'attr' => ['class' => 'form-select'],
]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
