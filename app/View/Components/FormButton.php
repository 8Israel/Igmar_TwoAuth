<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormButton extends Component
{
    public $text;
    public $color;

    public function __construct($text, $color)
    {
        $this->text = $text;
        $this->color = $color;
    }

    public function render()
    {
        return view('components.form-button');
    }
}
