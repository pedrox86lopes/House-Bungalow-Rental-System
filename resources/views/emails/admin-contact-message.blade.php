<!DOCTYPE html>
<html>
<head>
    <title>Nova Mensagem de Contacto</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { width: 80%; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        .header { background: #f4f4f4; padding: 10px; border-bottom: 1px solid #ddd; margin-bottom: 20px; }
        .message-body { margin-top: 20px; }
        .footer { margin-top: 30px; font-size: 0.9em; color: #777; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Nova Mensagem de Contacto de Utilizador</h2>
        </div>
        <p>Recebeu uma nova mensagem do utilizador:</p>
        <ul>
            <li><strong>Nome do Utilizador:</strong> {{ $user->name }}</li>
            <li><strong>Email do Utilizador:</strong> {{ $user->email }}</li>
            <li><strong>Assunto:</strong> {{ $subjectLine }}</li>
        </ul>

        <div class="message-body">
            <h3>Mensagem:</h3>
            <p>{{ $userMessage }}</p>
        </div>

        <div class="footer">
            <p>Esta é uma mensagem automática, por favor não responda a este e-mail.</p>
        </div>
    </div>
</body>
</html>
