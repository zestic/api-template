<?php

declare(strict_types=1);

namespace Application;

abstract class AbstractDTO
{
    protected array $data = [];

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }
}