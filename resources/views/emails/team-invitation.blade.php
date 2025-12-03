<!DOCTYPE html>
<html>
<head>
    <title>Invitación de Equipo</title>
</head>
<body>
    <h1>Hola,</h1>
    <p>Has sido invitado a unirte al despacho <strong>{{ $invitation->tenant->name }}</strong> en Qadra.</p>
    
    <p>Rol asignado: {{ ucfirst($invitation->role) }}</p>

    @if($invitationMessage)
        <div style="background-color: #f3f4f6; padding: 15px; border-left: 4px solid #4f46e5; margin: 20px 0;">
            <strong>Mensaje de invitación:</strong><br>
            {{ $invitationMessage }}
        </div>
    @endif
    
    <p>Para aceptar la invitación, haz clic en el siguiente enlace:</p>
    
    <a href="{{ $acceptUrl }}" style="background-color: #4F46E5; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Aceptar Invitación</a>
    
    <p>Este enlace expirará el {{ $invitation->expires_at->format('d/m/Y H:i') }}.</p>
    
    <p>Si no esperabas esta invitación, puedes ignorar este correo.</p>
</body>
</html>
