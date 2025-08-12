<?php

namespace App\DTOs;

class AuthorImportData implements \JsonSerializable
{
    public function __construct(
        public string $name,
        public ?string $bio = null,
        public ?string $birthDate = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: (string)($data['name'] ?? ''),
            bio: $data['bio'] ?? null,
            birthDate: $data['birth_date'] ?? ($data['birthDate'] ?? null),
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'bio' => $this->bio,
            'birth_date' => $this->birthDate,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}


