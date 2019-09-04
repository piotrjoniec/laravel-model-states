<?php

namespace Spatie\State;

use Spatie\State\Exceptions\InvalidState;

abstract class State
{
    /** @var static[] */
    public static $map = [];

    public static function make(string $value, ...$args): State
    {
        $stateClass = isset(static::$map[$value])
            ? static::$map[$value]
            : $value;

        if (! is_subclass_of($stateClass, static::class)) {
            throw InvalidState::make($value, static::class);
        }

        return new $stateClass(...$args);
    }

    public function __toString(): string
    {
        $className = get_class($this);

        $alias = array_search($className, self::$map);

        return $alias ?? $className;
    }
}
