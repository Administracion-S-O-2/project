@include('componentes.header')

    <section class="container-fluid mt-3">
        <h1 class="text-center">Alta de asamblea</h1>
        <div class="row justify-content-center align-items-center">
            <form class="col-4 card p-3" action="/asamblea" method="POST">
                @csrf
                <div class="form-floating mb-2"> 
                    <input type="text" class="form-control" name="purpose" id="floatingInputPurpose" placeholder="Ingrese un proposito" required>
                    <label for="floatingInput">Proposito</label>
                </div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" id="radioDefault1" checked value="General">
                        <label class="form-check-label" for="radioDefault1">
                            General
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" id="radioDefault2" value="Extraordinaria">
                        <label class="form-check-label" for="radioDefault2">
                            Extraordinaria
                        </label>
                    </div>
                <div>
                    <label for="date">Fecha y hora</label>
                    <input type="datetime-local" name="date" id="date">
                </div>
                <button class="mt-2 btn btn-primary" type="submit">Crear</button>
            </form>
        </div>
    </section>

@include('componentes.footer')