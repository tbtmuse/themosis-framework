<?php

namespace Themosis\Forms;

use Illuminate\Contracts\Validation\Factory as ValidationFactoryInterface;
use Illuminate\Contracts\View\Factory as ViewFactoryInterface;
use Themosis\Forms\Contracts\FormBuilderInterface;
use Themosis\Forms\Contracts\FormFactoryInterface;

class FormFactory implements FormFactoryInterface
{
    /**
     * @var ValidationFactoryInterface
     */
    protected $validation;

    /**
     * @var ViewFactoryInterface
     */
    protected $viewer;

    /**
     * Form generator/builder.
     *
     * @var FormBuilderInterface
     */
    protected $builder;

    /**
     * Form instances default attributes.
     *
     * @var array
     */
    protected $attributes = [
        'method' => 'post'
    ];

    /**
     * Form locale.
     *
     * @var string
     */
    protected $locale;

    public function __construct(ValidationFactoryInterface $validation, ViewFactoryInterface $viewer, $locale = 'en_US')
    {
        $this->validation = $validation;
        $this->viewer = $viewer;
        $this->locale = $locale;
    }

    /**
     * Create a FormBuilderInterface instance.
     *
     * @param array  $options
     * @param mixed  $data    Data object (DTO).
     * @param string $builder A FieldBuilderInterface class.
     *
     * @return FormBuilderInterface
     */
    public function make($options = [], $data = null, $builder = FormBuilder::class): FormBuilderInterface
    {
        $form = new Form(new FormRepository(), $this->validation, $this->viewer);
        $form->setAttributes($this->attributes);
        $form->setOptions($options);
        $form->setLocale($this->locale);

        $this->builder = new $builder($form);

        return $this->builder;
    }
}
