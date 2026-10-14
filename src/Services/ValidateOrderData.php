<?php
namespace Services;

class ValidateOrderData
{
    public function validate(array $data): array
    {
        $errors = [];
        $sanitized = [];

        // 1. Проверка ФИО
        $fio = trim($data['fio'] ?? '');
        if (mb_strlen($fio) < 3) {
            $errors[] = 'ФИО должно содержать минимум 3 символа';
        } else {
            $sanitized['fio'] = htmlspecialchars(strip_tags($fio), ENT_QUOTES, 'UTF-8');
        }

        // 2. Санитизация телефона (оставляем только цифры и +, 8 меняем на +7, берем первые 11 цифр)
        $rawPhone = trim($data['phone'] ?? '');
        $digits = preg_replace('/\D/', '', $rawPhone);
        
        if (strlen($digits) >= 11) {
            $digits = substr($digits, 0, 11);
            if ($digits[0] === '8') {
                $digits = '7' . substr($digits, 1);
            }
            $sanitized['phone'] = '+' . $digits;
        } else {
            $sanitized['phone'] = $rawPhone;
        }

        // 3. Тип доставки
        $deliveryType = trim($data['delivery_type'] ?? 'email');
        $sanitized['delivery_type'] = $deliveryType;

        if ($deliveryType === 'email') {
            $email = trim($data['email'] ?? '');
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Некорректный email';
            }
            $sanitized['email'] = filter_var($email, FILTER_SANITIZE_EMAIL);
        } else {
            $address = trim($data['address'] ?? '');
            if (mb_strlen($address) < 10 || mb_strlen($address) > 200) {
                $errors[] = 'Адрес должен содержать от 10 до 200 символов';
            }
            $sanitized['address'] = htmlspecialchars(strip_tags($address), ENT_QUOTES, 'UTF-8');
        }

        return [
            'valid' => empty($errors),
            'sanitized' => $sanitized,
            'errors' => $errors
        ];
    }
}