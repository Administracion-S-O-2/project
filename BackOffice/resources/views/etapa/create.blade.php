@include('componentes.header')

    <section class="container-fluid mt-3">
        <h1 class="text-center">Alta de etapa</h1>
        <div class="row justify-content-center align-items-center">
            <form class="col-4 card p-3" action="/etapa" method="POST">
                @csrf
                <div class="form-floating mb-3"> 
                    <input type="text" class="form-control" name="name" id="floatingInputName" placeholder="Ingrese un nombre" required>
                    <label for="floatingInput">Nombre</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="description" id="floatingInputDescription" placeholder="Ingrese una descripcion" required>
                    <label for="floatingInput">Descripcion</label>
                </div>
                <button class="mt-2 btn btn-primary" type="submit">Crear</button>
            </form>
        </div>
    </section>

@include('componentes.footer')