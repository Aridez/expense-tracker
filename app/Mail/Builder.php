<?php

namespace App\Mail;

use Illuminate\Notifications\Messages\MailMessage;

class Builder extends MailMessage
{
    /**
     * The view to be rendered.
     *
     * @var array|string
     */
    public $view;
        
    /**
     * Creates an instance of the class
     *
     * @param  mixed $theme The theme to be used as defined in the resources/components/email folder
     * @return void
     */
    public function __construct(String $theme = 'default')
    {
        $this->viewData['components'] = [];
        $this->theme = $theme;
        $this->view = 'components.email.' . $theme . '.index';
    }

    /**
     * @override
     * Set the view for the mail message.
     *
     * @param  array|string  $view
     * @param  array  $data
     * @return $this
     */
    public function view($view, array $data = [])
    {
        $this->view = $view;
        $this->viewData = array_merge($data, $this->viewData);

        $this->markdown = null;

        return $this;
    }
    
    /**
     * Merges the existing parameters with an array of 'raw' parameters to be accessed in the view
     *
     * @param  mixed $data An array of raw parameters to access in the view
     * @return $this
     */
    public function params(array $data)
    {
        $this->viewData = array_merge($data, $this->viewData);
        return $this;
    }
    
    /**
     * Magic methods used to add a new component to be rendered in the view, together with its arguments
     *
     * @param  mixed $method_name The name of the component called
     * @param  mixed $args The data that will be accessed by the component
     * @return void
     */
    public function __call($method_name, $args) {

        $this->viewData['components'][] = [
            'view' => 'email.'.$this->theme.'.'.$method_name,
            'args' => $args
        ];
        return $this;   

     }

}