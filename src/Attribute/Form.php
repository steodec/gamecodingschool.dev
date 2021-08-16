<?php

namespace Steodec\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Form
{
    public function __construct(public string $name,
                                public string $type,
                                public bool   $hidden = FALSE,
                                public bool   $checked = FALSE)
    {
    }

    /**
     * @return string
     */
    public function get_name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function get_type(): string
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function is_hidden(): bool
    {
        return $this->hidden;
    }

    /**
     * @return bool
     */
    public function is_checked(): bool
    {
        return $this->checked;
    }


}