<!DOCTYPE html>
<html>
<head>
    <title>Восстановление пароля</title>
</head>
<body>
    <p>Для восстановления пароля, пожалуйста, перейдите по следующей ссылке:</p>
    <a href="{{ url('password/reset/'.$token) }}">Восстановить пароль</a>
</body>
</html>