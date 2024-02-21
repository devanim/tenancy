<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Contracts\SyncMaster;
use Stancl\Tenancy\Database\Concerns\CentralConnection;
use Stancl\Tenancy\Database\Concerns\ResourceSyncing;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Stancl\Tenancy\Database\Models\TenantPivot;

/**
 * Summary of PaymentMethod
 */
class PaymentMethod extends Model implements SyncMaster
{
    use ResourceSyncing, CentralConnection, HasFactory;

    /**
     * Summary of table
     * @var string
     */
    protected $table = 'payment_methods'; // Central table name
    /**
     * Summary of fillable
     * @var array
     */
    protected $fillable = [
        'name',
        'processing_name',
        'payment_provider_id',
        'has_send_verification_email',
        'is_void',
        'has_refund',
        'payment_method_type_global_id',
        'global_id'
    ];

    /**
     * Summary of casts
     * @var array
     */
    protected $casts = [
        'global_id' => 'string',
    ];
    /**
     * Summary of incrementing
     * @var 
     */
    public $incrementing = false;
    /**
     * Summary of keyType
     * @var string
     */
    protected $keyType = 'string';
    /**
     * Summary of primaryKey
     * @var string
     */
    protected $primaryKey = 'global_id';

    /**
     * Summary of tenants
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tenants(): BelongsToMany
    {
        return $this->belongsToMany(Tenant::class, 'tenant_payment_methods', 'global_id', 'tenant_id', 'global_id')
        ->using(TenantPivot::class);
    }

    /**
     * Summary of getTenantModelName
     * @return string
     */
    public function getTenantModelName(): string
    {
        return Tenant\PaymentMethod::class;
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
        return static::class;
    }

    /**
     * Summary of getSyncedAttributeNames
     * @return array
     */
    public function getSyncedAttributeNames(): array
    {
        return [
            'name',
            'processing_name',
            'payment_provider_id',
            'has_send_verification_email',
            'is_void',
            'has_refund',
            'payment_method_type_global_id'
        ];
    }

    /**
     * Summary of triggerSync
     * @return void
     */
    public function triggerSync()
    {
        $this->touch();
    }
    /**
     * Summary of paymentProvider
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paymentProvider()
    {
        return $this->belongsTo(PaymentProvider::class, 'payment_provider_id');
    }

    /**
     * Summary of paymentMethodType
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paymentMethodType()
    {
        return $this->belongsTo(PaymentMethodType::class);
    }
}
