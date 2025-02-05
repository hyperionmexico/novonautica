<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class PagoCombustibleType extends AbstractType
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(
        Security $security
    ) {
        $this->security = $security;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $dolarAttributes = [
            'class' => 'esdecimal'
        ];

        if (!in_array('ROLE_ADMIN', $this->security->getUser()->getRoles())) {
            $dolarAttributes['readonly'] = 'readonly';
        }

        $builder
            ->add('metodopago', ChoiceType::class, [
                'choices' => [
                    'Efectivo' => 'Efectivo',
                    'Transferencia' => 'Transferencia',
                    'Tarjeta de crédito' => 'Tarjeta de crédito',
                    'Tarjeta de débito' => 'Tarjeta de débito'
                ],
                'placeholder' => 'Seleccionar...',
                'label' => 'Método de pago',
            ])
            ->add('divisa', ChoiceType::class, [
                'choices' => ['MXN' => 'MXN','USD' => 'USD'],
                'label' => 'Divisa',
            ])
            ->add('cantidad', MoneyType::class, [
                'label' => 'Pago',
                'currency' => 'USD',
                'divisor' => 100,
                'grouping' => true,
                'attr' => ['class' => 'esdecimal']
            ])
            ->add('fecharealpago', DateType::class, [
                'label' => 'Fecha de pago',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => [
                    'class' => 'datepicker-solo input-calendario',
                    'readonly' => true
                ],
                'format' => 'yyyy-MM-dd',
                'empty_data' => new \DateTime()
            ])
            ->add('dolar', MoneyType::class, [
                'label' => 'Valor del dolar',
                'currency' => 'USD',
                'divisor' => 100,
                'grouping' => true,
                'attr' => $dolarAttributes,
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Pago'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_pago';
    }


}
