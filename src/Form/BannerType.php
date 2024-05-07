<?php

declare(strict_types=1);

namespace Siganushka\BannerBundle\Form;

use Siganushka\BannerBundle\Entity\Banner;
use Siganushka\BannerBundle\Media\BannerImg;
use Siganushka\MediaBundle\Form\Type\MediaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class BannerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'banner.title',
                'constraints' => new NotBlank(),
            ])
            ->add('img', MediaType::class, [
                'label' => 'banner.img',
                'channel' => BannerImg::class,
                'constraints' => new NotBlank(),
                'style' => 'width: auto; min-height: 150px',
            ])
            ->add('sort', IntegerType::class, [
                'label' => 'generic.sort',
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'generic.enabled',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Banner::class,
        ]);
    }
}
