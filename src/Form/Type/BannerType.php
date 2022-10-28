<?php

declare(strict_types=1);

namespace Siganushka\BannerBundle\Form\Type;

use Siganushka\BannerBundle\Entity\Banner;
use Siganushka\BannerBundle\Media\BannerImg;
use Siganushka\MediaBundle\Form\Type\MediaUrlType;
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
            ->add('img', MediaUrlType::class, [
                'label' => 'banner.img',
                'channel' => BannerImg::class,
                'constraints' => new NotBlank(),
            ])
            ->add('sorted', IntegerType::class, [
                'label' => 'banner.sorted',
                'priority' => -1,
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'banner.enabled',
                'priority' => -1,
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
