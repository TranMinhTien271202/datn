<?php

namespace App\Mail;

use App\Models\JobPost;
use App\Models\SeekerProfile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $subject;
    public $company_name;
    public $post_name;

    public function __construct($subject, $company_name,$post_name)
    {
        $this->subject = $subject;
        $this->company_name = $company_name;
        $this->post_name = $post_name;
    }
    public function build(Request $request){
        $user = auth('candidate')->user()->id;
        $name = auth('candidate')->user()->name;
        $seeker = SeekerProfile::where('candidate_id', $user)->where('is_active',1)->first();
        $company_name = $this->company_name;
        $post_name = $this->post_name;
        return $this->subject('UbWork')
                    ->view('email.email', compact('name','company_name','seeker','post_name'));
    }
}
