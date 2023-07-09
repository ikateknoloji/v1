<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Company;
use App\Models\CompanyDetail;
use App\Models\Message;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
class FormController extends Controller
{
    public function orderForm(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'customer_fullname' => 'required|string',
            'phone' => ['required', 'string', 'regex:/^\d{10}$/'], 
            'email' => 'required|email',
            'company_name' => 'required|string',
            'activity_field' => 'required|string',
            'motto' => 'required|string',
            'establishment_year' => 'required|numeric|digits:4',
            'about_company' => 'required|string',
            'message' => 'required|string',
            'city_id' => 'required|exists:cities,id',
            'district_id' => 'required|exists:districts,id',
        ], [
            'required' => ':attribute alanı zorunludur.',
            'string' => ':attribute alanı metin olmalıdır.',
            'email' => ':attribute alanı geçerli bir e-posta adresi olmalıdır.',
            'numeric' => ':attribute alanı sayı olmalıdır.',
            'digits' => ':attribute alanı 4 basamaklı bir sayı olmalıdır.',
            'exists' => 'Seçilen :attribute geçersizdir.',
            'regex' => ':attribute alanı geçerli bir telefon numarası formatında olmalıdır. (Örnek: 5551234567)',

        ] , [
            'customer_fullname' => 'Ad ve Soyad',
            'phone' => 'Telefon numaranız', 
            'email' => 'Email Adresiniz',
            'company_name' => 'Firmanızın Ad',
            'activity_field' => 'Faliyet Alanınız',
            'motto' => 'Mottonuz',
            'establishment_year' => 'Kuruluş Yılınız',
            'about_company' => 'Hakkınızda',
            'message' => 'Mesaj',
            'city_id' => 'İl',
            'district_id' => 'İlçe',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 400);
        }
    
        $customer = Customer::create($request->only(['customer_fullname', 'phone', 'email']));
    
        $companyData = $request->only(['company_name', 'activity_field', 'motto']);
        $companyData['customer_id'] = $customer->id;
        $company = Company::create($companyData);
    
        $companyDetailData = $request->only(['establishment_year', 'about_company', 'message']);
        $companyDetailData['customer_id'] = $customer->id;
        $companyDetailData['city_id'] = $request->input('city_id');
        $companyDetailData['district_id'] = $request->input('district_id');
        $companyDetail = CompanyDetail::create($companyDetailData);
    
        $messageData = $request->only(['message']);
        $messageData['customer_id'] = $customer->id;
        $message = Message::create($messageData);
    
        if ($customer && $company && $companyDetail && $message) {
            return response()->json(['success' => true, 'message' => 'Form başarıyla eklendi.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Form eklenirken bir hata oluştu.']);
        }
    }
    
    public function contactForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_fullname' => 'required|string',
            'phone' => ['required', 'string', 'regex:/^\d{10}$/'], 
            'email' => 'required|email',
            'company_name' => 'required|string',
            'activity_field' => 'required|string',
            'motto' => 'required|string',
            'message' => 'required|string',
        ], [
            'required' => ':attribute alanı zorunludur.',
            'string' => ':attribute alanı metin olmalıdır.',
            'email' => ':attribute alanı geçerli bir e-posta adresi olmalıdır.',
            'regex' => ':attribute alanı geçerli bir telefon numarası formatında olmalıdır. (Örnek: 5551234567)',
        ]
        ,[
            'customer_fullname' => 'Ad ve Soyad',
            'phone' => 'Telefon numaranız', 
            'email' => 'Email Adresiniz',
            'company_name' => 'Firmanızın Ad',
            'activity_field' => 'Faliyet Alanınız',
            'motto' => 'Mottonuz',
            'about_company' => 'Hakkınızda',
            'message' => 'Mesaj',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 400);
        }
    
        $customer = Customer::create($request->only(['customer_fullname', 'phone', 'email']));
    
        $companyData = $request->only(['company_name', 'activity_field', 'motto']);
        $companyData['customer_id'] = $customer->id;
        $company = Company::create($companyData);
    
        $messageData = $request->only(['message']);
        $messageData['customer_id'] = $customer->id;
        $message = Message::create($messageData);
    
        if ($customer && $company && $message) {
            return response()->json(['success' => true, 'message' => 'Veriler başarıyla kaydedildi.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Veriler kaydedilirken bir hata oluştu.']);
        }
    }
    

    public function basicForm (Request $request){
        // Form verilerini doğrula
        $validatedData = $request->validate([
            'customer_fullname' => 'required|string',
            'phone' => ['required', 'string', 'regex:/^\d{10}$/'], 
            'email' => 'required|email|unique:customers',
        ], [
            'required' => ':attribute alanı zorunludur.',
            'string' => ':attribute alanı metin olmalıdır.',
            'email' => ':attribute alanı geçerli bir e-posta adresi olmalıdır.',
            'unique' => ':attribute alanı daha önceden kaydedilmiştir.',
        ],[
            'customer_fullname' => 'Ad ve Soyad',
            'phone' => 'Telefon numaranız', 
            'email' => 'Email Adresiniz',
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
