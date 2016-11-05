<?php

declare(strict_types=1);

namespace AppBundle\Form;

use SimpleHabits\Application\Command\Goal\AddGoalStepCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class AddGoalStepType extends AbstractType implements DataMapperInterface
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'value',
                TextType::class,
                [
                    'required' => true,
                    'constraints' => [
                        new NotBlank(),
                    ],
                ]
            )
            ->add(
                'date',
                DateType::class,
                [
                    'required' => false,
                    'widget' => 'single_text',
                    'constraints' => [
                        new Date(),
                        new Range([
                            'min' => $options['goal']->getStartedAt()->format('Y-m-d'),
                            'max' => 'now'
                        ]),
                    ],
                ]
            )
            ->add('save', SubmitType::class)
            ->setDataMapper($this);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'goal' => null,
            'data_class' => AddGoalStepCommand::class,
            'empty_data' => null,

//                function (FormInterface $form) {
//                $goalId = $form->getConfig()->getOption('goal')->getId();
//
//                return new AddGoalStepCommand(
//                    $goalId,
//                    $form->get('value')->getData(),
//                    $form->get('date')->getData()
//                );
//            },
        ]);

        $resolver->setRequired(['goal']);
    }

    public function mapDataToForms($data, $forms)
    {
        $forms = iterator_to_array($forms);
        $forms['value']->setData($data ? $data->getValue() : null);
        $forms['date']->setData($data ? $data->getDate() : null);
    }

    public function mapFormsToData($forms, &$data)
    {
        $forms = iterator_to_array($forms);
        $goalId = $forms['date']->getParent()->getConfig()->getOption('goal')->getId();

        $data = new AddGoalStepCommand(
            $goalId,
            $forms['value']->getData(),
            $forms['date']->getData()
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app_add_goal_step_type';
    }
}
