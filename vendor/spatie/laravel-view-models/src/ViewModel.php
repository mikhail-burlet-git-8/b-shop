<?php

namespace Spatie\ViewModels;

use Closure;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;
use Symfony\Component\HttpFoundation\Response;

abstract class ViewModel implements Arrayable, Responsable
{
    protected $ignore = [];

    protected $view = '';

    protected $_data = [];
    protected $snakeCase = false;

    public function toArray(): array
    {
        return $this
            ->items()
            ->all();
    }

    public function toResponse($request): Response
    {
        if ($request->wantsJson()) {
            return new JsonResponse($this->items());
        }

        if ($this->view) {
            return response()->view($this->view, $this);
        }

        return new JsonResponse($this->items());
    }

    public function view(string $view, array $data = []): ViewModel
    {
        $this->view = $view;
        $this->_data = $data;

        return $this;
    }

    protected function items(): Collection
    {
        $class = new ReflectionClass($this);

        $publicProperties = collect($class->getProperties(ReflectionProperty::IS_PUBLIC))
            ->reject(function (ReflectionProperty $property) {
                return $this->shouldIgnore($property->getName());
            })
            ->mapWithKeys(function (ReflectionProperty $property) {
                return [$this->resolveName($property->getName()) => $this->{$property->getName()}];
            });

        $publicMethods = collect($class->getMethods(ReflectionMethod::IS_PUBLIC))
            ->reject(function (ReflectionMethod $method) {
                return $this->shouldIgnore($method->getName());
            })
            ->mapWithKeys(function (ReflectionMethod $method) {
                return [$this->resolveName($method->getName()) => $this->createVariableFromMethod($method)];
            });


        return $publicProperties->merge($publicMethods)->merge($this->_data);
    }

    protected function shouldIgnore(string $methodName): bool
    {
        if (Str::startsWith($methodName, '__')) {
            return true;
        }

        return in_array($methodName, $this->ignoredMethods());
    }

    protected function ignoredMethods(): array
    {
        return array_merge([
            'toArray',
            'toResponse',
            'view',
        ], $this->ignore);
    }

    protected function createVariableFromMethod(ReflectionMethod $method)
    {
        if ($method->getNumberOfParameters() === 0) {
            return $this->{$method->getName()}();
        }

        return Closure::fromCallable([$this, $method->getName()]);
    }

    protected function resolveName(string $name): string
    {
        if (! $this->snakeCase) {
            return $name;
        }

        return Str::snake($name);
    }
}
