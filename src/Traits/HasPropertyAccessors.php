<?php

declare(strict_types=1);

namespace NorseBlue\HandyProperties\Traits;

use NorseBlue\HandyProperties\Exceptions\PropertyNotAccessibleException;

/**
 * Handles property accessors.
 */
trait HasPropertyAccessors
{
    use BuildsMethodName;

    /**
     * Checks if an accessor exists for the key.
     *
     * @param string $key
     * @param string|null $accessor optional Output parameter to get the accessor name.
     *
     * @return bool
     */
    final protected function hasAccessor(string $key, ?string &$accessor = null): bool
    {
        $accessor = $this->buildMethodName($key, 'accessor');

        return method_exists($this, $accessor);
    }

    /**
     * Magic accessor.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function __get(string $key)
    {
        if ($this->hasAccessor($key, $accessor)) {
            return $this->$accessor();
        }

        throw new PropertyNotAccessibleException($key, 'The property is not accessible.');
    }

    /**
     * Magic variable set check.
     *
     * @param string $key
     *
     * @return bool
     */
    public function __isset(string $key): bool
    {
        $value = $this->__get($key);

        return isset($value);
    }
}
