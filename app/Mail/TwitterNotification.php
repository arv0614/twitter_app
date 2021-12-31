<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TwitterNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title='テスト', $data=null, $template_html='emails.sample', $template_text='emails.sample_text')
    {
        $this->title = $title;
        $this->data = $data;
        $this->template_html = $template_html;
        $this->template_text = $template_text;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view($this->template_html)
                           ->text($this->template_text)
                           ->subject($this->title)
                           ->with($this->data);
    }
    
}
