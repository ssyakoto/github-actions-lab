<?php
namespace Services;
use Models\User;

class ValidateRegisterData
{
    public function validate(array $data, ?User $userModel = null): array
    {
        $errors = [];
        $sanitized = [];

        // 1. Имя
        $name = trim($data['name'] ?? '');
        if (mb_strlen($name) < 2) {
            $errors[] = 'Имя должно содержать минимум 2 символа';
        } else {
            $sanitized['name'] = htmlspecialchars(strip_tags($name), ENT_QUOTES, 'UTF-8');
        }

        // 2. Email
        $email = trim($data['email'] ?? '');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Некорректный формат email';
        } else {
            $sanitizedEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
            $sanitized['email'] = $sanitizedEmail;
            
            // Проверка уникальности, если передана модель
            if ($userModel && method_exists($userModel, 'findByEmail')) {
                if ($userModel->findByEmail($sanitizedEmail)) {
                    $errors[] = 'Пользователь с таким email уже существует';
                }
            }
        }

        // 3. Пароль
        $password = $data['password'] ?? '';
        if (strlen($password) < 6) {
            $errors[] = 'Пароль должен содержать минимум 6 символов';
        }

        // 4. Подтверждение пароля
        $passwordConfirm = $data['password_confirm'] ?? '';
        if ($password !== $passwordConfirm) {
            $errors[] = 'Пароли не совпадают';
        }

        return [
            'valid' => empty($errors),
            'sanitized' => $sanitized,
            'errors' => $errors
        ];
    }
}