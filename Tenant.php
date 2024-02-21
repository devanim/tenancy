<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Domain;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;


/**
 * Summary of Tenant
 */
class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;
    /**
     * Summary of casts
     * @var array
     */
    protected $casts = [
        'data' => 'array',
    ];
    /**
     * Summary of domains
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function domains()
    {
        return $this->hasMany(Domain::class);
    }
    /**
     * Summary of paymentMethods
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function paymentMethods()
    {
        return $this->belongsToMany(PaymentMethod::class, 'tenant_payment_methods', 'tenant_id', 'global_id', 'id', 'global_id');
    }

    /**
     * Summary of paymentMethodTypes
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function paymentMethodTypes()
    {
        return $this->belongsToMany(PaymentMethod::class, 'tenant_payment_method_types', 'tenant_id', 'global_id', 'id', 'global_id');
    }
}
