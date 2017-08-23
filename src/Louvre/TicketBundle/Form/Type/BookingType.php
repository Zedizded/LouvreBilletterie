<?php
 
 namespace Louvre\TicketBundle\Form;
 
 use Symfony\Component\Form\AbstractType;
 use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
 use Symfony\Component\Form\Extension\Core\Type\DateType;
 use Symfony\Component\Form\Extension\Core\Type\EmailType;
 use Symfony\Component\Form\Extension\Core\Type\IntegerType;
 use Symfony\Component\Form\FormBuilderInterface;
 use Symfony\Component\OptionsResolver\OptionsResolver;
 
 class BookingType extends AbstractType
 {
     /**
      * {@inheritdoc}
      */
     public function buildForm(FormBuilderInterface $builder, array $options)
     {
         $builder
             ->add('ticketDate',        DateType::Class, array(
                 'widget' => 'single_text',
                 'format' => 'dd/MM/yyyy'
             ))
             ->add('email',             EmailType::class)
             ->add('ticketType',        ChoiceType::class, array(
                 'choices' =>        array(
                     'Journée'    => true,
                     '1/2 journée'=> false
                 )
             ))
             ->add('totalNbTickets',    IntegerType::class);
     }
     
     /**
      * {@inheritdoc}
      */
     public function configureOptions(OptionsResolver $resolver)
     {
         $resolver->setDefaults(array(
             'data_class' => 'Louvre\TicketBundle\Entity\Booking'
         ));
     }
 
     /**
      * {@inheritdoc}
      */
     public function getBlockPrefix()
     {
         return 'louvre_ticketbundle_booking';
     }
 
 
 }