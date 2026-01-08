<?php

namespace App\DTOs;

class TaskDto
{
    public function __construct(
        public string $title,
        public ?string $description,
        public string $status
    ){
    }

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
            description: $data['description'],
            status: $data['status'],
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status
        ];
    }
}
