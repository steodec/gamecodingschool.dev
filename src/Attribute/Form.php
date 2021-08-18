<?php

namespace Steodec\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class Form
{
    public function __construct(public string $form_name,
                                public string $name,
                                public string $type,
                                public bool $hidden = FALSE,
                                public bool $checked = FALSE)
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

    /**
     * @return string
     */
    public function get_form_name(): string
    {
        return $this->form_name;
    }


}