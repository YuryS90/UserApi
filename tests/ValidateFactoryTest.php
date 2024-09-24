<?php
use App\Modules\Validate\ValidateFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class ValidateFactoryTest extends TestCase
{
    private ContainerInterface $container;

    protected function setUp(): void
    {
        // Создаем mock для ContainerInterface, чтобы передать в конструктор Validator
        $this->container = $this->createMock(ContainerInterface::class);
    }

    /**
     * Корректное создание правила MaxRule с использованием фабричного метода.
     * @throws Exception
     */
    public function testCreateCheckForMax(): void
    {
        $rule = ValidateFactory::create('max', $this->container);

        $this->assertInstanceOf(\App\Modules\Validate\Rules\CheckForMax::class, $rule);
    }

    public function testCreateInvalidRule(): void
    {
        // Ожидаем исключение с конкретным сообщением
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Класс invalid_rule с соответствующим правилом не создан!");

        // Выполняем вызов, который должен выбросить исключение
        ValidateFactory::create('invalid_rule', $this->container);
    }
}