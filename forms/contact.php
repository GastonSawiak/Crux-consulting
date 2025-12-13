<?php
// Inicializamos variables para mensajes de estado
$mensaje_estado = "";
$clase_estado = "";

// Verificamos si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Recogemos y limpiamos los datos (Sanitización para seguridad)
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $mensaje = htmlspecialchars(trim($_POST['mensaje']));

    // 2. Validaciones básicas
    if (empty($nombre) || empty($email) || empty($mensaje)) {
        $mensaje_estado = "Por favor, completa todos los campos.";
        $clase_estado = "error";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje_estado = "El correo electrónico no es válido.";
        $clase_estado = "error";
    } else {
        // 3. Configuración del correo a enviar
        $destinatario = "gastonsawiak2@gmail.com"; // <--- PON TU CORREO AQUÍ
        $asunto = "Nuevo mensaje de contacto de: $nombre";
        
        $cuerpo = "Has recibido un nuevo mensaje desde el formulario web.\n\n";
        $cuerpo .= "Nombre: $nombre\n";
        $cuerpo .= "Correo: $email\n";
        $cuerpo .= "Mensaje:\n$mensaje\n";

        // Cabeceras (Headers) para que el correo llegue correctamente
        $headers = "From: $nombre <$email>\r\n";
        $headers .= "Reply-To: $email\r\n";
        
        // 4. Enviar el correo
        // Nota: La función mail() requiere que el servidor tenga configurado un servicio SMTP.
        if (mail($destinatario, $asunto, $cuerpo, $headers)) {
            $mensaje_estado = "¡Gracias! Tu mensaje ha sido enviado correctamente.";
            $clase_estado = "exito";
            
            // Limpiar campos después de enviar
            $nombre = $email = $mensaje = ""; 
        } else {
            $mensaje_estado = "Lo sentimos, hubo un error al enviar el mensaje. Inténtalo más tarde.";
            $clase_estado = "error";
        }
    }
}
?>
