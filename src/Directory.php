<?php

namespace Equip;

use Equip\Route;
use Equip\Exception\DirectoryException;
use Equip\Structure\Dictionary;

class Directory extends Dictionary
{
    const ANY = '*';
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const PATCH = 'PATCH';
    const HEAD = 'HEAD';
    const DELETE = 'DELETE';
    const OPTIONS = 'OPTIONS';

    /**
     * @param string $path
     * @param string|Route $actionOrRoute
     *
     * @return static
     */
    public function any($path, $actionOrRoute)
    {
        return $this->route(self::ANY, $path, $actionOrRoute);
    }

    /**
     * @param string $path
     * @param string|Route $actionOrRoute
     *
     * @return static
     */
    public function get($path, $actionOrRoute)
    {
        return $this->route(self::GET, $path, $actionOrRoute);
    }

    /**
     * @param string $path
     * @param string|Route $actionOrRoute
     *
     * @return static
     */
    public function post($path, $actionOrRoute)
    {
        return $this->route(self::POST, $path, $actionOrRoute);
    }

    /**
     * @param string $path
     * @param string|Route $actionOrRoute
     *
     * @return static
     */
    public function put($path, $actionOrRoute)
    {
        return $this->route(self::PUT, $path, $actionOrRoute);
    }

    /**
     * @param string $path
     * @param string|Route $actionOrRoute
     *
     * @return static
     */
    public function patch($path, $actionOrRoute)
    {
        return $this->route(self::PATCH, $path, $actionOrRoute);
    }

    /**
     * @param string $path
     * @param string|Route $actionOrRoute
     *
     * @return static
     */
    public function head($path, $actionOrRoute)
    {
        return $this->route(self::HEAD, $path, $actionOrRoute);
    }

    /**
     * @param string $path
     * @param string|Route $actionOrRoute
     *
     * @return static
     */
    public function delete($path, $actionOrRoute)
    {
        return $this->route(self::DELETE, $path, $actionOrRoute);
    }

    /**
     * @param string $path
     * @param string|Route $actionOrRoute
     *
     * @return static
     */
    public function options($path, $actionOrRoute)
    {
        return $this->route(self::OPTIONS, $path, $actionOrRoute);
    }

    /**
     * @param string $method
     * @param string $path
     * @param string|Route $actionOrRoute
     *
     * @return static
     */
    public function route($method, $path, $actionOrRoute)
    {
        if ($actionOrRoute instanceof Route) {
            $action = $actionOrRoute;
        } else {
            $action = new Route($actionOrRoute);
        }

        return $this->withValue(sprintf('%s %s', $method, $path), $action);
    }

    /**
     * @inheritDoc
     *
     * @throws DirectoryException If a value is not an Route instance
     */
    protected function assertValid(array $data)
    {
        parent::assertValid($data);

        foreach ($data as $value) {
            if (!is_object($value) || !$value instanceof Route) {
                throw DirectoryException::invalidEntry($value);
            }
        }
    }
}
