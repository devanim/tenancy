<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Contracts\Syncable;
use Stancl\Tenancy\Database\Concerns\ResourceSyncing;

/**
 * Summary of PaymentMethodType
 */
class PaymentMethodType extends Model implements Syncable
{
    use HasFactory, ResourceSyncing;

    /**
     * Summary of fillable
     * @var array
     */
    protected $fillable = [
        'global_id',
        'name',
    ];

    /**
     * Summary of incrementin
     * @var 
     */
    public $incrementing = false;
    /**
     * Summary of keyType
     * @var string
     */
    protected $keyType = 'string';
    /**
     * Summary of paymentMethods
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paymentMethods()
    {
        return $this->hasMany(PaymentMethod::class, 'payment_method_type_global_id', 'global_id');
    }

    /**
     * Summary of getGlobalIdentifierKey
     * @return mixed
     */
    public function getGlobalIdentifierKey()
    {
        return $this->getAttribute($this->getGlobalIdentifierKeyName());
    }

    /**
     * Summary of getGlobalIdentifierKeyName
     * @return string
     */
    public function getGlobalIdentifierKeyName(): string
    {
        return 'global_id';
    }

    /**
     * Summary of getCentralModelName
     * @return string
     */
    public function getCentralModelName(): string
    {
        return \App\Models\PaymentMethodType::class;
    }



    /**
     * Summary of getSyncedAttributeNames
     * @return array
     */
    public function getSyncedAttributeNames(): array
    {
        return [
            'name',
        ];
    }
}
