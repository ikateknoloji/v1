<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Company;
use App\Models\CompanyDetail;
use App\Models\Message;
use Illuminate\Validation\Rule;

class FormController extends Controller
{
    public function OrderForm(Request $request)
    {
        // Form verilerini doğrula
        $validatedData = $request->validate([
            'customer_fullname' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'company_name' => 'required|string',
            'activity_field' => 'required|string',
            'motto' => 'required|string',
            'establishment_year' => 'required|numeric',
            'about_company' => 'required|string',
            'message' => 'required|string',
            'city_id' => 'required|exists:cities,id',
            'district_id' => 'required|exists:districts,id',
        ], 
        [
            'required' => ':attribute alanı zorunludur.',
            'string' => ':attribute alanı metin olmalıdır.',
            'email' => ':attribute alanı geçerli bir e-posta adresi olmalıdır.',
            'numeric' => ':attribute alanı sayı olmalıdır.',
            'exists' => 'Seçilen :attribute geçersizdir.',
        ]);

        // Customer verilerini al
        $customerData = $request->only(['customer_fullname', 'phone', 'email']);
        $customer = Customer::create($customerData);
        
        // Company verilerini al
        $companyData = $request->only(['company_name', 'activity_field', 'motto']);
        $companyData['customer_id'] = $customer->id;
        $company = Company::create($companyData);
        
        // CompanyDetail verilerini al
        $companyDetailData = $request->only(['establishment_year', 'about_company', 'message']);
        $companyDetailData['customer_id'] = $customer->id;
        $companyDetailData['city_id'] = $request->input('city_id');
        $companyDetailData['district_id'] = $request->input('district_id');
        $companyDetail = CompanyDetail::create($companyDetailData);
        
        // Message verilerini al
        $messageData = $request->only(['message']);
        $messageData['customer_id'] = $customer->id;
        $message = Message::create($messageData);
        
        // Başarılı bir şekilde veritabanına eklenmişse
        if ($customer && $company && $companyDetail && $message) {
            return response()->json(['success' => true, 'message' => 'Form başarıyla eklendi.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Form eklenirken bir hata oluştu.']);
        }
    }

    public function ContactForm(Request $request){

        // Form verilerini doğrula
        $validatedData = $request->validate([
            'customer_fullname' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'company_name' => 'required|string',
            'activity_field' => 'required|string',
            'motto' => 'required|string',
            'message' => 'required|string',
        ], 
        [
            'required' => ':attribute alanı zorunludur.',
            'string' => ':attribute alanı metin olmalıdır.',
            'email' => ':attribute alanı geçerli bir e-posta adresi olmalıdır.',
        ]);

        // Customer verilerini kaydet
        $customerData = $request->only(['customer_fullname', 'phone', 'email']);
        $customer = Customer::create($customerData);

        // Company verilerini kaydet
        $companyData = $request->only(['company_name', 'activity_field', 'motto']);
        $companyData['customer_id'] = $customer->id;
        $company = Company::create($companyData);

        // Message verisini kaydet
        $messageData = $request->only(['message']);
        $messageData['customer_id'] = $customer->id;
        $message = Message::create($messageData);

        // Başarılı bir şekilde veritabanına eklenmişse
        if ($customer && $company && $message) {
            return response()->json(['success' => true, 'message' => 'Veriler başarıyla kaydedildi.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Veriler kaydedilirken bir hata oluştu.']);
        }
    }

    public function BasicForm (Request $request){
        // Form verilerini doğrula
        $validatedData = $request->validate([
            'customer_fullname' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email|unique:customers',
        ], [
            'required' => ':attribute alanı zorunludur.',
            'string' => ':attribute alanı metin olmalıdır.',
            'email' => ':attribute alanı geçerli bir e-posta adresi olmalıdır.',
            'unique' => ':attribute alanı daha önceden kaydedilmiştir.',
        ]);

        // Müşteri verisini kaydet
        $customer = Customer::create($validatedData);

        // Başarılı bir şekilde veritabanına eklenmişse
        if ($customer) {
            return response()->json(['success' => true, 'message' => 'Müşteri başarıyla kaydedildi.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Müşteri kaydedilirken bir hata oluştu.']);
        }
    }
}
