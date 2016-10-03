<?php

namespace AppBundle\Form;

use SimpleHabits\Application\Command\AddViolationCommand;
use SimpleHabits\Domain\Model\Violation\Violation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class CreateViolationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'reason',
                TextType::class,
                [
                    'required' => false,
                    'constraints' => [
                        new Length([
                            'max' => Violation::MAX_REASON_LENGTH,
                        ]),
                    ],
                ]
            )
            ->add('save', SubmitType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'abstinence' => null,
            'data_class' => AddViolationCommand::class,
            'empty_data' => function (FormInterface $form) {
                $abstinenceId = $form->getConfig()->getOption('abstinence')->getId();

                return new AddViolationCommand(
                    $abstinenceId,
                    $form->get('reason')->getData()
                );
            },
        ]);

        $resolver->setRequired(['abstinence']);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app_create_violation_type';
    }
}
