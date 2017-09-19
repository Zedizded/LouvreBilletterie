<?php

namespace Louvre\tests\LouvreTicketBundle\Validator;

use DateTime;
use Louvre\TicketBundle\Validator\CheckDate;
use Louvre\TicketBundle\Validator\CheckDateValidator;
use PHPUnit\Framework\TestCase;

class CheckDateValidatorTest extends TestCase
{
    private $constraint;
    private $context;

    public function setUp()
    {
        $this->constraint = new CheckDate();
        $this->context = $this->getMockBuilder('Symfony\Component\Validator\Context\ExecutionContext')
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testDateDay()
    {
        $day = new DateTime('2017-10-31');
        $validator = new CheckDateValidator();
        $validator->initialize( $this->context);

        $this->context->expects($this->once())
            ->method('addViolation')
            ->with($this->constraint->messageTue);
        $validator->validate($day, $this->constraint);
    }

    public function testDateMonth()
    {
        $date = new DateTime('2017-12-25');
        $validator = new CheckDateValidator();
        $validator->initialize( $this->context);

        $this->context->expects($this->once())
            ->method('addViolation')
            ->with($this->constraint->messageDec);
        $validator->validate($date, $this->constraint);
    }
}