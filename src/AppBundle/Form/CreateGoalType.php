<?php

namespace AppBundle\Form;

use SimpleHabits\Application\Command\Goal\CreateNewGoalCommand;
use SimpleHabits\Domain\Model\Goal\Goal;
use SimpleHabits\Domain\Model\User\UserId;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Type;

class CreateGoalType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'empty_data' => '',
                    'required' => true,
                    'constraints' => [
                        new NotBlank(),
                        new Length([
                            'min' => Goal::NAME_MIN_LENGTH,
                            'max' => Goal::NAME_MAX_LENGTH,
                        ]),
                    ],
                ]
            )
            ->add(
                'targetDate',
                DateTimeType::class,
                [
                    'required' => true,
                    'widget' => 'single_text',
                    'constraints' => [
                        new DateTime(),
                        new Range([
                            'min' => 'now',
                        ]),
                    ],
                ]
            )
            ->add(
                'targetValue',
                TextType::class,
                [
                    'empty_data' => '',
                    'required' => true,
                    'constraints' => [
                        new NotBlank(),
                        new Type('numeric'),
                        new Length([
                            'min' => Goal::NAME_MIN_LENGTH,
                            'max' => Goal::NAME_MAX_LENGTH,
                        ]),
                    ],
                ]
            )
            ->add(
                'initialValue',
                TextType::class,
                [
                    'empty_data' => '',
                    'required' => true,
                    'constraints' => [
                        new NotBlank(),
                        new Type('numeric'),
                        new Length([
                            'min' => Goal::NAME_MIN_LENGTH,
                            'max' => Goal::NAME_MAX_LENGTH,
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
            'user' => null,
            'data_class' => CreateNewGoalCommand::class,
            'empty_data' => function (FormInterface $form) {
                $userId = $form->getConfig()->getOption('user')->getId();

                return new CreateNewGoalCommand(
                    new UserId($userId),
                    $form->get('name')->getData(),
                    $form->get('targetDate')->getData(),
                    $form->get('targetValue')->getData(),
                    $form->get('initialValue')->getData()
                );
            },
        ]);

        $resolver->setRequired(['user']);
    }
}
