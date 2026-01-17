<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class ObatRestocked implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $id;
    public $nama;
    public $new_stock;

    public function __construct($id, $nama, $new_stock)
    {
        $this->id = $id;
        $this->nama = $nama;
        $this->new_stock = $new_stock;
    }

    public function broadcastOn()
    {
        return new Channel('obat');
    }
}
