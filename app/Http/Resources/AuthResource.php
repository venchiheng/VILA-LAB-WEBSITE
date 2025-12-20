<?php
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
class AuthResource extends JsonResource{
    protected $token;
    public function __construct($resource, $token = null){
        parent::__construct($resource);
        $this->token = $token;
    }
    public function toArray($request){
        return[
            'id'=> $this->id,
            'name'=> $this->name,
            'email'=>$this->email,
            'role'=> $this->role,
            'member_id'=> $this->member_id,
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
            'token' => $this->token, 
        ];
    }
}