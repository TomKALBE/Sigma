<?php

namespace App\Mail;

use App\Models\Register;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Validator;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $params = $this->data;
        $register = new Register($this->data);
        $register->save();
        return $this->view('emails.contact')->from($this->data['email'])->with(['email'=>$this->data['email'],'token'=>$this->data['token']]);
    }


}
