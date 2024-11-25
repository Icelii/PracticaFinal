<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenidos!!!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-4 mb-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Productos</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalProducto">
            Agregar Producto
        </button>
    </div>
    
    <div class="row" id="lista-productos">
        @forelse ($productos as $producto)
            <div class="col-md-4 mb-4">
                <div class="card">
                    @if ($producto->imgpath)
                        <img src="{{ asset('storage/' . $producto->imgpath) }}" class="card-img-top" alt="{{ $producto->nombre_producto }}">
                    @else
                        <img src="https://via.placeholder.com/150" class="card-img-top" alt="Producto sin imagen">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $producto->nombre_producto }}</h5>
                        <p class="card-text">{{ $producto->descripcion ?? 'Sin descripción.' }}</p>
                        <p class="card-text"><strong>Precio:</strong> ${{ number_format($producto->precio, 2) }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center">No hay productos disponibles.</p>
            </div>
        @endforelse
    </div>
</div>

    <!-- MODAL -->
    <div class="modal fade" id="modalProducto" tabindex="-1" aria-labelledby="modalProductoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalProductoLabel">Agregar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formulario-producto" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombre_producto" class="form-label">Nombre del Producto</label>
                            <input type="text" class="form-control" id="nombre_producto" name="nombre_producto"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio</label>
                            <input type="number" class="form-control" id="precio" name="precio" step="0.01"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Imagen</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    $(document).ready(function () {
        $('#formulario-producto').on('submit', function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('productos.store') }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        alert(response.message);

                        location.reload();
                    }
                },
                error: function (response) {
                    alert('Error al guardar el producto. Revisa los campos.');
                }
            });
        });
    });
</script>
</body>
</html>
