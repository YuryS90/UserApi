<?php
use App\Modules\Validate\Validator;
use Psr\Container\ContainerInterface;

class ValidatorTest extends \PHPUnit\Framework\TestCase
{
    private ContainerInterface $container;
    private Validator $validator;

    protected function setUp(): void
    {
        // Создаем mock для ContainerInterface, чтобы передать в конструктор Validator
        $this->container = $this->createMock(ContainerInterface::class);

        // Настраиваем валидатор с пустым конфигом
        $this->validator = new Validator($this->container, []);
    }

    public function testFieldEmailError(): void
    {
        $payload = ['name' => 'email', 'value' => '', 'confirm' => null];

        // ============================================
        $this->validator->execute($payload, true, ['required']);

        $this->assertEquals(
            'Заполните поле email!',
            $this->validator->getError());

        // ============================================
        $this->validator->execute($payload, true, ['email']);

        $this->assertEquals(
            'Email должен соответствовать формату mail@some.com!',
            $this->validator->getError());

        // ============================================
        $this->validator->execute($payload, true, ['min:5']);

        $this->assertEquals(
            'Email слишком короткий: минимум 5 символов!',
            $this->validator->getError());
    }

    public function testFieldEmailSuccess(): void
    {
        $payload = ['name' => 'email', 'value' => 'example@gmail.com', 'confirm' => null];

        // ============================================
        $this->validator->execute($payload, true, ['required']);

        $this->assertEquals(
            '',
            $this->validator->getError());

        // ============================================
        $this->validator->execute($payload, true, ['email']);

        $this->assertEquals(
            '',
            $this->validator->getError());

        // ============================================
        $this->validator->execute($payload, true, ['min:5']);

        $this->assertEquals(
            '',
            $this->validator->getError());
    }
}