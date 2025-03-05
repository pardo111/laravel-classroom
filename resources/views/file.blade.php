<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Archivo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Subir Archivo</h2>
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('file.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label for="user" class="form-label">Usuario</label>
                <input type="text" id="user" name="user" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label for="subject" class="form-label">Asunto</label>
                <input type="text" id="subject" name="subject" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label for="activity" class="form-label">Actividad</label>
                <input type="text" id="activity" name="activity" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label for="file" class="form-label">Archivo</label>
                <input type="file" id="file" name="file" class="form-control" accept=".jpeg,.png,.pdf,.rar,.zip" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Subir Archivo</button>
        </form>
    </div>
</body>
</html>
