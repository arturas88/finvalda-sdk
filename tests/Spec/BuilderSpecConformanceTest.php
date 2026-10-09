<?php

declare(strict_types=1);

namespace Finvalda\Tests\Spec;

use BackedEnum;
use Finvalda\Builders\CapitalizationBuilder;
use Finvalda\Builders\ClearingBuilder;
use Finvalda\Builders\DisbursementBuilder;
use Finvalda\Builders\InflowBuilder;
use Finvalda\Builders\InternalTransferBuilder;
use Finvalda\Builders\InventoryCountBuilder;
use Finvalda\Builders\NonAnalyticalBuilder;
use Finvalda\Builders\OperationBuilder;
use Finvalda\Builders\PaymentBuilder;
use Finvalda\Builders\ProductionBuilder;
use Finvalda\Builders\ProductLine;
use Finvalda\Builders\PurchaseBuilder;
use Finvalda\Builders\PurchaseOrderBuilder;
use Finvalda\Builders\PurchaseReturnBuilder;
use Finvalda\Builders\PurchaseUpdateBuilder;
use Finvalda\Builders\SaleBuilder;
use Finvalda\Builders\SalesReservationBuilder;
use Finvalda\Builders\SalesReturnBuilder;
use Finvalda\Builders\ServiceLine;
use Finvalda\Builders\UvmCancellationBuilder;
use Finvalda\Builders\UvmPurchaseOrderBuilder;
use Finvalda\Builders\UvmSalesReservationBuilder;
use Finvalda\Builders\WriteOffBuilder;
use Finvalda\Enums\PaymentType;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionParameter;
use ReflectionUnionType;
use Throwable;

/**
 * Every key a builder can put on the wire must exist in the spec table of the
 * envelope it lands in. The server silently drops unknown tags, so a misnamed
 * field "succeeds" and does nothing — this test is the only thing that notices.
 *
 * Setters are discovered by reflection, so a new setter is covered the moment
 * it is written. Each one is called alone on a fresh builder; a setter or
 * build() that throws is a refusal, which is fine — only a key that reaches the
 * payload and is not in the spec fails.
 */
class BuilderSpecConformanceTest extends TestCase
{
    /** Methods that are plumbing, not payload. */
    private const SKIP = [
        'using', 'parameter', 'build', 'save', 'getOperationClass', 'short',
        'setHeader', 'addProductLine', 'addServiceLine', 'addPaymentLine', 'assertNotSold',
        'forDocument',
    ];

    /**
     * @return array<string, array{class-string, bool}>
     */
    public static function builders(): array
    {
        $cases = [];

        foreach ([
            SaleBuilder::class, SalesReservationBuilder::class, SalesReturnBuilder::class,
            PurchaseBuilder::class, PurchaseOrderBuilder::class, PurchaseReturnBuilder::class,
            UvmSalesReservationBuilder::class, UvmPurchaseOrderBuilder::class, UvmCancellationBuilder::class,
            InternalTransferBuilder::class, WriteOffBuilder::class, CapitalizationBuilder::class,
            InventoryCountBuilder::class, InflowBuilder::class, DisbursementBuilder::class,
            ClearingBuilder::class, ProductionBuilder::class, NonAnalyticalBuilder::class,
        ] as $class) {
            $cases[self::shortName($class)] = [$class, false];

            if (method_exists($class, 'short')) {
                $cases[self::shortName($class) . ' short'] = [$class, true];
            }
        }

        return $cases;
    }

    /**
     * @param  class-string<OperationBuilder>  $class
     */
    #[DataProvider('builders')]
    public function test_every_emitted_key_is_in_the_spec(string $class, bool $short): void
    {
        $violations = [];

        foreach (self::setters($class) as $method) {
            $builder = new $class();

            if ($short) {
                $builder->short();
            }

            // A payment refuses to build without its required type; give it one
            // so its setters are still exercised.
            if ($builder instanceof PaymentBuilder) {
                $builder->type(PaymentType::Fifo);
            }

            try {
                $method->invokeArgs($builder, self::argumentsFor($method));
                $payload = $builder->build();
            } catch (Throwable) {
                continue;
            }

            self::walkRoot($payload, "{$method->getName()}()", $violations);
        }

        $this->assertSame([], $violations, 'Keys absent from docs/FVS_Webservice.md §3.70');
    }

    public function test_every_emitted_key_of_a_purchase_correction_is_in_the_spec(): void
    {
        $violations = [];
        $headerFields = (new \ReflectionClassConstant(PurchaseUpdateBuilder::class, 'HEADER_FIELDS'))->getValue();

        $builder = (new PurchaseUpdateBuilder())
            ->journal('PIRK')
            ->number(1)
            ->header(array_fill_keys($headerFields, 'X'))
            ->removeProduct('P1', 'W1')
            ->removeService('S1');

        try {
            $builder->product(self::fullProductLine())->service(self::fullServiceLine());
        } catch (Throwable) {
            // Rejecting a line field is a refusal, not a silent drop.
        }

        self::walk('update', 'KoregPirkDok', $builder->build()['KoregPirkDok'], 'build()', $violations);

        $this->assertSame([], $violations, 'Keys absent from docs/FVS_Webservice.md §3.72');
    }

