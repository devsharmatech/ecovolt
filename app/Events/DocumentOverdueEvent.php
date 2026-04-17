<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DocumentOverdueEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $document;
    public $user;

    public function __construct($document, $user = null)
    {
        $this->document = $document;
        $this->user = $user;
    }
}