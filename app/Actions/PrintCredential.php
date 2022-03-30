<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class PrintCredential extends AbstractAction
{
    public function getTitle()
    {
        return 'Imprimir';
    }

    public function getIcon()
    {
        return 'glyphicon glyphicon-print';
    }

    public function getPolicy()
    {
        return 'add';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-default pull-right',
            'target' => 'blank',
            'style' => 'margin: 5px;'
        ];
    }

    public function getDefaultRoute()
    {
        return route('players.print', ['id' => $this->data->id]);
    }
    
    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'players';
    }
}