    /**
     * Lines built with every ProductLine / ServiceLine setter, checked against
     * the detail envelope of each builder that accepts generic lines.
     *
     * @param  class-string<OperationBuilder>  $class
     */
    #[DataProvider('builders')]
    public function test_line_dtos_only_emit_spec_fields(string $class, bool $short): void
    {
        $violations = [];

        foreach (['product' => self::fullProductLine(), 'service' => self::fullServiceLine()] as $kind => $line) {
            $builder = new $class();

            if ($short) {
                $builder->short();
            }

            try {
                $builder->{$kind}($line);
                $payload = $builder->build();
            } catch (Throwable) {
                continue;
            }

            self::walkRoot($payload, "{$kind}()", $violations);
        }

        $this->assertSame([], $violations, 'Line keys absent from docs/FVS_Webservice.md §3.70');
    }

    /**
     * @param  array<string, mixed>  $payload
     * @param  list<string>  $violations
     */
    private static function walkRoot(array $payload, string $context, array &$violations): void
    {
        // Inventorizacija is the one flat envelope: { mode, Inventorizacija: [...] }.
        if (array_key_exists('mode', $payload)) {
            unset($payload['mode']);

            foreach ($payload['Inventorizacija'] ?? [] as $row) {
                self::walk('insert', 'Inventorizacija', $row, $context, $violations);
            }

            return;
        }

        foreach ($payload as $envelope => $node) {
            self::walk('insert', $envelope, $node, $context, $violations);
        }
    }

    /**
     * @param  array<string, mixed>  $node
     * @param  list<string>  $violations
     */
    private static function walk(string $section, string $envelope, array $node, string $context, array &$violations): void
    {
        $fields = OperationSpec::fields($section, $envelope);

        if ($fields === null) {
            $violations[] = "{$context}: envelope {$envelope} is not in the spec";

            return;
        }

        foreach ($node as $key => $value) {
            if (is_array($value) && array_is_list($value)) {
                foreach ($value as $row) {
                    self::walk($section, (string) $key, $row, $context, $violations);
                }
            } elseif (is_array($value)) {
                self::walk($section, (string) $key, $value, $context, $violations);
            } elseif (! in_array($key, $fields, true)) {
                $violations[] = "{$context}: {$envelope}.{$key}";
            }
        }
    }

    /**
     * @return list<ReflectionMethod>
     */
    private static function setters(string $class): array
    {
        return array_values(array_filter(
            (new \ReflectionClass($class))->getMethods(ReflectionMethod::IS_PUBLIC),
            fn (ReflectionMethod $m): bool => ! $m->isStatic()
                && ! $m->isConstructor()
                && ! in_array($m->getName(), self::SKIP, true),
        ));
    }

    /**
     * @return list<mixed>
     */
    private static function argumentsFor(ReflectionMethod $method): array
    {
        return array_map(self::valueFor(...), $method->getParameters());
    }

    private static function valueFor(ReflectionParameter $parameter): mixed
    {
        $type = $parameter->getType();
        $names = match (true) {
            $type instanceof ReflectionNamedType => [$type->getName()],
            $type instanceof ReflectionUnionType => array_map(fn ($t) => $t->getName(), $type->getTypes()),
            default => ['mixed'],
        };

        foreach ($names as $name) {
            if (enum_exists($name) && is_subclass_of($name, BackedEnum::class)) {
                return $name::cases()[0];
            }
        }

        foreach ($names as $name) {
            if ($name === 'DateTimeInterface') {
                return '2024-01-15';
            }
        }

        return match ($names[0]) {
            ProductLine::class => self::fullProductLine(),
            ServiceLine::class => self::fullServiceLine(),
            'int' => 1,
            'float' => 1.5,
            'bool' => true,
            'array' => match (true) {
                $parameter->getDeclaringFunction()->getName() === 'additionalCosts' => [1 => 1.5],
                in_array($parameter->getName(), ['objects', 'map'], true) => [1 => 'O1'],
                default => [],
            },
            default => 'X1',
        };
    }

    private static function fullProductLine(): ProductLine
    {
        return self::exercise(ProductLine::make('P1', 1), ['make', 'set', 'toArray', 'secondMeasurement']);
    }

    private static function fullServiceLine(): ServiceLine
    {
        return self::exercise(ServiceLine::make('S1', 1), ['make', 'set', 'toArray']);
    }

    /**
     * @template T of object
     *
     * @param  T  $line
     * @param  list<string>  $skip
     * @return T
     */
    private static function exercise(object $line, array $skip): object
    {
        foreach ((new \ReflectionClass($line))->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            if ($method->isStatic() || $method->isConstructor() || in_array($method->getName(), $skip, true)) {
                continue;
            }

            $method->invokeArgs($line, self::argumentsFor($method));
        }

        return $line;
    }

    private static function shortName(string $class): string
    {
        return substr($class, strrpos($class, '\\') + 1);
    }
}
