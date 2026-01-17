<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class ObatUsed implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $id;
    public $nama;
    public $sisa_stok;

    public function __construct($id, $nama, $sisa_stok)
    {
        $this->id = $id;
        $this->nama = $nama;
        $this->sisa_stok = $sisa_stok;
    }

    public function broadcastOn()
    {
        return new Channel('obat');
    }
}
