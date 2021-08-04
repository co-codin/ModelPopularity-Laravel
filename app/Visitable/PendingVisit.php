<?php

namespace App\Visitable;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class PendingVisit
{
    protected $attributes = [];

    public function __construct(protected Model $model) {}

    public function withIp($ip = null)
    {
        $this->attributes['ip'] = $ip ?? request()->ip();

        return $this;
    }

    public function withData($data)
    {
        $this->attributes = array_merge($this->attributes, $data);

        return $this;
    }

    public function withUser(?User $user = null)
    {
        $this->attributes['user_id'] = $user?->id ?? auth()->id();

        return $this;
    }

    public function __destruct()
    {
        $this->model->visits()->create([
            'data' => $this->attributes,
        ]);
    }
}
