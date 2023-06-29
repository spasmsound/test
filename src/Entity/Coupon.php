<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Coupon
{
    use HasId;

    public const TYPE_FIXED = 'fixed';
    public const TYPE_PERCENT = 'percent';

    #[ORM\Column(type: 'string')]
    private string $type = self::TYPE_FIXED;

    #[ORM\Column(type: 'integer')]
    private int $value;

    #[ORM\Column(type: 'string', unique: true)]
    private string $code;

    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @throws \Exception
     */
    public function setType(string $type): void
    {
        if (!in_array($type, [self::TYPE_FIXED, self::TYPE_PERCENT])) {
            throw new \Exception($type . ' type is not allowed');
        }

        $this->type = $type;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue(int $value): void
    {
        $this->value = $value;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }
}
