<?php
session_start();
include 'db.php'; // Asegúrate de que este archivo exista en el mismo directorio

// Verifica que se hayan enviado datos
if (isset($_POST['gmail']) && isset($_POST['contaseña'])) {
    $correo = $_POST['gmail'];
    $contrasena = $_POST['contaseña'];

    // Consulta por correo
    $sql = "SELECT * FROM usuarios WHERE correo = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();

    // Verifica la contraseña con password_verify si está encriptada
    if ($usuario && $contrasena === $usuario['contraseña']) {

        $_SESSION['correo'] = $usuario['correo'];
        $_SESSION['nombre'] = $usuario['nombre']; // si quieres mostrarlo en admin.php
        header("Location: admin.php");
        exit;
    } else {
        echo "<script>alert('Correo o contraseña incorrectos'); window.location.href='interfas de login.html';</script>";
        exit;
    }
} else {
    echo "<script>alert('Por favor ingrese sus datos'); window.location.href='index.html';</script>";
    exit;
}
?>
