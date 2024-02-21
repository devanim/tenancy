<?php
public function updateTenantPaymentMethods(Request $request, $tenantId)
{
    $validator = Validator::make($request->all(), [
        'payment_methods' => 'sometimes|array',
        'payment_methods.*' => 'exists:payment_methods,global_id'
    ], $this->messages);

    try {
        $validatedData = $validator->validated();
        $tenant = Tenant::findOrFail($tenantId);
        $newMethods = $validatedData['payment_methods'] ?? [];

        $paymentMethodTypeIds = [];

        // Collect PaymentMethodType IDs
        foreach ($newMethods as $methodId) {
            $paymentMethod = PaymentMethod::with('paymentMethodType')->find($methodId);
            if ($paymentMethod && $paymentMethod->paymentMethodType) {
                $paymentMethodType = $paymentMethod->paymentMethodType;
                $paymentMethodTypeIds[] = $paymentMethodType->global_id;
            }
        }

        // Remove duplicates and null values
        $paymentMethodTypeIds = array_unique(array_filter($paymentMethodTypeIds));

        // Sync PaymentMethodType with the tenant
        $tenant->paymentMethodTypes()->sync($paymentMethodTypeIds);

        // Trigger sync for each PaymentMethodType
        foreach ($paymentMethodTypeIds as $typeGlobalId) {
            $paymentMethodType = PaymentMethodType::find($typeGlobalId);
            if ($paymentMethodType) {
                $paymentMethodType->triggerSync();
            }
        }

        // Sync PaymentMethod with the tenant
        $tenant->paymentMethods()->sync($newMethods);

        // Trigger sync for each PaymentMethod
        foreach ($newMethods as $methodId) {
            $paymentMethod = PaymentMethod::find($methodId);
            if ($paymentMethod) {
                $paymentMethod->triggerSync();
            }
        }
    }catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred while updating payment methods. ' . $e->getMessage()], 500);
    }
}
    
